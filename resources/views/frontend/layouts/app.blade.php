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
    <link href="/assets/css/login.css" rel="stylesheet">
    <!-- Icons CSS -->
    <link href="https://digitalelixirr.com/sales/assets/css/fontawesome.css" rel="stylesheet">
    <link href="https://digitalelixirr.com/sales/assets/css/bootstrap-icons.css" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

</head>

<body>
    @include('frontend.components.header')
    @yield('content')
    @include('frontend.components.footer')
</body>

</html>
