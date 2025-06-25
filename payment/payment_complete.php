<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/../database/dbconfig.php';

// Check if there's a success message
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

if (!$successMessage) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful | Success at 11 Plus English</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --theme-blue: #1e40af;
            --theme-gold: #f59e0b;
            --success-green: #16a34a;
            --bg-light: #f8fafc;
            --bg-credentials: #e8f5e8;
            --text-dark: #222;
        }
        body {
            background: linear-gradient(135deg, var(--theme-blue) 0%, var(--theme-gold) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .success-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(30,64,175,0.10);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }
        .success-header {
            background: var(--success-green);
            color: #fff;
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
        }
        .success-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 2.5rem;
        }
        .success-body {
            padding: 2.5rem 2rem;
            color: var(--text-dark);
        }
        .alert-info {
            background: var(--bg-light);
            border: 1px solid #e0e7ef;
            color: var(--theme-blue);
        }
        .details {
            background: var(--bg-light);
            border-radius: 0.7rem;
            padding: 1.2rem 1.5rem;
            margin: 1.5rem 0;
        }
        .credentials {
            background: var(--bg-credentials);
            border-radius: 0.7rem;
            padding: 1.2rem 1.5rem;
            margin: 1.5rem 0;
        }
        .btn-primary {
            background: var(--theme-blue);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-outline-primary {
            color: var(--theme-blue);
            border-color: var(--theme-blue);
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-outline-primary:hover {
            background: var(--theme-blue);
            border-color: var(--theme-blue);
            color: #fff;
        }
        .footer {
            text-align: center;
            color: #888;
            font-size: 0.95rem;
            padding: 1.5rem 2rem 2rem;
        }
        .footer a { color: var(--theme-blue); text-decoration: none; }
        @media (max-width: 600px) {
            .success-card, .success-body, .footer { padding: 1rem !important; }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h1 class="h2 mb-0">Payment Successful!</h1>
                <div style="font-size:1.1rem;opacity:0.95;">Thank you for your purchase</div>
            </div>
            <div class="success-body">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
                <div class="details">
                    <h3 style="color:#1e40af;margin-top:0;">What happens next?</h3>
                    <div class="row text-start mb-4">
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3 mt-1">
                                    <i class="bi bi-envelope-fill text-primary fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Check Your Email</h6>
                                    <small class="text-muted">Your login credentials have been sent to your email address.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3 mt-1">
                                    <i class="bi bi-person-check-fill text-success fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Access Your Account</h6>
                                    <small class="text-muted">Use the credentials to log in and start your learning journey.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3 mt-1">
                                    <i class="bi bi-book-fill text-info fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Start Learning</h6>
                                    <small class="text-muted">Access your module content and begin your studies immediately.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="credentials">
                
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                        <a href="<?php echo BASE_URL; ?>Login.php" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Now
                        </a>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-primary">
                            <i class="bi bi-house-fill me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
                <hr class="my-4">
                <div class="footer">
                    <p class="mb-2">
                        <i class="bi bi-headset me-2"></i>
                        Need help? Contact us at 
                        <a href="mailto:success@elevenplusenglish.co.uk" class="text-decoration-none">success@elevenplusenglish.co.uk</a>
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-globe me-2"></i>
                        Visit <a href="https://elevenplusenglish.co.uk" class="text-decoration-none">elevenplusenglish.co.uk</a>
                    </p>
                    <p style="margin-top:1.2rem;">&copy; <?php echo date('Y'); ?> Success At 11 Plus English</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
