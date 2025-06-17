<?php
if (!isset($_SESSION)) {
    session_start();

    require dirname(__DIR__) . '/database/dbconfig.php';

    $query = "SELECT * FROM students WHERE role = 10 ORDER BY id DESC";
    $run_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($run_query);
    
    $queryN = "SELECT * FROM students WHERE users_type = 'NewStudent'";
    $run_queryN = mysqli_query($connection, $queryN);
    $nScount = mysqli_num_rows($run_queryN);
    $queryO = "SELECT * FROM students WHERE users_type = 'ExistingStudent'";
    $run_queryO = mysqli_query($connection, $queryO);
    $oScount = mysqli_num_rows($run_queryO);
    
    $queryL = "SELECT * FROM students WHERE Stu_Status = 'Live'";
    $run_queryL = mysqli_query($connection, $queryL);
    $LScount = mysqli_num_rows($run_queryL);
    $queryP = "SELECT * FROM students WHERE Stu_Status = 'Pending'";
    $run_queryP = mysqli_query($connection, $queryP);
    $PScount = mysqli_num_rows($run_queryP);
    
    $fileQuery = "SELECT * FROM addhomework WHERE Section = 'Homework'";
    $fileQRun = mysqli_query($connection, $fileQuery);
    $hwresult = mysqli_num_rows($fileQRun);
    // $fileQuery = "SELECT * FROM addhomework WHERE Section = 'Activity'";
    // $fileQRun = mysqli_query($connection, $fileQuery);
    // $actresult = mysqli_num_rows($fileQRun);
    // $fileQuery = "SELECT * FROM addhomework WHERE Section = 'Songs'";
    // $fileQRun = mysqli_query($connection, $fileQuery);
    // $songresult = mysqli_num_rows($fileQRun);
    // $fileQuery = "SELECT * FROM addhomework WHERE Section = 'Festival'";
    // $fileQRun = mysqli_query($connection, $fileQuery);
    // $fesresult = mysqli_num_rows($fileQRun);
    $fileQuery = "SELECT * FROM addhomework WHERE Section = 'E-Book'";
    $fileQRun = mysqli_query($connection, $fileQuery);
    $ebresult = mysqli_num_rows($fileQRun);
     $fileQuery = "SELECT * FROM newsletter";
    $fileQRun = mysqli_query($connection, $fileQuery);
    $subresult = mysqli_num_rows($fileQRun);
    if (!isset($_SESSION['logged_in']) == true) {
    header('Location:' . BASE_URL . 'Login.php');
    }
    
    // Student list refresh function 
        function RefreshStudent($run_queryL,$connection){

        // echo '<pre>';
        $getLSdetail=mysqli_fetch_all($run_queryL, MYSQLI_ASSOC);
        // var_dump(count($getLSdetail));
        
        $date = new DateTime();
        $setDate=$date->modify("-77 days")->format('Y-m-d H:i:s');
        foreach($getLSdetail as $getDate){
            $userid= $getDate['id'];
            $_query = "SELECT * FROM terms_details WHERE student_id = $userid AND termname <> 'EBook' AND termname <> 'TEST' ORDER BY id DESC LIMIT 1";
            $query_run1 = mysqli_query($connection, $_query);
            $termrow = mysqli_fetch_array($query_run1);
            if($termrow['student_id']??null && $termrow){

                // echo $termrow['student_id'].'  ';
                // echo $termrow['created_at'];
                // echo '  ==>>  ';
                // echo $setDate;
                // echo $date;
                if($termrow['created_at']<$setDate){
                    $update_sql = "UPDATE students SET Stu_Status = 'Pending' WHERE id= $userid ";
                    $query_run = mysqli_query($connection, $update_sql);
                // echo '  PENDING';
                // }else{
                // echo '  LIVE';
                }
                // echo $getDate['Stu_Status'];
                // echo '<br>';
            }
        }
        //    print_r($getLSdetail['updated_at']);
    }
    RefreshStudent($run_queryL,$connection);
}
//
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids |Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/AdminPanel/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<style>
#newsletter {
    background-color: #ff6600;
    color: white;
    transition: .5s;
}

#newsletter:hover {
    transform: scale(1.01);
    background-color: rgb(255, 102, 0, .7);
}

.table-striped>tbody>tr:nth-child(even)>td,
.table-striped>tbody>tr:nth-child(even)>th {
    background-color: #F5DCD9;
}
</style>

