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


        // --- Newsletter Popup Logic ---
        const $newsLetterContainer = $('.newsLetterContainer');
        const $formTitle = $('#formTitle');
        const $formDescription = $('#formDescription');
        const $tipTypeInput = $('#tipType');
        const $newsForm = $('#newsPop');

        const DEFAULT_FORM_TITLE = 'Subscribe to our Newsletter';
        const DEFAULT_FORM_DESCRIPTION = 'Enter your details below to subscribe to our newsletter and receive updates.';

        function openNewsletterPopup(type = '') {
            if (!$newsLetterContainer.length) return;

            // Reset form state every time it opens
            $newsForm[0].reset();
            $newsForm.find('.form-control').removeClass('is-valid is-invalid');
            $newsForm.find('span').text('').css('color', '');
            $newsForm.find('button[type="submit"]').prop('disabled', false);

            // Configure popup content based on type
            if (type === 'comprehension_creative_writing') {
                $formTitle.text('Get Your FREE Comprehension & Creative Writing Tips');
                $formDescription.text('Expert strategies for 11+ exam success. Enter your details below to receive your tips.');
                $tipTypeInput.val('comprehension_creative_writing');
                $newsForm.find('button[type="submit"]').text('GET MY FREE TIPS');
            } else if (type === 'reading_tips') {
                $formTitle.text('Get Your FREE Reading Tips for Parents');
                $formDescription.text('A guide to help your child love reading. Enter your details below to receive your tips.');
                $tipTypeInput.val('reading_tips');
                $newsForm.find('button[type="submit"]').text('GET MY FREE TIPS');
            } else {
                $formTitle.text(DEFAULT_FORM_TITLE);
                $formDescription.text(DEFAULT_FORM_DESCRIPTION);
                $tipTypeInput.val('');
                $newsForm.find('button[type="submit"]').text('Subscribe');
            }

            $newsLetterContainer.addClass('active');
            $('body').addClass('popup-open');
            setTimeout(() => $('#n_name').trigger('focus'), 100);
        }

        // --- Event Listeners for Opening/Closing Popups ---
        $('#sendMeBtn').on('click', () => openNewsletterPopup('comprehension_creative_writing'));
        $('.reading-tips-btn').on('click', () => openNewsletterPopup('reading_tips'));
        $('#openNewsletterPopupBtn').on('click', () => openNewsletterPopup());

        // Close newsletter popup via close button or backdrop click
        $newsLetterContainer.on('click', function (event) {
            if (event.target === this || $(event.target).hasClass('btn-close')) {
                $newsLetterContainer.removeClass('active');
                if ($('.ourClassContainer.active').length === 0) {
                    $('body').removeClass('popup-open');
                }
            }
        });
        
        // CONSOLIDATED: Single 'Escape' key listener for all popups
        $(document).on('keydown', function (event) {
            if (event.key === 'Escape') {
                $('.ourClassContainer.active, .newsLetterContainer.active').removeClass('active');
                $('body').removeClass('popup-open');
            }
        });

        // --- Newsletter Form AJAX Submission ---
        $newsForm.on('submit', function (e) {
            e.preventDefault();
            const $form = $(this);
            const name = $('#n_name').val().trim();
            const email = $('#n_email').val().trim();
            const $submitButton = $form.find('button[type="submit"]');
            
            // Basic client-side validation
            let isValid = true;
            $form.find('.form-control').removeClass('is-invalid is-valid');
            $form.find('span').text('').css('color', '');

            if (name === '') {
                $('#n_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#n_name').addClass('is-valid');
            }

            if (email === '') {
                $('#n_email').addClass('is-invalid').siblings('span').text('Email is required.').css('color', 'red');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                $('#n_email').addClass('is-invalid').siblings('span').text('Please enter a valid email address.').css('color', 'red');
                isValid = false;
            } else {
                $('#n_email').addClass('is-valid').siblings('span').text('We will not share your email with anyone.').css('color', '');
            }

            if (!isValid) return;

            $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subscribing...');

            $.ajax({
                type: 'POST',
                url: 'tipAction.php',
                data: $form.serialize() + '&action=newsletter', // Use serialize for simplicity
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $newsLetterContainer.removeClass('active');
                        $('body').removeClass('popup-open');
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message || 'Successfully subscribed!', { timeOut: 5000 });
                        }
                    } else {
                        // FIX: Keep the modal open on error to show field-specific messages
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Subscription failed. Please try again.');
                        }
                        if (response.field === 'email') {
                            $('#n_email').addClass('is-invalid').removeClass('is-valid');
                            $('#n_email').siblings('span').text(response.message).css('color', 'red');
                        }
                    }
                },
                error: function () {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('An error occurred. Please try again later.');
                    }
                },
                complete: function () {
                    // Re-enable button and restore text
                    const buttonText = $tipTypeInput.val() ? 'GET MY FREE TIPS' : 'Subscribe';
                    $submitButton.prop('disabled', false).text(buttonText);
                }
            });
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