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
    <meta name="description" content="smile4kids" />
    <title>Smile4Kids | Activity</title>
</head>

<body>

    <!-- Add popup -->
    <div class="modal add-main-container justify-content-center align-items-center position-fixed" id="dataAddModal"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog add-container shadow p-3 rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="h3 text-center fw-bold">Add Activity<i class="fa-solid fa-person-running mx-2"></i>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="saveData" class="addForm needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <input type="hidden" value="Activity" name="section" />
                        <label for="category" class="fw-bolder py-2">Category</label>
                        <select class="form-select shadow-none" name="category" aria-label="Default select example"
                            required>
                            <option value="SpaG">SpaG</option>
                            <option value="Creative writing">Creative writing</option>
                            <option value="Comprehension">Comprehension</option>
                            <option value="Vocabulary">Vocabulary</option>
                        </select>

                        <label for="subject" class="fw-bolder py-2">Years/Ages</label>
                        <select class="form-select shadow-none" name="subject" aria-label="Default select example"
                            required>
                            <option value="Year 6">Year 6</option>
                            <option value="Year 5">Year 5</option>
                            <option value="Year 4">Year 4</option>
                        </select>

                        <label for="terms" class="fw-bolder py-2">Terms</label>
                        <select class="form-select shadow-none" name="terms" aria-label="Default select example"
                            required>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                            <option value="Term 4">Term 4</option>
                            <option value="Term 5">Term 5</option>
                            <option value="Term 6">Term 6</option>
                            <option value="Term 7">Term 7</option>
                            <option value="Term 8">Term 8</option>
                            <option value="Term 9">Term 9</option>
                            <option value="Term 10">Term 10</option>
                            <option value="Term 11">Term 11</option>
                            <option value="Term 12">Term 12</option>
                            <option value="Term 13">Term 13</option>
                        </select>

                        <label for="addDate" class="fw-bolder py-2">Date</label>
                        <input type="text" class="datepicker form-control shadow-none" name="addDate"
                            aria-describedby="Date" required />

                        <!-- id="upDate" -->
                        <label for="fesFol" class="fw-bolder py-2">Activity Folder</label>
                        <input type="file" class="form-control shadow-none" name="files[]" multiple id="fesFol"
                            webkitdirectory multiple required>
                        <div class="invalid-feedback">
                            Please Choose file
                        </div>

                        <small class="text-primary">Please choose folder which has .pdf format files only</small>


                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn cancelBtn fw-bold shadow-none"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn ubloadBtn fw-bold shadow-none uploadBtn "><img
                                    src="./assect/logo/fileupload.gif" class=" d-none" width="20px"> Upload</button>
                        </div>
                        <div class="d-none progressBar">
                            <label class="pt-3 text-success">Uploading...</label>
                            <div class="progress my-3">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit popup Modal -->
    <div class="modal fade" id="dataEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog updateActivityCon ">
            <div class="modal-content shadow p-2  rounded maindiv">
                <div class="modal-header">
                    <h3 class="text-center m-2"> ACTIVITY <i class="fa-solid fa-person-running mx-2"></i></h3>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="updateData" class="addForm needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                        <input type="hidden" name="data_id" id="data_id">

                        <label for="category" class="fw-bolder py-2">Category</label>
                        <select class="form-select fw-bold shadow-none" name="category" id="category"
                            aria-label="Default select example" id="category" required>
                            <option value="SpaG">SpaG</option>
                            <option value="Creative writing">Creative writing</option>
                            <option value="Comprehension">Comprehension</option>
                            <option value="Vocabulary">Vocabulary</option>
                        </select>

                        <label for="subject" class="fw-bolder py-2">Years/Ages</label>
                        <select class="form-select fw-bold shadow-none" name="subject" id="subject"
                            aria-label="Default select example" required>
                            <option value="Year 6">Year 6</option>
                            <option value="Year 5">Year 5</option>
                            <option value="Year 4">Year 4</option>
                        </select>
                        <div class="form-group fw-bold">
                            <label for="exampleInputdate">FILE NAME</label>
                            <input type="file" class="form-control shadow-none" name="files" id="files" accept=".pdf">
                            <div class="invalid-feedback">
                                Please Choose file
                            </div>
                        </div>
                        <input type="hidden" name="oldfile" id="oldfile">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn shadow-none my-3 rounded fw-bold bg-success text-white"
                                data-bs-dismiss="modal">Back</button>
                            <button type="submit" class="btn shadow-none my-3 rounded fw-bold updateBtn"><img
                                    src="./assect/logo/fileupload.gif" class=" d-none" width="20px">Click to
                                Update</button>
                        </div>

                        <div class="d-none progressBar">
                            <label class="pt-3 text-success">Uploading...</label>
                            <div class="progress my-3">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View popup Modal -->
    <div class="modal fade viewContainer" id="dataViewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow p-2 rounded maindiv">
                <div class="modal-header">
                    <div class="h3 text-center m-2"> ACTIVITY <i class="fa-solid fa-person-running mx-2"></i></div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Category:</label><span id="view_Category"
                            class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Language:</label><span id="view_Language"
                            class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Date:</label><span id="view_Date" class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Terms:</label><span id="view_Terms"
                            class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">File:</label><span id="view_File" class="fs-5 border-0"></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn shadow-none my-3 btn-success rounded fw-bold viewBackBtn"
                        data-bs-dismiss="modal">BACK</button>
                    <a href="" class="btn shadow-none my-3 btn-danger rounded fw-bold viewPdfBtn">VIEW PDF</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('adminpanel.php') ?>
    <div class="body_container">
        <?php include('adminHeader.php') ?>
        <div class="container">
            <div class="dash_Board_Hedding ">
                <h3 class="fw-bold text-center pt-3">ACTIVITIES</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div><span class="fs-4 fw-bold" style=" color: #165BAA;">Years/Ages</span></div>
                    <div class="my-2">
                        <input type="radio" name="subjectSelect" value="Year 6" class="subjectRadio filt"
                            id="year6-Hwork">
                        <label for="year6-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 6</label>
                        <input type="radio" name="subjectSelect" value="Year 5" class="subjectRadio filt"
                            id="year5-Hwork">
                        <label for="year5-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 5</label>
                        <input type="radio" name="subjectSelect" value="Year 4" class="subjectRadio filt"
                            id="year4-Hwork">
                        <label for="year4-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 4</label>
                    </div>
                </div>
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
            <div>
                <span class="fs-4 fw-bold" style=" color: #165BAA;">Category</span>
            </div>
            <div id="cat_btn" class="my-2">
                <input type="radio" name="categorytSelect" value="SpaG" class="catRadio filt" id="spag-cul">
                <label for="spag-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">SpaG</label>
                <input type="radio" name="categorytSelect" value="Creative writing" class="catRadio filt" id="creative-writing-cul">
                <label for="creative-writing-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Creative writing</label>
                <input type="radio" name="categorytSelect" value="Comprehension" class="catRadio filt" id="comprehension-cul">
                <label for="comprehension-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Comprehension</label>
                <input type="radio" name="categorytSelect" value="Vocabulary" class="catRadio filt" id="vocabulary-cul">
                <label for="vocabulary-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Vocabulary</label>
            </div>
            <div class="my-2 d-flex justify-content-end addContentContainer">
                <button type="button" class="btn shadow-none fw-bold px-3 float-end content-Add-Btn"
                    data-bs-toggle="modal" data-bs-target="#dataAddModal">
                    Add
                </button>
            </div>

            <div class="tablContainer">

                <table class="table table-bordered table-striped " id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">FILE</th>
                            <th scope="col">DATE</th>
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
    <script>
    $(document).ready(function() {
        filter_data();

        function filter_data() {
            $('.filter_data').html('<td colspan="7"><div id="loading" style=""></div></td>');
            var action = 'Activity';
            var selLang = get_filter('subjectRadio');
            var selTerm = get_filter('termRadio');
            var selCat = get_filter('catRadio');

            $.ajax({
                url: 'adminactCode.php',
                type: 'POST',
                data: {
                    action: action,
                    selLang: selLang,
                    selTerm: selTerm,
                    selCat: selCat
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
    // $('.datepicker').datepicker('setDate', 'today');


    $(document).on('submit', '#saveData', function(e) {
        e.preventDefault();

        $('.uploadBtn').prop('disabled', true);
        $('.uploadBtn img').removeClass('d-none');
        $('.progressBar').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("save_data", true);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(Math.round(percentComplete) + '%');
                        $(".progress-bar").html(Math.round(percentComplete) + '%');
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            url: "adminactCode.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);

                } else if (res.status == 500) {
                    alert(res.message);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(res.message);
                    $('.uploadBtn').prop('disabled', false);
                    $('.uploadBtn img').addClass('d-none');
                    $('.progressBar').addClass('d-none');
                }
                // else {

                $('#errorMessage').addClass('d-none');
                $('#dataAddModal').modal('hide');
                $('#saveData')[0].reset();

                alertify.set('notifier', 'position', 'top-right');
                alertify.success(res.message);
                $('.uploadBtn').prop('disabled', false);
                $('.uploadBtn img').addClass('d-none');
                $('.progressBar').addClass('d-none');
                $('#myTable').load(location.href + " #myTable");
                // }
            }
        });

    });

    $(document).on('click', '.editDataBtn', function() {

        var data_id = $(this).val();
        // alert(data_id);
        $.ajax({
            type: "GET",
            url: "adminactCode.php?data_id=" + data_id,
            success: function(response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 404) {

                    alert(res.message);
                } else if (res.status == 200) {

                    $('#category').val(res.data.Category);
                    $('#subject').val(res.data.Subject);
                    $('#oldfile').val(res.data.file_Path);
                    $('#dataEditModal').modal('show');
                }

            }
        });
    });


    $(document).on('submit', '#updateData', function(e) {
        e.preventDefault();
        $('.updateBtn').prop('disabled', true);
        $('.updateBtn img').removeClass('d-none');
        $('.progressBar').removeClass('d-none');
        var formData = new FormData(this);
        formData.append("update_data", true);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(Math.round(percentComplete) + '%');
                        $(".progress-bar").html(Math.round(percentComplete) + '%');
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            url: "adminactCode.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#dataEditModal').modal('hide');
                $('#updateData')[0].reset();
                $('#myTable').load(location.href + " #myTable");
                var res = jQuery.parseJSON(response);
                // console.log(response);
                if (res.status == 422) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);

                } else if (res.status == 200) {

                    $('#errorMessageUpdate').addClass('d-none');

                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);

                    $('.updateBtn').prop('disabled', false);
                    $('.updateBtn img').addClass('d-none');
                    $('.progressBar').addClass('d-none');

                    $('#dataEditModal').modal('hide');
                    $('#updateData')[0].reset();

                    $('#myTable').load(location.href + " #myTable");

                } else if (res.status == 500) {
                    alert(res.message);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(res.message);
                    $('.updateBtn').prop('disabled', false);
                    $('.updateBtn img').addClass('d-none');
                    $('.progressBar').addClass('d-none');
                } else if (res.status == 100) {
                    alert(res.message);
                }
            }
        });

    });

    $(document).on('click', '.viewDatatBtn', function() {

        var data_id = $(this).val();
        // alert(data_id);
        $.ajax({
            type: "GET",
            url: "adminactCode.php?data_id=" + data_id,
            success: function(response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 404) {

                    alert(res.message);
                } else if (res.status == 200) {

                    $('#view_Category').text(res.data.Category);
                    $('#view_Language').text(res.data.Subject);
                    $('#view_Date').text(res.data.Date);
                    $('#view_Terms').text(res.data.Terms);
                    $('#view_File').text(res.data.Files);
                    // $('#view_course').text(res.data.course);
                    console.log(response);
                    var url = "hwUploads/" + res.data.Files;
                    $('.viewPdfBtn').attr('href', url);
                    $('#dataViewModal').modal('show');
                }
            }
        });
    });

    $(document).on('click', '.deleteDataBtn', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete this data?')) {
            var data_id = $(this).val();
            var path = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: "adminactCode.php",
                data: {
                    'delete_data': true,
                    'data_id': data_id,
                    'path': path
                },
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 500) {

                        alert(res.message);
                    } else {
                        $('#row' + data_id).remove();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                    }
                }
            });
        }
    });
    </script>

</body>

</html>