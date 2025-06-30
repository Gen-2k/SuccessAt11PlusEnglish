// index.js - Refactored and Corrected

(function ($) {
    // Use jQuery's DOM ready for consistency since it's a dependency
    $(function () {
        // --- Our Classes Popup Logic ---
        const classTriggers = {
            'spag-main': '.spag',
            'creative-writing-main': '.creative-writing',
            'comprehension-main': '.comprehension',
            'vocabulary-main': '.vocabulary',
            'late-Teens-main': '.Late-teens'
        };

        // REFACTOR: More efficient click handler for class cards
        $('.class-card').on('click', function (e) {
            e.preventDefault();
            const card = $(this);
            // Find the matching trigger class from our map
            for (const triggerClass in classTriggers) {
                if (card.hasClass(triggerClass)) {
                    const popupSelector = classTriggers[triggerClass];
                    const $popup = $(popupSelector);
                    if ($popup.length) {
                        $popup.addClass('active');
                        $('body').addClass('popup-open');
                        $popup.find('.btn-close').trigger('focus');
                    }
                    break; // Exit loop once a match is found
                }
            }
        });

        // Add event listeners to close buttons for "Our Classes" popups
        $('.ourClassContainer .btn-close').on('click', function () {
            $(this).closest('.ourClassContainer').removeClass('active');
            // Check if any other popups are open before removing the body class
            if ($('.ourClassContainer.active, .newsLetterContainer.active').length === 0) {
                $('body').removeClass('popup-open');
            }
        });

        // --- Event Listeners for Opening/Closing Popups ---
        // Newsletter popup handlers are now in footer.php for global availability
        // but we still support special trigger buttons on the index page
        const sendMeBtn = document.getElementById('sendMeBtn');
        if (sendMeBtn && window.openNewsletterPopup) {
            sendMeBtn.addEventListener('click', () => window.openNewsletterPopup('comprehension_creative_writing'));
        }
        
        const readingTipsBtns = document.querySelectorAll('.reading-tips-btn');
        if (readingTipsBtns.length && window.openNewsletterPopup) {
            readingTipsBtns.forEach(btn => {
                btn.addEventListener('click', () => window.openNewsletterPopup('reading_tips'));
            });
        }

        // CONSOLIDATED: Single 'Escape' key listener for our classes popups only
        $(document).on('keydown', function (event) {
            if (event.key === 'Escape') {
                $('.ourClassContainer.active').removeClass('active');
                // Check if any popups are still open before removing body class
                if ($('.ourClassContainer.active, .newsLetterContainer.active').length === 0) {
                    $('body').removeClass('popup-open');
                }
            }
        });

        // --- Component Initializations ---

        // FIX: Corrected Bootstrap Carousel initialization
        const $carouselElement = $('.carousel'); // Lowercase 'c'
        if ($carouselElement.length && typeof bootstrap !== 'undefined') {
            new bootstrap.Carousel($carouselElement[0], {
                interval: 5000, // interval should be a number
                ride: 'carousel'  // Lowercase 'c'
            });
        }

        // Scroll indicator functionality
        const scrollIndicator = $('#scrollIndicator');
        if (scrollIndicator.length) {
            scrollIndicator.on('click', function () {
                const nextSection = $('.hero-section').next();
                if (nextSection.length) {
                    $('html, body').animate({
                        scrollTop: nextSection.offset().top
                    }, 'smooth');
                }
            });

            $(window).on('scroll', function () {
                scrollIndicator.css('opacity', $(window).scrollTop() > 100 ? '0' : '1');
            });
        }
    });
})(jQuery);