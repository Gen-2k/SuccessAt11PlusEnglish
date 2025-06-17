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

    <!-- css link -->
    <link rel="stylesheet" href="applyformstyle/style.css">
    <title>Success at 11 Plus English</title>
</head>
<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #e0f2fe;
        --accent-color: #3b82f6;
        --error-color: #dc2626;
        --success-color: #16a34a;
        --text-color: #1e293b;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--light-bg);
        min-height: 100vh;
        color: var(--text-color);
        font-size: 16px;
        line-height: 1.6;
    }

    .box_shad {
        background-color: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 1rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .form_container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .card {
        padding: 2rem !important;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: var(--accent-color);
        transform: translateY(-1px);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .h3,
    .h4 {
        color: var(--text-color);
        margin-bottom: 1.5rem;
    }

    .form_tab {
        padding: 1.5rem 0;
    }

    .page-title {
        color: var(--text-color);
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
        padding: 0.5rem 0;
    }

    .section-heading {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 1.5rem 0 2rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--border-color);
    }

    /* Checkbox and radio styling */
    input[type="checkbox"],
    input[type="radio"] {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        accent-color: var(--primary-color);
    }

    .form_tab p {
        color: var(--text-color);
        line-height: 1.7;
        margin-bottom: 1rem;
    }

    /* Form validation states */
    .invalid-feedback {
        font-size: 0.875rem;
        color: var(--error-color);
        margin-top: 0.375rem;
    }

    .form_error input {
        border-color: var(--error-color);
    }

    .form_success input {
        border-color: var(--success-color);
    }    /* Loading overlay */
    .loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .loading img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .loading::after {
        content: "Processing your application...";
        color: var(--text-color);
        font-size: 1rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form_container {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem !important;
        }
    }
</style>

<body>
    <div class="position-fixed loading d-none justify-content-center align-items-center">
        <img src="./assets/load1.gif" class="user-select-none">
    </div>
    <div class="form_bg_container min-vh-100 py-4">
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
                                <h1 class="page-title"><?php echo isset($_GET['courseName']) ? $_GET['courseName'] : $_SESSION['courseName']; ?></h1>
                                <h2 class="section-heading">Student Details</h2>
                                <div class="row g-3">
                                    <div class="col-md">
                                        <label for="FirstName" class="form-label h5 fw-bold" name="fName">First name</label>
                                        <input type="text" name="fname" class="form-control shadow-none" placeholder="Enter First Name" id="FirstName" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            please enter correct firstname
                                        </small>
                                    </div>
                                    <div class="col-md ">
                                        <label for="SurName" class="form-label h5 fw-bold" name="Surname">Surname</label>
                                        <input type="text" name="surname" class="form-control shadow-none" id="SurName" placeholder="Enter Surname" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            please enter correct surname.
                                        </small>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="dateOfBirth" class="form-label h5 fw-bold" name="Date of Birth">Date of
                                            Birth</label>
                                        <input type="text" name="dob" class="form-control datepicker shadow-none" id="dateOfBirth" pattern="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" aria-describedby="inputGroupPrepend" autocomplete="off" required>
                                        <small class="invalid-feedback">
                                            please pick your date of birth.
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
                                        <input type="text" name="parentfirstname" class="form-control shadow-none" placeholder="Enter First Name" id="parentFirstName" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                                        <small class="invalid-feedback">
                                            please enter correct firstname.
                                        </small>
                                    </div>
                                    <div class="col-md">
                                        <label for="parentSurName" class="form-label h5 fw-bold">Surname</label>
                                        <input type="text" name="parentsurname" class="form-control shadow-none" id="parentSurName" pattern="\S(.*\S)? ||[a-zA-Z]+" placeholder="Enter Surname" required>
                                        <small class="invalid-feedback">
                                            please enter correct surname.
                                        </small>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="parentAdderss" class="h5 fw-bold">Address</label>
                                        <textarea class="form-control shadow-none" name="address" id="parentAdderss" rows="3" placeholder="Enter your recent Address" minlength="12" pattern=".*\S+.*" required></textarea>
                                        <small class="invalid-feedback">
                                            please enter your recent address.
                                        </small>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="Email" class="form-label h5 fw-bold">Email Address</label>
                                        <input type="email" name="email" class="form-control shadow-none" id="email" placeholder="Enter Email" pattern="\S(.*\S)?" required>
                                        <small class="invalid-feedback">
                                            please enter correct email.
                                        </small>
                                        <span class="fs-6"></span>
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="phoneNumber" class="form-label h5 fw-bold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control shadow-none" minlength="10" maxlength="11" pattern="^(?:\d{11}|\d{10})$" id="phoneNumber" placeholder="Enter phone Number" required>
                                        <small class="invalid-feedback">
                                            please enter your phone number.
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
                                        or
                                        acquired by my child as a result of subscribing the course/s under Success at 11 Plus English.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition1" checked name="dataprotectioncondition1" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition1" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I shall not in case reproduce and /or distribute, allow reproduction and /or distribution
                                        of
                                        any such course material by any third party including but not limited to any of my
                                        family
                                        members for commercial or non-commercial purpose. Course materials are being provided to
                                        my
                                        child who had subscribed the course with Success at 11 Plus English and shall at all times be used
                                        solely by my child only.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition2" checked name="dataprotectioncondition2" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition2" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I understand that selling, commercial copying, hiring or lending of course materials are
                                        strictly prohibited. I consent to indemnify Success at 11 Plus English for any losses or damages
                                        resulting out of my failure to protect the course materials as mentioned above with my
                                        best
                                        endeavours.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition3" checked name="dataprotectioncondition3" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition3" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">Success at 11 Plus English will presume that the parents/other party has read and consented to all the
                                        terms and clauses in the agreement and NDA should they prefer not to return a signed
                                        copy of
                                        such documents and the student attends a class. </p>
                                    <input type="checkbox" id="termsAndCondition4" checked name="dataprotectioncondition4" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition4" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I undertake that my child is under parental/guardian supervision, at all times, during
                                        the
                                        length of the class. I agree not to hold Success at 11 Plus English responsible, for being unable to
                                        supervise my child individually. </p>
                                    <input type="checkbox" id="termsAndCondition5" checked name="dataprotectioncondition5" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition5" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mt-3 nextPrevBtn justify-content-between">
                                    <button class="btn btn-primary shadow-none priviousbtn2" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none nextButton3" type="button">Next</button>
                                </div>

                            </div>
                            <!-- Data Protection & Terms and Conditions -->
                            <div class="form_tab">
                                <div class="h3 fw-bold">
                                    Data Protection & Terms and Conditions
                                </div>
                                <div class="mb-3">
                                    <p class="fw-bold">I undertake that my child is under parental/guardian supervision, at all times, during
                                        the
                                        length of the class. I agree not to hold Success at 11 Plus English responsible, for being unable to
                                        supervise my child individually.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition6" checked name="dataprotectioncondition6" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition6" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">By enrolling my child onto a Success at 11 Plus English course, I agree that I have read and will be
                                        bound
                                        by all the terms and conditions and policies, on the Success at 11 Plus English website. </p>
                                    <input type="checkbox" id="termsAndCondition7" checked name="dataprotectioncondition7" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition7" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I understand that termly fees once paid are non-refundable.</p>
                                    <input type="checkbox" id="termsAndCondition8" checked name="dataprotectioncondition8" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition8" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I consent to occasional classes being recorded for staff training purposes only. I accept
                                        that I will have the right to decline or permit use of any footage of my child, when
                                        asked,
                                        (for use on Success at 11 Plus English website or social media), prior to use. </p>
                                    <input type="radio" id="yes" value="yes" checked class="cursorPointer" name="yesorno" required><label for="yes" class="ps-2 user-select-none cursorPointer fw-bold fs-5">Yes</label> <br>
                                    <input type="radio" id="no" value="no" class="cursorPointer" name="yesorno" required><label for="no" class="ps-2 user-select-none cursorPointer fw-bold fs-5">No</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>


                                <div class="mt-3 nextPrevBtn justify-content-between">
                                    <button class="btn btn-primary shadow-none priviousbtn3" type="button">Previous</button>
                                    <button class="btn btn-primary shadow-none nextButton4" type="button">Next</button>
                                </div>
                            </div>


                            <!-- Data Protection & Terms and Conditions -->
                            <div class="form_tab last_tab">
                                <div class="h3 fw-bold">
                                    Data Protection & Terms and Conditions
                                </div>
                                <div class="mb-3">
                                    <p class="fw-bold">I agree to reading all policies on Success at 11 Plus English website including Health/safety,
                                        Safeguarding, Online Safety T's and C's and Privacy Policy.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition9" checked name="dataprotectioncondition9" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition9" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I accept that no refund or partial refund will be given if a student leaves, part term.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition10" checked name="dataprotectioncondition10" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition10" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold">I accept that any missed classes cannot be replaced/accommodated, on alternative dates.
                                    </p>
                                    <input type="checkbox" id="termsAndCondition11" checked name="dataprotectioncondition11" value="yes" class="cursorPointer checkBoxSize" required><label for="termsAndCondition11" class="ps-2 user-select-none cursorPointer fw-bold fs-5">I Agree</label>
                                    <small class="invalid-feedback">
                                        please accept the terms and conditions.
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
                    // Initialize datepicker with default settings
                    $('.datepicker').datepicker({
                        format: 'mm/dd/yyyy',
                        autoclose: true,
                        todayHighlight: true
                    });

                    // Handle student type change
                    $("input[name='users_type']").change(function() {
                        var datePicker = $('.datepicker');
                        if ($(this).val() === "ExistingStudent") {
                            datePicker.datepicker('destroy');
                            datePicker.datepicker({
                                format: 'mm/dd/yyyy',
                                endDate: '-0m',
                                autoclose: true,
                                todayHighlight: true
                            });
                        } else {
                            datePicker.datepicker('destroy');
                            newOldStudentValidate();
                        }
                    });

                    // Initial validation based on student type
                    newOldStudentValidate();
                });

                function newOldStudentValidate() {
                    var datePicker = $('.datepicker');

                    datePicker.datepicker('destroy');

                    switch (studentAge) {
                        case "Year 4":
                            datePicker.datepicker({
                                format: 'mm/dd/yyyy',
                                autoclose: true,
                                startDate: '-10y',
                                endDate: '-9y',
                                todayHighlight: true
                            });
                            break;
                        case "Year 5":
                            datePicker.datepicker({
                                format: 'mm/dd/yyyy',
                                autoclose: true,
                                startDate: '-11y',
                                endDate: '-10y',
                                todayHighlight: true
                            });
                            break;
                        case "Year 6":
                            datePicker.datepicker({
                                format: 'mm/dd/yyyy',
                                autoclose: true,
                                startDate: '-12y',
                                endDate: '-11y',
                                todayHighlight: true
                            });
                            break;
                        default:
                            datePicker.datepicker({
                                format: 'mm/dd/yyyy',
                                autoclose: true,
                                todayHighlight: true
                            });
                            break;
                    }
                }

                const termcontainer = document.querySelector('.selectTrems');
                const DOBcontainer = document.querySelector('.DOB');

                const studentType = document.getElementsByClassName('studentType');
                for (let i = 0; i < studentType.length; i++) {

                    document.addEventListener('change', oldNewStudent)

                    function oldNewStudent(e) {
                        if (e.target.value == "ExistingStudent") {
                            termcontainer.innerHTML = completeTermsDiv;
                        } else if (e.target.value == "NewStudent") {
                            termcontainer.innerHTML = null;
                        }
                    }
                }

                $('document').ready(function() {
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
                            data: {
                                userEmail: userEmail
                            },
                            success: function(response) {
                                // alert(response);
                                if (response == 'Email Exist') {
                                    emailState = false;
                                    $('#email').val("");
                                    $('#email').parent().removeClass();
                                    $('#email').parent().addClass("form_error");
                                    $('#email').siblings("span").text('Sorry... Email already exist try another one');
                                } else if (response == 'Available') {
                                    emailState = true;
                                    $('#email').parent().removeClass();
                                    $('#email').parent().addClass("form_success");
                                    $('#email').siblings("span").text('');
                                }
                            }
                        });
                    });
                });
                const last_tab = document.querySelector('.last_tab');
                const submitBtn = document.getElementById('checkout');
                var formsval = document.querySelectorAll(".needs-validation");
                last_tab.addEventListener('change', () => {
                    for (let i = 0; i < formsval.length; i++) {
                        if (!formsval[i].checkValidity()) {
                            submitBtn.disabled = true;
                        } else {
                            submitBtn.disabled = false;
                        }

                    }
                })
                const loadinGif = document.querySelector('.loading');
                submitBtn.addEventListener('click', () => {
                    loadinGif.classList.replace('d-none', 'd-flex')
                })
            </script>
            <script src="applyformscript/formval.js"></script>
</body>

</html>