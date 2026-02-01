        </div>
        </main>

        <footer class="footer">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Tous droits réservés.</p>
                <p>Version <?php echo APP_VERSION; ?></p>
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