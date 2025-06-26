<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Success At 11 Plus English - Apply for a Trial Class">
    <title>Success At 11 Plus English | Apply for a Trial Class</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <style>
        :root {
            --theme-blue: #1E40AF;
            --theme-blue-dark: #1e3a8a;
            --theme-gold: #F59E0B;
            --theme-gold-dark: #d97706;
            --text-muted: #6c757d;
            --heading-color: #343a40;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --card-border: #dee2e6;
        }
        
        body {
            background-color: var(--body-bg);
            font-family: 'Varela Round', sans-serif;
            color: #495057;
            line-height: 1.7;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Source Serif Pro', serif;
            font-weight: 600;
            color: var(--heading-color);
        }
        
        .form-container {
            padding: 3rem 0;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.03), rgba(30, 64, 175, 0.08));
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .page-title h1 {
            color: var(--theme-blue);
            font-weight: 700;
            font-size: 2.4rem;
            margin-bottom: 0.5rem;
        }
        
        .page-title p {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 650px;
            margin: 0 auto;
        }
        
        .trial-form-card {
            background: var(--card-bg);
            border-radius: 16px;
            border-top: 5px solid var(--theme-blue);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin: 1rem auto;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark));
            color: white;
            padding: 1.75rem;
            border-bottom: none;
            position: relative;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(90deg, var(--theme-blue), var(--theme-blue-dark), var(--theme-blue));
            opacity: 0.6;
        }
        
        .card-header h2 {
            margin-bottom: 0;
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .card-header .accent {
            color: var(--theme-gold);
            font-weight: 700;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 0.5rem;
            color: var(--theme-blue);
            font-size: 1.1rem;
        }
        
        .form-control, .form-select {
            padding: 0.85rem 1rem;
            font-size: 1rem;
            border-radius: 10px;
            border: 1px solid #dde1e7;
            margin-bottom: 1.25rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--theme-blue);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.15);
        }
        
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%231E40AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }
        
        .benefits-list {
            background: linear-gradient(to right, rgba(30, 64, 175, 0.03), rgba(30, 64, 175, 0.08));
            border-radius: 12px;
            padding: 1.75rem;
            margin-bottom: 2.25rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
            border-left: 4px solid var(--theme-blue);
        }
        
        .benefits-list h3 {
            color: var(--theme-blue);
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
        }

        .benefits-list h3 i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .benefits-list ul {
            padding-left: 1.8rem;
            margin-bottom: 0;
        }
        
        .benefits-list li {
            margin-bottom: 0.75rem;
            position: relative;
            padding-left: 0.5rem;
        }
        
        .benefits-list li:last-child {
            margin-bottom: 0;
        }
        
        .submit-container {
            margin-top: 1.5rem;
        }
        
        .btn-apply {
            background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark));
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.15rem;
            padding: 1rem 2rem;
            border-radius: 100px;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.35);
        }
        
        .btn-apply::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(255, 255, 255, 0.1), transparent);
            opacity: 0.6;
        }
        
        .btn-apply span, 
        .btn-apply i {
            position: relative;
            color: white !important;
        }
        
        .btn-apply:hover {
            background: linear-gradient(135deg, var(--theme-blue-dark), var(--theme-blue));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.5);
            color: #ffffff !important;
        }
        
        .btn-apply:active,
        .btn-apply:focus {
            transform: translateY(1px);
            color: #ffffff !important;
            outline: none;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.4);
        }
        
        .btn-apply i {
            margin-right: 0.75rem;
            font-size: 1.4rem;
        }
        
        .form-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: -1rem;
            margin-bottom: 1rem;
        }
        
        .note-text {
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 1.5rem;
        }
        
        .form-divider {
            margin: 1.5rem 0;
            border-top: 1px dashed #dde1e7;
            position: relative;
        }
        
        .form-divider::before {
            content: "Student Information";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 0 1rem;
            color: var(--theme-blue);
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        @media (max-width: 767.98px) {
            .card-header h2 {
                font-size: 1.8rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .page-title h1 {
                font-size: 2rem;
            }
            
            .btn-apply {
                padding: 0.85rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="sticky-sm-top">
        <?php include('navbar2.php') ?>
    </div>
    
    <div class="container-fluid form-container">
    <div class="container">
<?php
// Display status messages from session if they exist (for non-AJAX form submissions)
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];
    
    // Create appropriate alert type
    $alert_class = ($status_code === 'success') ? 'alert-success' : 'alert-danger';
    $icon = ($status_code === 'success') 
        ? '<i class="bi bi-check-circle-fill me-2"></i>' 
        : '<i class="bi bi-exclamation-triangle-fill me-2"></i>';
    
    echo '<div class="row justify-content-center mb-4">';
    echo '<div class="col-xl-8 col-lg-9 col-md-11">';
    echo '<div class="alert ' . $alert_class . '">' . $icon . $status . '</div>';
    echo '</div>';
    echo '</div>';
    
    // Clear the session variables
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
            <div class="page-title">
                <h1>Trial Classes Available</h1>
                <p>Experience our expert tutoring firsthand before committing to any of our programs</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-11">
                    <div class="trial-form-card">
                        <div class="card-header text-center">
                            <h2>Apply for a <span class="accent">Trial</span> Class</h2>
                        </div>
                        <div class="card-body">
                            <!-- <div class="benefits-list">
                                <h3><i class="bi bi-stars"></i>Why Try Our Classes?</h3>
                                <ul>
                                    <li>Experience our teaching methodology firsthand with expert tutors</li>
                                    <li>Assess our teaching style and approach to learning</li>
                                    <li>Understand how we support your child's learning journey</li>
                                    <li>No obligation – determine if our approach suits your child's needs</li>
                                </ul>
                            </div> -->

                <form action="./enqcode.php" method="POST" id="trial-form" class="needs-validation" novalidate>
                    <!-- Hidden field to ensure eqTry is always set for trial applications -->
                    <input type="hidden" name="eqTry" value="1">
                    <div class="row">
                        <div class="col-12">
                            <label for="fname" class="form-label"><i class="bi bi-person-fill"></i>Full Name</label>
                            <input type="text" id="fname" name="eqName" class="form-control" placeholder="Enter your full name" required>
                        </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i>Email Address</label>
                                        <input type="email" id="email" name="eqMail" class="form-control" placeholder="Enter your email address" required>
                                        <div class="form-text">We'll never share your email with others</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="phn" class="form-label"><i class="bi bi-telephone-fill"></i>Phone Number</label>
                                        <input type="text" id="phn" name="eqPhone" class="form-control" pattern="[0-9]+" placeholder="Enter your phone number" required>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-divider"></div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="apfor" class="form-label"><i class="bi bi-mortarboard-fill"></i>Year Group</label>
                                        <select id="apfor" name="eqApply" class="form-select" required>
                                            <option value="">Select a year group</option>
                        <option value="Year 4">Year 4</option>
                        <option value="Year 5">Year 5</option>
                        <option value="Year 6">Year 6</option>
                    </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="module" class="form-label"><i class="bi bi-book-fill"></i>Module Interest</label>
                                        <select id="module" name="eqModule" class="form-select" required>
                                            <option value="">Select a module</option>
                                            <option value="Comprehension">Comprehension</option>
                                            <option value="Creative Writing">Creative Writing</option>
                                            <option value="SPaG">SPaG (Spelling, Punctuation & Grammar)</option>
                                            <option value="Vocabulary">Vocabulary</option>
                                            <option value="Verbal Reasoning" class="vr-option">Verbal Reasoning</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="msg" class="form-label"><i class="bi bi-chat-left-text-fill"></i>Additional Information</label>
                                        <textarea id="msg" name="eqMsg" class="form-control" rows="3" placeholder="Please let us know of any specific requirements or questions"></textarea>
                                    </div>
                                    
                                    <div class="col-12 submit-container">
                                        <button type="submit" name="eqTry" class="btn btn-apply w-100">
                                            <i class="bi bi-check2-circle"></i>
                                            <span>Submit Application</span>
                    </button>
                                        <!-- <div class="note-text">
                                            Our team will contact you within 24 hours to arrange your trial class
                                        </div> -->
                                    </div>
                                </div>
                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // Form submission with AJAX
        $('#trial-form').on('submit', function(e) {
            e.preventDefault();
            
            // Remove any existing alerts before validation
            $('.alert').remove();
            
            // Form validation
            if (this.checkValidity() === false) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                
                // Show an error message
                $('<div class="alert alert-danger mb-4">' +
                    '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
                    'Please fill in all required fields before submitting.' +
                    '</div>').insertBefore('#trial-form button[type="submit"]');
                
                // Scroll to first error
                let firstError = $(this).find(':invalid').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                    
                    // Add visual indication to the first error field
                    firstError.addClass('is-invalid').focus();
                    if (!firstError.next('.invalid-feedback').length) {
                        firstError.after('<div class="invalid-feedback">' + (firstError[0].validationMessage || 'This field is required') + '</div>');
                    }
                }
                return;
            }
            
            // Show loading indicator
            let submitBtn = $(this).find('button[type="submit"]');
            let originalBtnText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...');
            submitBtn.prop('disabled', true);
            
            // Get form data
            let formData = $(this).serialize();
            
            console.log('Submitting form data:', formData);
            
            // Send the AJAX request
            $.ajax({
                url: './enqcode.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    console.log('Response received:', response);
                    
                    // Reset the button
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    
                    if (response.status === 'success') {
                        // Load and display the thank you message
                        $.get('thank-you-inline.php', function(thankyouContent) {
                            $('#trial-form').html(thankyouContent);
                            
                            // Scroll to top of form
                            $('html, body').animate({
                                scrollTop: $('#trial-form').offset().top - 100
                            }, 500);
                            
                            // Set a cookie or localStorage item to show they've applied
                            localStorage.setItem('trialClassApplied', 'true');
                        });
                    } else {
                        // Show error message
                        $('<div class="alert alert-danger mb-4">' +
                            '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
                            (response.message || 'There was a problem submitting your application. Please try again or contact us directly.') +
                            '</div>').insertBefore('#trial-form button[type="submit"]');
                            
                        // Scroll to error
                        $('html, body').animate({
                            scrollTop: $('.alert-danger').offset().top - 100
                        }, 500);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                    console.error('Response text:', xhr.responseText);

                    // Reset the button
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);

                    // Determine error message
                    let errorMessage = 'There was a problem submitting your application. Please try again or contact us directly.';
                    // Check if the response is JSON and contains a message
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        // Fallback for non-JSON responses or unexpected server errors
                        // Avoid showing raw server errors to the user
                        errorMessage = 'A server error occurred. Please try again or contact us directly.';
                    }

                    // Remove any existing alerts before showing the new one
                    $('.alert').remove();

                    // Show the error
                    $('<div class="alert alert-danger mb-4">' +
                        '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
                        errorMessage +
                        '</div>').insertBefore('#trial-form button[type="submit"]');

                    // Scroll to error
                    $('html, body').animate({
                        scrollTop: $('.alert-danger').offset().top - 100
                    }, 500);
                },
                timeout: 15000, // 15 second timeout
                complete: function() {
                    // Always make sure button is re-enabled in case of any errors
                    if (submitBtn.prop('disabled')) {
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                    }
                }
            });
        });
        
        // Real-time validation as user types/changes fields
        $('#trial-form input, #trial-form select, #trial-form textarea').on('input blur', function() {
            validateField($(this));
        });
        
        // Phone number validation - allow only numbers
        $('#phn').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
            validateField($(this));
        });
        
        // Function to validate a single field
        function validateField($field) {
            // Remove existing feedback
            $field.next('.invalid-feedback, .valid-feedback').remove();
            
            if ($field.val() === '') {
                // Empty field
                $field.removeClass('is-valid').addClass('is-invalid');
                $field.after('<div class="invalid-feedback">This field is required</div>');
                return false;
            } else if (!$field[0].checkValidity()) {
                // Invalid according to HTML5 validation
                $field.removeClass('is-valid').addClass('is-invalid');
                $field.after('<div class="invalid-feedback">' + ($field[0].validationMessage || 'Please enter a valid value') + '</div>');
                return false;
            } else {
                // Additional specific validations
                if ($field.attr('id') === 'email') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test($field.val())) {
                        $field.removeClass('is-valid').addClass('is-invalid');
                        $field.after('<div class="invalid-feedback">Please enter a valid email address</div>');
                        return false;
                    }
                } else if ($field.attr('id') === 'phn') {
                    if ($field.val().length < 10) {
                        $field.removeClass('is-valid').addClass('is-invalid');
                        $field.after('<div class="invalid-feedback">Please enter a valid phone number</div>');
                        return false;
                    }
                }
                
                // All validation passed
                $field.removeClass('is-invalid').addClass('is-valid');
                return true;
            }
        }
        
        // Clear validation on focus
        $('#trial-form input, #trial-form select, #trial-form textarea').on('focus', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        
        // Handle year group selection to show/hide Verbal Reasoning
        $('#apfor').on('change', function() {
            const selectedYear = $(this).val();
            const vrOption = $('#module option[value="Verbal Reasoning"]');
            const moduleSelect = $('#module');
            
            if (selectedYear === 'Year 6') {
                // Hide Verbal Reasoning for Year 6
                vrOption.hide();
                // If Verbal Reasoning was selected, reset the selection
                if (moduleSelect.val() === 'Verbal Reasoning') {
                    moduleSelect.val('');
                    // Remove validation styling if present
                    moduleSelect.removeClass('is-valid is-invalid');
                    moduleSelect.next('.invalid-feedback, .valid-feedback').remove();
                }
            } else {
                // Show Verbal Reasoning for Year 4 and 5
                vrOption.show();
            }
        });
        
        // Initialize the module options based on current year selection
        $('#apfor').trigger('change');
    });
    </script>
</body>

</html>