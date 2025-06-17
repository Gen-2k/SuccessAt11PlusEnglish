<?php
if (!isset($_SESSION)) {
    session_start();
    require_once __DIR__ . '/database/dbconfig.php';

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Success At 11 Plus English | Unsubscribe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <style>
     .unsubcribeContainer {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form .input_enter {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: px solid #ccc;
            outline: none;
        }

        form .input_enter:focus {
            border: 1px solid #6e20a7;
        }


        .h4 {
            color: #6e20a7;

        }

        .txt {
            font-weight: bold;
            color: black;
        }

        /* login */
        .box_shad {
            max-width: 500px;
            box-shadow: 3px 3px 20px 10px #e5caf7;
            margin-top: 10%;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="sticky-sm-top">
        <?php include('navbar2.php') ?>
    </div>
    <?php
        $unPage="0";
        $error_message="";
        $unsubMail=base64_decode($_GET['unsub_email']);
        if(isset($_POST['unsub_submit'])){
            $nlselectQ="SELECT * FROM newsletter WHERE Subr_email = '$unsubMail'";
            $nlselectQR=mysqli_query($connection, $nlselectQ);
            if($nlselectQR){
                $nlunsubQ="DELETE FROM newsletter WHERE Subr_email = '$unsubMail'";
                $nlunsubQR=mysqli_query($connection, $nlunsubQ);
                if($nlunsubQR){
                    $unPage="1";
                    $error_message="Unsubscribed Successfully";
                }else{
                    $unPage="0";
                    $error_message="Try Again Later";
                }
            }else{
                $unPage="0";
                $error_message="Not yet to subscribe";
            }
        }
    ?>
<div class="container d-flex justify-content-center">
        <div class="unsubcribeContainer">
            <div class="box_shad d-flex my-3 p-3">
                <?php if (!empty($unPage == '0')) { ?>
                    <div class="" style="background-color: #fff; padding: 10px">
                        <div class="h4 text-center fw-bold"> Do you want to unsubscribe ? </div>
                        <?php
                        if (!empty($error_message)) {
                        ?>
                            <div class="message error_message text-danger fs-5 text-center"><?php echo $error_message; ?></div>
                        <?php
                        }
                        ?>
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <p class="txt">Hi,</p>
                            <p for="email" class="txt">If you unsubscribe your email <span class="text-secondary">"<?php echo $unsubMail; ?>"</span>, you will no longer receive our newsletter emails.</p>
                            <div class="d-flex justify-content-between">
                                <button type="submit" name="unsub_submit" class="btn  btn-block" style="background-color: #6e20a7; color: #fff; ">
                                    Unsubscribe
                                </button>
                                <a href="https://www.successat11plusenglish.com/" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
            <?php } elseif (!empty($unPage == '1')) {
                    if (!empty($error_message)) {
            ?>
                <div class=" text-success fs-1 text-center"><?php echo $error_message; ?></div>
        <?php
                    }
                } ?>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

</body>

</html>