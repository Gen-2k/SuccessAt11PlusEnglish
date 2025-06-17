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
    <title>Smile4Kids | E-Book</title>
</head>
<style>
#changeAmount {
    background-color: #165BAA;
    color: white;
}

#changeAmount:hover {
    background-color: white;
    color: #165BAA;
}
</style>

<body>

    <!-- Add popup -->
    <div class="modal add-main-container justify-content-center align-items-center position-fixed" id="dataAddModal"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog add-container shadow p-3 rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="h3 text-center fw-bold">Add E-Book</div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="saveData" class="addForm needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <input type="hidden" value="E-Book" name="section" />
                        <label for="ebookSelectCategory" class="fw-bolder py-2">Category</label>
                        <select class="form-select shadow-none" name="category" id="ebookSelectCategory"
                            aria-label="Default select example" required>
                            <option value="SpaG">SpaG</option>
                            <option value="Creative writing">Creative writing</option>
                            <option value="Comprehension">Comprehension</option>
                            <option value="Vocabulary">Vocabulary</option>
                        </select>

                        <label for="ebookSelectSubject" class="fw-bolder py-2">Subject</label>
                        <select class="form-select shadow-none" name="subject" id="ebookSelectSubject"
                            aria-label="Default select example" required>
                            <option value="Year 6">Year 6</option>
                            <option value="Year 5">Year 5</option>
                            <option value="Year 4">Year 4</option>
                        </select>

                        <label for="EbookAmount" class="fw-bolder py-2">Amount</label>
                        <!-- <div class="fw-bold">£ <input class="border-0 fw-bold rounded-pill" style=" color: #165BAA;" name="eBamount" value="18.99" id="EbookAmount" /></div> -->
                        <div class="fw-bold fs-5">£ <input type="text" class="shadow-none border-0 rounded-pill fw-bold"
                                style=" color: #165BAA;" value="18.99" name="eBamount" id="EbookAmount"
                                pattern="^\d+\.{0,1}\d{0,2}$" maxlength="6" required /></div>
                        <label for="terms" class="fw-bolder py-2">Term</label>
                        <select class="form-select shadow-none" name="terms" aria-label="Default select example"
                            required>
                            <!-- <option selected disabled>Select Term</option> -->
                            <option value="EBook">E-Book</option>
                        </select>

                        <!-- id="upDate" -->
                        <label for="fesFol" class="fw-bolder py-2">Choose E-Book</label>
                        <!--<input type="file" class="form-control shadow-none" name="files[]" multiple id="fesFol" webkitdirectory multiple required>-->
                        <input type="file" class="form-control shadow-none" name="files" id="fesFol" accept=".pdf">
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
                    <h3 class="text-center m-2"> E-BOOK <i class="fa-solid fa-book"></i></h3>
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

                        <label for="amount" class="fw-bolder">Amount</label>
                        <div class="fw-bold">£ <input type="text" id="amount" name="amount"
                                class="shadow-none border-0 rounded-pill fw-bold" value="18.99"
                                pattern="^\d+\.{0,1}\d{0,2}$" maxlength="6" required /></div>

                        <label for="Subject" class="fw-bolder py-2">Subject</label>
                        <select class="form-select fw-bold shadow-none" name="subject" id="subject"
                            aria-label="Default select example" required>
                            <option value="Year 6">Year 6</option>
                            <option value="Year 5">Year 5</option>
                            <option value="Year 4">Year 4</option>
                            <option value="Spanish">Spanish</option>
                        </select>
                        <div class="form-group fw-bold">
                            <label for="files">FILE NAME</label>
                            <input type="file" class="form-control shadow-none" name="files" id="files" accept=".pdf">
                            <div class="invalid-feedback">
                                Please Choose file
                            </div>
                        </div>
                        <input type="hidden" name="oldfile" id="oldfile">
                        <div class="d-flex justify-content-between">
                            <!-- <button type="button" class="btn shadow-none my-3 rounded fw-bold bg-danger text-white viewBackBtn" onclick="history.back()">Back</button> -->
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
        <div class="modal-dialog ">
            <div class="modal-content shadow p-2 rounded maindiv">
                <div class="modal-header">
                    <div class="h3 text-center m-2"> E-Book<i class="fa-solid fa-book mx-2"></i></div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Category:</label><span id="view_Category"
                            class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Subject Name:</label><span id="view_Language"
                            class="fs-5 border-0"></span>
                    </div>
                    <div class="mb-3">
                        <label class="fs-5 pe-2" for="">Amount: £</label><span id="view_Amount"
                            class="fs-5 border-0"></span>
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

    <!-- All E-Book Amount Change -->
    <div class="modal viewContainer" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  updateActivityCon">
            <div class="modal-content shadow p-2 rounded maindiv">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                    <h3 class="text-center m-2"> E-BOOK <i class="fa-solid fa-sack-dollar"></i></h3>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <div class="m-3">
                        <form id="eBook_Amt" class="needs-validation" novalidate>
                            <div id="errorMessage" class="alert alert-warning d-none"></div>
                            <input type="hidden" value="E-Book" name="section" />
                            <label for="">CATEGORY</label>
                            <select class="form-select fw-bold shadow-none" name="category" required>
                                <option value="SpaG">SpaG</option>
                                <option value="Creative writing">Creative writing</option>
                                <option value="Comprehension">Comprehension</option>
                                <option value="Vocabulary">Vocabulary</option>
                            </select>
                            <label for="subject">SUBJECT</label>
                            <select class="form-select fw-bold shadow-none" name="subject" required>
                                <option value="Year 6">Year 6</option>
                                <option value="Year 5">Year 5</option>
                                <option value="Year 4">Year 4</option>
                                <option value="Spanish">Spanish</option>
                            </select>
                            <label for="">AMOUNT</label>
                            <div class="input-group">
                                <div class="fw-bold text-secondary input-group-text">£ </div><input type="text"
                                    class="shadow-none form-control" style=" color: #165BAA;" name="eBamount" id=""
                                    placeholder="Enter your Offer Price" pattern="^\d+\.{0,1}\d{0,2}$" maxlength="6"
                                    required />
                                <small class="invalid-feedback">
                                    Please Enter Your Amount
                                </small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn shadow-none my-3 rounded fw-bold bg-danger text-white"
                                    data-bs-dismiss="modal">Back</button>
                                <button type="submit" class="btn shadow-none my-3 rounded fw-bold updateBtn">Click to
                                    Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include('adminpanel.php') ?>
    <div class="body_container">
        <?php include('adminHeader.php') ?>
        <div class="container">
            <div class="dash_Board_Hedding ">
                <h3 class="fw-bold text-center pt-3">E-BOOKS</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div><span class="fs-4 fw-bold" style=" color: #165BAA;">Subject</span></div>
                    <div class="my-2">
                        <!-- <div id="lang_btn" onchange="selectLang()"> -->
                        <input type="radio" name="subjectSelect" value="Year 6" class="subjectRadio filt"
                            id="year6-Hwork">
                        <label for="year6-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 6</label>
                        <input type="radio" name="subjectSelect" value="Year 5" class="subjectRadio filt"
                            id="year5-Hwork">
                        <label for="year5-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 5</label>
                        <input type="radio" name="subjectSelect" value="Year 4" class="subjectRadio filt"
                            id="year4-Hwork">
                        <label for="year4-Hwork" class="subjectBtn my-2 fw-bold user-select-none me-1">Year 4</label>
                        <!-- </div> -->
                    </div>
                </div>
            </div>

            <!-- terms -->

            <div>
                <span class="fs-4 fw-bold" style=" color: #165BAA;">Category</span>
            </div>
            <div id="cat_btn" class="my-2">
                <input type="radio" name="categorytSelect" value="SpaG" class="catRadio filt" id="pre-prep-cul">
                <label for="pre-prep-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">SpaG</label>
                <input type="radio" name="categorytSelect" value="Creative writing" class="catRadio filt" id="junior-cul">
                <label for="junior-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Creative writing</label>
                <input type="radio" name="categorytSelect" value="Comprehension" class="catRadio filt" id="Early-Teen-cul">
                <label for="Early-Teen-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Comprehension</label>
                <input type="radio" name="categorytSelect" value="Vocabulary" class="catRadio filt" id="adults-cul">
                <label for="adults-cul" class="subjectBtn my-2 fw-bold user-select-none me-1">Vocabulary</label>
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
                            <th scope="col">VIEW</th>
                            <th scope="col">EDIT</th>
                            <th scope="col">DELETE</th>
                        </tr>
                    </thead>
                    <tbody id="trBody" class="filter_data">
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end pb-5">
                <!-- <button type="button" class="btn shadow-none fw-bold" id="changeAmount" data-bs-toggle="modal" data-bs-target="#dataChangeModal">Change Amount</button> -->
                <button type="button" class="btn shadow-none fw-bold" id="changeAmount" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Change Amount
                </button>
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
            $('.filter_data').html('<td colspan="6"><div id="loading" style=""></div></td>');
            var action = 'E-Book';
            var selLang = get_filter('subjectRadio');
            var selTerm = get_filter('termRadio');
            var selCat = get_filter('catRadio');

            $.ajax({
                url: 'eBookFilter.php',
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
    const stuCatagory = document.getElementById('ebookSelectCategory');
    const eBookAmount = document.getElementById('EbookAmount');

    // console.log(stuCatagory);
    stuCatagory.addEventListener('change', () => {
        if (stuCatagory.value == 'SpaG') {
            eBookAmount.value = '18.99'
        } else if (stuCatagory.value == 'Creative writing') {
            eBookAmount.value = '21.99'
        } else {
            eBookAmount.value = '0'
        }
    })


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
            url: "eBookCode.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                var res = $.parseJSON(response);

                if (res.status == 100) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(res.message);


                } else if (res.status == 500) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error(res.message);
                    $('.uploadBtn').prop('disabled', false);
                    $('.uploadBtn img').addClass('d-none');
                    $('.progressBar').addClass('d-none');
                } else if (res.status == 200) {
                    $('#dataAddModal').modal('hide');
                    $('#saveData')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);
                    $('.uploadBtn').prop('disabled', false);
                    $('.uploadBtn img').addClass('d-none');
                    $('.progressBar').addClass('d-none');
                }
            }
        });

    });

    $(document).on('click', '.editDataBtn', function() {

        var data_id = $(this).val();
        // alert(data_id);
        $.ajax({
            type: "GET",
            url: "eBookCode.php?data_id=" + data_id,
            success: function(response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 404) {

                    alert(res.message);
                } else if (res.status == 200) {

                    $('#category').val(res.data.Category);
                    $('#subject').val(res.data.Subject);
                    $('#amount').val(res.data.Amount)
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
            url: "eBookCode.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#dataEditModal').modal('hide');
                $('#updateData')[0].reset();
                $('#myTable').load(location.href + " #myTable");
                $('.updateBtn').prop('disabled', false);
                $('.updateBtn img').addClass('d-none');
                $('.progressBar').addClass('d-none');
                var res = $.parseJSON(response);
                console.log(response);
                if (res.status == 422) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);

                    // } else if (res.status == 200) {



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

                alertify.set('notifier', 'position', 'top-right');
                alertify.success(res.message);



                $('#dataEditModal').modal('hide');
                $('#updateData')[0].reset();

                $('#myTable').load(location.href + " #myTable");

                $('#errorMessageUpdate').addClass('d-none');
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
                    $('#view_Amount').text(res.data.Amount);
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
                url: "eBookCode.php",
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

    $(document).on('submit', '#eBook_Amt', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        action = "update";
        $.ajax({
            type: "POST",
            url: "eBookCode.php",
            data: {
                data: formData,
                action: action
            },
            success: function(response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success('Successfully Updated');
                // $('#exampleModal').modal('hide');
                $('#eBook_Amt')[0].reset();
                $('#myTable').load(location.href + " #myTable");
                console.log(response);
                var res = $.parseJSON(response);
                // if (res.status == 500) {
                // alert(res.message);
                // } else {
                // alertify.set('notifier', 'position', 'top-right');
                // alertify.success(res.message);

                // $('#myTable').load(location.href + " #myTable");
                // }
            }

        });
    });
    </script>

</body>

</html>