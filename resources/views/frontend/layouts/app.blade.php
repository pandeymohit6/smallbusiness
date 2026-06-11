<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
   <meta charset="utf-8">
		<meta name="theme color" content="#005faf">
		<meta name="viewport" content="width=device-width, initial-scale=1">
         <meta name="csrf-token" content="{{ csrf_token() }}">
		<title></title>
		<link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
		<link href="https://digitalelixirr.com/sales/assets/style.css" rel="stylesheet">
		<link href="https://digitalelixirr.com/sales/assets/custom.css" rel="stylesheet">
		<link href="https://digitalelixirr.com/sales/assets/css/vendors.css" rel="stylesheet">

		<!-- Icons CSS -->
		<link href="https://digitalelixirr.com/sales/assets/css/fontawesome.css" rel="stylesheet">
		<link href="https://digitalelixirr.com/sales/assets/css/bootstrap-icons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .user-menu-btn {
            transition: all 0.3s ease;
        }

        .user-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
        }

        .user-menu-wrapper {
            position: relative;
        }

        .user-menu-wrapper button span:first-child {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .user-menu-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    @include('frontend.components.header')
    @yield('content')
    @include('frontend.components.footer')
</body>

</html>