<body>
    <!-- MAIL SEND for newsletter -->
    <div class="modal mailSendContainer" id="mailSentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog rounded">
            <div class="modal-content shadow p-1 maindiv">
                <div class="modal-header">
                    <label for="enter maessage" class="fw-bold mb-2" style="color: #165BAA;font-size: 20px;">Send A
                        Newsletter!</label>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="send" class="needs-validation p-3" novalidate
                    enctype="multipart/form-data">
                    <label for="mailHeading" class="h5 my-2 fw-bold" style="color: #165BAA;">Title</label>
                    <input type="text" name="newsLetterHeading" id="mailHeading"
                        class="form-control shadow-none rounded" placeholder="Enter mail title" required>
                    <label for="email_text" class="h5 my-2 fw-bold" style="color: #165BAA;">Message</label>
                    <textarea class="form-control shadow-none rounded" name="news" id="email_text" cols="50" rows="5"
                        autofocus required></textarea>
                    <div class="d-flex justify-content-end">
                        <label for="image" class="h5 p-3 form-label d-block cursor-pointer" style="color: #165BAA;"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Attach files">
                            <span class="fileName" style="font-size:15px ; color:gray;"></span>
                            <i class="fa-solid fa-paperclip"></i>
                        </label>
                        <input type="file" name='files' id="image" class="d-none">
                    </div>
                    <div class="d-flex justify-content-between modal-body">
                        <input type="hidden" name="newsletter" id="action" value="newsletter" />
                        <button type="button" class="btn shadow-none rounded fw-bold bg-dark text-white"
                            data-bs-dismiss="modal">Back</button>
                        <button type="submit" value='newsletter'
                            class="btn shadow-none bg-success text-white fw-bold uploadBtn"><img
                                src="./assect/logo/fileupload.gif" class="me-1 pb-1 d-none" width="20px">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- student details View popup Modal -->
    <?php include('StudentView.php') ?>

    <?php include('adminpanel.php') ?>
    <div class="body_container">
        <?php include('adminHeader.php') ?>
        <div class="container">
            <div class="mt-3 row gap-2 mb-5 gx-0">
                <div class="d-flex justify-content-between">
                    <div class="dash_Board_Hedding">
                        <h2>Dashboard</h2>
                    </div>
                    <div>
                        <button class="btn shadow-none fw-bold position-relative" id="newsletter" data-bs-toggle="modal"
                            data-bs-target="#mailSentModal">
                            Send Newsletter
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                                <?php echo $subresult ?>
                        </button>
                    </div>
                </div>
                <div
                    class="col-lg col-5 card position-relative shadow d-flex justify-content-center incom_container bg_before1 ps-3">
                    <span class="content_text h3"><?php echo $count; ?></span>
                    <span class="heding_text  fw-bold">STUDENTS</span>
                    <!--        <div class="position-absolute top-0 end-0">-->
                    <!--            <div>-->
                    <!--                <span class="badge stuTtip" data-bs-toggle="tooltip" data-bs-placement="top" title="NEW STUDENTS"><?php echo $nScount; ?></span>-->
                    <!--                <span class="badge stuTtip" data-bs-toggle="tooltip" data-bs-placement="top" title="EXISTING STUDENTS"><?php echo $oScount; ?></span>-->
                    <!--            </div>-->
                    <!--            <div>-->
                    <!--                <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="LIVE STUDENTS"><?php echo $LScount; ?></span>-->
                    <!--                <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="PENDING STUDENTS"><?php echo $PScount; ?></span>-->
                    <!--            </div>-->
                    <!--            <div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                </div>
                <a href="HomeWork.php"
                    class="col-lg col-5 card shadow d-flex justify-content-center incom_container bg_before2 ps-3 text-decoration-none">
                    <span class="content_text h3 text-dark"><?php echo $hwresult; ?></span>
                    <span class="heding_text  fw-bold" style="color:#8dc800;">HOMEWORKS</span>
                </a>
                <!-- Commenting out Songs, Culture Topic, and Festivals sections -->
                <?php /*
                <a href="songsAdmin.php"
                    class="col-lg col-5 card shadow d-flex justify-content-center incom_container bg_before3 ps-3 text-decoration-none">
                    <span class="content_text h3 text-dark"><?php echo $songresult; ?></span>
                    <span class="heding_text  fw-bold" style="color:#01a2c8;">SONGS</span>
                </a>
                <a href="culturalAdmin.php"
                    class="col-lg col-5 card shadow d-flex justify-content-center incom_container bg_before4 ps-3 text-decoration-none">
                    <span class="content_text h3 text-dark"><?php echo $fesresult; ?></span>
                    <span class="heding_text fw-bold" style="color:#ff6600;">CULTURE TOPIC</span>
                </a>
                <a href="activityAdmin.php"
                    class="col-lg col-5 card shadow d-flex justify-content-center incom_container bg_before5 ps-3 text-decoration-none">
                    <span class="content_text h3 text-dark"><?php echo $actresult; ?></span>
                    <span class="heding_text fw-bold" style="color:#FFAC0D;">FESTIVALS</span>
                </a>
                */ ?>
                <a href="E-Book.php"
                    class="col-lg col-5 card shadow d-flex justify-content-center incom_container bg_before6 ps-3 text-decoration-none">
                    <span class="content_text h3 text-dark"><?php echo $ebresult; ?></span>
                    <span class="heding_text fw-bold" style="color:#bf0a92;">E-BOOK</span>
                </a>
            </div>

            <div class="dash_Board_Hedding">
                <h3 class="fw-bold text-center">Recent Application</h2>
            </div>

            <div class="tablContainer">
                <table class="table table-bordered table-striped pt-3" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Kids Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Subject</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Application Status</th>
                            <th scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($run_query) > 0) {
                            //$results = mysqli_fetch_array($run_query, MYSQLI_ASSOC);
                            $serialNumber = 1;
                            while($row = mysqli_fetch_assoc($run_query))  {
                                $dateFormat = date('d-m-Y', strtotime($row['dob']));
                        ?>

                        <tr class="align-middle">
                            <td><?php echo $serialNumber; ?></td>
                            <td class="position-relative "><?= $row['fname']; ?> </td>
                            <!--<td><?php echo $row['fname']; ?></td>-->
                            <td><?php echo $row['Stu_Cat']; ?></td>
                            <td><?php echo $row['Stu_Sub']; ?></td>
                            <td><?php echo $dateFormat; ?></td>
                            <?php
                                    if ($row['Stu_Status'] == 'Live') {
                                    ?>
                            <td class="bg-success text-white text-center"><?= $row['Stu_Status']; ?></td>
                            <?php
                                    } else {
                                    ?>
                            <td class="bg-danger text-white text-center"><?= $row['Stu_Status']; ?></td>
                            <?php
                                    }
                                    ?>
                            <td><button type="button" class="btn fw-bold shadow-none viewBtn viewDataBtn"
                                    value="<?php echo $row['id']; ?>"><i
                                        class="fa-regular fa-eye pe-1"></i>View</button></td>
                        </tr>
                        <?php 
                                $serialNumber++;
                            }
                        } else { ?>
                        <td colspan="6" class="text-denger">No Students Found Here...! </td>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#mytable').DataTable();
});

