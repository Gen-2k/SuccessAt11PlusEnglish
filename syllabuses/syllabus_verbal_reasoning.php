<?php
// Define BASE_URL if not already defined globally
if (!defined('BASE_URL')) { define('BASE_URL', '/'); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="Verbal Reasoning Syllabus, 11 Plus English, VR Questions, Logical Thinking, Pattern Recognition, Year 4, Year 5">
    <meta name="description" content="Comprehensive Verbal Reasoning syllabus for 11 Plus English preparation covering all VR question types with detailed weekly structure and techniques.">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:site_name" content="Success At 11 Plus English">
    <meta property="og:title" content="Verbal Reasoning Syllabus | Success At 11 Plus English">
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="og:image" content="<?php echo rtrim(BASE_URL, '/'); ?>/assets/images/logonew.png">
    
    <title>Verbal Reasoning Syllabus | Success At 11 Plus English</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo rtrim(BASE_URL, '/'); ?>/assets/images/logonew.png">

    <style>
        :root {
            /* Primary Color Palette - Royal Blue Family (Admin Panel Colors) */
            --primary-900: #0f172a;
            --primary-800: #1e293b;
            --primary-700: #1E3A8A;
            --primary-600: #1E40AF;
            --primary-500: #1E40AF;
            --primary-400: #3B82F6;
            --primary-300: #93c5fd;
            --primary-200: #DBEAFE;
            --primary-100: #eff6ff;

            /* Secondary Color Palette - Golden Yellow Family */
            --secondary-900: #78350f;
            --secondary-800: #92400e;
            --secondary-700: #b45309;
            --secondary-600: #d97706;
            --secondary-500: #f59e0b;
            --secondary-400: #fbbf24;
            --secondary-300: #fcd34d;
            --secondary-200: #fde68a;
            --secondary-100: #fef3c7;

            /* Neutral Palette */
            --neutral-900: #111827;
            --neutral-800: #1f2937;
            --neutral-700: #374151;
            --neutral-600: #4b5563;
            --neutral-500: #6b7280;
            --neutral-400: #9ca3af;
            --neutral-300: #d1d5db;
            --neutral-200: #e5e7eb;
            --neutral-100: #f3f4f6;
            --neutral-50: #f9fafb;
            --white: #ffffff;

            /* Semantic Colors */
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #3b82f6;

            /* Design System Variables */
            --border-radius-sm: 0.375rem;
            --border-radius-md: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;
            --border-radius-2xl: 1.5rem;

            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            --spacing-3xl: 4rem;

            --font-size-xs: 0.75rem;
            --font-size-sm: 0.875rem;
            --font-size-base: 1rem;
            --font-size-lg: 1.125rem;
            --font-size-xl: 1.25rem;
            --font-size-2xl: 1.5rem;
            --font-size-3xl: 1.875rem;
            --font-size-4xl: 2.25rem;
            --font-size-5xl: 3rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--neutral-50) 0%, var(--white) 100%);
            color: var(--neutral-800);
            font-size: var(--font-size-lg);
            line-height: 1.6;
            min-height: 100vh;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .main-container {
            max-width: 1200px;
            margin: var(--spacing-xl) auto;
            padding: var(--spacing-2xl);
            background: var(--white);
            box-shadow: var(--shadow-xl);
            border-radius: var(--border-radius-2xl);
            border: 1px solid var(--neutral-200);
        }

        /* Typography Scale */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            line-height: 1.25;
            color: var(--neutral-900);
            margin-bottom: var(--spacing-md);
        }

        h1 { font-size: var(--font-size-5xl); }
        h2 { font-size: var(--font-size-3xl); }
        h3 { font-size: var(--font-size-2xl); }
        h4 { font-size: var(--font-size-xl); }

        p {
            line-height: 1.7;
            color: var(--neutral-600);
            margin-bottom: var(--spacing-md);
        }

        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: var(--spacing-3xl);
            padding: var(--spacing-3xl) var(--spacing-xl);
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-700) 100%);
            border-radius: var(--border-radius-2xl);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -25%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: var(--secondary-400);
            border-radius: 50%;
            opacity: 0.15;
        }

        .header-section::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -5%;
            width: 150px;
            height: 150px;
            background: var(--secondary-300);
            border-radius: 50%;
            opacity: 0.1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .main-title {
            font-size: var(--font-size-5xl);
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            color: var(--white);
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: var(--font-size-xl);
            color: var(--primary-100);
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
            line-height: 1.6;
        }

        /* Navigation */
        .back-navigation {
            margin-bottom: var(--spacing-xl);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            background: var(--secondary-400);
            color: var(--primary-800);
            padding: var(--spacing-md) var(--spacing-xl);
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: var(--font-size-base);
            box-shadow: var(--shadow-md);
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background: var(--secondary-500);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .back-btn i {
            margin-right: var(--spacing-sm);
            font-size: var(--font-size-sm);
        }

        /* Timeline Container */
        .timeline-container {
            position: relative;
            margin: var(--spacing-3xl) 0;
        }

        .timeline-line {
            position: absolute;
            left: 2rem;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-400), var(--secondary-400));
            border-radius: var(--border-radius-sm);
        }

        /* Section Dividers */
        .section-divider {
            display: flex;
            align-items: center;
            margin: var(--spacing-3xl) 0 var(--spacing-xl) 0;
            position: relative;
        }

        .section-number {
            background: var(--primary-500);
            color: var(--white);
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-xl);
            font-weight: 700;
            margin-right: var(--spacing-xl);
            box-shadow: var(--shadow-lg);
            border: 4px solid var(--white);
        }

        .section-title {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: var(--white);
            padding: var(--spacing-lg) var(--spacing-xl);
            border-radius: 50px;
            font-size: var(--font-size-xl);
            font-weight: 600;
            flex-grow: 1;
            box-shadow: var(--shadow-md);
        }

        /* Week Cards */
        .week-card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            margin: var(--spacing-xl) 0 var(--spacing-xl) 5rem;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border: 1px solid var(--neutral-200);
            position: relative;
            transition: all 0.2s ease;
        }

        .week-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .week-card::before {
            content: '';
            position: absolute;
            left: -5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            background: var(--secondary-400);
            border-radius: 50%;
            border: 3px solid var(--white);
            box-shadow: 0 0 0 3px var(--primary-400);
        }

        .week-header {
            background: linear-gradient(135deg, var(--neutral-50), var(--white));
            padding: var(--spacing-xl);
            border-bottom: 2px solid var(--secondary-300);
        }

        .week-number {
            display: inline-block;
            background: var(--primary-500);
            color: var(--white);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 20px;
            font-size: var(--font-size-sm);
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            letter-spacing: 0.025em;
        }

        .week-title {
            font-size: var(--font-size-xl);
            font-weight: 700;
            color: var(--primary-700);
            margin: 0;
            line-height: 1.3;
        }

        .week-content {
            padding: var(--spacing-xl);
        }

        .learning-objectives {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .learning-objectives li {
            position: relative;
            padding: var(--spacing-md) 0 var(--spacing-md) 2.5rem;
            font-size: var(--font-size-lg);
            line-height: 1.6;
            color: var(--neutral-700);
            border-bottom: 1px solid var(--neutral-100);
        }

        .learning-objectives li:last-child {
            border-bottom: none;
        }

        .learning-objectives li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: var(--spacing-md);
            background: var(--secondary-400);
            color: var(--primary-700);
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: var(--font-size-xs);
        }

        .learning-objectives li strong {
            color: var(--primary-600);
            font-weight: 700;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-container {
                margin: var(--spacing-md);
                padding: var(--spacing-xl);
            }
            
            .main-title {
                font-size: var(--font-size-4xl);
            }
            
            .timeline-line {
                left: 1.5rem;
            }
            
            .week-card {
                margin-left: 3rem;
            }
            
            .week-card::before {
                left: -3rem;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: var(--spacing-lg);
            }
            
            .main-title {
                font-size: var(--font-size-3xl);
            }
            
            .subtitle {
                font-size: var(--font-size-lg);
            }
            
            .timeline-line {
                display: none;
            }
            
            .week-card {
                margin-left: 0;
            }
            
            .week-card::before {
                display: none;
            }
            
            .section-divider {
                flex-direction: column;
                text-align: center;
            }
            
            .section-number {
                margin-right: 0;
                margin-bottom: var(--spacing-md);
            }
            
            .week-header,
            .week-content {
                padding: var(--spacing-lg);
            }
        }

        @media (max-width: 480px) {
            .main-container {
                margin: var(--spacing-sm);
                padding: var(--spacing-md);
            }
            
            .header-section {
                padding: var(--spacing-xl) var(--spacing-md);
            }
            
            .main-title {
                font-size: var(--font-size-2xl);
            }
            
            .learning-objectives li {
                padding-left: 2rem;
                font-size: var(--font-size-base);
            }
            
            .learning-objectives li::before {
                width: 1.25rem;
                height: 1.25rem;
            }
        }

        /* Accessibility Improvements */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus States */
        .back-btn:focus {
            outline: 2px solid var(--primary-400);
            outline-offset: 2px;
        }

        /* Print Styles */
        @media print {
            .back-navigation {
                display: none;
            }
            
            .main-container {
                box-shadow: none;
                border: none;
            }
            
            .week-card {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Back Navigation -->
        <div class="back-navigation">
            <a href="javascript:history.back()" class="back-btn">
                <i class="bi bi-arrow-left"></i>Back to Courses
            </a>
        </div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <h1 class="main-title">VERBAL REASONING SYLLABUS</h1>
            </div>
        </div>

        <!-- Timeline Container -->
        <div class="timeline-container">
            <div class="timeline-line"></div>

            <!-- Week 1 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 1</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE A-INSERT A LETTER</li>
                        <li>TYPE B-ODD WORDS</li>
                        <li>TYPE D-SYNONYMS</li>
                    </ul>
                </div>
            </div>

            <!-- Week 2 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 2</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE H-ANTONYMS</li>
                        <li>TYPE E-HIDDEN WORDS</li>
                        <li>TYPE F-FIND THE WORD</li>
                    </ul>
                </div>
            </div>

            <!-- Week 3 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 3</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE C-ALPHABET CODE</li>
                        <li>TYPE J-REARRANGE - MAKE NEW WORDS</li>
                        <li>TYPE G-CALCULATING WITH LETTERS</li>
                    </ul>
                </div>
            </div>

            <!-- Week 4 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 4</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE I-COMPLETE THE CALCULATION</li>
                        <li>TYPE K-NUMBER RELATIONSHIP</li>
                    </ul>
                </div>
            </div>

            <!-- Week 5 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 5</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE L-COMPLETE THE ALPHABET SERIES</li>
                        <li>TYPE M-COMPLETE THE SENTENCE</li>
                    </ul>
                </div>
            </div>

            <!-- Week 6 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 6</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE N-WORD CODE</li>
                        <li>TYPE O-COMPLETE THE PAIRS</li>
                    </ul>
                </div>
            </div>

            <!-- Week 7 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 7</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE P-NUMBER SERIES</li>
                    </ul>
                </div>
            </div>

            <!-- Week 8 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 8</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE Q-FORM A NEW WORD</li>
                        <li>TYPE R-CREATE WORD</li>
                        <li>TYPE S-SIMILAR MEANING</li>
                    </ul>
                </div>
            </div>

            <!-- Week 9 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 9</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE U-Letter RELATIONSHIP</li>
                    </ul>
                </div>
            </div>

            <!-- Week 10 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 10</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>TYPE Z-COMPREHENSION</li>
                    </ul>
                </div>
            </div>

            <!-- Week 11/12 -->
            <div class="week-card">
                <div class="week-header">
                    <div class="week-number">WEEK 11/12</div>
                </div>
                <div class="week-content">
                    <ul class="learning-objectives">
                        <li>MIXED PRACTICE QUESTIONS</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
