<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Feedback Section -->
            <div class="col-md-3 col-sm-6">
                <h4>Feedback</h4>
                <ul class="footer-links">
                    <li><a href="mailto:info@skillprofinder.com?subject=Complaint" aria-label="File a complaint or suggestion via email">File a Complaint/Suggestion</a></li>
                </ul>
            </div>
            <!-- Reach Us Section -->
            <div class="col-md-3 col-sm-6">
                <h4>Reach Us</h4>
                <address>
                    <ul class="footer-links">
                        <li>Email: <a href="mailto:info@skillprofinder.com" aria-label="Email SkillProFinder support">info@skillprofinder.com</a></li>
                        <li>WhatsApp: <a href="https://wa.me/2349023250180" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp +2349023250180">+2349023250180</a></li>
                    </ul>
                </address>
            </div>
            <!-- Navigation Links -->
            <div class="col-md-6 col-sm-12">
                <h4>Explore</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#about" aria-label="About SkillProFinder">About</a></li>
                    <li><a href="{{ route('home') }}#faq" aria-label="Frequently Asked Questions">FAQ</a></li>
                    <li><a href="{{ route('terms') }}" aria-label="Terms and Conditions">Terms & Conditions</a></li>
                    <li><a href="{{ route('privacy') }}" aria-label="Privacy Policy">Privacy Policy</a></li>
                   
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <p class="footer-copyright">&copy; {{ date('Y') }} SkillProFinder. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: #242c36;
    color: #fff;
    padding: 40px 0;
}
.footer h4 {
    font-size: 18px;
    color: #fff;
    margin-bottom: 15px;
    font-weight: bold;
}
.footer .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer .footer-links li {
    margin-bottom: 10px;
}
.footer .footer-links a {
    color: #fff;
    text-decoration: none;
    font-size: 14px;
}
.footer .footer-links a:hover {
    color: #ccc;
    text-decoration: underline;
}
.footer address {
    font-style: normal;
}
.footer .footer-copyright {
    font-size: 14px;
    margin-top: 20px;
    color: #ccc;
}
</style>
