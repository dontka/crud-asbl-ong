    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <h4 class="footer-brand"><?php echo APP_NAME; ?></h4>
                <p class="footer-description">Plateforme de gestion</p>
                <div class="footer-social">
                    <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-links-group">
                <a href="<?php echo BASE_URL; ?>/documentation"><i class="fas fa-book"></i> Documentation</a>
                <a href="<?php echo BASE_URL; ?>/help"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="mailto:support@asbl-ong.local"><i class="fas fa-envelope"></i> Contact</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong><?php echo APP_NAME; ?></strong> v<?php echo APP_VERSION; ?> | <a href="#">Confidentialité</a> | <a href="#">Conditions</a></p>
        </div>
    </footer>

    <!-- Flash message auto-hide -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
    </body>

    </html>