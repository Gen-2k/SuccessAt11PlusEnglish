<?php
    include('database/dbconfig.php');
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png">
        <!-- boostrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- font awesome -->
        <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">        <style>
            :root {
                /* Professional Color Palette - Optimized */
                --primary-blue: #1E40AF;
                --primary-dark: #1E3A8A;
                --primary-light: #DBEAFE;
                --secondary-blue: #3B82F6;
                
                --accent-gold: #F59E0B;
                --accent-gold-dark: #D97706;
                --accent-gold-light: #FEF3C7;
                
                --white: #FFFFFF;
                --gray-50: #F9FAFB;
                --gray-100: #F3F4F6;
                --gray-200: #E5E7EB;
                --gray-300: #D1D5DB;
                --gray-600: #4B5563;
                --gray-700: #374151;
                --gray-800: #1F2937;
                
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-fast: all 0.15s ease-out;
            }
                
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: var(--white);
            }            /* Main Navigation Styling - Optimized */
            .logo-header {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 30%, #f1f5f9 70%, #fef7ed 100%);
                border-bottom: 3px solid var(--accent-gold);
                box-shadow: var(--shadow-md);
                /* padding: 1.2rem 0; */
                position: sticky;
                top: 0;
                z-index: 1000;
                transition: var(--transition);
                backdrop-filter: saturate(180%) blur(20px);
            }

            .logo-header.scrolled {
                background: linear-gradient(135deg, #f1f5f9 0%, #dbeafe 40%, #f8fafc 60%, #fef3c7 100%);
                border-bottom: 3px solid var(--accent-gold);
                /* padding: 0.8rem 0; */
                box-shadow: var(--shadow-xl);
            }            /* Logo Styling - Improved Readability */
            .navbar-brand {
                display: flex;
                align-items: center;
                text-decoration: none;
                /* padding: 0.5rem 0; */
            }

            .navbar-brand img {
                height: 120px;
                width: auto;
                filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
                /* background: #fff;
                border-radius: 12px;
                padding: 4px; */
            }

            .brand-text {
                margin-left: 1.75rem;
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
                color: var(--gray-800);
                line-height: 1.05;
            }

            .brand-text .main-text {
                display: block;
                font-size: 2rem;
                color: var(--primary-blue);
                font-weight: 700;
                letter-spacing: -0.02em;
            }

            .brand-text .sub-text {
                display: block;
                font-size: 1.25rem;
                color: var(--accent-gold);
                font-weight: 600;
                margin-top: -4px;
                letter-spacing: 0.02em;
            }/* Navigation Toggle Button - Optimized */
            .navbar-toggler {
                border: 2px solid var(--accent-gold);
                border-radius: 8px;
                padding: 0.6rem 0.8rem;
                background: var(--white);
                transition: var(--transition);
                box-shadow: var(--shadow-sm);
            }

            .navbar-toggler:hover {
                background: var(--accent-gold);
                border-color: var(--accent-gold-dark);
                transform: scale(1.05);
                box-shadow: var(--shadow-md);
            }

            .navbar-toggler:focus {
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
                outline: none;
            }

            .nav-toggle-icon {
                color: var(--accent-gold);
                font-size: 1.2rem;
                transition: var(--transition-fast);
            }

            .navbar-toggler:hover .nav-toggle-icon {
                color: var(--white);
            }/* Navigation Container */
            .nav-container {
                background: transparent;
            }

            .navbar-nav {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }            /* Navigation Links - Optimized */
            .nav-link {
                color: var(--gray-700) !important;
                font-weight: 500;
                font-size: 1rem;
                padding: 0.8rem 1.2rem !important;
                border-radius: 8px;
                text-decoration: none;
                display: flex;
                align-items: center;
                transition: var(--transition);
                background: var(--white);
                margin: 0 0.25rem;
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-200);
                position: relative;
                overflow: hidden;
            }

            .nav-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
                transition: var(--transition);
                z-index: -1;
            }

            .nav-link:hover {
                color: var(--white) !important;
                transform: translateY(-2px);
                box-shadow: var(--shadow-lg);
                border-color: var(--primary-blue);
            }

            .nav-link:hover::before {
                left: 0;
            }            /* Dropdown Styling - Optimized */
            .dropdown {
                position: relative;
            }

            .dropdown-toggle::after {
                margin-left: 0.6rem;
                color: var(--accent-gold);
                transition: var(--transition);
                font-size: 0.8rem;
            }

            .nav-link:hover .dropdown-toggle::after {
                color: var(--white);
                transform: rotate(180deg);
            }

            .dropdown-menu {
                background: var(--white);
                border: 2px solid var(--accent-gold-light);
                border-top: 4px solid var(--accent-gold);
                border-radius: 12px;
                box-shadow: var(--shadow-xl);
                padding: 0.75rem 0;
                margin-top: 0.5rem;
                min-width: 240px;
                display: none;
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
                transition: var(--transition);
            }

            .dropdown:hover .dropdown-menu {
                display: block;
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            .dropdown-item {
                color: var(--gray-700);
                padding: 0.75rem 1.25rem;
                font-weight: 500;
                border-radius: 8px;
                display: flex;
                align-items: center;
                transition: var(--transition);
                margin: 0 0.5rem;
                position: relative;
                overflow: hidden;
            }

            .dropdown-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, var(--accent-gold-light), var(--accent-gold-light));
                transition: var(--transition);
                z-index: -1;
            }

            .dropdown-item i {
                color: var(--accent-gold);
                width: 18px;
                margin-right: 0.75rem;
                transition: var(--transition-fast);
            }

            .dropdown-item:hover {
                color: var(--primary-blue);
                transform: translateX(5px);
            }

            .dropdown-item:hover::before {
                left: 0;
            }

            .dropdown-item:hover i {
                color: var(--primary-blue);
                transform: scale(1.1);
            }            /* Sign In Button - Optimized */
            .signin-btn {
                background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-dark));
                color: var(--white);
                border: 2px solid var(--accent-gold);
                padding: 0.8rem 1.75rem;
                border-radius: 25px;
                font-weight: 700;
                font-size: 0.95rem;
                margin-left: 1.25rem;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                transition: var(--transition);
                box-shadow: var(--shadow-md);
                position: relative;
                overflow: hidden;
                white-space: nowrap; /* Prevent line break */
            }

            .signin-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: var(--white);
                transition: var(--transition);
                z-index: -1;
            }

            .signin-btn:hover {
                color: var(--accent-gold);
                border-color: var(--accent-gold);
                transform: translateY(-2px);
                box-shadow: var(--shadow-xl);
            }

            .signin-btn:hover::before {
                left: 0;
            }

            .signin-btn i {
                margin-right: 0.6rem;
                transition: var(--transition-fast);
                font-size: 1rem;
            }

            .signin-btn:hover i {
                color: var(--accent-gold);
                transform: scale(1.1);
            }            /* Mobile Responsive - Enhanced */
            @media (max-width: 1199.98px) {
                .navbar-brand img {
                    height: 90px;
                }
                
                .brand-text .main-text {
                    font-size: 1.8rem;
                }
                
                .brand-text .sub-text {
                    font-size: 1.1rem;
                }
            }

            @media (max-width: 991.98px) {
                .logo-header {
                    padding: 0.8rem 0;
                }

                .logo-header.scrolled {
                    padding: 0.6rem 0;
                }

                .navbar-collapse {
                    background: var(--white);
                    margin-top: 1rem;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: var(--shadow-xl);
                    border: 2px solid var(--accent-gold-light);
                    border-top: 4px solid var(--accent-gold);
                }

                .navbar-nav {
                    flex-direction: column;
                    gap: 0.75rem;
                    width: 100%;
                }

                .nav-link {
                    padding: 1rem 1.25rem !important;
                    width: 100%;
                    text-align: left;
                    margin: 0;
                    justify-content: flex-start;
                    font-size: 1.1rem;
                }

                .dropdown-menu {
                    position: static;
                    display: block;
                    background: var(--accent-gold-light);
                    border: 1px solid var(--accent-gold);
                    margin: 0.5rem 0;
                    box-shadow: none;
                    opacity: 1;
                    transform: none;
                }

                .dropdown-item {
                    color: var(--gray-700);
                    margin: 0;
                    border-radius: 6px;
                    padding: 0.75rem 1rem;
                }

                .dropdown-item:hover {
                    background: var(--white);
                    color: var(--primary-blue);
                }

                .signin-btn {
                    margin-left: 0;
                    margin-top: 1rem;
                    justify-content: center;
                    width: 100%;
                    padding: 1rem 1.5rem;
                    font-size: 1.1rem;
                    white-space: nowrap; /* Prevent line break on tablets/laptops */
                }

                .navbar-brand {
                    padding: 0.25rem 0;
                }

                .navbar-brand img {
                    height: 85px;
                }

                .brand-text {
                    margin-left: 1.25rem;
                }

                .brand-text .main-text {
                    font-size: 1.6rem;
                }

                .brand-text .sub-text {
                    font-size: 1rem;
                }
            }

            @media (max-width: 767.98px) {
                .navbar-brand {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .navbar-brand img {
                    height: 80px;
                    margin-bottom: 0.5rem;
                }

                .brand-text {
                    margin-left: 0;
                    text-align: left;
                }

                .brand-text .main-text {
                    font-size: 1.4rem;
                }

                .brand-text .sub-text {
                    font-size: 0.9rem;
                    margin-top: -2px;
                }

                .navbar-collapse {
                    padding: 1rem;
                }

                .nav-link {
                    padding: 0.875rem 1rem !important;
                    font-size: 1rem;
                }

                .signin-btn {
                    padding: 0.875rem 1.25rem;
                    font-size: 1rem;
                    white-space: nowrap; /* Prevent line break on mobile */
                }
            }

            @media (max-width: 575.98px) {
                .logo-header {
                    padding: 0.6rem 0;
                }

                .navbar-brand img {
                    height: 70px;
                }

                .brand-text .main-text {
                    font-size: 1.2rem;
                }

                .brand-text .sub-text {
                    font-size: 0.8rem;
                }

                .navbar-collapse {
                    margin-top: 0.75rem;
                    padding: 0.75rem;
                }

                .nav-link {
                    padding: 0.75rem 0.875rem !important;
                    font-size: 0.95rem;
                }

                .dropdown-item {
                    padding: 0.625rem 0.875rem;
                }

                .signin-btn {
                    padding: 0.75rem 1rem;
                    font-size: 0.95rem;
                    white-space: nowrap; /* Prevent line break on mobile */
                }
            }/* Accessibility Improvements */
            .nav-link:focus,
            .dropdown-item:focus,
            .signin-btn:focus {
                outline: 2px solid var(--primary-blue);
                outline-offset: 2px;
            }            /* Active State - Optimized */
            .nav-link.active {
                color: var(--white) !important;
                font-weight: 600;
                box-shadow: var(--shadow-lg);
                border-color: var(--primary-dark);
                background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
            }

            .nav-link.active::before {
                left: 0;
            }
        </style>
        
        <title>Success At 11 Plus English</title>
    </head>

    <body>
        <nav class="logo-header navbar navbar-expand-lg">
            <div class="container-fluid">                <!-- Logo -->
                <a href="./index.php" class="navbar-brand"> 
                    <img src="./assets/logo/success logo2.png" alt="Success At 11 Plus English logo" class="img-fluid" >
                    <div class="brand-text">
                        <span class="main-text">Success At 11 Plus <span style="color: var(--accent-gold);">English</span></span>

                     
                    </div>
                </a>
                
                <!-- Navigation Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars nav-toggle-icon"></i>
                </button>
                
                <!-- Navigation Content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <div class="nav-container ms-auto">
                        <ul class="navbar-nav">
                            <!-- Home -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            
                            <!-- Classes Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="classesDropdown" role="button" aria-expanded="false">
                                    Classes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="classesDropdown">
                                    <li><a class="dropdown-item" href="courses_year4.php?lan=<?php echo urlencode('Year 4'); ?>">
                                        <i class="fa-solid fa-graduation-cap me-2"></i>Year 4
                                    </a></li>
                                    <li><a class="dropdown-item" href="courses_year5.php?lan=<?php echo urlencode('Year 5'); ?>">
                                        <i class="fa-solid fa-graduation-cap me-2"></i>Year 5
                                    </a></li>
                                    <li><a class="dropdown-item" href="courses_year6.php?lan=<?php echo urlencode('Year 6'); ?>">
                                        <i class="fa-solid fa-graduation-cap me-2"></i>Year 6
                                    </a></li>
                                </ul>
                            </li>
                            
                            <!-- Policies Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="policiesDropdown" role="button" aria-expanded="false">
                                    Policies
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="policiesDropdown">
                                    <li><a class="dropdown-item" href="Remoteteaching.php">
                                        <i class="fa-solid fa-shield-halved me-2"></i>Remote Teaching Policy
                                    </a></li>
                                    <li><a class="dropdown-item" href="Privacy-policy.php">
                                        <i class="fa-solid fa-user-shield me-2"></i>Privacy Policy
                                    </a></li>
                                    <li><a class="dropdown-item" href="TermsAndCondition.php">
                                        <i class="fa-solid fa-file-contract me-2"></i>Terms and Conditions
                                    </a></li>
                                    <li><a class="dropdown-item" href="Safeguarding.php">
                                        <i class="fa-solid fa-heart me-2"></i>Safeguarding Policy
                                    </a></li>
                                </ul>
                            </li>
                            
                            <!-- About -->
                            <li class="nav-item">
                                <a class="nav-link" href="About.php">About</a>
                            </li>
                            <li class="nav-item">
    <a href="Login.php" class="signin-btn">
        <i class="fa-solid fa-user me-2"></i>Sign In
    </a>
</li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>        <script>
            // Optimized Header Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.querySelector('.logo-header');
                const dropdowns = document.querySelectorAll('.dropdown');
                let ticking = false;

                // Optimized scroll handler with throttling
                function updateNavbar() {
                    if (window.scrollY > 30) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                    ticking = false;
                }

                function requestTick() {
                    if (!ticking) {
                        requestAnimationFrame(updateNavbar);
                        ticking = true;
                    }
                }

                window.addEventListener('scroll', requestTick, { passive: true });

                // Enhanced active link detection
                const currentPath = window.location.pathname.toLowerCase();
                const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
                
                navLinks.forEach(link => {
                    if (link.href) {
                        const linkPath = new URL(link.href).pathname.toLowerCase();
                        if (currentPath.includes(linkPath) && linkPath !== '/' && linkPath.length > 1) {
                            link.classList.add('active');
                        }
                    }
                });                // Enhanced dropdown functionality
                dropdowns.forEach(dropdown => {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    let timeout;

                    // Desktop hover behavior
                    dropdown.addEventListener('mouseenter', () => {
                        clearTimeout(timeout);
                        if (window.innerWidth > 991) {
                            menu.style.display = 'block';
                            setTimeout(() => {
                                menu.style.opacity = '1';
                                menu.style.transform = 'translateY(0) scale(1)';
                            }, 10);
                        }
                    });

                    dropdown.addEventListener('mouseleave', () => {
                        if (window.innerWidth > 991) {
                            menu.style.opacity = '0';
                            menu.style.transform = 'translateY(-10px) scale(0.95)';
                            timeout = setTimeout(() => {
                                menu.style.display = 'none';
                            }, 300);
                        }
                    });

                    // Mobile click behavior for dropdown items only (not main navbar toggle)
                    toggle.addEventListener('click', function(e) {
                        if (window.innerWidth <= 991) {
                            e.preventDefault();
                            e.stopPropagation(); // Prevent event bubbling
                            
                            // Close all other dropdowns first
                            dropdowns.forEach(otherDropdown => {
                                if (otherDropdown !== dropdown) {
                                    const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                                    otherMenu.style.display = 'none';
                                }
                            });
                            
                            // Toggle current dropdown
                            const isVisible = menu.style.display === 'block';
                            menu.style.display = isVisible ? 'none' : 'block';
                            if (!isVisible) {
                                menu.style.opacity = '1';
                                menu.style.transform = 'translateY(0) scale(1)';
                            }
                        }
                    });
                });

                // Keyboard navigation enhancement
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdowns.forEach(dropdown => {
                            const menu = dropdown.querySelector('.dropdown-menu');
                            menu.style.display = 'none';
                        });
                    }
                });

                // Handle Bootstrap navbar collapse events
                const navbarCollapse = document.getElementById('navbarContent');
                if (navbarCollapse) {
                    // Close all dropdowns when main navbar is collapsed
                    navbarCollapse.addEventListener('hidden.bs.collapse', function() {
                        dropdowns.forEach(dropdown => {
                            const menu = dropdown.querySelector('.dropdown-menu');
                            menu.style.display = 'none';
                        });
                    });

                    // Also close dropdowns when clicking outside
                    document.addEventListener('click', function(e) {
                        if (window.innerWidth <= 991) {
                            const clickedInsideNav = navbarCollapse.contains(e.target);
                            const clickedToggler = e.target.closest('.navbar-toggler');
                            
                            if (!clickedInsideNav && !clickedToggler) {
                                dropdowns.forEach(dropdown => {
                                    const menu = dropdown.querySelector('.dropdown-menu');
                                    menu.style.display = 'none';
                                });
                            }
                        }
                    });
                }
            });
        </script>
    </body>
    </html>
