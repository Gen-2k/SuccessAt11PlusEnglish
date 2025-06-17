// Admin Panel JavaScript - Optimized

document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Create sidebar overlay for mobile
    if (window.innerWidth <= 768) {
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
            
            overlay.addEventListener('click', function() {
                sidebar?.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    }
    
    // Menu toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.toggle('show');
                overlay?.classList.toggle('show');
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar?.classList.remove('show');
            overlay?.classList.remove('show');
        }
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert:not(.no-auto-hide)');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
