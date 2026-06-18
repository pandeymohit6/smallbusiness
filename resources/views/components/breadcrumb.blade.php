@props([
    'title' => '',
    'backUrl' => null,
])

<div class="bw-breadcrumb">

    <div class="bw-breadcrumb-left">

        @if($backUrl)
            <a href="{{ $backUrl }}" class="bw-back-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        <div>

            @if($title)
                <h1 class="bw-page-title">
                    {{ $title }}
                </h1>
            @endif

        </div>

    </div>

</div>