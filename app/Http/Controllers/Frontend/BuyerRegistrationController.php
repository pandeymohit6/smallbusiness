<?php
declare(strict_types=1);

namespace App\Traits;

use App\Models\AutoNews;
use App\Models\Publication;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

trait CreateFromFtp
{
    public function createDataInReadyToPushUsingFtp($publicationId)
    {
        $currentTime = Carbon::now()->tz('Asia/Kolkata');

        // Format the date and time
        $date = $currentTime->format('d-m-Y');
        $publication = Publication::with(['publicationFeedField'])->find($publicationId);
        $file_public = public_path() . DIRECTORY_SEPARATOR . 'xml-source';
        if (!is_dir($file_public . DIRECTORY_SEPARATOR . $publication->id)) {
            mkdir($file_public . DIRECTORY_SEPARATOR . $publication->id, 0777, true);
        }
        if ($publication->protocol == 'ftp' && !in_array($publication->id, [255, 312, 313])) {
            try {
                $ftp_conn = ftp_connect($publication->ftp_host);
                if ($ftp_conn) {
                    $ftp_login = @ftp_login($ftp_conn, $publication->ftp_username, $publication->ftp_password);
                    ftp_pasv($ftp_conn, true);
                    if ($ftp_login) {
                        $all_file_list = ftp_mlsd($ftp_conn, $publication->ftp_file_path);
                        $file_list = array_filter($all_file_list, function ($var) {
                            return strpos($var['name'], '.xml') == true;
                        });
                        $unlink_files = [];
                        foreach ($file_list as $xml_file) {
                            $fileModifiedDate = date('d-m-Y', strtotime($xml_file['modify']));
                            $remote_file_path = $publication->ftp_file_path . $xml_file['name'];

                            $local_file_path = $file_public . DIRECTORY_SEPARATOR . $publication->id . DIRECTORY_SEPARATOR . $xml_file['name'];
                            //if ($date == $fileModifiedDate && $xml_file['size'] > 0) {
                            if ($xml_file['size'] > 0) {
                                ftp_get($ftp_conn, $local_file_path, $remote_file_path, FTP_ASCII);

                                $deletedFile = ftp_delete($ftp_conn, $remote_file_path);
                                //if($deletedFile){
                                //     //  Log::info('File deleted ' . $remote_file_path .'-'. $publication->id);
                                //}
                            }
                        }
                    }
                }
                $this->storeDatainTable($publication);
            } catch (\Exception $e) {
                Log::error('Message: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
                return true;
            }
        } else {
            $this->storeDatainTableTender($publication);
        }
    }

    function getValueFromNestedArray($array, $searchKey)
    {
        foreach ($array as $key => $value) {
            if ($key === $searchKey) {
                return empty($value) ? null : $value;
            }
            if (is_array($value) && array_key_exists($searchKey, $value)) {
                return empty($value[$searchKey]) ? null : $value[$searchKey];
            }
            if (is_array($value)) {
                $result = $this->getValueFromNestedArray($value, $searchKey);
                if ($result !== null) {
                    return empty($result) ? null : $result;
                }
            }
        }

        return null;
    }

    public function storeDatainTable($publication)
    {
        $currentTime = Carbon::now()->tz('Asia/Kolkata');

        // Format the date and time
        $formattedDateTime = $currentTime->format('Y-m-d H:i:s');

        $combinedArray = [];
        foreach ($publication['publicationFeedField'] as $field) {
            if (isset($field['field'], $field['x_path'])) {
                $combinedArray[$field['field']] = $field['x_path'];
            }
        }
        $file_public = public_path() . DIRECTORY_SEPARATOR . 'xml-source';
        $files = glob($file_public . DIRECTORY_SEPARATOR . $publication->id . DIRECTORY_SEPARATOR . '*xml');

        $limit = 1000;
        $limitedFiles = array_slice($files, 0, $limit);

        if (!empty($limitedFiles)) {
            foreach ($limitedFiles as $key => $filename) {
                try {
                    libxml_use_internal_errors(true); // Prevent warnings from crashing script
                    $xml = simplexml_load_file($filename);

                    if ($xml === false) {
                        Log::warning("Failed to parse XML file: {$filename}", [
                            'errors' => libxml_get_errors(),
                        ]);
                        libxml_clear_errors();
                        continue; // Skip to next file
                    }
                    $jsonres = json_decode(json_encode($xml), true);
                    $publication_id = $publication->id;
                    $storyText = null;
                    if ($publication->id == 299) {
                        $keywords = ['Bollywood', 'Cinema', 'Entertainment'];
                        $section = $this->getValueFromNestedArray($jsonres, $combinedArray['section']);
                        foreach ($keywords as $word) {
                            if (stripos($section, $word) !== false) {
                                $publication_id = 300;
                                break;
                            }
                        }
                    }
                    $input[$key]['publication_id'] = $publication_id;
                    $input[$key]['headline'] = $this->getValueFromNestedArray($jsonres, $combinedArray['headline']);
                    $input[$key]['rss_headline'] = $this->getValueFromNestedArray($jsonres, $combinedArray['headline']);
                    $input[$key]['section'] = $this->getValueFromNestedArray($jsonres, $combinedArray['section']);
                    $input[$key]['imglink'] = $this->getValueFromNestedArray($jsonres, $combinedArray['imglink']);
                    $input[$key]['secondary_headline'] = $this->getValueFromNestedArray($jsonres, $combinedArray['secondary_headline']);
                    $input[$key]['story_category'] = $this->getValueFromNestedArray($jsonres, $combinedArray['story_category']);
                    $input[$key]['summary_text'] = $this->getValueFromNestedArray($jsonres, $combinedArray['summary_text']);
                    $input[$key]['story_text'] = $this->getValueFromNestedArray($jsonres, $combinedArray['story_text']);
                    if ($publication->id == 299) {
                        $input[$key]['story_text'] = is_array($input[$key]['story_text'])
                            ? implode(
                                '',
                                array_map(function ($p) {
                                    if (!is_string($p)) {
                                        return '';
                                    }
                                    $text = trim($p);
                                    return !empty($text) ? "<p>{$text}</p>" : '';
                                }, $input[$key]['story_text']),
                            )
                            : null;
                    }
                    $input[$key]['author_name'] = $this->getValueFromNestedArray($jsonres, $combinedArray['author_name']);
                    $input[$key]['location'] = $this->getValueFromNestedArray($jsonres, $combinedArray['location']);
                    $input[$key]['story_link'] = $this->getValueFromNestedArray($jsonres, $combinedArray['story_link']);
                    $input[$key]['story_date'] = $formattedDateTime; //$this->getValueFromNestedArray($jsonres, $combinedArray['story_date']) ? $this->getValueFromNestedArray($jsonres, $combinedArray['story_date']) :  $formattedDateTime;
                    $input[$key]['story_status'] = 2;
                    $input[$key]['user_id'] = 1;
                    $input[$key]['created_at'] = $this->getValueFromNestedArray($jsonres, $combinedArray['story_date']) ? $this->getValueFromNestedArray($jsonres, $combinedArray['story_date']) : $formattedDateTime;
                    // dd($input);
                } catch (\Throwable $th) {
                    Log::error($th->getMessage(), $th->getLine(), $jsonres);
                    Log::alert('something wrong with file' . $filename);
                    continue;
                }
            }
            if (!empty($input)) {
                $data = $this->remove_empty($input);
                //dd($data);
                $this->createNews($data);
                if ($publication->send_real_time == 1) {
                    Artisan::call('command:sendrealtime');
                }
                foreach ($limitedFiles as $key => $filename) {
                    $deletedFile = File::delete($filename);
                    //  if ($deletedFile == null) {
                    //      Log::info('File deleted ' . $filename);
                    //  }
                }
            }
        }
    }

    // tenderd

    public function storeDatainTableTender($publication)
    {
        $currentTime = Carbon::now()->tz('Asia/Kolkata');
        $formattedDateTime = $currentTime->format('Y-m-d H:i:s');
        try {
            $combinedArray = [];
            foreach ($publication['publicationFeedField'] as $field) {
                if (isset($field['field'], $field['x_path'])) {
                    $combinedArray[$field['field']] = $field['x_path'];
                }
            }
            $file_public = public_path() . DIRECTORY_SEPARATOR . 'xml-source';
            $files = glob($file_public . DIRECTORY_SEPARATOR . $publication->id . DIRECTORY_SEPARATOR . '*xml');

            $limit = 1000;
            $limitedFiles = array_slice($files, 0, $limit);
            if (!empty($limitedFiles)) {

                foreach ($limitedFiles as $key => $filename) {
                    try {
                        $xml = simplexml_load_file($filename);
                    } catch (\Throwable $th) {
                        $xml = file_get_contents($filename);
                        $xml = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xml);
                        $xml = simplexml_load_string($xml);
                        Log::error($th->getMessage());
                        Log::alert('something wrong with tender file' . $filename);
                    }

                    $jsonres = json_decode(json_encode($xml), true);

                    $postingId = getValueCaseInsensitive($jsonres, 'posting_id');
                    $headline = getValueCaseInsensitive($jsonres, $combinedArray['headline']);
                    $story = getValueCaseInsensitive($jsonres, $combinedArray['story_text']);

                    $combinedTitle = trim(
                        ($postingId ? 'Posting_Id: ' . $postingId : '') .
                            ($headline ? ', ' . $headline : '')
                    );

                    $input[$key]['publication_id'] = $publication->id;

                    $input[$key]['headline'] =
                        !hasKeyCaseInsensitive($jsonres, 'posting_id')
                        ? getValueCaseInsensitive($jsonres, 'headline')
                        : $combinedTitle;

                    $input[$key]['rss_headline'] = $input[$key]['headline'];

                    $input[$key]['secondary_headline'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['secondary_headline']
                    );

                    $input[$key]['story_category'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['story_category']
                    );

                    $input[$key]['summary_text'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['summary_text']
                    );

                    $input[$key]['story_text'] =
                        !hasKeyCaseInsensitive($jsonres, 'posting_id')
                        ? getValueCaseInsensitive($jsonres, 'Story')
                        : $story;

                    $input[$key]['author_name'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['author_name']
                    );

                    $input[$key]['location'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['location']
                    );

                    $input[$key]['story_link'] = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['story_link'],
                        null
                    );

                    $storyDate = getValueCaseInsensitive(
                        $jsonres,
                        $combinedArray['story_date']
                    );

                    $input[$key]['story_date'] = !empty($storyDate)
                        ? Carbon::parse($storyDate)->format('Y-m-d')
                        : $formattedDateTime;

                    $input[$key]['story_status'] = 2;
                    $input[$key]['user_id'] = 1;
                    $input[$key]['created_at'] = $formattedDateTime;
                }
                dd($input);
                if (!empty($input)) {
                    try {
                        $data = $this->remove_empty($input);
                        $this->createNews($data);
                        foreach ($limitedFiles as $key => $filename) {
                            $deletedFile = File::delete($filename);
                        }
                    } catch (\Throwable $th) {
                        Log::error('Message: ' . $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile());
                        return true;
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('Message: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            return true;
        }
    }

    // public function getIans($paragraphs){
    //     dd($paragraphs);
    //     $paragraphs = array_map(function($p) {
    //     return '<p>' . (is_array($p) ? implode('', $p) : $p) . '</p>';
    //     }, $paragraphs);
    //     $htmlWithPTags = implode("\n", $paragraphs);
    //     echo $htmlWithPTags;
    // }

    public function createNews($data)
    {
        try {
            $insertData = [];

            foreach ($data as $story) {
                // Skip if title already exists
                $exists = AutoNews::where('headline', $story['headline'])->first();

                if (!$exists) {
                    $insertData[] = $story;
                } else {
                    Log::alert('Duplicate skipped: ' . $story['headline'] . ',Date: ' . $exists->story_date);
                }
            }

            // Bulk insert
            if (!empty($insertData)) {
                AutoNews::insert($insertData);

                Log::info(count($insertData) . ' records inserted');
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    function remove_empty($array)
    {
        foreach ($array as $key => $link) {
            $keys = array_keys($link);
            $hasHeadline = isset($link['headline']);
            $hasStoryText = isset($link['story_text']);

            if ((isset($link) && ($hasHeadline && $link['headline'] === '')) || ($hasStoryText && $link['story_text'] === '')) {
                unset($array[$key]);
                // Log::alert('Message: something wrong with this URL ' . $link['headline'] . ' publication Id '.$link['publication_id']);
            }
            if ($hasStoryText && is_array($link['story_text'])) {
                $array[$key]['story_text'] = $this->flattenArrayToString($link['story_text']);
            }

            foreach ($keys as $keyg) {
                if (is_array($link[$keyg]) && $link[$keyg] === []) {
                    $array[$key][$keyg] = null;
                }
            }
        }
        return $array;
    }

    function flattenArrayToString($array, $separator = ', ')
    {
        $result = [];

        foreach ($array as $value) {
            if (is_array($value)) {
                $result[] = $this->flattenArrayToString($value, $separator);
            } else {
                $result[] = strval($value);
            }
        }

        return implode($separator, $result);
    }

    public function parseRssFeed($xmlPathOrUrl)
    {
        try {
            libxml_use_internal_errors(true);
            $xmldata = simplexml_load_file($xmlPathOrUrl);

            if ($xmldata === false) {
                foreach (libxml_get_errors() as $error) {
                    Log::error('XML parsing error: ' . $error->message);
                }
                libxml_clear_errors();
                return [];
            }

            $items = [];
            // Check if items exist in the channel
            if (isset($xmldata->channel->item)) {
                foreach ($xmldata->channel->item as $item) {
                    $imgUrl = null;
                    if (isset($item->links->link)) {
                        $imgUrl = (string) $item->links->link['url'];
                    }
                    $items[] = [
                        'title' => (string) $xmldata->channel->title,
                        'description' => (string) $xmldata->channel->description,
                        'headline' => (string) $item->title,
                        'story_text' => (string) $item->description,
                        'story_date' => (string) $item->pubdate,
                        'author_name' => (string) $item->author,
                        'uid' => (string) $item->uid,
                        'section' => (string) $item->section,
                        'imglink' => $imgUrl,
                        'publication' => isset($item->publication) ? (string) $item->publication : '',
                    ];
                }
            } else {
                Log::warning("No items found in RSS feed at: {$xmlPathOrUrl}");
            }

            return $items;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Failed to parse RSS feed: ' . $e->getMessage());
            return [];
        }
    }

    function getValueCaseInsensitive(array $data, $key, $default = '')
    {
        if (empty($key)) {
            return $default;
        }

        foreach ($data as $k => $value) {
            if (strcasecmp($k, $key) === 0) {
                return is_array($value) ? $default : $value;
            }
        }

        return $default;
    }

    function hasKeyCaseInsensitive(array $data, $key)
    {
        foreach ($data as $k => $value) {
            if (strcasecmp($k, $key) === 0) {
                return true;
            }
        }

        return false;
    }
}
