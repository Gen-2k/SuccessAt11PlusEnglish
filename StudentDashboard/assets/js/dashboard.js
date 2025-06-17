/**
 * Student Dashboard JavaScript
 * Handles mobile navigation, interactions, and UI enhancements
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar functionality
    initMobileSidebar();
    
    // Initialize other components
    initTooltips();
    initFadeInAnimations();
    initCardInteractions();
});

/**
 * Initialize mobile sidebar toggle functionality
 */
function initMobileSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (!menuToggle || !sidebar || !sidebarOverlay) return;
    
    // Toggle sidebar on menu button click
    menuToggle.addEventListener('click', function() {
        toggleSidebar();
    });
    
    // Close sidebar when clicking overlay
    sidebarOverlay.addEventListener('click', function() {
        closeSidebar();
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('show')) {
            closeSidebar();
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar.classList.contains('show')) {
            closeSidebar();
        }
    });
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebar.classList.contains('show')) {
        closeSidebar();
    } else {
        openSidebar();
    }
}

/**
 * Open sidebar
 */
function openSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.add('show');
    sidebarOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

/**
 * Close sidebar
 */
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.remove('show');
    sidebarOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

/**
 * Initialize tooltip functionality
 */
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.position = 'relative';
        });
    });
}

/**
 * Initialize fade-in animations for elements as they come into view
 */
function initFadeInAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -10px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe cards and other animated elements
    const animatedElements = document.querySelectorAll('.stat-card, .resource-card, .empty-state');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Initialize card interaction enhancements
 */
function initCardInteractions() {
    // Card interactions removed for professional appearance
    // Keeping function for future enhancements if needed
}

/**
 * Show loading state on buttons
 */
function showButtonLoading(button) {
    if (!button) return;
    
    button.classList.add('loading');
    button.disabled = true;
    
    const originalText = button.innerHTML;
    button.dataset.originalText = originalText;
    
    const loadingText = button.dataset.loadingText || 'Loading...';
    button.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${loadingText}`;
}

/**
 * Hide loading state on buttons
 */
function hideButtonLoading(button) {
    if (!button) return;
    
    button.classList.remove('loading');
    button.disabled = false;
    
    const originalText = button.dataset.originalText;
    if (originalText) {
        button.innerHTML = originalText;
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = document.createElement('div');
    alertContainer.className = `alert alert-${type} alert-dismissible fade show`;
    alertContainer.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)}"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of main content
    const mainContent = document.querySelector('.main-content .content');
    if (mainContent) {
        mainContent.insertBefore(alertContainer, mainContent.firstChild);
    }
    
    // Auto dismiss after duration
    if (duration > 0) {
        setTimeout(() => {
            if (alertContainer.parentNode) {
                alertContainer.remove();
            }
        }, duration);
    }
}

/**
 * Get appropriate icon for alert type
 */
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'danger': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

/**
 * Smooth scroll to element
 */
function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

/**
 * Format number with thousand separators
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Debounce function for performance optimization
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export functions for global use
window.Dashboard = {
    showAlert,
    showButtonLoading,
    hideButtonLoading,
    smoothScrollTo,
    formatNumber,
    debounce
};
