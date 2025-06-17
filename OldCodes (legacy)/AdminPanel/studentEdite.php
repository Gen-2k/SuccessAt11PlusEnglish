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
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="smile4kids" />
    <!-- <title>Smile4Kids | Student</title> -->
    <!-- <link rel="stylesheet" href="style.css"> -->

    <link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <style>
    .editeStudentContainer {
        background-color: rgb(0, 0, 0, .5);
        height: 100vh;
        width: 100%;
        display: flex;
        z-index: 100;
    }

    .editeStudentContainer .card {
        width: 800px;
    }

    .comple-term-select-con label {
        user-select: none;
        background-color: lightgray;
        padding: 5px 10px;
        border-radius: 25px;
        font-weight: bold;
        cursor: pointer;
        margin: 5px 3px;
    }

    .comple-term-select-con input {
        display: none;
    }

    .comple-term-select-con input:checked+label {
        background-color: green;
        color: white;
    }

    .colpurple {
        color: #6e20a7;
    }

    span {
        color: red;
    }
    </style>

</head>

<body>
    <div class="editeStudentContainer position-fixed  justify-content-center align-items-center">
        <div class="card p-3">
            <div class="h4 fw-bold colpurple text-center">STUDENT DETAILS</div>
            <div class="my-2 mt-2 mb-2">
                <div class="row">
                    <div class="col-sm">
                        <div class="fw-bold">FIRSTNAME : <span>Siva</span></div>
                        <div class="fw-bold">SURNAME : <span>Sankaran</span></div>
                        <div class="fw-bold">DATE OF BIRTH : <span>11-07-1998</span></div>
                        <div class="fw-bold">GENDER : <span>Male</span></div>
                    </div>

                    <div class="col-sm">
                        <div class="fw-bold">CATEGORY : <span> ADULTS </span></div>
                        <div class="fw-bold">SUBJECT : <span> Panjabi</span></div>
                        <div class="fw-bold">EMAIL ADDRESS : <span> mailto:siva@gmail.com</span></div>
                        <div class="fw-bold">PHONE NUMBER : <span> 86598658989 </span></div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="comple-term-select-con ">
                <div class="h4 fw-bold colpurple">Select Completed Term</div>
                <div>
                    <input type="checkbox" class="form-check-input" id="completeT-1">
                    <label for="completeT-1">Term 1</label>
                    <input type="checkbox" class="form-check-input" id="completeT-2">
                    <label for="completeT-2">Term 2</label>
                    <input type="checkbox" class="form-check-input" id="completeT-3">
                    <label for="completeT-3">Term 3</label>
                    <input type="checkbox" class="form-check-input" id="completeT-4">
                    <label for="completeT-4">Term 4</label>
                    <input type="checkbox" class="form-check-input" id="completeT-5">
                    <label for="completeT-5">Term 5</label>
                    <input type="checkbox" class="form-check-input" id="completeT-6">
                    <label for="completeT-6">Term 6</label>
                    <input type="checkbox" class="form-check-input" id="completeT-7">
                    <label for="completeT-7">Term 7</label>
                    <input type="checkbox" class="form-check-input" id="completeT-8">
                    <label for="completeT-8">Term 8</label>
                    <input type="checkbox" class="form-check-input" id="completeT-9">
                    <label for="completeT-9">Term 9</label>
                    <input type="checkbox" class="form-check-input" id="completeT-10">
                    <label for="completeT-10">Term 10</label>
                    <input type="checkbox" class="form-check-input" id="completeT-11">
                    <label for="completeT-11">Term 11</label>
                    <input type="checkbox" class="form-check-input" id="completeT-12">
                    <label for="completeT-12">Term 12</label>
                    <input type="checkbox" class="form-check-input" id="completeT-13">
                    <label for="completeT-13">Term 13</label>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <div><button class="btn shadow-none bg-danger fw-bold text-white" onclick="history.back()">Back</button>
                </div>
                <div><button class="btn shadow-none bg-success fw-bold text-white">Update</button></div>
            </div>
        </div>
    </div>
</body>

</html>