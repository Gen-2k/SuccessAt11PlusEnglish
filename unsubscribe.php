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
            border: 1px solid #1e40af;
        }


        .h4 {
            color: #1e40af;

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
        $unPage = 'form'; // 'form', 'success', 'error'
        $message = '';
        $unsubMail = '';
        
        // Get encoded email from GET or POST
        $encodedUnsubEmail = '';
        if (isset($_GET['unsub_email']) && !empty(trim($_GET['unsub_email']))) {
            $encodedUnsubEmail = trim(urldecode($_GET['unsub_email']));
        } elseif (isset($_POST['unsub_email']) && !empty(trim($_POST['unsub_email']))) {
            $encodedUnsubEmail = trim($_POST['unsub_email']);
        }
        
        // Validate and decode email
        if (!empty($encodedUnsubEmail)) {
            // Try to decode the base64
            $decodedEmail = base64_decode($encodedUnsubEmail, true);
            
            if ($decodedEmail !== false && !empty($decodedEmail)) {
                $unsubMail = $decodedEmail;
                // Validate email format
                if (!filter_var($unsubMail, FILTER_VALIDATE_EMAIL)) {
                    $unPage = 'error';
                    $message = 'The email address in the unsubscribe link is not valid.';
                }
            } else {
                $unPage = 'error';
                $message = 'The unsubscribe link appears to be corrupted. Please use the original link from your email.';
            }
        } else {
            $unPage = 'error';
            $message = 'This page requires a valid unsubscribe link. Please use the unsubscribe link from your email newsletter.';
        }
        
        // Process unsubscribe request
        if (isset($_POST['unsub_submit']) && $unPage == 'form') {
            // Check if email exists in newsletter
            $stmt = mysqli_prepare($connection, "SELECT id FROM newsletter WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $unsubMail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                // Email exists, delete it
                $deleteStmt = mysqli_prepare($connection, "DELETE FROM newsletter WHERE email = ?");
                mysqli_stmt_bind_param($deleteStmt, "s", $unsubMail);
                
                if (mysqli_stmt_execute($deleteStmt)) {
                    $unPage = 'success';
                    $message = 'You have been successfully unsubscribed from our newsletter';
                } else {
                    $unPage = 'error';
                    $message = 'Error occurred while unsubscribing. Please try again later';
                }
                mysqli_stmt_close($deleteStmt);
            } else {
                $unPage = 'error';
                $message = 'Email address not found in our newsletter subscription list';
            }
            mysqli_stmt_close($stmt);
        }
    ?>
<div class="container d-flex justify-content-center">
    <div class="unsubcribeContainer">
        <div class="box_shad d-flex my-3 p-3">
            <div class="" style="background-color: #fff; padding: 20px; width: 100%;">
                
                <?php if ($unPage == 'form'): ?>
                    <!-- Show unsubscribe form -->
                    <div class="h4 text-center fw-bold">Do you want to unsubscribe?</div>
                    <form action="" method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="unsub_email" value="<?php echo htmlspecialchars($encodedUnsubEmail); ?>">
                        <p class="txt">Hi,</p>
                        <p class="txt">If you unsubscribe your email <span class="text-primary fw-bold">"<?php echo htmlspecialchars($unsubMail); ?>"</span>, you will no longer receive our newsletter emails.</p>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="unsub_submit" class="btn btn-primary" style="background-color: #1e40af; border-color: #1e40af;">
                                Unsubscribe
                            </button>
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                
                <?php elseif ($unPage == 'success'): ?>
                    <!-- Show success message -->
                    <div class="text-center">
                        <div class="h4 text-success fw-bold mb-3">✓ Unsubscribed Successfully</div>
                        <p class="text-muted"><?php echo htmlspecialchars($message); ?></p>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary mt-3">Return to Website</a>
                    </div>
                
                <?php else: ?>
                    <!-- Show error message -->
                    <div class="text-center">
                        <div class="h4 text-danger fw-bold mb-3">⚠ Error</div>
                        <p class="text-muted"><?php echo htmlspecialchars($message); ?></p>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary mt-3">Return to Website</a>
                    </div>
                
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>

    <?php include('footer.php') ?>

</body>

</html>