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
        .terms { padding: 60px 0; background-color: #fff; }
        .terms h2 { font-size: 32px; color: #242c36; margin-bottom: 20px; font-weight: bold; }
        .terms h3 { font-size: 24px; color: #242c36; margin-top: 30px; margin-bottom: 15px; }
        .terms p, .terms li { font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 10px; }
        .terms ul { padding-left: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>
    @include('layouts.header')
    @include('layouts.navbar')

    <section class="terms">
        <div class="container">
            <h2>Terms & Conditions</h2>
            <p><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>
            <p>Welcome to SkillProFinder. By accessing or using our website or services, you agree to be bound by these Terms & Conditions in compliance with EU law. Please read them carefully.</p>

            <h3>1. Acceptance of Terms</h3>
            <p>By registering, browsing, or using SkillProFinder, you confirm that you agree to these Terms & Conditions and our <a href="/privacy-policy">Privacy Policy</a>, in accordance with the General Data Protection Regulation (GDPR).</p>

            <h3>2. Eligibility</h3>
            <p>You must be at least 18 years old or have the legal capacity to enter into a binding agreement under the laws of your country of residence.</p>

            <h3>3. User Accounts</h3>
            <ul>
                <li>You are responsible for maintaining the confidentiality of your login details.</li>
                <li>You must provide accurate and truthful information when creating your profile.</li>
                <li>You must notify us immediately if you suspect unauthorized use of your account.</li>
            </ul>

            <h3>4. Services & Listings</h3>
            <ul>
                <li>Only skills or services you are qualified to offer may be listed.</li>
                <li>Content posted must not be unlawful, misleading, discriminatory, or infringe intellectual property rights.</li>
                <li>We reserve the right to remove content that violates EU laws or these Terms.</li>
            </ul>

            <h3>5. Payments & Transactions</h3>
            <ul>
                <li>Currently, SkillProFinder does not process payments. Transactions are handled directly between clients and providers.</li>
                <li>When integrated, payment processing will comply with EU PSD2 (Payment Services Directive) and consumer protection rules.</li>
            </ul>

            <h3>6. Data Protection & Privacy</h3>
            <p>We process personal data in accordance with the <strong>General Data Protection Regulation (GDPR)</strong>. For details on how your data is collected, used, and stored, please refer to our <a href="/privacy-policy">Privacy Policy</a>.</p>

            <h3>7. Consumer Rights</h3>
            <p>If you are a consumer within the EU, you may have specific rights under the <strong>EU Consumer Rights Directive</strong>, including withdrawal rights for certain digital services.</p>

            <h3>8. Limitation of Liability</h3>
            <p>SkillProFinder is not liable for disputes, losses, or damages arising from interactions between users. Users are encouraged to perform due diligence before entering agreements.</p>

            <h3>9. Intellectual Property</h3>
            <p>All trademarks, logos, and platform content belong to SkillProFinder unless otherwise stated. You may not reproduce, modify, or distribute without prior consent.</p>

            <h3>10. Termination</h3>
            <p>We may suspend or terminate accounts that breach these Terms, EU law, or engage in fraudulent or harmful activities.</p>

            <h3>11. Changes to Terms</h3>
            <p>We may update these Terms to reflect changes in law or platform features. Continued use of the service implies acceptance of the latest version.</p>

            <h3>12. Governing Law & Jurisdiction</h3>
            <p>These Terms are governed by the laws of the European Union and the Member State in which you reside. Disputes shall be subject to the competent courts of that jurisdiction.</p>

            <h3>13. Contact Information</h3>
            <p>If you have questions or concerns about these Terms, please contact us at: <a href="mailto:support@skillprofinder.com">support@skillprofinder.com</a>.</p>
        </div>
    </section>

    @include('layouts.footer')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
