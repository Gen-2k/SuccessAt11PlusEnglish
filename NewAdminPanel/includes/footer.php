</div> <!-- End admin-wrapper -->
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/admin-script.js"></script>
<script>
// Initialize dropdowns after Bootstrap is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for Bootstrap to fully initialize
    setTimeout(function() {
        // Force dropdown initialization for all dropdowns
        var dropdownToggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdownToggles.forEach(function(toggle) {
            if (!bootstrap.Dropdown.getInstance(toggle)) {
                new bootstrap.Dropdown(toggle);
            }
        });
        
        // Add click outside to close functionality
        var adminDropdown = document.getElementById('adminDropdown');
        if (adminDropdown) {
            document.addEventListener('click', function(event) {
                var dropdownMenu = adminDropdown.nextElementSibling;
                if (dropdownMenu && !adminDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    var dropdown = bootstrap.Dropdown.getInstance(adminDropdown);
                    if (dropdown && dropdownMenu.classList.contains('show')) {
                        dropdown.hide();
                    }
                }
            });
        }
    }, 100);
});
</script>
</body>
</html>
