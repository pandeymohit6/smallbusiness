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

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function updateProgressBar() {
            const progressLine = document.getElementById('progress-line');
            // Manage smooth width calculation positioning
            const percentage = ((currentStep - 1) / (totalSteps - 1)) * 75;
            progressLine.style.width = percentage + '%';

            // Manage active node layout circles coloring
            for (let i = 1; i <= totalSteps; i++) {
                const node = document.getElementById('step-node-' + i);
                if (!node) continue;

                if (i < currentStep) {
                    node.className = "step-list completed-list";
                } else if (i === currentStep) {
                    node.className = "step-list active-list";
                } else {
                    node.className = "step-list";
                }
            }

            // Hide lower notice on confirmation screen
            const note = document.getElementById('disclaimer-note');
            if (currentStep === 4) {
                note.style.display = 'none';
            } else {
                note.style.display = 'block';
            }
        }

        function navigateToTab(stepNumber) {
            if (stepNumber > 4 || stepNumber < 1) return;

            // Hide all template tab frames
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById('tab-page-' + i).classList.remove('active-tab-list');
            }

            // Target specific dynamic tab view frame
            currentStep = stepNumber;
            document.getElementById('tab-page-' + currentStep).classList.add('active-tab-list');

            updateProgressBar();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function nextTab() {
            if (currentStep < totalSteps) {
                navigateToTab(currentStep + 1);
            }
        }

        function prevTab() {
            if (currentStep > 1) {
                navigateToTab(currentStep - 1);
            }
        }

        // Set layout line initialization setup triggers
        updateProgressBar();
    </script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333333;
            line-height: 1.6;
            padding: 20px;
        }

        .container-list {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* Top Navigation Header */
        .top-nav-list {
            text-align: right;
            font-size: 14px;
            margin-bottom: 25px;
            color: #666;
        }

        .top-nav-list a {
            color: #0056b3;
            text-decoration: none;
            margin: 0 5px;
        }

        /* Modern Progress Bar Line */
        .progress-container-list {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 50px;
        }

        .progress-container-list::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background: #e0e0e0;
            z-index: 1;
        }

        .progress-line-active-list {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 0%;
            background: #008080;
            z-index: 2;
            transition: width 0.4s ease;
        }

        .step-list {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .step-list.completed-list {
            background: #2ecc71 !important;
        }

        .step-list.active-list {
            background: #008080;
            box-shadow: 0 0 0 5px rgba(0, 128, 128, 0.2);
        }

        .step-list .step-label-list {
            position: absolute;
            top: 45px;
            font-size: 11px;
            color: #666;
            white-space: nowrap;
            text-align: center;
            font-weight: normal;
        }

        .step-list.active-list .step-label-list {
            color: #008080;
            font-weight: bold;
        }

        .step-list.completed-list .step-label-list {
            color: #2ecc71;
        }

        /* Headings & Intro */
        h1 {
            font-size: 24px;
            color: #222;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .intro-text-list {
            font-size: 13px;
            color: #666;
            margin-bottom: 25px;
            background: #fff8f0;
            padding: 15px;
            border-left: 4px solid #f39c12;
            border-radius: 4px;
        }

        /* Action Buttons Header/Footer */
        .action-buttons-list {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .action-buttons-list.bottom-list {
            border-bottom: none;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 30px;
        }

        .btn-left-group-list {
            display: flex;
            gap: 10px;
        }

        .btn-secondary-list {
            background: #f1f1f1;
            color: #333;
            padding: 10px 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-secondary-list:hover {
            background: #e5e5e5;
        }

        .btn-back-list {
            background: #ffffff;
            border: 1px solid #a0a0a0;
            font-weight: bold;
        }

        .btn-primary-list {
            background: #f39c12;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: background 0.2s;
        }

        .btn-primary-list:hover {
            background: #e08e0b;
        }

        /* Wizard Controlling Screen Switching Layout */
        .wizard-tab-list {
            display: none;
        }

        .wizard-tab-list.active-tab-list {
            display: block;
        }

        /* Form Sections */
        .form-section-list {
            background: #fbfbfb;
            border: 1px solid #eef2f5;
            border-radius: 6px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-section-list h2 {
            font-size: 18px;
            color: #008080;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eef2f5;
        }

        /* Form Groups */
        .form-group-list {
            margin-bottom: 20px;
        }

        .form-group-list label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group-list label span {
            color: red;
        }

        .form-group-list .help-text-list {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }

        /* Inputs configuration */
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #008080;
            box-shadow: 0 0 5px rgba(0, 128, 128, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Input Group with $ prefix labels */
        .input-group-list {
            display: flex;
            align-items: center;
        }

        .input-group-addon-list {
            background: #eee;
            border: 1px solid #cccccc;
            border-right: none;
            padding: 10px 15px;
            font-weight: bold;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            color: #555;
            font-size: 14px;
        }

        .input-group-addon-right-list {
            background: #eee;
            border: 1px solid #cccccc;
            border-left: none;
            padding: 10px 15px;
            font-size: 13px;
            color: #555;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .input-group-list input,
        .input-group-list select {
            border-radius: 0;
        }

        /* Radio & Checkbox structural element styles */
        .radio-group-list,
        .checkbox-group-list {
            display: flex;
            gap: 20px;
            margin-top: 5px;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .checkbox-stack-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 5px;
            font-size: 14px;
        }

        .radio-item-list,
        .checkbox-item-list {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            cursor: pointer;
        }

        .radio-item-list input,
        .checkbox-item-list input {
            margin-top: 3px;
        }

        /* Financial rows grid alignment */
        .financial-row-list {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .financial-field-list {
            flex: 1;
            min-width: 240px;
        }

        .financial-or-list {
            font-weight: bold;
            color: #888;
            padding-top: 20px;
        }

        /* Upload files section box container */
        .upload-box-list {
            background: #fff;
            border: 2px dashed #ccc;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }

        .btn-upload-list {
            background: #555;
            color: #fff;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin-top: 8px;
        }

        /* Review Section layout items */
        .package-section-list {
            background: #ffffff;
            border: 1px solid #eef2f5;
            border-radius: 6px;
            padding: 30px;
        }

        .pricing-grid-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .price-card-list {
            background: #ffffff;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .price-card-list:hover {
            border-color: #008080;
        }

        .price-info-list {
            display: flex;
            flex-direction: column;
        }

        .price-duration-list {
            font-size: 13px;
            font-weight: 700;
            color: #444;
            text-transform: uppercase;
        }

        .price-amount-list {
            font-size: 18px;
            font-weight: 800;
            color: #0056b3;
        }

        .decline-option-list {
            background: #fff5f5;
            border: 1px dashed #f5c2c2;
            padding: 15px 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #c0392b;
            cursor: pointer;
        }

        /* Final screen details display */
        .confirmation-box-list {
            background: #fafbfc;
            border: 1px solid #eef2f5;
            border-radius: 6px;
            padding: 30px;
        }

        .summary-card-list {
            background: #ffffff;
            border-left: 4px solid #008080;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .summary-row-list {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .summary-row-list strong {
            display: inline-block;
            width: 200px;
        }

        .action-link-list {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }

        /* Global Footer elements spacing design */
        .footer-note-list {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 30px;
            line-height: 1.8;
        }

        .footer-links-list {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .footer-links-list a {
            color: #0056b3;
            text-decoration: none;
            margin: 0 8px;
        }

        @media (max-width: 768px) {
            .progress-container-list {
                display: none;
            }

            .financial-row-list {
                flex-direction: column;
                align-items: stretch;
            }

            .pricing-grid-list {
                grid-template-columns: 1fr;
            }

            .action-buttons-list {
                flex-direction: column;
                gap: 15px;
            }

            .summary-row-list strong {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
