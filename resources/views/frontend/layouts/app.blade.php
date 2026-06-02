<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="theme color" content="#005faf">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="https://digitalelixirr.com/sales/assets/style.css" rel="stylesheet">
    <link href="https://digitalelixirr.com/sales/assets/custom.css" rel="stylesheet">
    <link href="https://digitalelixirr.com/sales/assets/css/vendors.css" rel="stylesheet">

    <!-- Icons CSS -->
    <link href="https://digitalelixirr.com/sales/assets/css/fontawesome.css" rel="stylesheet">
    <link href="https://digitalelixirr.com/sales/assets/css/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        .header-wrapper_1 {
            width: 100%;
            background-color: #1b3160;
            /* Exact dark blue from image */
            position: relative;
            z-index: 9999;
        }

        /* --- DESKTOP VIEW TOP ROW --- */
        .top-bar {
            border-bottom: 1px solid #282856;
        }

        .logo-desktop {
            color: #ffffff;
            font-size: 26px;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .stars {
            color: #ff9900;
            font-size: 20px;
            margin-left: 4px;
        }

        .orange-cta {
            background: linear-gradient(to bottom, #ffa800 0%, #ff8400 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            border: 1px solid #d46f00;
            white-space: nowrap;
        }

        /* --- DESKTOP VIEW BOTTOM NAVIGATION ROW --- */
        .bottom-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            position: relative;
            margin-left: -22px;
        }

        .nav-menus {
            display: flex;
            list-style: none;
            padding-left: 0px !important;
            margin-left: -10px !important;
            margin-bottom: 0px;
        }

        .top_mob {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0px 10px 0px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 14px 20px;
            cursor: pointer;
            user-select: none;
            font-family: 'Open Sans', Arial, Helvetica, sans-serif;
        }

        .nav-link:hover {
            color: #ff9900;
        }

        .nav-item.active .nav-link {
            color: #ff9900;
        }

        .arrow-down {
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid currentColor;
            transition: transform 0.2s;
        }

        /* --- DROPDOWN MENU (STABLE CLICK BASED) --- */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #ffffff;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            list-style: none;
            padding: 6px 0;
            display: none;
            border-radius: 4px;
            z-index: 10000;
        }

        /* Active show state controlled by JavaScript click */
        .nav-item.open .dropdown-menu {
            display: block;
        }

        .nav-item.open .arrow-down {
            transform: rotate(180deg);
        }

        .dropdown-menu li a {
            color: #333333;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 18px;
            display: block;
            font-weight: 500;
        }

        .dropdown-menu li a:hover {
            background-color: #f4f6f9;
            color: #ff9900;
        }

        .right-meta {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .lang-link,
        .login-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Open Sans', Arial, Helvetica, sans-serif;
        }

        .lang-link:hover,
        .login-link:hover {
            color: #ff9900;
        }

        /* --- MOBILE ONLY ROW STYLE --- */
        .mobile-header {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            width: 100%;
        }

        .logo-mobile {
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .mobile-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle {
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 5px;
        }

        .menu-toggle span {
            width: 24px;
            height: 3px;
            background-color: #ffffff;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* Separate Mobile Dropdown Drawer Panel */
        .mobile-drawer {
            display: none;
            background-color: #15274d;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            width: 100%;
        }

        .mobile-drawer.active {
            display: block;
        }

        /* --- CRITICAL FIX FOR DESKTOP RESIZE --- */
        @media (min-width: 1025px) {
            .mobile-drawer {
                display: none !important;
                /* बड़ी स्क्रीन होते ही मोबाइल ड्रावर जबरदस्ती बंद हो जाएगा */
            }
        }

        /* --- MEDIA QUERY FOR PHONE & TABLETS --- */
        @media (max-width: 1024px) {

            .top-bar,
            .bottom-bar {
                display: none;
                /* Hide Desktop system */
            }

            .mobile-header {
                display: flex;
                /* Activate Clean Mobile single row view */
            }

            .mobile-drawer .nav-menu {
                flex-direction: column;
                width: 100%;
            }

            .mobile-drawer .nav-item {
                width: 100%;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .mobile-drawer .nav-link {
                padding: 15px 0;
                justify-content: space-between;
                width: 100%;
                font-size: 16px;
            }

            .mobile-drawer .dropdown-menu {
                position: relative;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.2);
                box-shadow: none;
                padding: 0;
                border-radius: 0;
            }

            .mobile-drawer .dropdown-menu li a {
                color: #e0e0e0;
                padding: 12px 20px;
                font-size: 15px;
            }

            .mobile-login-btn {
                display: block;
                padding: 18px 0;
                color: #ffffff;
                text-decoration: none;
                font-size: 16px;
                font-weight: bold;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                margin-top: 10px;
            }

            /* Hamburger transform to X icon */
            .menu-toggle.open span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .menu-toggle.open span:nth-child(2) {
                opacity: 0;
            }

            .menu-toggle.open span:nth-child(3) {
                transform: rotate(-45deg) translate(6px, -6px);
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
