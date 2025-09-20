<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn how SkillProFinder collects, uses, and protects your personal data in our Privacy Policy.">
    <meta name="keywords" content="SkillProFinder, privacy policy, data protection">
    <title>Privacy Policy - SkillProFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .privacy {
            padding: 60px 0;
            background-color: #fff;
        }
        .privacy h2 {
            font-size: 32px;
            color: #242c36;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .privacy h3 {
            font-size: 24px;
            color: #242c36;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .privacy p, .privacy li {
            font-size: 16px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .privacy ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }
        .privacy a {
            color: #242c36;
            text-decoration: underline;
        }
        .privacy a:hover {
            color: #1a2028;
        }
    </style>
</head>
<body>
    @include('layouts.header')
    @include('layouts.navbar')

    <section class="privacy">
        <div class="container">
            <h2>Privacy Policy</h2>
            <p><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>
            <p>Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your personal data.</p>

            <h3>1. Information We Collect</h3>
            <ul>
                <li><strong>Account Info:</strong> Name, email address, phone number, location, and skills.</li>
                <li><strong>Usage Data:</strong> Device info, IP address, and browser data.</li>
                <li><strong>Optional Data:</strong> Profile photos, skill descriptions, reviews.</li>
            </ul>

            <h3>2. How We Use Your Information</h3>
            <ul>
                <li>To match clients with relevant service providers.</li>
                <li>To improve the functionality and security of the platform.</li>
                <li>To communicate with you about your account or updates.</li>
            </ul>

            <h3>3. Sharing of Information</h3>
            <p>We do not sell or rent your data. However, your profile information (excluding contact details unless opted-in) may be visible to registered users.</p>

            <h3>4. Data Security</h3>
            <p>We take precautions to protect your data through encryption and secured storage. However, no system is 100% secure—please use the platform responsibly.</p>

            <h3>5. Cookies</h3>
            <p>SkillProFinder uses cookies to improve user experience and analyze traffic. You can manage cookie settings in your browser.</p>

            <h3>6. Your Rights</h3>
            <ul>
                <li>Access the data we hold about you</li>
                <li>Request corrections or deletion</li>
                <li>Withdraw consent at any time</li>
            </ul>

            <h3>7. Contact</h3>
            <p>If you have questions about this policy, please contact us at <a href="mailto:info@skillprofinder.com">info@skillprofinder.com</a>.</p>
        </div>
    </section>

    @include('layouts.footer')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
