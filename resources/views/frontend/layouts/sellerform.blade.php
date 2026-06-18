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
    <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">
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
</head>

<body>
    @yield('content')
</body>

</html>
