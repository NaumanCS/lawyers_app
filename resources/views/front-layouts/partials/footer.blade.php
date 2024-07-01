<!-- Footer -->
<footer class="footer">
    <!-- Footer Top -->
    <div class="footer-top aos">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Quick Links  </h2>
                        <ul>
                            <li>
                                <a href="#">About Us</a>
                            </li>
                            <li>
                                <a href="{{ route('contact.us') }}">Contact Us</a>
                            </li>
                            <li>
                                <a href="#">Faq</a>
                            </li>
                            <li>
                                <a href="{{ route('help.center') }}">Help</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /Footer Widget -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Categories</h2>
                        <ul>
                            <li>
                                <a href="{{ route('categories', ['filter' => 'all']) }}">See all Categories</a>
                            </li>
                        </ul>
                        
                    </div>
                    <!-- /Footer Widget -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact Us</h2>
                        <div class="footer-contact-info">
                            <div class="footer-address">
                                <span><i class="far fa-building"></i></span>
                                <p>367 Hillcrest Lane, Irvine, California, United States</p>
                            </div>
                            <p><i class="fas fa-headphones"></i> 321 546 8764</p>
                            {{-- <p class="mb-0"><i class="fas fa-envelope"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="52262027373e2b21373e3e12372a333f223e377c313d3f">[email&#160;protected]</a></p> --}}
                            <p><i class="fas fa-envelope"></i>@example.com</p>
                        </div>
                    </div>
                    <!-- /Footer Widget -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget">
                        <h2 class="footer-title">Follow Us</h2>
                       
                        <div class="subscribe-form">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button type="submit" class="btn footer-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /Footer Widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- /Footer Top -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <!-- Copyright -->
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="copyright-text">
                            <p class="mb-0">&copy; 2022 <a href="{{route('front')}}">Lawyers</a>. All rights reserved.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <!-- Copyright Menu -->
                        <div class="copyright-menu">
                            <ul class="policy-menu">
                                <li>
                                    <a href="#">Terms and Conditions</a>
                                </li>
                                <li>
                                    <a href="#">Privacy</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /Copyright Menu -->
                    </div>
                </div>
            </div>
            <!-- /Copyright -->
        </div>
    </div>
    <!-- /Footer Bottom -->

</footer>
<!-- /Footer -->
