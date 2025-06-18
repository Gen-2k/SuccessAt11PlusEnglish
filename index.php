<?php
/**
 * Start the session if it hasn't been started already.
 * This should be done before any HTML output.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- SEO Meta Tags -->
    <title>Success At 11 Plus English | Home</title>
    <meta name="keywords" content="11 Plus English, 11+ English Tutoring, Verbal Reasoning, Kent 11 Plus" />
    <meta name="description"
        content="Success At 11 Plus English provides expert online tutoring for 11+ exams. We cover all boards including Kent 11 plus, independent schools, entrance exams and SATs." />

    <!-- Open Graph Meta Tags (for social sharing) -->
    <meta property="og:site_name" content="Success At 11 Plus English" />
    <meta property="og:title" content="Success At 11 Plus English - Expert Online Tutoring" />
    <!-- <meta property="og:url" content="https://success11plusenglish.co.uk/" /> -->
    <meta property="og:image" content="./assets/images/logonew.png" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png">

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="./indexStyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    <!-- Minimal inline styles for Toastr overrides -->
    <style>
        /* Custom Toastr notification styles */
        #toast-container>.toast-success {
            background-color: #26b280;
            /* Success green */
            color: #fff;
        }

        #toast-container>.toast-error {
            background-color: red;
            /* Error red */
            color: #fff;
        }
    </style>
</head>

