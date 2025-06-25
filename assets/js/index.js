// index.js - extracted from index.php

// DOM ready execution
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        // Our Classes Popup Logic
        const classTriggers = {
            'spag-main': '.spag',
            'creative-writing-main': '.creative-writing',
            'comprehension-main': '.comprehension',
            'vocabulary-main': '.vocabulary',
            'late-Teens-main': '.Late-teens'
        };

        // Add event listeners to trigger elements
        Object.keys(classTriggers).forEach(triggerClass => {
            const triggerElement = document.querySelector('.' + triggerClass);
            const targetPopupSelector = classTriggers[triggerClass];
            const targetPopup = document.querySelector(targetPopupSelector);
            if (triggerElement && targetPopup) {
                triggerElement.addEventListener('click', e => {
                    e.preventDefault();
                    targetPopup.classList.add('active');
                    document.body.classList.add('popup-open');
                    const closeBtn = targetPopup.querySelector('.btn-close');
                    if (closeBtn) closeBtn.focus();
                });
            }
        });

        // Add event listeners to close buttons
        document.querySelectorAll('.ourClassContainer .btn-close').forEach(button => {
            button.addEventListener('click', () => {
                const popup = button.closest('.ourClassContainer');
                if (popup) {
                    popup.classList.remove('active');
                    document.body.classList.remove('popup-open');
                }
            });
        });

        // Close popups on Escape key press
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                document.querySelectorAll('.ourClassContainer.active, .newsLetterContainer.active').forEach(popup => {
                    popup.classList.remove('active');
                });
                document.body.classList.remove('popup-open');
            }
        });

        // Newsletter Popup Logic
        const sendBtn = document.getElementById('sendMeBtn');
        const readingTipsMainBtn = document.querySelector('.reading-tips-btn');
        const newsLetterContainer = document.querySelector('.newsLetterContainer');
        const newsCloseBtn = newsLetterContainer ? newsLetterContainer.querySelector('.btn-close') : null;
        const formTitle = document.getElementById('formTitle');
        const formDescription = document.getElementById('formDescription');
        const tipTypeInput = document.getElementById('tipType');

        function openNewsletterPopup(type) {
            if (!newsLetterContainer) return;
            newsLetterContainer.classList.add('active');
            document.body.classList.add('popup-open');
            if (formTitle && formDescription && tipTypeInput) {
                if (type === 'comprehension_creative_writing') {
                    formTitle.textContent = 'Get Your FREE Comprehension & Creative Writing Tips';
                    formDescription.textContent = 'Expert strategies for 11+ exam success. Enter your details below to receive your tips.';
                    tipTypeInput.value = 'comprehension_creative_writing';
                } else if (type === 'reading_tips') {
                    formTitle.textContent = 'Get Your FREE Reading Tips for Parents';
                    formDescription.textContent = 'A guide to help your child love reading. Enter your details below to receive your tips.';
                    tipTypeInput.value = 'reading_tips';
                }
            }
            setTimeout(() => {
                const nameInput = document.getElementById('n_name');
                if (nameInput) nameInput.focus();
            }, 100);
        }

        if (sendBtn) {
            sendBtn.addEventListener('click', () => openNewsletterPopup('comprehension_creative_writing'));
        }
        if (readingTipsMainBtn) {
            readingTipsMainBtn.addEventListener('click', () => openNewsletterPopup('reading_tips'));
        }
        if (newsCloseBtn) {
            newsCloseBtn.addEventListener('click', () => {
                newsLetterContainer.classList.remove('active');
                document.body.classList.remove('popup-open');
            });
        }
        if (newsLetterContainer) {
            newsLetterContainer.addEventListener('click', event => {
                if (event.target === newsLetterContainer) {
                    newsLetterContainer.classList.remove('active');
                    document.body.classList.remove('popup-open');
                }
            });
        }

        // Also close popups when clicking outside the content
        document.querySelectorAll('.ourClassContainer').forEach(container => {
            container.addEventListener('click', e => {
                if (e.target === container) {
                    container.classList.remove('active');
                    document.body.classList.remove('popup-open');
                }
            });
        });

        // Newsletter Form AJAX Submission
        if (typeof jQuery !== 'undefined') {
            $(document).ready(function () {
                function handleEmailValidation(isValid, message, $emailField, $errorSpan) {
                    const $parentDiv = $emailField.parent();
                    if (!isValid) {
                        $emailField.addClass('is-invalid').removeClass('is-valid');
                        $parentDiv.addClass('form_error');
                        $errorSpan.text(message).css('color', 'red');
                        $emailField.val('');
                        if (typeof toastr !== 'undefined') toastr.warning(message);
                    } else {
                        $emailField.removeClass('is-invalid').addClass('is-valid');
                        $parentDiv.removeClass('form_error');
                        if ($errorSpan.text() !== 'We will not share your email with anyone.') {
                            $errorSpan.text('We will not share your email with anyone.').css('color', '');
                        }
                    }
                }

                $(document).on('blur', '#n_email', function () {
                    var valmail = $(this).val().trim();
                    var $emailField = $(this);
                    var $errorSpan = $emailField.siblings('span');
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (valmail === '') {
                        $emailField.removeClass('is-invalid is-valid');
                        $errorSpan.text('We will not share your email with anyone.').css('color', '');
                        return;
                    } else if (!emailRegex.test(valmail)) {
                        handleEmailValidation(false, 'Please enter a valid email address.', $emailField, $errorSpan);
                        return;
                    }
                    $.ajax({
                        url: 'tipAction.php',
                        method: 'POST',
                        data: { check_email: valmail },
                        dataType: 'json',
                        success: function (rep) {
                            if (rep.status === 'exists') {
                                handleEmailValidation(true, 'Already Subscribed, Thank You.', $emailField, $errorSpan);
                            } else if (rep.status === 'valid') {
                                handleEmailValidation(true, '', $emailField, $errorSpan);
                            } else {
                                handleEmailValidation(true, '', $emailField, $errorSpan);
                            }
                        },
                        error: function () {
                            $emailField.removeClass('is-invalid is-valid');
                            $errorSpan.text('Could not verify email. Please try again.').css('color', 'orange');
                        }
                    });
                });

                $(document).on('submit', '#newsPop', function (e) {
                    e.preventDefault();
                    var $form = $(this);
                    var name = $('#n_name').val().trim();
                    var email = $('#n_email').val().trim();
                    var tipType = $('#tipType').val().trim();
                    var isChecked = $('#privacyCheck').is(':checked');
                    var $submitButton = $form.find('.subscribeBtn');
                    var isValid = true;
                    $form.find('.form-control').removeClass('is-invalid is-valid');
                    $form.find('.form-check-input').removeClass('is-invalid');
                    $form.find('span').text('').css('color', '');
                    if (name === '') {
                        $('#n_name').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#n_name').addClass('is-valid');
                    }
                    if (email === '') {
                        $('#n_email').addClass('is-invalid');
                        $('#n_email').siblings('span').text('Email is required.').css('color', 'red');
                        isValid = false;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        $('#n_email').addClass('is-invalid');
                        $('#n_email').siblings('span').text('Please enter a valid email address.').css('color', 'red');
                        isValid = false;
                    } else {
                        $('#n_email').addClass('is-valid');
                        $('#n_email').siblings('span').text('We will not share your email with anyone.').css('color', '');
                    }
                    if (!isChecked) {
                        if (typeof toastr !== 'undefined') toastr.error('Please check the privacy policy box.');
                        return;
                    }
                    if (!isValid) {
                        return;
                    }
                    $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subscribing...');
                    $.ajax({
                        type: 'POST',
                        url: 'tipAction.php',
                        data: {
                            n_name: name,
                            n_email: email,
                            tip_type: tipType,
                            action: 'newsletter'
                        },
                        dataType: 'json',
                        success: function (response) {
                            $form[0].reset();
                            $form.find('.form-control').removeClass('is-valid is-invalid');
                            $form.find('.form-check-input').removeClass('is-invalid');
                            $form.find('span').text('').css('color', '');
                            if (newsLetterContainer) {
                                newsLetterContainer.classList.remove('active');
                                document.body.classList.remove('popup-open');
                            }
                            if (response.status === 'success') {
                                if (typeof toastr !== 'undefined') toastr.success(response.message || 'Successfully subscribed!', { timeOut: 5000 });
                            } else {
                                if (typeof toastr !== 'undefined') toastr.error(response.message || 'Subscription failed. Please try again.');
                                if (response.field === 'email') {
                                    $('#n_email').addClass('is-invalid').removeClass('is-valid');
                                    $('#n_email').siblings('span').text(response.message).css('color', 'red');
                                }
                            }
                        },
                        error: function () {
                            if (typeof toastr !== 'undefined') toastr.error('An error occurred during subscription. Please try again later.');
                        },
                        complete: function () {
                            $submitButton.prop('disabled', false).text('GET MY FREE TIPS');
                        }
                    });
                });
            });
        } else {
            console.error('jQuery is not loaded. Newsletter form submission might not work.');
        }

        // Initialize Bootstrap components if needed
        const CarouselElements = document.querySelectorAll('.Carousel');
        if (CarouselElements.length > 0 && typeof bootstrap !== 'undefined') {
            CarouselElements.forEach(element => {
                new bootstrap.Carousel(element, {
                    interval: 8000,
                    ride: 'Carousel'
                });
            });
        }

        // Make entire class cards clickable
        document.querySelectorAll('.class-card').forEach(card => {
            card.addEventListener('click', function () {
                for (const triggerClass in classTriggers) {
                    if (this.classList.contains(triggerClass)) {
                        const popup = document.querySelector(classTriggers[triggerClass]);
                        if (popup) {
                            popup.classList.add('active');
                            document.body.classList.add('popup-open');
                            const closeBtn = popup.querySelector('.btn-close');
                            if (closeBtn) closeBtn.focus();
                        }
                        break;
                    }
                }
            });
        });

        // Scroll indicator functionality
        const scrollIndicator = document.getElementById('scrollIndicator');
        if (scrollIndicator) {
            scrollIndicator.addEventListener('click', function () {
                const nextSection = document.querySelector('.hero-section')?.nextElementSibling;
                if (nextSection) {
                    nextSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
            window.addEventListener('scroll', function () {
                if (window.scrollY > 100) {
                    scrollIndicator.style.opacity = '0';
                    scrollIndicator.style.transition = 'opacity 0.3s ease';
                } else {
                    scrollIndicator.style.opacity = '1';
                }
            });
        }
    });
})();
