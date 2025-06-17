<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
     if (!isset($_SESSION['logged_in']) == true) {
        header('Location:' . BASE_URL . 'Login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | Students List</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/AdminPanel/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/AdminPanel/viewPagestyle.css">
    <style>

    </style>
</head>

<body>
    <!-- Edit popup Modal -->
    <div class="modal fade" id="dataEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog updateActivityCon ">
            <div class="modal-content editeStudentContainer shadow p-2  rounded maindiv">
                <div class="modal-header">
                    <div class="h4 fw-bold colpurple text-center">EXISTING STUDENT DETAILS</div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="data_id" id="data_id">

                    <div class="my-2 mt-2 mb-2">
                        <div class="row">
                            <div class="col-sm">
                                <div class="fw-bold">NAME : <span class="view_Fname"></span> <span
                                        class="view_Sname"></span></div>
                                <div class="fw-bold">DATE OF BIRTH : <span class="view_dob"></span></div>
                                <div class="fw-bold">GENDER : <span class="view_gender"></span></div>
                                <div class="fw-bold">TERMS : <span class="view_term"></span></div>
                            </div>

                            <div class="col-sm">
                                <div class="fw-bold">CATEGORY : <span class="view_cat"></span></div>
                                <div class="fw-bold">SUBJECT : <span class="view_sub"></span></div>
                                <div class="fw-bold">EMAIL : <span class="view_eMail"></span></div>
                                <div class="fw-bold">PHONE NUMBER : <span class="view_Ph"></span></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form id="updateData" class="addForm">
                        <div class="compleTermSelectCon completeTContainer">
                            <div class="h4 fw-bold colpurple">Select Completed Term</div>
                            <div id='checkbox'>
                                <input type="checkbox" name="temr-1" class="form-check-input" value="Term 1"
                                    id="completeT-1">
                                <label for="completeT-1">Term 1</label>
                                <input type="checkbox" name="temr-2" class="form-check-input" value="Term 2"
                                    id="completeT-2">
                                <label for="completeT-2">Term 2</label>
                                <input type="checkbox" name="temr-3" class="form-check-input" value="Term 3"
                                    id="completeT-3">
                                <label for="completeT-3">Term 3</label>
                                <input type="checkbox" name="temr-4" class="form-check-input" value="Term 4"
                                    id="completeT-4">
                                <label for="completeT-4">Term 4</label>
                                <input type="checkbox" name="temr-5" class="form-check-input" value="Term 5"
                                    id="completeT-5">
                                <label for="completeT-5">Term 5</label>
                                <input type="checkbox" name="temr-6" class="form-check-input" value="Term 6"
                                    id="completeT-6">
                                <label for="completeT-6">Term 6</label>
                                <input type="checkbox" name="temr-7" class="form-check-input" value="Term 7"
                                    id="completeT-7">
                                <label for="completeT-7">Term 7</label>
                                <input type="checkbox" name="temr-8" class="form-check-input" value="Term 8"
                                    id="completeT-8">
                                <label for="completeT-8">Term 8</label>
                                <input type="checkbox" name="temr-9" class="form-check-input" value="Term 9"
                                    id="completeT-9">
                                <label for="completeT-9">Term 9</label>
                                <input type="checkbox" name="temr-10" class="form-check-input" value="Term 10"
                                    id="completeT-10">
                                <label for="completeT-10">Term 10</label>
                                <input type="checkbox" name="temr-11" class="form-check-input" value="Term 11"
                                    id="completeT-11">
                                <label for="completeT-11">Term 11</label>
                                <input type="checkbox" name="temr-12" class="form-check-input" value="Term 12"
                                    id="completeT-12">
                                <label for="completeT-12">Term 12</label>
                                <input type="checkbox" name="temr-13" class="form-check-input" value="Term 13"
                                    id="completeT-13">
                                <label for="completeT-13">Term 13</label>
                                <div id="btnforCat"></div>
                                <input type="hidden" name="stu_id" class="hidden_id" value="">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn shadow-none my-3 rounded fw-bold bg-success text-white"
                                data-bs-dismiss="modal">Back</button>
                            <button type="submit" class="btn shadow-none my-3 rounded fw-bold updateBtn"><img
                                    src="./assect/logo/fileupload.gif" class=" d-none" width="20px"> Click to
                                Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- student details View popup Modal -->
    <?php include('StudentView.php') ?>

    <!-- MAIL SEND for Pending Students -->
    <?Php include('./pendingStudentMailPopUp.php') ?>

    <?php include('adminpanel.php') ?>
    <div class="body_container">
        <?php include('adminHeader.php') ?>
        <div class="container">
            <div class="dash_Board_Hedding ">
                <h3 class="fw-bold text-center pt-3">EXISTING STUDENTS LIST</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div><span class="fs-4 fw-bold" style=" color: #165BAA;">Years/Ages</span></div>
                    <div class="my-2">
                        <input type="radio" name="subjectSelect" value="Year 6" class="subjectRadio filt"
                            id="year6-Hwork">
                        <label for="year6-Hwork"
                            class="subjectBtn my-2 fw-bold user-select-none me-1">Year 6</label>
                        <input type="radio" name="subjectSelect" value="Year 5" class="subjectRadio filt"
                            id="year5-Hwork">
                        <label for="year5-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 5</label>
                        <input type="radio" name="subjectSelect" value="Year 4" class="subjectRadio filt"
                            id="year4-Hwork">
                        <label for="year4-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 4</label>
                        <!-- <input type="radio" name="subjectSelect" value="Spanish" class="subjectRadio filt"
                            id="spanish-Hwork">
                        <label for="spanish-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Spanish</label> -->
                    </div>
                </div>
            </div>
            <div>
                <span class="fs-4 fw-bold" style=" color: #165BAA;">Category</span>
            </div>
            <div id="cat_btn" class="my-2">
                <input type="radio" name="stucategorytSelect" value="PrePrep" class="stucatRadio filt"
                    id="pre-prep-cul">
                <label for="pre-prep-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">SpaG</label>
                <input type="radio" name="stucategorytSelect" value="Junior" class="stucatRadio filt" id="junior-cul">
                <label for="junior-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Creative writing</label>
                <input type="radio" name="stucategorytSelect" value="Teen" class="stucatRadio filt" id="Early-Teen-cul">
                <label for="Early-Teen-cul" class="subjectBtn my-2 fw-bold user-select-none me-1    ">Comperhension</label>
                <input type="radio" name="stucategorytSelect" value="Adults" class="stucatRadio filt" id="adults-cul">
                <label for="adults-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Vocabulary</label>
            </div>

            <!-- terms -->
            <div>
                <div><span class="fs-4 fw-bold" style=" color: #165BAA;">Terms</span></div>
                <div class="my-2">
                    <input type="radio" name="termsSelect" value="Term 1" class="termRadio filt" id="term1-Hwork">
                    <label for="term1-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 1</label>
                    <input type="radio" name="termsSelect" value="Term 2" class="termRadio filt" id="term2-Hwork">
                    <label for="term2-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 2</label>
                    <input type="radio" name="termsSelect" value="Term 3" class="termRadio filt" id="term3-Hwork">
                    <label for="term3-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 3</label>
                    <input type="radio" name="termsSelect" value="Term 4" class="termRadio filt" id="term4-Hwork">
                    <label for="term4-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 4</label>
                    <input type="radio" name="termsSelect" value="Term 5" class="termRadio filt" id="term5-Hwork">
                    <label for="term5-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 5</label>
                    <input type="radio" name="termsSelect" value="Term 6" class="termRadio filt" id="term6-Hwork">
                    <label for="term6-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 6</label>
                    <input type="radio" name="termsSelect" value="Term 7" class="termRadio filt" id="term7-Hwork">
                    <label for="term7-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 7</label>
                    <input type="radio" name="termsSelect" value="Term 8" class="termRadio filt" id="term8-Hwork">
                    <label for="term8-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 8</label>
                    <input type="radio" name="termsSelect" value="Term 9" class="termRadio filt" id="term9-Hwork">
                    <label for="term9-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 9</label>
                    <input type="radio" name="termsSelect" value="Term 10" class="termRadio filt" id="term10-Hwork">
                    <label for="term10-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 10</label>
                    <input type="radio" name="termsSelect" value="Term 11" class="termRadio filt" id="term11-cul">
                    <label for="term11-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 11</label>
                    <input type="radio" name="termsSelect" value="Term 12" class="termRadio filt" id="term12-cul">
                    <label for="term12-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 12</label>
                    <input type="radio" name="termsSelect" value="Term 13" class="termRadio filt" id="term13-cul">
                    <label for="term13-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Term 13</label>
                </div>
            </div>

            <!-- terms -->

            <div>
                <span class="fs-4 fw-bold" style=" color: #165BAA;">Status</span>
            </div>
            <div id="cat_btn" class=" d-flex flex-wrap justify-content-between aligin-items-center">
                <div class="d-flex aligin-items-center">
                    <div>
                        <input type="radio" name="categorytSelect" value="Live" class="catRadio filt" id="Live-cul">
                        <label for="Live-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Live</label>
                        <input type="radio" name="categorytSelect" value="Pending" class="catRadio filt"
                            id="Pending-cul">
                        <label for="Pending-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Pending</label>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="search_bar">
                        <input type="text" placeholder="search" id="search">
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="">
                        <button class="btn shadow-none fw-bold text-nowrap" id="pendingStuMsg" data-bs-toggle="modal"
                            data-bs-target="#mailSentModal">Send Email</button>
                    </div>
                </div>
            </div>
            <div class="tablContainer">

                <table class="table table-bordered table-striped " id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Subject</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Status</th>
                            <th scope="col">VIEW</th>
                            <th scope="col">EDIT</th>
                            <th scope="col">DELETE</th>
                        </tr>
                    </thead>
                    <tbody id="trBody" class="filter_data">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="admindashscript.js"></script>
    <script src="formValidation.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!--This javascript link is used to send pending student mail pop up data to backend -->
    <script src="./sendMailData.js"></script>

    <script>
    const pendingRadio = document.getElementById('Pending-cul');
    const pendingMsgBtn = document.getElementById('pendingStuMsg');
    document.addEventListener('change', () => {
        if (pendingRadio.checked == true) {
            pendingMsgBtn.style.display = "flex";
        } else {
            pendingMsgBtn.style.display = "none";
        }
    });
    $(document).ready(function() {
        filter_data();


        $("#search").on("keyup", function() {
            var val = $.trim(this.value);
            if (val) {
                val = val.toLowerCase();
                $("#trBody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
                });
            } else {
                filter_data();
            }
        });

        function filter_data() {
            $('.filter_data').html('<td colspan="8"><div id="loading" style=""></div></td>');
            var action = 'ExistingStudent';
            var selLang = get_filter('subjectRadio');
            var selTerm = get_filter('termRadio');
            var selCat = get_filter('catRadio');
            var stuCat = get_filter('stucatRadio');
            $.ajax({
                url: 'Exit-studentsCode.php',
                type: 'POST',
                data: {
                    action: action,
                    selLang: selLang,
                    selTerm: selTerm,
                    selCat: selCat,
                    stuCat: stuCat
                },
                success: function(response) {
                    $('.filter_data').html(response);
                }
            })
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }
        $('.filt').click(function() {
            filter_data();
        });

    });

    $('#updateData').submit(function(e) {
        var allVals = [];
        $('input[type="checkbox"]:checked').each(function() {

            allVals.push($(this).val());
        });

        e.preventDefault();

        var studenId = $('.hidden_id').val();
        action = "update_terms";
        $('.updateBtn').prop('disabled', true);
        $('.updateBtn img').removeClass('d-none');

        $.ajax({
            type: "POST",
            url: "Exit-studentsCode.php",
            data: {
                id: studenId,
                terms: allVals,
                condition: action
            },
            success: function(callBack) {
                alert(callBack);
                window.location.href = "existingstudent.php";
            }
        })
    });

    $(document).on('click', '.editDataBtn', function() {
        $('#dataEditModal').modal('show');
        var data_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "Exit-studentsCode.php?data_id=" + data_id,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {

                    alert(res.message);
                } else if (res.status == 200) {

                    $('.view_Fname').text(res.data.fname.toUpperCase());
                    $('.view_Sname').text(res.data.surname.toUpperCase());
                    var dateArr = res.data.dob.split('-');
                    $('.view_dob').text(dateArr[2] + '-' + dateArr[1] + '-' + dateArr[0]);
                    $('.view_gender').text(res.data.gender.toUpperCase());
                    $('.view_cat').text(res.data.Stu_Cat.toUpperCase());
                    $('.view_sub').text(res.data.Stu_Sub.toUpperCase());
                    $('.view_eMail').text(res.data.email);
                    $('.view_Ph').text(res.data.phone);
                    $('.view_term').text(res.data.terms);
                    $('.hidden_id').val(res.data.id);
                    if (res.data.Stu_Cat == 'PrePrep' || res.data.Stu_Cat == 'Junior') {
                        $('#btnforCat').html(`<input type="checkbox" name="EBook" class="form-check-input" value="EBook" id="completeEBook">
                                <label for="completeEBook">e-Book</label>`);
                    } else {
                        $('#btnforCat').html("");
                    };
                    var arrTerms = res.data.terms.split(',');
                    $('input:checkbox').prop('checked', false);

                    for (var i = 0; i < arrTerms.length; i++) {
                        $('input[type="checkbox"][value="' + arrTerms[i] + '"]').prop('checked',
                            true);
                    }
                    $('#dataEditModal').modal('show');
                }
            }

        });
    });


    $(document).on('click', '.viewDatatBtn', function() {
        $('#dataViewModal').modal('show');
        var data_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "Exit-studentsCode.php?data_id=" + data_id,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    alert(res.message);

                } else if (res.status == 200) {

                    $('.view_Fname').text(res.data.fname.toUpperCase());
                    $('.view_Sname').text(res.data.surname.toUpperCase());
                    var dateArr = res.data.dob.split('-');
                    $('.view_dob').text(dateArr[2] + '-' + dateArr[1] + '-' + dateArr[0]);
                    $('.view_gender').text(res.data.gender.toUpperCase());
                    $('.view_cat').text(res.data.Stu_Cat.toUpperCase());
                    $('.view_sub').text(res.data.Stu_Sub.toUpperCase());
                    if (res.data.Stu_Status == null) {
                        $('#view_status').text('');
                    } else {
                        $('#view_status').text(res.data.Stu_Status.toUpperCase());
                    }
                    $('.view_dofe').text(res.data.DOFE);
                    $('#pFname').text(res.data.parentfirstname.toUpperCase());
                    $('#pSname').text(res.data.parentsurname.toUpperCase());
                    $('#view_address').text(res.data.address.toUpperCase());
                    $('.view_eMail').text(res.data.email);
                    $('.view_Ph').text(res.data.phone);
                    $('#userpwd').text(res.data.password);
                    $('#view_YoN').text(res.data.yesorno.toUpperCase());
                    $('.view_term').text(res.data.terms);
                    $('#view_CrAmt').text(res.data.child_category);
                    $('#dataViewModal').modal('show');

                    $(document).on('submit', '#disc_Amt', function(e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        formData.append("discountAmt", true);
                        $.ajax({
                            method: "POST",
                            url: "studentsCode.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                location.reload().delay(3000);
                            }
                        })
                    });
                }
            }
        });
    });


    $(document).on('click', '.deleteDataBtn', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete this data?')) {
            var data_id = $(this).val();
            var action = "delete_student";
            $.ajax({
                type: "POST",
                url: "Exit-studentsCode.php",
                data: {
                    id: data_id,
                    requestCondition: action
                },
                success: function(response) {
                    if (response) {
                        var reid = $('#row' + data_id).remove();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(response);

                    } else {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error(response);

                    }
                }
            });
        }
    });
    </script>

</body>

</html>