<body id="main">

    <!-- Newsletter Popup -->
    <div class="newsLetterContainer align-items-center justify-content-center">
        <div class="card p-4 p-md-5 position-relative newsLetterCard">
            <button type="button" class="btn-close closeButton position-absolute top-0 end-0 mt-2 me-2"
                aria-label="Close"></button>
            <h3 class="card-title blue fw-bold mb-4">Get Your <br>FREE TOP 10 TIPS</h3>
            <form action="" id="newsPop" method="POST">
                <div class="mb-3">
                    <label for="n_name" class="form-label visually-hidden">Name</label>
                    <input class="form-control shadow-none" type="text" name="n_name" id="n_name" placeholder="Name"
                        required>
                    <span></span>
                </div>
                <div class="mb-3">
                    <label for="n_email" class="form-label visually-hidden">Email</label>
                    <input class="form-control shadow-none eMail" type="email" name="n_email" id="n_email"
                        placeholder="Email" required>
                    <span class="form-text">We will not share your email with anyone.</span>
                </div>
                <div class="mb-3 form-check checkBoxCon">
                    <input type="checkbox" class="form-check-input shadow-none" id="privacyCheck" required>
                    <label for="privacyCheck" class="form-check-label"><small>Yes I understand that you will use the
                            information
                            provided via this form to be in touch and to send the freebie, and also to keep me updated
                            with your newsletters.
                            <a href="Privacy-policy">Privacy Policy</a></small></label>
                </div>
                <button type="submit" class="btn btn-danger w-100 shadow-none subscribeBtn mt-4"
                    name="n_submit">SUBSCRIBE</button>
            </form>
        </div>
    </div>

    <!-- Navigation Bar -->
    <header class="sticky-lg-top shadow-sm">
        <?php include('navbar2.php'); ?>
    </header>

    <?php
    if (isset($_SESSION['status_code'])) {
        $message = isset($_SESSION['status']) ? $_SESSION['status'] : 'An unknown status occurred.';
        $type = $_SESSION['status_code'] === 'success' ? 'success' : 'error';
        $sanitized_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        echo "<script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function() {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeButton = true;
                    toastr.$type('$sanitized_message');
                });
              </script>";

        unset($_SESSION['status']);
        unset($_SESSION['status_code']);
    }
    ?>

    <!-- Main Content Area -->
    <main>
        <!-- Hero Section -->
        <section class="hero-section position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 d-none d-lg-block"
                style="z-index: 0; width: 30%; height: 100%; background: radial-gradient(circle, rgba(30,64,175,0.08) 0%, rgba(0,0,0,0) 70%);">
            </div>
            <div class="position-absolute bottom-0 start-0 d-none d-lg-block"
                style="z-index: 0; width: 30%; height: 30%; background: radial-gradient(circle, rgba(30,64,175,0.08) 0%, rgba(0,0,0,0) 70%);">
            </div>

            <div class="position-absolute d-none d-lg-block"
                style="top: 15%; right: 10%; z-index: 0; width: 150px; height: 150px; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; background-color: rgba(30,64,175,0.04);">
            </div>
            <div class="position-absolute d-none d-lg-block"
                style="bottom: 10%; left: 5%; z-index: 0; width: 100px; height: 100px; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; background-color: rgba(30,64,175,0.04);">
            </div>

            <div class="container py-5">
                <div class="row gy-5 align-items-center">
                    <!-- Text Column -->
                    <div class="col-lg-6 position-relative" style="z-index: 1;">
                        <h1 class="display-4 fw-bold mb-3 lh-sm">
                            The <span class="blue position-relative d-inline-block">Outstanding<span
                                    class="position-absolute"
                                    style="height: 8px; width: 100%; bottom: 5px; left: 0; background-color: rgba(30,64,175,0.3); z-index: -1;"></span></span>
                            Experts in<br class="d-none d-sm-block"> ONLINE English & VR Tuition!
                        </h1>

                        <h2 class="h5 blue fw-bold mb-4">
                            Welcome to Success at 11 plus English.
                        </h2>

                        <div class="mb-5">
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-shrink-0 me-3 gold">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fs-5">We cover <strong class="blue">all boards</strong> including
                                        Kent 11 plus, independent schools, Entrance Exams and SATs.</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-shrink-0 me-3 gold">
                                    <i class="bi bi-trophy-fill fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fs-5">We nurture your child to <strong class="blue">grow in
                                            confidence</strong> and <strong class="blue">succeed in English and
                                            VR</strong>!</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3 gold">
                                    <i class="bi bi-star-fill fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fs-5">We offer <strong class="blue">tailored</strong>, <strong
                                            class="blue">premium quality classes</strong> with GL resources that make
                                        your child's confidence grow!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action Buttons -->
                        <div class="d-grid gap-3 d-sm-flex mb-5">
                            <a href="tryfreeform"
                                class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-sm hover-lift">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Apply for Trial Class
                            </a>
                            <a href="#ages-section"
                                class="btn btn-outline-blue btn-lg px-4 py-3 fw-semibold shadow-sm hover-lift">
                                <i class="bi bi-collection me-2"></i>View All Courses
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="d-flex align-items-center flex-wrap justify-content-start gap-4 text-muted fs-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check blue me-2 fs-5"></i>
                                <span>Fully DBS checked teachers</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-patch-check blue me-2 fs-5"></i>
                                <span>Years 4-6 specialists</span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Column -->
                    <div class="col-lg-6 text-center text-lg-end position-relative" style="z-index: 1;">
                        <div class="position-relative">
                            <img src="./assets/images/success/home.jpeg"
                                alt="Happy students learning and growing with Success at 11 plus English"
                                class="img-fluid rounded-4 shadow-lg"
                                style="width: 90%; max-width: 550px; border: 8px solid white; z-index: 2; position: relative;">

                            <div class="position-absolute top-0 end-0 translate-middle-y d-none d-lg-block"
                                style="z-index: 1; width: 120px; height: 120px; border-radius: 20px; transform: rotate(10deg); background-color: rgba(30,64,175,0.15);">
                            </div>
                            <div class="position-absolute bottom-0 start-0 translate-middle d-none d-lg-block"
                                style="z-index: 1; width: 80px; height: 80px; border-radius: 15px; transform: rotate(-15deg); background-color: rgba(30,64,175,0.1);">
                            </div>

                            <div class="position-absolute top-0 start-0 translate-middle-y bg-white shadow-sm rounded-pill py-2 px-3 d-flex align-items-center d-none d-lg-flex"
                                style="z-index: 3; border-left: 4px solid var(--theme-blue);">
                                <i class="bi bi-mortarboard-fill blue me-2 fs-5"></i>
                                <span class="fw-bold gold">11+ Success</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="scroll-indicator" id="scrollIndicator">
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
                <div class="text">Scroll Down</div>
            </div>
        </section>

        <!-- What We Offer Section -->
        <section class="what-we-offer-section py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center mb-5">
                            <h2 class="head2 fw-bold display-6">WHAT WE OFFER</h2>
                            <p class="lead" style="color: red; font-weight: bold;">Complete and top quality tutoring
                                services, tailored to your child's needs.</p>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5 position-relative">
                                <!-- Decorative elements -->
                                <div class="position-absolute d-none d-lg-block"
                                    style="top: -15px; right: -15px; width: 120px; height: 120px; background-color: rgba(30,64,175,0.03); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; z-index: 1;">
                                </div>
                                <div class="position-absolute d-none d-lg-block"
                                    style="bottom: -25px; left: -25px; width: 150px; height: 150px; background-color: rgba(30,64,175,0.03); border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; z-index: 1;">
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-lg-7">
                                        <div class="mb-4 p-3 rounded-3"
                                            style="background-color: rgba(30,64,175,0.03); border-left: 4px solid var(--theme-blue);">
                                            <p class="mb-0 text-muted">
                                                Success at 11 plus English tutoring, offers a complete and top quality
                                                tutoring service.
                                                We pride ourselves by using carefully prepared guided resources for
                                                students, in Years 4 and 5 working towards GL and other boards, 11+
                                                exams.
                                                In addition, we tutor Year 6 students, working towards their SATs or
                                                independent school exams.
                                            </p>
                                        </div>

                                        <p class="mb-4 fw-semibold blue">
                                            <i class="bi bi-stars me-2"></i>All our teachers are fully DBS checked, and
                                            we provide expert tutoring for:
                                        </p>

                                        <ul class="list-unstyled mb-4 ms-0">
                                            <li class="d-flex align-items-start mb-4">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bi bi-patch-check-fill fs-4"></i>
                                                </div>                                                <div>
                                                    <h6 class="fw-bold mb-1 blue">Years 4 & 5</h6>
                                                    <p class="mb-0 text-muted">GL and other 11+ exam boards preparation
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bi bi-patch-check-fill fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1 blue">Year 6</h6>
                                                    <p class="mb-0 text-muted">SATs & independent school entrance exams
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-5 d-none d-lg-block">
                                        <div
                                            class="position-relative h-100 d-flex align-items-center justify-content-center">
                                            <div class="position-absolute"
                                                style="width: 200px; height: 200px; background-color: rgba(30,64,175,0.05); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; z-index: 0;">
                                            </div>
                                            <div class="card border-0 shadow-sm p-4 position-relative expertise-card"
                                                style="width: 90%; background-color: #eff6ff; transform: rotate(2deg); z-index: 2;">


                                                <div
                                                    class="blue fw-bold mb-3 pb-2 border-bottom d-flex align-items-center">
                                                    <div class="me-2 d-flex align-items-center justify-content-center bg-blue rounded-circle"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="bi bi-stars text-gold small"></i>
                                                    </div>
                                                    Our Expertise
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 36px; height: 36px;">
                                                        <i class="bi bi-book-half text-gold"></i>
                                                    </div>
                                                    <span>Comprehensive English Skills</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 36px; height: 36px;">
                                                        <i class="bi bi-puzzle text-gold"></i>
                                                    </div>
                                                    <span>Verbal Reasoning Techniques</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 36px; height: 36px;">
                                                        <i class="bi bi-trophy text-gold"></i>
                                                    </div>
                                                    <span>Exam Tips and practice papers</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 36px; height: 36px;">
                                                        <i class="bi bi-emoji-smile text-gold"></i>
                                                    </div>
                                                    <span>Confidence Building</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ages Section -->
        <section id="ages-section" class="ages-section py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">AGES / YEARS</h2>
                    <p class="lead" style="color: red; font-weight: bold;">Tailored tutoring for specific year groups.
                    </p>
                </div>

                <!-- Decorative shapes -->
                <div class="position-relative">
                    <div class="position-absolute d-none d-lg-block"
                        style="top: 10%; right: 5%; width: 150px; height: 150px; background-color: rgba(30,64,175,0.03); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; z-index: 0;">
                    </div>
                    <div class="position-absolute d-none d-lg-block"
                        style="bottom: 10%; left: 5%; width: 120px; height: 120px; background-color: rgba(30,64,175,0.03); border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; z-index: 0;">
                    </div>

                    <div class="row text-center g-4 justify-content-center">
                        <!-- Year 4 Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm border-0"
                                style="background-color: #eff6ff; width: 100%; height: 100%; min-height: 350px;">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="position-relative">
                                        <div class="age-item-icon mx-auto mb-4 text-danger">
                                            <i class="bi bi-book display-3"></i>
                                        </div>
                                    </div>
                                    <h3 class="h4 fw-bold blue mb-4">Year 4</h3>
                                    <div class="mt-auto">
                                        <a class="btn btn-outline-blue px-4 py-2" href="courses_year4?lan=Year4"
                                            role="button">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year 5 Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm border-0"
                                style="background-color: #fffbeb; width: 100%; height: 100%; min-height: 350px;">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="position-relative">
                                        <div class="age-item-icon mx-auto mb-4 text-warning">
                                            <i class="bi bi-pencil-square display-3"></i>
                                        </div>
                                    </div>
                                    <h3 class="h4 fw-bold blue mb-4">Year 5</h3>
                                    <div class="mt-auto">
                                        <a class="btn btn-outline-gold px-4 py-2" href="courses_year5?lan=Year5"
                                            role="button">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year 6 Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm border-0"
                                style="background-color: #f0fdf4; width: 100%; height: 100%; min-height: 350px;">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="position-relative">
                                        <div class="age-item-icon mx-auto mb-4 text-success">
                                            <i class="bi bi-mortarboard-fill display-3"></i>
                                        </div>
                                    </div>
                                    <h3 class="h4 fw-bold blue mb-4">Year 6</h3>
                                    <div class="mt-auto">
                                        <a class="btn btn-outline-blue px-4 py-2" href="courses_year6?lan=Year6"
                                            role="button">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Classes Clickable Tiles Section -->
        <section class="our-classes-tiles-section py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">Our Classes</h2>
                    <p class="lead" style="color: red; font-weight: bold;">Unlock your child's potential with expert 11+
                        English & VR tutoring.</p>

                </div>

                <div class="row justify-content-center g-4">
                    <!-- Tile 1: Targeted Individual Block modules -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="class-card shadow-sm hover-lift spag-main">
                            <div class="class-card-ribbon">Years 4-6</div>
                            <div class="card-image"
                                style="background-image: url('./assets/images/success/groupkids.png');">
                                <div class="card-overlay">
                                    <div class="card-content">
                                        <div class="card-icon"><i class="bi bi-book-half"></i></div>
                                        <h3 class="text-white">Targeted Module Blocks</h3>
                                        <div class="year-tags">
                                            <span>Year 4</span>
                                            <span>Year 5</span>
                                            <span>Year 6</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tile 2: Carousel Courses -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="class-card shadow-sm hover-lift creative-writing-main">
                            <div class="class-card-ribbon">Years 4-5</div>
                            <div class="card-image"
                                style="background-image: url('./assets/images/success/image11.png');">
                                <div class="card-overlay">
                                    <div class="card-content">
                                        <div class="card-icon"><i class="bi bi-arrow-repeat"></i></div>
                                        <h3 class="text-white">Carousel Courses</h3>
                                        <div class="year-tags">
                                            <span>Year 4</span>
                                            <span>Year 5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tile 3: Exam Practice
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="class-card shadow-sm hover-lift comprehension-main">
                            <div class="class-card-ribbon">Years 5-6</div>
                            <div class="card-image"
                                style="background-image: url('./assets/images/success/image6.jpeg');">
                                <div class="card-overlay">
                                    <div class="card-content">
                                        <div class="card-icon"><i class="bi bi-tools"></i></div>
                                        <h3 class="text-white">English/VR Exam Practice & Techniques</h3>
                                        <div class="year-tags">
                                            <span>Year 5</span>
                                            <span>Year 6</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Tile 4: Intensive Courses -->
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="class-card shadow-sm hover-lift late-Teens-main">
                            <div class="class-card-ribbon">All Years</div>
                            <div class="card-image"
                                style="background-image: url('./assets/images/success/image7.jpeg');">
                                <div class="card-overlay">
                                    <div class="card-content">
                                        <div class="card-icon"><i class="bi bi-calendar-event-fill"></i></div>
                                        <h3 class="text-white">Intensive Courses</h3>
                                        <div class="year-tags">
                                            <span>Holiday</span>
                                            <span>All Years</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tile 5: Verbal Reasoning -->
                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="class-card shadow-sm hover-lift vocabulary-main">
                            <div class="class-card-ribbon">11+ Prep</div>
                            <div class="card-image"
                                style="background-image: url('./assets/images/success/image12.png');">
                                <div class="card-overlay">
                                    <div class="card-content">
                                        <div class="card-icon"><i class="bi bi-search"></i></div>
                                        <h3 class="text-white">Verbal Reasoning</h3>
                                        <div class="year-tags">
                                            <span>11+ Specific</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Classes Popups -->
        <!-- Popup 1: Targeted Individual Block modules -->
        <div class="ourClassContainer spag" style="display: none;">
            <div class="ourClassChild shadow-lg rounded p-0">
                <div class="popup-header bg-primary text-white p-4 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white shadow-none ourclass_close_btn position-absolute top-0 end-0 m-3"
                        aria-label="Close"></button>
                    <div class="d-flex align-items-center">
                        <div class="popup-icon me-3">
                            <i class="bi bi-book-half fs-1"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Targeted Module Blocks</h4>
                            <p class="mb-0 mt-1 text-white">Years 4, 5 & 6</p>
                        </div>
                    </div>
                </div>

                <div class="popup-body p-4">
                    <p class="mb-3 text-muted"><i class="bi bi-people-fill text-primary me-2 align-middle"></i>Ideal for
                        focused learning in small groups (4-8 students).</p>
                    <hr class="my-3">

                    <h5 class="fw-semibold mb-3">Available Modules:</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="module-card p-3 rounded bg-light hover-lift">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-book-half text-primary fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Comprehension</h6>
                                        <p class="mb-0 small">6 Weeks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="module-card p-3 rounded bg-light hover-lift">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-pencil-fill text-warning fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Creative Writing</h6>
                                        <p class="mb-0 small">8 Weeks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="module-card p-3 rounded bg-light hover-lift">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-spellcheck text-success fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">SPaG</h6>
                                        <p class="mb-0 small">Spelling, Punctuation, Grammar – 8 Weeks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="module-card p-3 rounded bg-light hover-lift">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-journal-text text-info fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">English Vocabulary</h6>
                                        <p class="mb-0 small">8 Weeks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="module-card p-3 rounded bg-light hover-lift">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-puzzle-fill text-danger fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Verbal Reasoning</h6>
                                        <p class="mb-0 small">8 Weeks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup 2: Carousel Courses -->
        <div class="ourClassContainer creative-writing" style="display: none;">
            <div class="ourClassChild shadow-lg rounded p-0">
                <div class="popup-header bg-warning text-dark p-4 position-relative">
                    <button type="button"
                        class="btn-close shadow-none ourclass_close_btn position-absolute top-0 end-0 m-3"
                        aria-label="Close"></button>
                    <div class="d-flex align-items-center">
                        <div class="popup-icon me-3">
                            <i class="bi bi-arrow-repeat fs-1"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Carousel Courses</h4>
                            <p class="mb-0 mt-1 text-white">Years 4 & 5</p>
                        </div>
                    </div>
                </div>

                <div class="popup-body p-4">
                    <p class="mb-3 text-muted"><i
                            class="bi bi-arrow-repeat text-warning me-2 align-middle"></i>Comprehensive coverage with
                        modules rotating every 2 weeks.</p>
                    <hr class="my-3">

                    <h5 class="fw-semibold mb-3">Modules Included:</h5>
                    <ul class="list-unstyled mb-3">                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                            <div>
                                <p class="mb-0 small">
                                    <b>Comprehension –</b> <span class="text-muted">worded and multiple choice.</span>
                                </p>
                                <p class="text-muted mb-0 small">Tips, techniques and practice to improve speed and
                                    accuracy.</p>
                            </div>
                        </li>                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                            <div>
                                <p class="mb-0 small">
                                    <strong>Creative Writing –</strong> <span class="text-muted">Descriptive, Report,
                                        Letter, Diary Entry and Persuasive techniques and practice.</span>
                                </p>
                                <p class="text-muted mb-0 small">Step by step guide each week plus writing task set and
                                    marked individual feedback provided each week.</p>
                            </div>
                        </li>                        <li class="mb-3 d-flex">
                            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                            <div>
                                <p class="mb-0 small">
                                    <strong>SPaG –</strong> <span class="text-muted">Spelling, Punctuation and
                                        Grammar.</span>
                                </p>
                                <p class="text-muted mb-0 small">Structured weekly lessons with challenges and quizzes
                                    in class, to reinforce concepts.</p>
                            </div>
                        </li>                        <li class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                            <div>
                                <p class="mb-0 small">
                                    <strong>Vocabulary –</strong> <span class="text-muted">antonyms / synonyms plus
                                        sentences.</span>
                                </p>
                                <p class="text-muted mb-0 small">Making vocabulary stick! Engaging and interactive
                                    classes where students enjoy learning new vocabulary. Repetition and colourful
                                    slideshows in class, help to secure words effectively. Practice sentences used.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Popup 3: Exam Practice -->
        <div class="ourClassContainer comprehension" style="display: none;">
            <div class="ourClassChild shadow-lg rounded p-0">
                <div class="popup-header bg-success text-white p-4 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white shadow-none ourclass_close_btn position-absolute top-0 end-0 m-3"
                        aria-label="Close"></button>
                    <div class="d-flex align-items-center">
                        <div class="popup-icon me-3">
                            <i class="bi bi-tools fs-1"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">English / VR - exam preparation using past papers</h4>
                            <p class="mb-0 mt-1 text-white">Years 5 & 6</p>
                        </div>
                    </div>
                </div>

                <div class="popup-body p-4">
                    <p class="mb-3"><i class="bi bi-tools text-success me-2 align-middle"></i>Focuses on exam
                        strategies, identifying weaknesses, and correction using past papers (English/VR).</p>
                    <hr class="my-3">

                    <div class="alert alert-light border mt-3">
                        <p class="mb-0"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Ideal for students
                            preparing for 11+ or Independent School entrance exams.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup 4: Intensive Courses -->
        <div class="ourClassContainer Late-teens" style="display: none;">
            <div class="ourClassChild shadow-lg rounded p-0">
                <div class="popup-header bg-danger text-white p-4 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white shadow-none ourclass_close_btn position-absolute top-0 end-0 m-3"
                        aria-label="Close"></button>
                    <div class="d-flex align-items-center">
                        <div class="popup-icon me-3">
                            <i class="bi bi-calendar-event-fill fs-1"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Intensive Courses</h4>
                            <p class="mb-0 mt-1 text-white">All Year Groups</p>
                        </div>
                    </div>
                </div>

                <div class="popup-body p-4">
                    <p class="mb-3"><i class="bi bi-calendar-event-fill text-danger me-2 align-middle"></i>Available all
                        year round and during holidays. Targeted courses that boost skills and confidence.</p>
                    <hr class="my-3">

                    <div class="alert alert-light border mt-3">
                        <p class="mb-0 text-muted"><i class="bi bi-info-circle-fill text-primary me-2"></i>Flexible
                            option for accelerated learning when needed most.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup 5: Verbal Reasoning -->
        <div class="ourClassContainer vocabulary" style="display: none;">
            <div class="ourClassChild shadow-lg rounded p-0">
                <div class="popup-header bg-primary text-white p-4 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white shadow-none ourclass_close_btn position-absolute top-0 end-0 m-3"
                        aria-label="Close"></button>
                    <div class="d-flex align-items-center">
                        <div class="popup-icon me-3">
                            <i class="bi bi-search fs-1"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Verbal Reasoning</h4>
                            <p class="mb-0 mt-1 text-white">11+ Specific Training</p>
                        </div>
                    </div>
                </div>

                <div class="popup-body p-4">
                    <p class="mb-3"><i class="bi bi-search text-primary me-2 align-middle"></i>Master all VR types (A to
                        Z) with clear explanations and dedicated practice materials (in and out of class).</p>
                    <hr class="my-3">

                    <div class="alert alert-light border mt-3">
                        <p class="mb-0 text-muted"><i class="bi bi-star-fill text-warning me-2"></i>Builds confidence
                            and competence in tackling diverse VR questions.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <section class="why-choose-us-section py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">Why Choose Us?</h2>
                    <p class="lead" style="color: red; font-weight: bold;">Unlock your child's potential with expert 11+
                        English & VR tutoring.</p>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="col-lg-10">
                        <p class="fs-5 mb-4">
                            <strong>At Success at 11+ English Tutors, we put your child first.</strong> Our engaging,
                            interactive lessons use specialist GL and other board-specific resources, backed by years of
                            teaching expertise.
                        </p>
                        <p class="fs-5 mb-4">
                            <strong>We build confidence, skills, and success</strong> in a fun, supportive, and
                            structured environment. When your child learns with us, they don't just prepare for
                            exams—they unlock their full potential.
                        </p>
                        <p class="fs-5 fw-bold blue mb-0">
                            Let's make success happen. Join us today!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Try a Class Section -->
        <section class="try-class-section py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">Try a Class</h2>
                    <p class="lead" style="color: red; font-weight: bold;">
                        Experience our teaching approach before committing.
                    </p>

                </div>

                <div class="row align-items-center g-5">
                    <div class="col-lg-6 position-relative">
                        <div class="position-relative">
                            <img src="./assets/images/success/image.png"
                                alt="Student learning online during a trial class"
                                class="img-fluid rounded-4 shadow-lg try-class-image">

                            <!-- Decorative elements -->
                            <div
                                class="position-absolute top-0 start-0 translate-middle-y d-none d-lg-block try-class-badge">
                                <div class="rounded-pill bg-white shadow-sm py-2 px-3 d-flex align-items-center">
                                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                                    <span class="fw-semibold">Trial Available</span>
                                </div>
                            </div>

                            <div class="position-absolute d-none d-lg-block"
                                style="bottom: -15px; right: -15px; z-index: 0; width: 70px; height: 70px; border-radius: 20px; transform: rotate(10deg); background-color: rgba(30,64,175,0.1);">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm p-4 p-lg-5 h-100">
                            <div class="card-body p-0">
                                <h3 class="fw-bold blue mb-4">Start Your Journey With Us !</h3>

                                <p class="fs-5 mb-4">
                                    We offer a <strong class="blue">paid trial class</strong> for each student. This
                                    ensures that your child can:
                                </p>

                                <ul class="list-unstyled mb-4">
                                    <li class="mb-3 d-flex align-items-start">
                                        <div
                                            class="feature-icon-wrapper bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-check-fill text-success"></i>
                                        </div>
                                        <span>Meet their potential teacher and connect with them</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <div
                                            class="feature-icon-wrapper bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-stars text-warning"></i>
                                        </div>
                                        <span>Experience our interactive teaching approach firsthand</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <div
                                            class="feature-icon-wrapper bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check2-circle text-primary"></i>
                                        </div>
                                        <span>Decide if our course is the right fit before committing</span>
                                    </li>
                                </ul>

                                <h4 class="h5 fw-bold blue mb-3">What Makes Us Special:</h4>
                                <div class="d-flex flex-wrap mb-4">
                                    <span
                                        class="badge bg-light text-dark border mb-2 me-2 p-2 fs-6 d-flex align-items-center">
                                        <i class="bi bi-award-fill text-blue me-2"></i> Expert Teachers
                                    </span>
                                    <span
                                        class="badge bg-light text-dark border mb-2 me-2 p-2 fs-6 d-flex align-items-center">
                                        <i class="bi bi-shield-check text-blue me-2"></i> DBS Checked
                                    </span>
                                    <span
                                        class="badge bg-light text-dark border mb-2 me-2 p-2 fs-6 d-flex align-items-center">
                                        <i class="bi bi-book-half text-blue me-2"></i> Quality Resources
                                    </span>
                                    <span
                                        class="badge bg-light text-dark border mb-2 me-2 p-2 fs-6 d-flex align-items-center">
                                        <i class="bi bi-people-fill text-blue me-2"></i> Small Classes
                                    </span>
                                </div>

                                <a class="btn btn-primary btn-lg shadow hover-lift w-100" href="tryfreeform"
                                    role="button">
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i>Apply for Trial Class
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How We Learn Section -->
        <section class="how-we-learn-section py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">How We Learn</h2>
                    <p class="lead" style="color: red; font-weight: bold;">
                        Structured, engaging, and effective learning methods.
                    </p>
                </div>
                <div class="row g-4 justify-content-center">
                    <!-- Guided Teaching -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 text-center p-4 shadow-sm border-0 hover-lift"
                            style="background-color: #eff6ff;">
                            <div class="mb-3">
                                <i class="bi bi-person-workspace display-3 text-blue"></i>
                            </div>
                            <h4 class="h5 fw-bold mb-2">Guided Teaching</h4>
                            <p class="text-muted small mb-0">Expert instruction introducing concepts clearly and
                                interactively.</p>
                        </div>
                    </div>

                    <!-- Learning Resources -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 text-center p-4 shadow-sm border-0 hover-lift"
                            style="background-color: #f0f9ff;">
                            <div class="mb-3">
                                <i class="bi bi-journal-richtext display-3 text-blue"></i>
                            </div>
                            <h4 class="h5 fw-bold mb-2">Learning Resources</h4>
                            <p class="text-muted small mb-0">Access to notes, materials, and weekly resources via the
                                student portal.</p>
                        </div>
                    </div>

                    <!-- Worksheets & Tests -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 text-center p-4 shadow-sm border-0 hover-lift"
                            style="background-color: #f0fdf4;">
                            <div class="mb-3">
                                <i class="bi bi-card-checklist display-3 text-gold"></i>
                            </div>
                            <h4 class="h5 fw-bold mb-2">Worksheets & Tests</h4>
                            <p class="text-muted small mb-0">Regular practice through worksheets and optional
                                end-of-term assessments.</p>
                        </div>
                    </div>


                    <!-- Video Section -->
                    <!-- <section class="video-section py-5 bg-light"> 
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="head2 fw-bold display-6">Our Classes In Action!</h2>
                    <p class="lead text-muted">See a glimpse of our engaging learning environment.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <div class="video-wrapper shadow-lg rounded overflow-hidden position-relative border" style="padding-bottom: 56.25%; height: 0;">
                            <video controls class="position-absolute top-0 start-0 w-100 h-100" poster="./assets/images/video_poster.jpg" title="Success at 11 Plus English Class Example">
                                <source src="assets/videos/videohome.mp4" type="video/mp4">
                                Your browser does not support the video tag. Please update your browser.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

                    <!-- Benefits/Structure Section -->
                    <section class="benefits-structure-section py-5">
                        <div class="container">
                            <div class="text-center mb-5">
                                <h2 class="head2 fw-bold display-6">Structure & Benefits</h2>
                                <p class="lead" style="color: red; font-weight: bold;">
                                    Designed for effective learning and student success.
                                </p>

                            </div>

                            <!-- Row 1: Structure -->
                            <div class="row g-5 align-items-center mb-5">
                                <div class="col-md-6">
                                    <img src="assets/images/success/image17.png" alt="Happy student showing thumbs up"
                                        class="img-fluid rounded shadow-lg">
                                </div>
                                <div class="col-md-6">
                                    <div class="benefit-item d-flex align-items-start mb-4">
                                        <i class="bi bi-clock-fill blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Structured Weekly Classes</h4>
                                            <p class="mb-0 text-muted">1 hour per week - live class with homework and
                                                progress
                                                monitoring.</p>
                                        </div>
                                    </div>
                                    <div class="benefit-item d-flex align-items-start mb-4">
                                        <i class="bi bi-people-fill blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Small Group Sizes</h4>
                                            <p class="mb-0 text-muted">Maximum of 8 students per class ensures
                                                personalised
                                                attention and interaction.</p>
                                        </div>
                                    </div>
                                    <div class="benefit-item d-flex align-items-start">
                                        <i class="bi bi-person-video3 blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Expert Teachers</h4>
                                            <p class="mb-0 text-muted">Full trained and experienced teachers with up to
                                                date DBS
                                                checks.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Resources & Practice -->
                            <div class="row g-5 align-items-center flex-md-row-reverse">
                                <div class="col-md-6">
                                    <img src="assets/images/success/image18.png"
                                        alt="Student accessing online portal resources"
                                        class="img-fluid rounded shadow-lg">
                                </div>
                                <div class="col-md-6">
                                    <div class="benefit-item d-flex align-items-start mb-4">
                                        <i class="bi bi-folder-fill blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Individual Student Portal</h4>
                                            <p class="mb-0 text-muted">Access to all weekly learning materials, notes,
                                                and resources
                                                online.</p>
                                        </div>
                                    </div>
                                    <div class="benefit-item d-flex align-items-start mb-4">
                                        <i class="bi bi-house-heart-fill blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Focused homework</h4>
                                            <p class="mb-0 text-muted">Targeted homework set and marked after each
                                                class, to ensure
                                                students have secured learning.</p>
                                        </div>
                                    </div>
                                    <div class="benefit-item d-flex align-items-start">
                                        <i class="bi bi-clipboard-check-fill blue fs-2 me-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <h4 class="h5 fw-bold blue mb-1">Optional Assessments</h4>
                                            <p class="mb-0 text-muted">End-of-term assessments available to track
                                                progress, with
                                                materials provided beforehand.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Top Tips Section -->
                    <section class="top-tips-section py-5 bg-light">
                        <div class="container">
                            <div class="row align-items-center g-5">
                                <div class="col-lg-7">
                                    <div class="p-lg-4">
                                        <h2 class="h3 blue fw-bold mb-4">TOP TIPS FOR PARENTS</h2>
                                        <div class="fs-6 lh-lg mb-4">
                                            <p><strong class="blue me-2">1.</strong>Struggling to make time and find
                                                ways to speak
                                                your <strong class="text-danger">MOTHER TONGUE</strong> with your
                                                children?</p>
                                            <p><strong class="blue me-2">2.</strong>Let Success at 11+ English help
                                                you.</p>
                                            <p><strong class="blue me-2">3.</strong>Get your 10 <strong
                                                    class="text-success">PRACTICAL TIPS</strong> – <strong
                                                    class="blue">EASY</strong> and <strong
                                                    class="text-danger">FREE!</strong></p>
                                            <p><strong class="blue me-2">4.</strong>Watch your Mother Tongue become
                                                part of your
                                                everyday vocabulary.</p>
                                            <p><strong class="blue me-2">5.</strong><strong
                                                    class="text-uppercase">FREE
                                                    GUIDE</strong> to help your children and family <strong
                                                    class="blue">SPEAK</strong> your mother tongue.</p>
                                        </div>
                                        <button type="button"
                                            class="btn btn-danger btn-lg shadow-sm hover-lift mt-3 px-4" id="sendMeBtn">
                                            <i class="bi bi-envelope-fill me-2"></i> SEND IT TO ME NOW
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-none d-lg-block">
                                    <div class="top-tips-image-wrapper rounded shadow-lg overflow-hidden">
                                        <!-- <img src="assets/images/safrina.jpeg" alt="Founder offering top tips" class="img-fluid"> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

    </main>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Page Script -->
    <script>
        // DOM ready execution
        document.addEventListener('DOMContentLoaded', function () {
            // Our Classes Popup Logic
            const classTriggers = {
                'spag-main': '.spag',
                'creative-writing-main': '.creative-writing',
                'comprehension-main': '.comprehension',
                'vocabulary-main': '.vocabulary',
                'late-Teens-main': '.Late-teens'
            };

            const closeButtons = document.querySelectorAll('.ourClassContainer .btn-close');

            // Add event listeners to trigger elements
            for (const triggerClass in classTriggers) {
                const triggerElement = document.querySelector('.' + triggerClass);
                const targetPopupSelector = classTriggers[triggerClass];
                const targetPopup = document.querySelector(targetPopupSelector);

                if (triggerElement && targetPopup) {
                    triggerElement.addEventListener('click', (e) => {
                        e.preventDefault();
                        targetPopup.classList.add('active');
                        document.body.classList.add('popup-open');
                        targetPopup.querySelector('.btn-close').focus();
                    });
                }
            }

            // Add event listeners to close buttons
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const popup = button.closest('.ourClassContainer');
                    if (popup) {
                        popup.classList.remove('active');
                        document.body.classList.remove('popup-open');
                    }
                });
            });

            // Close popups on Escape key press
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    document.querySelectorAll('.ourClassContainer').forEach(popup => {
                        if (popup.classList.contains('active')) {
                            popup.classList.remove('active');
                            document.body.classList.remove('popup-open');
                        }
                    });
                    const newsLetterPopup = document.querySelector('.newsLetterContainer');
                    if (newsLetterPopup && newsLetterPopup.classList.contains('active')) {
                        newsLetterPopup.classList.remove('active');
                        document.body.classList.remove('popup-open');
                    }
                }
            });

            // Newsletter Popup Logic
            const sendBtn = document.getElementById('sendMeBtn');
            const newsLetterContainer = document.querySelector('.newsLetterContainer');
            const newsCloseBtn = newsLetterContainer.querySelector('.btn-close');

            if (sendBtn && newsLetterContainer && newsCloseBtn) {
                sendBtn.addEventListener('click', () => {
                    newsLetterContainer.classList.add('active');
                    document.body.classList.add('popup-open');
                    newsLetterContainer.querySelector('#n_name').focus();
                });

                newsCloseBtn.addEventListener('click', () => {
                    newsLetterContainer.classList.remove('active');
                    document.body.classList.remove('popup-open');
                });

                newsLetterContainer.addEventListener('click', (event) => {
                    if (event.target === newsLetterContainer) {
                        newsLetterContainer.classList.remove('active');
                        document.body.classList.remove('popup-open');
                    }
                });
            }

            // Also close popups when clicking outside the content
            document.querySelectorAll('.ourClassContainer').forEach(container => {
                container.addEventListener('click', (e) => {
                    if (e.target === container) {
                        container.classList.remove('active');
                        document.body.classList.remove('popup-open');
                    }
                });
            });

            // Newsletter Form AJAX Submission
            if (typeof jQuery !== 'undefined') {
                $(document).ready(function () {
                    function handleEmailValidation(isValid, message, $emailField, $errorSpan) {
                        const $parentDiv = $emailField.parent();
                        if (!isValid) {
                            $emailField.addClass('is-invalid').removeClass('is-valid');
                            $parentDiv.addClass("form_error");
                            $errorSpan.text(message).css('color', 'red');
                            $emailField.val('');
                            toastr.warning(message);
                        } else {
                            $emailField.removeClass('is-invalid').addClass('is-valid');
                            $parentDiv.removeClass("form_error");
                            if ($errorSpan.text() !== "We will not share your email with anyone.") {
                                $errorSpan.text("We will not share your email with anyone.").css('color', '');
                            }
                        }
                    }

                    $(document).on('blur', '#n_email', function () {
                        var valmail = $(this).val().trim();
                        var $emailField = $(this);
                        var $errorSpan = $emailField.siblings("span");

                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (valmail === '') {
                            $emailField.removeClass('is-invalid is-valid');
                            $errorSpan.text("We will not share your email with anyone.").css('color', '');
                            return;
                        } else if (!emailRegex.test(valmail)) {
                            handleEmailValidation(false, "Please enter a valid email address.", $emailField, $errorSpan);
                            return;
                        }

                        $.ajax({
                            url: "tipAction.php",
                            method: "POST",
                            data: { check_email: valmail },
                            dataType: "json",
                            success: function (rep) {
                                if (rep.status === "exists") {
                                    handleEmailValidation(false, rep.message, $emailField, $errorSpan);
                                } else if (rep.status === "valid") {
                                    handleEmailValidation(true, "", $emailField, $errorSpan);
                                } else {
                                    handleEmailValidation(true, "", $emailField, $errorSpan);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX error checking email:", textStatus, errorThrown);
                                $emailField.removeClass('is-invalid is-valid');
                                $errorSpan.text("Could not verify email. Please try again.").css('color', 'orange');
                            }
                        });
                    });

                    $(document).on('submit', '#newsPop', function (e) {
                        e.preventDefault();

                        var $form = $(this);
                        var name = $("#n_name").val().trim();
                        var email = $("#n_email").val().trim();
                        var isChecked = $('#privacyCheck').is(':checked');
                        var $submitButton = $form.find('.subscribeBtn');
                        var isValid = true;

                        $form.find('.form-control').removeClass('is-invalid is-valid');
                        $form.find('.form-check-input').removeClass('is-invalid');
                        $form.find('span').text('').css('color', '');

                        if (name === '') {
                            $("#n_name").addClass('is-invalid');
                            isValid = false;
                        } else {
                            $("#n_name").addClass('is-valid');
                        }

                        if (email === '') {
                            $("#n_email").addClass('is-invalid');
                            $("#n_email").siblings('span').text('Email is required.').css('color', 'red');
                            isValid = false;
                        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                            $("#n_email").addClass('is-invalid');
                            $("#n_email").siblings('span').text('Please enter a valid email address.').css('color', 'red');
                            isValid = false;
                        } else {
                            $("#n_email").addClass('is-valid');
                            $("#n_email").siblings('span').text("We will not share your email with anyone.").css('color', '');
                        }

                        if (!isChecked) {
                            toastr.error('Please check the privacy policy box.');
                            return;
                        }

                        $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subscribing...');

                        $.ajax({
                            type: "POST",
                            url: "tipAction.php",
                            data: {
                                n_name: name,
                                n_email: email,
                                action: 'newsletter'
                            },
                            dataType: "json",
                            success: function (response) {
                                console.log("Subscription response:", response);
                                if (response.status === 'success') {
                                    $form[0].reset();
                                    $form.find('.form-control').removeClass('is-valid is-invalid');
                                    $form.find('.form-check-input').removeClass('is-invalid');
                                    if (newsLetterContainer) {
                                        newsLetterContainer.classList.remove('active');
                                        document.body.classList.remove('popup-open');
                                    }
                                    toastr.success(response.message || 'Successfully subscribed!', { timeOut: 5000 });
                                } else {
                                    toastr.error(response.message || 'Subscription failed. Please try again.');
                                    if (response.field === 'email') {
                                        $('#n_email').addClass('is-invalid').removeClass('is-valid');
                                        $('#n_email').siblings('span').text(response.message).css('color', 'red');
                                    }
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX subscription error:", textStatus, errorThrown);
                                toastr.error('An error occurred during subscription. Please try again later.');
                            },
                            complete: function () {
                                $submitButton.prop('disabled', false).text('SUBSCRIBE');
                            }
                        });
                    });
                });
            } else {
                console.error("jQuery is not loaded. Newsletter form submission might not work.");
            }

            // Initialize Bootstrap components if needed
            const CarouselElements = document.querySelectorAll('.Carousel');
            if (CarouselElements.length > 0 && typeof bootstrap !== 'undefined') {
                CarouselElements.forEach(element => {
                    new bootstrap.Carousel(element, {
                        interval: 8000,
                        ride: 'Carousel'
                    });
                });
            }
        });
    </script>

    <!-- Additional script for class card clicks and scroll indicator -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Define popup mapping
            const classTriggers = {
                'spag-main': '.spag',
                'creative-writing-main': '.creative-writing',
                'comprehension-main': '.comprehension',
                'vocabulary-main': '.vocabulary',
                'late-Teens-main': '.Late-teens'
            };

            // Make entire class cards clickable
            document.querySelectorAll('.class-card').forEach(card => {
                card.addEventListener('click', function () {
                    // Find which class matches this card
                    for (const triggerClass in classTriggers) {
                        if (this.classList.contains(triggerClass)) {
                            const popup = document.querySelector(classTriggers[triggerClass]);
                            if (popup) {
                                popup.classList.add('active');
                                document.body.classList.add('popup-open');
                                popup.querySelector('.btn-close').focus();
                            }
                            break;
                        }
                    }
                });
            });

            // Scroll indicator functionality
            const scrollIndicator = document.getElementById('scrollIndicator');
            if (scrollIndicator) {
                // Smooth scroll to the next section when indicator is clicked
                scrollIndicator.addEventListener('click', function () {
                    const nextSection = document.querySelector('.hero-section').nextElementSibling;
                    if (nextSection) {
                        nextSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });

                // Hide scroll indicator when user scrolls down
                window.addEventListener('scroll', function () {
                    if (window.scrollY > 100) {
                        scrollIndicator.style.opacity = '0';
                        scrollIndicator.style.transition = 'opacity 0.3s ease';
                    } else {
                        scrollIndicator.style.opacity = '1';
                    }
                });
            }
        });
    </script>

</body>

</html>