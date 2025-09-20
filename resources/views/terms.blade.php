<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Read the Terms & Conditions for using SkillProFinder, the platform connecting skilled individuals with clients.">
    <meta name="keywords" content="SkillProFinder, terms, conditions, service platform">
    <title>Terms & Conditions - SkillProFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .terms {
            padding: 60px 0;
            background-color: #fff;
        }
        .terms h2 {
            font-size: 32px;
            color: #242c36;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .terms h3 {
            font-size: 24px;
            color: #242c36;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .terms p, .terms li {
            font-size: 16px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .terms ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @include('layouts.header')
    @include('layouts.navbar')

    <section class="terms">
        <div class="container">
            <h2>Terms & Conditions</h2>
            <p><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>
            <p>Welcome to SkillProFinder. By accessing or using our website or services, you agree to be bound by the following terms and conditions. Please read them carefully.</p>

            <h3>1. Acceptance of Terms</h3>
            <p>By registering, browsing, or using SkillProFinder, you confirm that you agree to these Terms & Conditions and our Privacy Policy.</p>

            <h3>2. Eligibility</h3>
            <p>To use SkillProFinder, you must be at least 18 years old or have the legal capacity to form a binding agreement in your country of residence.</p>

            <h3>3. User Accounts</h3>
            <ul>
                <li>You are responsible for maintaining the confidentiality of your account and password.</li>
                <li>You agree to provide accurate and up-to-date information when creating your profile.</li>
            </ul>

            <h3>4. Service Listings</h3>
            <ul>
                <li>You may list only skills or services you are qualified to offer.</li>
                <li>All content you post must be respectful, legal, and not misleading.</li>
                <li>SkillProFinder reserves the right to remove any content deemed inappropriate or harmful.</li>
            </ul>

            <h3>5. Payment & Transactions</h3>
            <ul>
                <li>SkillProFinder does not handle payments between users at this stage. Transactions are carried out directly between clients and service providers.</li>
                <li>In the future, SkillProFinder may offer secure payment features with relevant terms.</li>
            </ul>

            <h3>6. Limitations of Liability</h3>
            <p>SkillProFinder is not liable for any direct or indirect damage or loss resulting from interactions between users, including disputes or service issues. Always use due diligence.</p>

            <h3>7. Termination</h3>
            <p>We reserve the right to suspend or delete user accounts that violate our policies or engage in harmful behavior on the platform.</p>

            <h3>8. Changes to Terms</h3>
            <p>These Terms may be updated at any time. Continued use of the platform constitutes your acceptance of any changes.</p>
        </div>
    </section>

    @include('layouts.footer')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
