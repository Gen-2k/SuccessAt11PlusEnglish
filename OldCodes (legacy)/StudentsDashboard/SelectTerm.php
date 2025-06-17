<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['logged_in']) == true) {
  header("Location:../Login");
}
require dirname(__DIR__) . '/database/dbconfig.php';
$userId = $_SESSION['id'];
$query1 = "SELECT * FROM terms_details WHERE student_id = '$userId'";
$query_run1 = mysqli_query($connection, $query1);
$query2 = "SELECT * FROM students WHERE id = '$userId'";
$query_run2 = mysqli_query($connection, $query2);
// die();

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--<meta name="description" content="smile4kids" />-->
  <title>Smile4Kids | Notification</title>
  <!--<link rel="stylesheet" href="../S4K/s4khome.css" />-->
  <!--<link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=oswald&family=georgia%family=serif">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <!-- jquery link -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .ourClassContainer {
      position: fixed;
      top: 0;
      justify-content: center;
      align-items: center;
      height: 100%;
      width: 100%;
      background-color: rgb(0, 0, 0, .5);
    }


    @keyframes popupOurclases {
      from {
        transform: scale(0.5);
      }

      to {
        transform: scale(1);
      }
    }

    .ourClassChild {
      border-radius: 5px;
      padding: 20px;
      background-color: white;
      max-width: 600px;
      animation: popupOurclases .5s;
    }

    .ourclass_close_btn_div .ourclass_close_btn {
      background-color: #dff9fb;
      color: #079992;
      font-weight: bold;
    }

    .colpurple {
      color: #6e20a7;
      font-size: 20px;
    }
  </style>
</head>

<body>
  <div class="ourClassContainer d-flex justify-content-center align-items-center pre-Prep">
    <div class="ourClassChild fw-bold">
        <div class="fw-bold h5 colpurple text-warning" style="color:#263326">Purchased Terms: </div>
      <div class="text-secondary"><?php echo mysqli_fetch_assoc($query_run2)['terms']; ?></div>
      <hr>
      <h3 class="colpurple fw-bold">Do you want to buy another term?</h3>


      <div class="d-flex justify-content-center ourclass_close_btn_div mt-3">
          <?php 
            if(mysqli_num_rows($query_run1)>0){
                //$row1 = mysqli_fetch_assoc($query_run1);
                    // echo '<pre>';
                    // print_r($row1);
                    //if($row1['termname'] == 'EBook'){ ?>
                        <!--<a href="BuyTerm" class="btn shadow-none ourclass_close_btn mx-2">YES</a>-->
                   <?php //}else{ ?>
                        <a href="purchaseTerms" class="btn shadow-none ourclass_close_btn mx-2">YES</a>
                   <?php
                   // }
                    
                
            }else{ ?>
                <a href="BuyTerm" class="btn shadow-none ourclass_close_btn mx-2">YES</a>
        <?php    }
          
          ?>
        
        <a href="adminstu" class="btn shadow-none ourclass_close_btn mx-2">NO</a>
        <!-- <button class="btn shadow-none ourclass_close_btn mx-2" type="button">YES</button>
        <button class="btn shadow-none ourclass_close_btn mx-2" type="button">NO</button> -->
      </div>
    </div>
  </div>

</body>

</html>