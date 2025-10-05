<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn how SkillProFinder collects, uses, and protects your personal data in our Privacy Policy.">
    <meta name="keywords" content="SkillProFinder, privacy policy, data protection, GDPR">
    <title>Privacy Policy - SkillProFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .privacy { padding: 60px 0; background-color: #fff; }
        .privacy h2 { font-size: 32px; color: #242c36; margin-bottom: 20px; font-weight: bold; }
        .privacy h3 { font-size: 24px; color: #242c36; margin-top: 30px; margin-bottom: 15px; }
        .privacy p, .privacy li { font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 10px; }
        .privacy ul { padding-left: 20px; margin-bottom: 20px; }
        .privacy a { color: #242c36; text-decoration: underline; }
        .privacy a:hover { color: #1a2028; }
    </style>
</head>
<body>
    @include('layouts.header')
    @include('layouts.navbar')

    <section class="privacy">
        <div class="container">
            <h2>Privacy Policy</h2>
            <p><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>
            <p>Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your personal data in accordance with the General Data Protection Regulation (GDPR) and applicable EU laws.</p>

            <h3>1. Information We Collect</h3>
            <ul>
                <li><strong>Account Info:</strong> Name, email address, phone number, location, and skills.</li>
                <li><strong>Usage Data:</strong> Device info, IP address, and browser data.</li>
                <li><strong>Optional Data:</strong> Profile photos, skill descriptions, reviews.</li>
            </ul>

            <h3>2. Legal Basis for Processing</h3>
            <p>We process personal data based on the following legal grounds:</p>
            <ul>
                <li>Performance of a contract (Art. 6(1)(b) GDPR) – providing our services.</li>
                <li>Consent (Art. 6(1)(a) GDPR) – e.g., marketing communications.</li>
                <li>Legitimate interests (Art. 6(1)(f) GDPR) – improving platform functionality and security.</li>
                <li>Legal obligations (Art. 6(1)(c) GDPR) – compliance with applicable laws.</li>
            </ul>

            <h3>3. How We Use Your Information</h3>
            <ul>
                <li>To match clients with relevant service providers.</li>
                <li>To improve platform security and functionality.</li>
                <li>To communicate with you about your account, services, or updates.</li>
            </ul>

            <h3>4. Sharing of Information</h3>
            <p>We do not sell or rent your data. Your profile information (excluding contact details unless opted-in) may be visible to other registered users.
            We may share limited data with trusted third-party service providers (such as hosting or analytics) under strict confidentiality agreements.</p>

            <h3>5. International Data Transfers</h3>
            <p>If we transfer personal data outside the European Economic Area (EEA), we ensure adequate safeguards, such as EU Commission-approved Standard Contractual Clauses (SCCs).</p>

            <h3>6. Data Retention</h3>
            <p>We keep your personal data only as long as necessary to provide our services or comply with legal obligations. When no longer needed, data will be securely deleted or anonymized.</p>

            <h3>7. Data Security</h3>
            <p>We implement technical and organizational measures (encryption, restricted access, secure hosting) to protect your personal data. However, no system is completely secure, and we encourage you to use the platform responsibly.</p>

            <h3>8. Cookies</h3>
            <p>We use cookies and similar technologies to enhance your experience and analyze traffic. You can adjust your cookie settings via your browser at any time. For details, see our <a href="/cookie-policy">Cookie Policy</a>.</p>

            <h3>9. Children’s Privacy</h3>
            <p>SkillProFinder is not intended for children under the age of 16. If you believe we have collected data from a minor, please contact us immediately.</p>

            <h3>10. Your Rights</h3>
            <p>Under GDPR, you have the following rights:</p>
            <ul>
                <li>Access to your personal data</li>
                <li>Rectification of inaccurate or incomplete data</li>
                <li>Erasure (“right to be forgotten”)</li>
                <li>Restriction of processing</li>
                <li>Data portability</li>
                <li>Object to processing, including direct marketing</li>
                <li>Withdraw consent at any time (where processing is based on consent)</li>
                <li>Lodge a complaint with your local Data Protection Authority</li>
            </ul>

            <h3>11. Contact</h3>
            <p>If you have questions about this Privacy Policy or wish to exercise your rights, please contact us at:
            <a href="mailto:info@skillprofinder.com">info@skillprofinder.com</a>.</p>

            
        </div>
    </section>

    @include('layouts.footer')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
