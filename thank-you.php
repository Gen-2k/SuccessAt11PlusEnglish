<?php
session_start();

// Check if the user was redirected properly
if (!isset($_SESSION['form_submitted']) || $_SESSION['form_submitted'] !== true) {
    // Redirect to the home page if someone tries to access this directly
    header('Location: index.php');
    exit;
}

// Clear the session variable once it's been used
$_SESSION['form_submitted'] = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Success At 11 Plus English - Thank You for Your Application">
    <title>Success At 11 Plus English | Thank You</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --theme-violet: #6e20a7;
            --theme-violet-dark: #5a1a8a;
            --theme-teal: #20c997;
            --theme-teal-dark: #19a479;
            --text-muted: #6c757d;
            --heading-color: #343a40;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
            --card-border: #dee2e6;
        }
        
        body {
            background-color: var(--body-bg);
            font-family: 'Lato', sans-serif;
            color: #495057;
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--heading-color);
        }
        
        .thank-you-container {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f9f7ff, #f0f8ff);
            flex: 1;
        }
        
        .thank-you-card {
            background: var(--card-bg);
            border-radius: 16px;
            border-top: 5px solid var(--theme-violet);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin: 1rem auto;
            text-align: center;
            max-width: 700px;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--theme-violet), #9541d3);
            color: white;
            padding: 1.75rem;
            border-bottom: none;
            position: relative;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(90deg, #6e20a7, #9541d3, #6e20a7);
            opacity: 0.6;
        }
        
        .card-header h2 {
            margin-bottom: 0;
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .card-body {
            padding: 3rem 2rem;
        }
        
        .thank-you-icon {
            font-size: 5rem;
            color: var(--theme-violet);
            margin-bottom: 1.5rem;
            display: inline-block;
            background: linear-gradient(135deg, var(--theme-violet), #9541d3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--theme-violet), #9541d3);
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 100px;
            border: none;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            box-shadow: 0 4px 15px rgba(110, 32, 167, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a1a8a, var(--theme-violet));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(110, 32, 167, 0.4);
        }
        
        @media (max-width: 767.98px) {
            .thank-you-container {
                padding: 3rem 0;
            }
            
            .card-header h2 {
                font-size: 1.8rem;
            }
            
            .thank-you-icon {
                font-size: 4rem;
            }
        }
    </style>
</head>

<body>
    <div class="sticky-sm-top">
        <?php include('navbar2.php') ?>
    </div>
    
    <div class="container-fluid thank-you-container">
        <div class="container">
            <div class="thank-you-card">
                <div class="card-header">
                    <h2>Thank You!</h2>
                </div>
                <div class="card-body">
                    <div class="thank-you-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h3>Application Submitted Successfully</h3>
                    <p class="lead mb-4">Thank you for your interest in our trial class. Your application has been received!</p>
                    <p>Our team will contact you within 24 hours to arrange your session. In the meantime, we've sent a confirmation email to your inbox.</p>
                    <p>If you have any questions, please feel free to contact us.</p>
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-house-door-fill me-2"></i>Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>