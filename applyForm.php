<?php
if (!isset($_SESSION)) {
    session_start();
}

// Handle both old and new parameter formats for backward compatibility
if (isset($_GET['class']) && isset($_GET['module'])) {
    // New simplified format
    $_SESSION['classid'] = $_GET['class'];
    $_SESSION['courseName'] = $_GET['class'] . ' - ' . $_GET['module'];
    $_SESSION['courseId'] = $_GET['class'];
    $_SESSION['module'] = $_GET['module'];
} elseif (isset($_GET['lan']) && $_GET['course']) {
    // Old format for backward compatibility
    $_SESSION['classid'] = $_GET['lan'];
    $_SESSION['courseName'] = $_GET['courseName'];
    $_SESSION['courseId'] = $_GET['course'];
}

function formatCourseTitle($title) {
    // Capitalize first letter of each word, but keep numbers as is
    return preg_replace_callback('/\b([a-z])/', function($matches) {
        return strtoupper($matches[1]);
    }, $title);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- datapicker -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="icon" type="image/x-icon" href="./assets/favicons/favicon.ico">

    <!-- css link -->
    <link rel="stylesheet" href="applyformstyle/style.css">
    <title>Success at 11 Plus English</title>
</head>


<body>
    <div class="position-fixed loading d-none justify-content-center align-items-center">
        <img src="./assets/load1.gif" class="user-select-none">
    </div>
    <div class="form_bg_container">
        <div class="container form_container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card box_shad">                        <form class="needs-validation" id="formdata" autocomplete="on" novalidate name="applyForm" method="POST" action="formAction.php">                            <!-- Hidden inputs -->
                            <input type="hidden" name="classid" value="<?php print_r($_SESSION['classid']); ?>">
                            <input type="hidden" id="studentCourse" name="studentCourse" value="<?php echo isset($_GET['course']) ? $_GET['course'] : (isset($_GET['class']) ? $_GET['class'] : ''); ?>">
                            <?php if (isset($_SESSION['module']) || isset($_GET['module'])): ?>
                            <input type="hidden" name="module" value="<?php echo isset($_GET['module']) ? $_GET['module'] : $_SESSION['module']; ?>">
                            <?php endif; ?>
                            <!-- Student Details --><div class="form_tab form_tab_active">
                                <h1 class="page-title">
                                    <?php
                                        $rawTitle = isset($_GET['courseName']) ? $_GET['courseName'] : (isset($_SESSION['courseName']) ? $_SESSION['courseName'] : '');
                                        echo formatCourseTitle($rawTitle);
                                    ?>
                                </h1>
                                <h2 class="section-heading">Student Details</h2>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <label for="FirstName" class="form-label h5 fw-bold" name="fName">First name</label>
                                        <input type="text" name="fname" class="form-control shadow-none" placeholder="Enter first name" id="FirstName" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid first name.
                                        </small>
                                    </div>
                                    <div class="col-md ">
                                        <label for="SurName" class="form-label h5 fw-bold" name="Surname">Surname</label>
                                        <input type="text" name="surname" class="form-control shadow-none" id="SurName" placeholder="Enter surname" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid surname.
                                        </small>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="dateOfBirth" class="form-label h5 fw-bold" name="Date of Birth">Date of Birth</label>
                                        <input type="text" name="dob" class="form-control datepicker shadow-none" id="dateOfBirth"
                                            placeholder="MM/DD/YYYY" pattern="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$"
                                            aria-describedby="dobHelp" autocomplete="off" required readonly>
                                        <small id="dobHelp" class="invalid-feedback">
                                            Please select a valid date of birth (MM/DD/YYYY) within the allowed age range.
                                        </small>
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label h5 fw-bold">Gender</label> <br>
                                        <input type="radio" id="male" name="gender" value="male" checked>
                                        <label for="male" class="form-label user-select-none me-2 cursorPointer fw-bold fs-5">Male</label>

                                        <input type="radio" id="female" name="gender" value="female">
                                        <label for="female" class="form-label user-select-none me-2 cursorPointer fw-bold fs-5">Female</label>
                                    </div>
                                </div>


                                <div class="mt-3 nextPrevBtn">
                                    <button class="btn btn-primary shadow-none nextButton1" type="button">Next</button>
                                </div>

                            </div>                            <!-- 1st Parent's Details -->                            <div class="form_tab">
                                <h1 class="page-title"><?php echo isset($_GET['courseName']) ? $_GET['courseName'] : $_SESSION['courseName']; ?></h1>
                                <h2 class="section-heading">Parent Details</h2>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <label for="parentFirstName" class="form-label h5 fw-bold">First name</label>
                                        <input type="text" name="parentfirstname" class="form-control shadow-none" placeholder="Enter first name" id="parentFirstName" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid first name.
                                        </small>
                                    </div>
                                    <div class="col-md">
                                        <label for="parentSurName" class="form-label h5 fw-bold">Surname</label>
                                        <input type="text" name="parentsurname" class="form-control shadow-none" id="parentSurName" pattern="\S(.*\S)? ||[a-zA-Z]+" placeholder="Enter surname" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid surname.
                                        </small>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="parentAddress" class="h5 fw-bold">Address</label>
                                        <textarea class="form-control shadow-none" name="address" id="parentAddress" rows="3" placeholder="Enter your current address" minlength="12" pattern=".*\S+.*" required></textarea>
                                        <small class="invalid-feedback">
                                            Please enter your current address.
                                        </small>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="Email" class="form-label h5 fw-bold">Email Address</label>
                                        <input type="email" name="email" class="form-control shadow-none" id="email" placeholder="Enter email address" pattern="\S(.*\S)?" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid email address.
                                        </small>
                                        <span class="fs-6"></span>
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="phoneNumber" class="form-label h5 fw-bold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control shadow-none" minlength="10" maxlength="11" pattern="^(?:\d{11}|\d{10})$" id="phoneNumber" placeholder="Enter phone number" required>
                                        <small class="invalid-feedback">
                                            Please enter a valid phone number.
                                        </small>
                                    </div>
                                </div>
                                <div class="mt-3 nextPrevBtn justify-content-between ">
                                    <button class="btn btn-primary shadow-none priviousbtn1" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none nextButton2" type="button">Next</button>
                                </div>
                            </div>

                            <!-- Data Protection & Terms and Conditions -->
                            <div class="form_tab">
                                <div class="h3 fw-bold">
                                    Data Protection & Terms and Conditions
                                </div>
                                <div class="mb-3">
                                    <p class="fw-bold">I hereby consent to protect all the course materials and intellectual properties obtained
                                        or acquired by my child as a result of subscribing the course/s under Success at 11 Plus English.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition1" checked name="dataprotectioncondition1" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition1" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I shall not reproduce and/or distribute, allow reproduction and/or distribution
                                        of any such course material by any third party including but not limited to any of my
                                        family members for commercial or non-commercial purpose. Course materials are being provided to
                                        my child who had subscribed the course with Success at 11 Plus English and shall at all times be used
                                        solely by my child only.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition2" checked name="dataprotectioncondition2" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition2" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I understand that selling, commercial copying, hiring or lending of course materials are
                                        strictly prohibited. I consent to indemnify Success at 11 Plus English for any losses or damages
                                        resulting out of my failure to protect the course materials as mentioned above with my
                                        best endeavours.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition3" checked name="dataprotectioncondition3" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition3" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">Success at 11 Plus English will presume that the parents/other party has read and consented to all the
                                        terms and clauses in the agreement and NDA should they prefer not to return a signed
                                        copy of such documents and the student attends a class.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition4" checked name="dataprotectioncondition4" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition4" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I undertake that my child is under parental/guardian supervision, at all times, during
                                        the length of the class. I agree not to hold Success at 11 Plus English responsible, for being unable to
                                        supervise my child individually.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition5" checked name="dataprotectioncondition5" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition5" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mt-3 nextPrevBtn justify-content-between">
                                    <button class="btn btn-primary shadow-none priviousbtn2" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none nextButton3" type="button">Next</button>
                                </div>
                            </div>

                            <!-- Additional Terms and Conditions -->
                            <div class="form_tab">
                                <div class="h3 fw-bold">
                                    Additional Terms and Conditions
                                </div>
                                <div class="mb-3">
                                    <p class="fw-bold">By enrolling my child onto a Success at 11 Plus English course, I agree that I have read and will be
                                        bound by all the terms and conditions and policies, on the Success at 11 Plus English website.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition6" checked name="dataprotectioncondition6" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition6" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I understand that termly fees once paid are non-refundable.</p>
                                    <input type="checkbox" id="termsAndCondition7" checked name="dataprotectioncondition7" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition7" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I accept that no refund or partial refund will be given if a student leaves, part term.</p>
                                    <input type="checkbox" id="termsAndCondition8" checked name="dataprotectioncondition8" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition8" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I accept that any missed classes cannot be replaced/accommodated, on alternative dates.</p>
                                    <input type="checkbox" id="termsAndCondition9" checked name="dataprotectioncondition9" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition9" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mt-3 nextPrevBtn justify-content-between">
                                    <button class="btn btn-primary shadow-none priviousbtn3" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none nextButton4" type="button">Next</button>
                                </div>
                            </div>

                            <!-- Final Terms and Recording Consent -->
                            <div class="form_tab last_tab">
                                <div class="h3 fw-bold">
                                    Final Terms and Recording Consent
                                </div>
                                <div class="mb-3">
                                    <p class="fw-bold">I agree to reading all policies on Success at 11 Plus English website including Health/safety,
                                        Safeguarding, Online Safety T's and C's and Privacy Policy.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition10" checked name="dataprotectioncondition10" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition10" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        Please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I consent to occasional classes being recorded for staff training purposes only. I accept
                                        that I will have the right to decline or permit use of any footage of my child, when
                                        asked, (for use on Success at 11 Plus English website or social media), prior to use.
                                    </p>
                                    <input type="radio" id="recordingYes" value="yes" checked class="cursorPointer" name="yesorno" required><label for="recordingYes" class="ps-2 user-select-none cursorPointer fw-bold fs-5">Yes</label> <br>
                                    <input type="radio" id="recordingNo" value="no" class="cursorPointer" name="yesorno" required><label for="recordingNo" class="ps-2 user-select-none cursorPointer fw-bold fs-5">No</label>
                                    <small class="invalid-feedback">
                                        Please select your recording consent preference.
                                    </small>
                                </div>

                                <div class="mt-3 nextPrevBtn justify-content-between">
                                    <button class="btn btn-primary shadow-none priviousbtn4" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none applyBtn" type="submit" id="checkout" name="submit">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <script>
                // Make studentAge available globally
                var studentAge = document.getElementById('studentCourse').value;

                $(document).ready(function() {
                    // Initialize datepicker
                    initializeDatePicker();

                    // Email validation
                    setupEmailValidation();

                    // Form validation on submit
                    setupFormValidation();
                });

                function initializeDatePicker() {
                    var datePicker = $('.datepicker');
                    datePicker.datepicker('destroy');

                    // Simple, robust config: restrict to 7-13 years old
                    var minDate = new Date();
                    minDate.setFullYear(minDate.getFullYear() - 13);
                    var maxDate = new Date();
                    maxDate.setFullYear(maxDate.getFullYear() - 7);

                    datePicker.datepicker({
                        format: 'mm/dd/yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        startDate: minDate,
                        endDate: maxDate,
                        orientation: 'bottom',
                        clearBtn: true
                    }).on('changeDate', function(e) {
                        // Remove validation error if date is valid
                        var input = $(this)[0];
                        if (input.checkValidity()) {
                            input.classList.remove('is-invalid');
                        }
                    });

                    // Prevent manual typing
                    datePicker.on('keydown paste', function(e) {
                        e.preventDefault();
                        return false;
                    });
                }

                function setupEmailValidation() {
                    var emailState = false;
                    $('#email').blur(function() {
                        var userEmail = $(this).val();
                        if (userEmail == '') {
                            emailState = false;
                            return;
                        }
                        $.ajax({
                            method: "POST",
                            url: "formAction.php",
                            data: { userEmail: userEmail },
                            success: function(response) {
                                if (response == 'Email Exist') {
                                    emailState = false;
                                    $('#email').val("");
                                    $('#email').parent().removeClass().addClass("form_error");
                                    $('#email').siblings("span").text('Sorry... Email already exists, try another one');
                                } else if (response == 'Available') {
                                    emailState = true;
                                    $('#email').parent().removeClass().addClass("form_success");
                                    $('#email').siblings("span").text('');
                                }
                            }
                        });
                    });
                }

                function setupFormValidation() {
                    const lastTab = document.querySelector('.last_tab');
                    const submitBtn = document.getElementById('checkout');
                    const form = document.getElementById('formdata');
                    
                    lastTab.addEventListener('change', function() {
                        submitBtn.disabled = !form.checkValidity();
                    });

                    submitBtn.addEventListener('click', function() {
                        document.querySelector('.loading').classList.replace('d-none', 'd-flex');
                    });
                }
            </script>
            <script src="applyformscript/formval.js"></script>
</body>

</html>