$(document).on('submit', '#send', function(event) {
    event.preventDefault();
    $('.uploadBtn').prop('disabled', true);
    $('.uploadBtn img').removeClass('d-none');
    $('#send').attr('disabled', 'disabled');

    $.ajax({
        url: "newsletter.php",
        method: "POST",
        data: new FormData(this),
        //action : action,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 'not') {
                alert('Newsletters Not Delivered...!');
            } else if (data == 'NO') {
                alert('Message Unable to get :(')
            } else {
                $('#send').attr('disabled', 'flase');
                $('.uploadBtn').prop('disabled', false);
                $('.uploadBtn img').addClass('d-none');
                alert("Newsletter Delivered Successful :)");
                location.reload(true);
            }

        }
    });
});

$(document).on('click', '.viewDataBtn', function() {
    $('#dataViewModal').modal('show');
    var data_id = $(this).val();
    //alert(data_id);
    $.ajax({
        type: "GET",
        url: "studentsCode.php?data_id=" + data_id,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            console.log(res.term);
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
                if (res.data.terms != '') {
                    $('.view_term').text(res.data.terms);
                } else {
                    $('.view_term').text('');
                }
                $('.view_dofe').text(res.data.DOFE);
                $('#view_status').text(res.data.Stu_Status.toUpperCase());
                $('#pFname').text(res.data.parentfirstname.toUpperCase());
                $('#pSname').text(res.data.parentsurname.toUpperCase());
                $('#view_address').text(res.data.address.toUpperCase());
                $('.view_eMail').text(res.data.email);
                $('#userpwd').text(res.data.password);
                $('.view_Ph').text(res.data.phone);
                $('#view_CrAmt').text(res.data.child_category);
                $('#view_YoN').text(res.data.yesorno.toUpperCase());
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
const fileName = document.querySelector('.fileName');
const image = document.getElementById('image');

image.addEventListener('change', () => {
    var file = image.value.split(/(\\|\/)/g).pop();
    fileName.textContent = file;
})
</script>