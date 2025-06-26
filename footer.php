<?php
// Footer - Professional Design
?>
<style>
        :root {
            /* Professional Color Palette - Matching Header */
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
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Main Footer Styling */
        .main-footer {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 30%, #f1f5f9 70%, #fef7ed 100%);
            color: var(--gray-800);
            font-family: 'Inter', sans-serif;
            margin-top: 4rem;
            border-top: 4px solid var(--accent-gold);
            position: relative;
            overflow: hidden;
        }

        .main-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--accent-gold) 50%, var(--primary-blue) 100%);
        }

        .footer-top {
            padding: 4rem 0 2rem;
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .footer-bottom {
            padding: 2rem 0;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--secondary-blue) 100%);
            color: var(--white);
            position: relative;
        }

        .footer-bottom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--accent-gold) 50%, transparent 100%);
        }

        /* Footer Logo */
        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .footer-logo img {
            height: 85px;
            width: auto;
            filter: drop-shadow(0 4px 12px rgba(30, 64, 175, 0.3));
            transition: var(--transition);
        }

        .footer-brand-text {
            margin-left: 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            line-height: 1.1;
            font-size: 1.6rem;
            color: var(--primary-blue);
            letter-spacing: -0.02em;
        }

        .footer-brand-text .main-text {
            display: block;
            font-size: 1.6rem;
            color: var(--primary-blue);
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(30, 64, 175, 0.1);
        }

        .footer-brand-text .sub-text {
            display: block;
            font-size: 1.1rem;
            color: var(--accent-gold);
            font-weight: 600;
            margin-top: -2px;
            text-shadow: 0 1px 3px rgba(245, 158, 11, 0.2);
        }

        /* Footer Description */
        .footer-description {
            color: var(--gray-600);
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 2rem;
            max-width: 90%;
        }

        /* Footer Content */
        .footer-section h5 {
            color: var(--primary-blue);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1.75rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-section h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            border-radius: 6px;
            position: relative;
        }

        .footer-links a:hover {
            color: var(--primary-blue);
            transform: translateX(8px);
            background: rgba(30, 64, 175, 0.05);
            padding-left: 0.75rem;
        }

        .footer-links a i {
            margin-right: 0.75rem;
            color: var(--accent-gold);
            width: 18px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-links a:hover i {
            color: var(--primary-blue);
            transform: scale(1.1);
        }

        /* Social Media */
        .social-links {
            display: flex;
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 50%;
            color: var(--primary-blue);
            text-decoration: none;
            transition: var(--transition);
            font-size: 1.3rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.2), transparent);
            transition: var(--transition);
        }

        .social-link:hover::before {
            left: 100%;
        }

        .social-link:hover {
            background: var(--accent-gold);
            color: var(--white);
            border-color: var(--accent-gold);
            transform: translateY(-4px) scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        /* Footer Bottom */
        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .footer-bottom-links {
            display: flex;
            gap: 2.5rem;
            flex-wrap: wrap;
        }

        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            position: relative;
        }

        .footer-bottom-links a::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--accent-gold);
            transition: var(--transition);
        }

        .footer-bottom-links a:hover {
            color: var(--accent-gold);
            background: rgba(245, 158, 11, 0.1);
        }

        .footer-bottom-links a:hover::before {
            width: 100%;
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 55px;
            height: 55px;
            background: var(--accent-gold);
            color: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: var(--transition);
            z-index: 1000;
            box-shadow: var(--shadow-lg);
        }

        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-to-top:hover {
            background: var(--accent-gold-dark);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 25px -5px rgba(245, 158, 11, 0.4);
        }

        @media (max-width: 768px) {
            .scroll-to-top {
                bottom: 1.5rem;
                right: 1.5rem;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .main-footer {
                margin-top: 3rem;
            }

            .footer-top {
                padding: 3rem 0 2rem;
            }

            .footer-logo {
                justify-content: center;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .footer-brand-text {
                margin-left: 0;
                margin-top: 1rem;
            }

            .footer-description {
                text-align: center;
                max-width: 100%;
                margin: 1.5rem 0;
            }

            .footer-section {
                text-align: center;
                margin-bottom: 2.5rem;
            }

            .footer-section h5::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links a {
                justify-content: center;
                padding: 0.75rem 1rem;
            }

            .footer-links a:hover {
                transform: translateX(0) scale(1.02);
                padding-left: 1rem;
            }

            .social-links {
                justify-content: center;
                margin-top: 1.5rem;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .footer-bottom-links {
                justify-content: center;
                gap: 1.5rem;
            }

            .footer-logo img {
                height: 75px;
            }

            .footer-brand-text .main-text {
                font-size: 1.4rem;
            }

            .footer-brand-text .sub-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-footer {
                margin-top: 2rem;
            }

            .footer-top {
                padding: 2.5rem 0 1.5rem;
            }

            .social-links {
                gap: 1rem;
            }

            .social-link {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }

            .footer-bottom-links {
                gap: 1rem;
                flex-direction: column;
            }

            .footer-bottom-links a {
                padding: 0.5rem 0;
            }

            .footer-section h5 {
                font-size: 1.1rem;
            }
        }

        /* Newsletter Footer Card */
        .newsletter-footer-card {
            position: relative;
            overflow: hidden;
        }

        .newsletter-footer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 64, 175, 0.05), transparent);
            transition: var(--transition);
        }

        .newsletter-footer-card:hover::before {
            left: 100%;
        }

        .newsletter-footer-card button:hover {
            background: linear-gradient(135deg, #1E3A8A, #1E40AF) !important;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 12px 35px -5px rgba(30, 64, 175, 0.5) !important;
        }

        /* Mobile responsiveness for newsletter card */
        @media (max-width: 768px) {
            .newsletter-footer-card {
                padding: 2rem 1.5rem !important;
                margin: 0 1rem;
            }
            
            .newsletter-footer-card h3 {
                font-size: 1.5rem !important;
            }
            
            .newsletter-footer-card p {
                font-size: 1rem !important;
            }
            
            .newsletter-footer-card .newsletter-icon div {
                width: 60px !important;
                height: 60px !important;
            }
            
            .newsletter-footer-card .newsletter-icon i {
                font-size: 1.5rem !important;
            }
        }

        /* Mobile Responsiveness */
    </style>

<footer class="main-footer">
        <!-- Footer Top Section -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <!-- Logo & Brand -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-logo" style="display: flex; align-items: center; margin-bottom: 2rem; gap: 1.2rem;">
                            <img src="./assets/logo/success logo2.png" alt="Success At 11 Plus English logo" class="img-fluid" style="height: 70px; width: auto;">
                            <div class="footer-brand-text" style="display: flex; flex-direction: column; justify-content: center;">
                                <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.7rem; color: #1E40AF; line-height: 1.1; letter-spacing: 0.01em;">Success At 11 Plus</span>
                                <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.7rem; color: #F59E0B; line-height: 1.1; margin-top: -2px; letter-spacing: 0.01em;">English</span>
                            </div>
                        </div>
                        <p class="footer-description">
                            Empowering students to achieve excellence in their 11 Plus English examinations through expert tutoring, comprehensive learning resources, and personalized support.
                        </p>
                        <!-- <div class="social-links">
                            <a href="https://www.facebook.com/share/19RVmRXYL6/?mibextid=wwXIfr" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://linkedin.com/in/safrina-saran-2071a8141" class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://www.instagram.com/smile_4_kids_indian_languages/" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.google.com/search?q=smile+4+kids" class="social-link" aria-label="Google">
                                <i class="fab fa-google"></i>
                            </a>
                        </div> -->
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Quick Links</h5>
                            <ul class="footer-links">
                                <li><a href="./index.php"><i class="fas fa-home"></i>Home</a></li>
                                <li><a href="./About.php"><i class="fas fa-info-circle"></i>About Us</a></li>
                                <li><a href="./Login.php"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Classes</h5>
                            <ul class="footer-links">
                                <li><a href="./courses_year4.php"><i class="fas fa-graduation-cap"></i>Year 4</a></li>
                                <li><a href="./courses_year5.php"><i class="fas fa-graduation-cap"></i>Year 5</a></li>
                                <li><a href="./courses_year6.php"><i class="fas fa-graduation-cap"></i>Year 6</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Resources & Support -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Resources & Support</h5>
                            <ul class="footer-links">
                                <li><a href="./Privacy-policy.php"><i class="fas fa-shield-alt"></i>Privacy Policy</a></li>
                                <li><a href="./TermsAndCondition.php"><i class="fas fa-file-contract"></i>Terms & Conditions</a></li>
                                <li><a href="./Safeguarding.php"><i class="fas fa-user-shield"></i>Safeguarding</a></li>
                                <li><a href="./Remoteteaching.php"><i class="fas fa-laptop"></i>Remote Teaching</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Newsletter Subscription Section -->
                <div class="row justify-content-center mt-4 pt-3" style="border-top: 1px solid #E5E7EB;">
                    <div class="col-lg-10 col-xl-9">
                        <div class="newsletter-footer-card text-center p-3 p-md-4" style="background: rgba(30, 64, 175, 0.02); border: 1px solid #DBEAFE; border-radius: 12px;">
                            <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                                <div class="newsletter-icon">
                                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; background: linear-gradient(135deg, #1E40AF, #3B82F6); border-radius: 50%;">
                                        <i class="fas fa-envelope" style="font-size: 1.2rem; color: white;"></i>
                                    </div>
                                </div>
                                <div class="newsletter-content flex-grow-1">
                                    <h4 class="fw-bold mb-1" style="color: #1E40AF; font-family: 'Poppins', sans-serif; font-size: 1.3rem;">Stay Updated</h4>
                                    <p class="mb-0" style="color: #4B5563; font-size: 0.95rem;">Get expert tips and updates delivered to your inbox</p>
                                </div>
                                <div class="newsletter-action">
                                    <button type="button" class="btn btn-primary" id="openNewsletterPopupBtn" style="padding: 0.6rem 1.5rem; font-weight: 600; border-radius: 8px; font-size: 0.95rem;">
                                        <i class="fas fa-paper-plane me-1"></i>Subscribe
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        © 2025 Success At 11 Plus English. All rights reserved.
                    </div>
                    <div class="footer-bottom-links">
                        <a href="./Privacy-policy.php">Privacy Policy</a>
                        <a href="./TermsAndCondition.php">Terms & Conditions</a>
                        <a href="./Safeguarding.php">Safeguarding</a>
                        <a href="./Remoteteaching.php">Remote Teaching</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>

    <!-- JavaScript for Scroll to Top Button -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scrollToTopBtn = document.getElementById('scrollToTop');

            // Show or hide the button on scroll
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    scrollToTopBtn.classList.add('visible');
                } else {
                    scrollToTopBtn.classList.remove('visible');
                }
            });

            // Scroll to top functionality
            scrollToTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>