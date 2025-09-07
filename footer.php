<?php
// footer.php
?>
    </main> <footer class="bg-custom-gray-800 text-custom-gray-100 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold text-text-white mb-4">Super Brothers LLC</h3>
                    <p class="text-sm">
                        Your trusted, family-owned partner for drywall, painting, and flooring. Delivering the highest quality service and workmanship in Nashville and surrounding areas.
                    </p>
                    <p class="text-sm mt-2">Fully Licensed & Insured.</p>
                </div>

                <div>
                    <h3 class="text-xl font-semibold text-text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="index.php" class="hover:text-accent-orange transition-colors duration-300">Home</a></li>
                        <li><a href="about.php" class="hover:text-accent-orange transition-colors duration-300">About Us</a></li>
                        <li><a href="services.php" class="hover:text-accent-orange transition-colors duration-300">Services</a></li>
                        <li><a href="portfolio.php" class="hover:text-accent-orange transition-colors duration-300">Portfolio</a></li>
                        <li><a href="reviews.php" class="hover:text-accent-orange transition-colors duration-300">Reviews</a></li>
                        <li><a href="contact.php" class="hover:text-accent-orange transition-colors duration-300">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-semibold text-text-white mb-4">Get In Touch</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-3 mt-1 text-accent-orange"></i>
                            <span>Serving: Nashville, Brentwood, Green Hills, Governor Clubs, Inglewood, West Meadow, Hermitage, Gallatin, Henderson, and surrounding areas.</span>
                        </li>
                        <li>
                            <a href="tel:+16158910749" class="hover:text-accent-orange transition-colors duration-300 flex items-center">
                                <i class="fas fa-phone mr-3 text-accent-orange"></i>615-891-0749
                            </a>
                        </li>
                        <li>
                            <a href="mailto:superbrothersllc@gmail.com" class="hover:text-accent-orange transition-colors duration-300 flex items-center">
                                <i class="fas fa-envelope mr-3 text-accent-orange"></i>superbrothersllc@gmail.com
                            </a>
                        </li>
                    </ul>
                    <div class="mt-6 flex space-x-4">
                        <a href="https://www.facebook.com/superbrothersllc" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-accent-orange transition-colors duration-300" aria-label="Facebook">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/superbrothersllc" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-accent-orange transition-colors duration-300" aria-label="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="https://www.tiktok.com/@superbrothersllc?lang=en" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-accent-orange transition-colors duration-300" aria-label="TikTok">
                            <i class="fab fa-tiktok fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-custom-gray-700 text-center text-sm">
                <p><a href="admin/login.php" title="Admin Login" style="text-decoration: none; color: inherit;" class="hover:text-accent-orange transition-colors">&copy;</a> <?php echo date("Y"); ?> Super Brothers LLC. All Rights Reserved.</p>
                <p class="mt-1">Website by <a href="https://chrisandemmashow.com" target="_blank" rel="noopener noreferrer" class="hover:text-accent-orange transition-colors duration-300">Chris & Emma</a></p>
                <p class="mt-1">Admin <a href="admin_login.php" target="_blank" rel="noopener noreferrer" class="hover:text-accent-orange transition-colors duration-300">Login</a></p>
            </div>
        </div>
    </footer>

    <script src="scripts.js"></script>
    <!-- The mobile menu toggle script is also in header.php for immediate functionality, 
         and a more robust version can be in scripts.js if preferred for separation.
         The inline script previously here for the menu has been removed to avoid redundancy. -->
</body>
</html>
