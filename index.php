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

    <!-- All inline CSS moved to indexStyles.css for maintainability and performance -->
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
                style="z-index: 0; width: 30%; height: 100%; background: radial-gradient(circle, rgba(30,64,175,0.10) 0%, rgba(0,0,0,0) 70%);">
            </div>
            <div class="position-absolute bottom-0 start-0 d-none d-lg-block"
                style="z-index: 0; width: 30%; height: 30%; background: radial-gradient(circle, rgba(30,64,175,0.10) 0%, rgba(0,0,0,0) 70%);">
            </div>
            <div class="position-absolute d-none d-lg-block"
                style="top: 15%; right: 10%; z-index: 0; width: 150px; height: 150px; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; background-color: rgba(30,64,175,0.08);">
            </div>
            <div class="position-absolute d-none d-lg-block"
                style="bottom: 10%; left: 5%; z-index: 0; width: 100px; height: 100px; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; background-color: rgba(30,64,175,0.08);">
            </div>
            <div class="container py-5">
                <div class="row gy-5 align-items-center">
                    <!-- Text Column -->
                    <div class="col-lg-6 position-relative" style="z-index: 1;">
                        <h1 class="display-4 fw-bold mb-3 lh-sm hero-title">
                            The <span class="blue position-relative d-inline-block">Outstanding<span
                                    class="position-absolute hero-underline"
                                    style="height: 10px; width: 100%; bottom: 5px; left: 0; background-color: rgba(30,64,175,0.25); z-index: -1;"></span></span>
                            Experts in<br class="d-none d-sm-block"> ONLINE English & VR Tuition!
                        </h1>

                        <h2 class="h5 blue fw-bold mb-4 hero-subtitle">
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
                        <div class="d-grid gap-3 d-sm-flex mb-5 hero-cta-group">
                            <a href="tryfreeform"
                                class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-md hover-lift hero-cta-main">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Apply for Trial Class
                            </a>
                            <a href="#ages-section"
                                class="btn btn-outline-blue btn-lg px-4 py-3 fw-semibold shadow-md hover-lift hero-cta-alt">
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
                            <img src="./assets/images/success/herosection-image.png"
                                alt="Happy students learning and growing with Success at 11 plus English"
                                class="img-fluid rounded-4 shadow-lg hero-img"
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
                    <h2 class="head2 fw-bold display-6">YEARS</h2>
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
                            <div class="year-card card shadow year-card-4 border-0">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="year-badge year-badge-4 mb-4">Year 4</div>
                                    <div class="age-item-icon mx-auto mb-4 text-danger">
                                        <i class="bi bi-book  display-3" style="color:#1E40AF;"></i>
                                    </div>
                                    <div class="mt-auto">
                                        <a class="btn btn-apply-now btn-blue px-4 py-2 fw-bold" href="courses_year4?lan=Year4"
                                            role="button">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year 5 Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="year-card card shadow year-card-5 border-0">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="year-badge year-badge-5 mb-4">Year 5</div>
                                    <div class="age-item-icon mx-auto mb-4 text-warning">
                                        <i class="bi bi-pencil-square display-3"></i>
                                    </div>
                                    <div class="mt-auto">
                                        <a class="btn btn-apply-now btn-gold px-4 py-2 fw-bold" href="courses_year5?lan=Year5"
                                            role="button">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year 6 Card -->
                        <div class="col-md-6 col-lg-4">
                            <div class="year-card card shadow year-card-6 border-0">
                                <div class="card-body py-5 px-4 d-flex flex-column align-items-center">
                                    <div class="year-badge year-badge-6 mb-4">Year 6</div>
                                    <div class="age-item-icon mx-auto mb-4 text-success">
                                        <i class="bi bi-mortarboard-fill display-3"></i>
                                    </div>
                                    <div class="mt-auto">
                                        <a class="btn btn-apply-now btn-blue px-4 py-2 fw-bold" href="courses_year6?lan=Year6"
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
                                style="background-image: url('./assets/images/success/targetmodules.png');">
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
                                style="background-image: url('./assets/images/success/intensive.png');">
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
                                style="background-image: url('./assets/images/success/Verbal Reasoning.png');">
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
            </div>        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);">
            <!-- Background decorative elements -->
            <div class="position-absolute top-0 start-0 d-none d-lg-block" style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(30,64,175,0.05) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
            <div class="position-absolute bottom-0 end-0 d-none d-lg-block" style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(245,158,11,0.05) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
            <div class="position-absolute top-50 start-50 translate-middle d-none d-lg-block" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(30,64,175,0.02) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>

            <div class="container position-relative" style="z-index: 2;">                <!-- Section Header -->
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block mb-4">
                        <h2 class="head2 fw-bold display-5 mb-0">What Parents & Students Say</h2>
                        <div class="position-absolute bottom-0 start-50 translate-middle-x" style="width: 100px; height: 4px; background: linear-gradient(90deg, var(--theme-blue), var(--theme-gold)); border-radius: 2px; margin-top: 1rem;"></div>
                    </div>
                    <p class="lead fw-semibold mb-0" style="color: red; font-size: 1.1rem;">Real feedback from families who trusted us with their 11+ journey</p>
                </div>

                <!-- Desktop Carousel -->
                <div class="position-relative d-none d-lg-block">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            <!-- Slide 1 -->
                            <div class="carousel-item active">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: var(--theme-blue); line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1" style="color: var(--theme-blue);">Mrs C Cheung</h6>
                                                        <p class="text-muted mb-0 small">Reading</p>
                                                    </div>
                                                </div>                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"We can't thank you enough for how you helped us to hugely improve English while we were with you. It helped immensely her confidence to do creative writing and comprehension grew so quickly. Thank you once again for your effort, going the extra mile to make sure she understands."</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: var(--theme-gold); line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--theme-gold), var(--theme-gold-dark)); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1" style="color: var(--theme-gold);">Mr J Aujla</h6>
                                                        <p class="text-muted mb-0 small">Harrow</p>
                                                    </div>
                                                </div>                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"I would definitely recommend these classes to anybody who requires tutoring. You do the best tutoring and make it not a stressful but happy and motivating process! You are amazing!"</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #198754; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #198754, #157347); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1 text-success">Mrs L King</h6>
                                                        <p class="text-muted mb-0 small">Birmingham</p>
                                                    </div>
                                                </div>                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"Thank you very much for being so gentle and engaging at the same time. I wish I found you before. She is happy and not intimidated, is trying her best to come out of her shell as I can see which is a massive win for us."</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #dc3545; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545, #b02a37); box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1 text-danger">Mr P Jain</h6>
                                                        <p class="text-muted mb-0 small">Kent</p>
                                                    </div>
                                                </div>
                                                <blockquote class="mb-3">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"Thanks for all efforts and dedication from you Mam. You have really helped him in English and VR. Your positivity and motivation helped Raghu to boost his confidence. Techniques for Comprehension, way of vocabulary teaching, SPaG is exceptional and kids oriented."</p>                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: var(--theme-blue); line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1" style="color: var(--theme-blue);">Mrs G Rajapaksha</h6>
                                                        <p class="text-muted mb-0 small">East London</p>
                                                    </div>
                                                </div>
                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"But one thing I can say, Taneesh loved your way of teaching and we can see a lot of change in his work. One request from my end, please let us know if you are offering any more courses related to English."</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #fd7e14; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #fd7e14, #e8590c); box-shadow: 0 4px 15px rgba(253, 126, 20, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1" style="color: #fd7e14;">Mrs S Aslan</h6>
                                                        <p class="text-muted mb-0 small">Surrey</p>
                                                    </div>
                                                </div>
                                                <blockquote class="mb-3">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"It's clear that your dedication, expertise, and personalized teaching methods are making a huge difference. I'm so grateful for the positive influence you've had on her academic growth and language development."</p>                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #0dcaf0; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #0dcaf0, #087990); box-shadow: 0 4px 15px rgba(13, 202, 240, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1 text-info">Mr A Ademolu</h6>
                                                        <p class="text-muted mb-0 small">Gloucestershire</p>
                                                    </div>
                                                </div>
                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"I can't thank you enough for the incredible impact your teaching has had on my daughter. Your approach to Comprehension and SPaG is truly exceptional, and the progress we've seen in just a few months is nothing short of amazing."</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="testimonial-card h-100 card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem; transition: all 0.3s ease;">
                                            <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #6c757d; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                                <i class="bi bi-quote"></i>
                                            </div>
                                            <div class="position-relative" style="z-index: 2;">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #6c757d, #495057); box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);">
                                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1 text-secondary">Mrs T James</h6>
                                                        <p class="text-muted mb-0 small">Leeds</p>
                                                    </div>
                                                </div>                                                <blockquote class="mb-0">
                                                    <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"She has passed her 11 plus for The Leeds Grammar School at Leeds. We can't thank you enough for how you helped us in the short few weeks we were with you. It helped immensely her confidence to do creative writing."</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        </div>

                        <!-- Custom Navigation Arrows -->
                        <button class="carousel-control-prev position-absolute top-50 start-0 translate-middle-y border-0 bg-transparent" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="width: 50px; height: 50px; margin-left: -25px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-center rounded-circle shadow-lg" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); transition: all 0.3s ease;">
                                <i class="bi bi-chevron-left text-white" style="font-size: 1.2rem; font-weight: bold;"></i>
                            </div>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="width: 50px; height: 50px; margin-right: -25px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-center rounded-circle shadow-lg" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--theme-gold), var(--theme-gold-dark)); transition: all 0.3s ease;">
                                <i class="bi bi-chevron-right text-white" style="font-size: 1.2rem; font-weight: bold;"></i>
                            </div>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Carousel Indicators - Properly Centered -->
                    <div class="carousel-indicators position-static d-flex justify-content-center mt-4 mb-0">
                        <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                </div>

                <!-- Mobile: Stacked Cards -->
                <div class="d-lg-none">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="testimonial-card card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem;">
                                <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: var(--theme-blue); line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <div class="position-relative" style="z-index: 2;">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);">
                                            <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1" style="color: var(--theme-blue);">Mrs C Cheung</h6>
                                            <p class="text-muted mb-0 small">Reading</p>
                                        </div>
                                    </div>                                    <blockquote class="mb-0">
                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"We can't thank you enough for how you helped us to hugely improve English while we were with you. It helped immensely her confidence to do creative writing and comprehension grew so quickly."</p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="testimonial-card card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem;">
                                <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: var(--theme-gold); line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <div class="position-relative" style="z-index: 2;">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--theme-gold), var(--theme-gold-dark)); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                                            <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1" style="color: var(--theme-gold);">Mr J Aujla</h6>
                                            <p class="text-muted mb-0 small">Harrow</p>
                                        </div>
                                    </div>                                    <blockquote class="mb-0">
                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"I would definitely recommend these classes to anybody who requires tutoring. You do the best tutoring and make it not a stressful but happy and motivating process!"</p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="testimonial-card card border-0 shadow-lg p-4 position-relative overflow-hidden" style="border-radius: 1rem;">
                                <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 6rem; color: #198754; line-height: 1; margin-top: -1rem; margin-right: -1rem;">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <div class="position-relative" style="z-index: 2;">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, #198754, #157347); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);">
                                            <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-success">Mrs L King</h6>
                                            <p class="text-muted mb-0 small">Birmingham</p>
                                        </div>
                                    </div>                                    <blockquote class="mb-0">
                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem; color: #495057; font-style: italic;">"Thank you very much for being so gentle and engaging at the same time. I wish I found you before. She is happy and not intimidated, is trying her best to come out of her shell."</p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Testimonials Section -->

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
                            <img src="./assets/images/success/tryclass.png"
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
                            style="background-color:#eff6ff;">
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
                            style="background-color: #eff6ff;">
                            <div class="mb-3">
                                <i class="bi bi-card-checklist display-3 text-blue"></i>
                            </div>
                            <h4 class="h5 fw-bold mb-2">Worksheets & Tests</h4>
                            <p class="text-muted small mb-0">Regular practice through worksheets and optional
                                end-of-term assessments.</p>
                        </div>
                    </div>


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
                            <!-- Section Header -->
                            <div class="text-center mb-5">
                                <div class="position-relative d-inline-block">
                                    <h2 class="head2 fw-bold display-5 mb-3">SUCCESS AT 11 PLUS ENGLISH</h2>
                                    <div class="position-absolute bottom-0 start-50 translate-middle-x" style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--theme-blue), var(--theme-gold)); border-radius: 2px;"></div>
                                </div>
                                <p class="lead text-danger fw-semibold mt-4 mb-0">Expert tips and strategies for 11+ exam success</p>
                            </div>

                            <!-- General Tips -->
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="card shadow-lg border-0 overflow-hidden">
                                        <div class="card-header position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); padding: 2rem 1.5rem;">
                                            <!-- Background decoration -->
                                            <div class="position-absolute top-0 end-0" style="font-size: 8rem; line-height: 1; margin-top: -2rem; margin-right: -1rem; color: rgba(255, 255, 255, 0.06);">
                                                <i class="bi bi-lightbulb-fill"></i>
                                            </div>
                                            
                                            <!-- Title with strong background for readability -->
                                            <div class="position-relative" style="z-index: 20;">
                                                <div class="d-inline-block px-4 py-2 rounded-3" >
                                                    <h3 class="h3 mb-0 fw-bold text-white" style=" letter-spacing: 0.5px;">
                                                        <i class="bi bi-lightbulb-fill me-3 fs-4 text-warning" style="filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5));"></i>
                                                        GENERAL TIPS for success at 11 plus English exams!
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-5 bg-white">
                                            <div class="row g-4">
                                                <div class="col-lg-4">
                                                    <div class="d-flex align-items-start h-100">
                                                        <div class="flex-shrink-0 me-4">
                                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--theme-blue), rgba(30, 64, 175, 0.8)); box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);">
                                                                <i class="bi bi-book text-white" style="font-size: 1.75rem;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fw-bold mb-3" style="color: var(--theme-blue); font-size: 1.1rem; letter-spacing: 0.5px;">DAILY READING</h5>
                                                            <p class="text-muted mb-0 lh-lg" style="font-size: 0.95rem;">At least 15 minutes per day. This must be purposeful - which means understanding what you have read and looking up/noting difficult words.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="d-flex align-items-start h-100">
                                                        <div class="flex-shrink-0 me-4">
                                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--theme-gold), #d97706); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                                                                <i class="bi bi-chat-text text-white" style="font-size: 1.75rem;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fw-bold mb-3" style="color: var(--theme-gold); font-size: 1.1rem; letter-spacing: 0.5px;">SOPHISTICATED VOCABULARY</h5>
                                                            <p class="text-muted mb-0 lh-lg" style="font-size: 0.95rem;">Learning and using sophisticated vocabulary in your daily conversations will make a huge difference to comprehension and creative writing skills.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="d-flex align-items-start h-100">
                                                        <div class="flex-shrink-0 me-4">
                                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #198754, #157347); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);">
                                                                <i class="bi bi-check2-circle text-white" style="font-size: 1.75rem;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fw-bold mb-3 text-success" style="font-size: 1.1rem; letter-spacing: 0.5px;">SPELLING, PUNCTUATION & GRAMMAR</h5>
                                                            <p class="text-muted mb-0 lh-lg" style="font-size: 0.95rem;">Learning the rules of spelling, punctuation and grammar are required to answer test questions successfully.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subject-Specific Tips -->
                            <div class="row g-4 mb-5">
                                <!-- Comprehension Tips -->
                                <div class="col-lg-4">
                                    <div class="card shadow-lg border-0 h-100 overflow-hidden">
                                        <div class="card-header position-relative" style="background: linear-gradient(135deg, #0dcaf0, #087990); padding: 1.75rem 1.5rem;">
                                            <div class="position-absolute top-0 end-0" style="font-size: 5rem; line-height: 1; margin-top: -1rem; margin-right: -0.5rem; color: rgba(255, 255, 255, 0.15);">
                                                <i class="bi bi-search"></i>
                                            </div>
                                            <h4 class="h5 mb-0 fw-bold position-relative" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                                                <i class="bi bi-search me-2 fs-5" style="color: #ffffff;"></i>
                                                COMPREHENSION - Top tips
                                            </h4>
                                        </div>
                                        <div class="card-body p-4 bg-white">
                                            <ol class="list-unstyled mb-0">
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">1</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Read the title.</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">2</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Read and understand each paragraph.</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">3</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Re-Read question and underline what is being asked - true/false etc.</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">4</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">For multiple choice questions - use the process of elimination to get to 2 answers. Then match answer in text - eliminate 3 silly answers!</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">5</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">For worded comprehension questions - provide evidence from text to support your answer.</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">6</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Remember, if it's not written/inferred exactly in text then it's NOT TRUE!</span>
                                                </li>
                                                <li class="mb-3 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">7</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Match synonyms exactly to quoted questions.</span>
                                                </li>
                                                <li class="mb-0 d-flex align-items-start">
                                                    <span class="badge rounded-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #087990); font-size: 0.85rem; font-weight: 600;">8</span>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Finally, double check all answers!</span>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vocabulary Tips -->
                                <div class="col-lg-4">
                                    <div class="card shadow-lg border-0 h-100 overflow-hidden">
                                        <div class="card-header position-relative" style="background: linear-gradient(135deg, #d97706); padding: 1.75rem 1.5rem;">
                                            <div class="position-absolute top-0 end-0" style="font-size: 5rem; line-height: 1; margin-top: -1rem; margin-right: -0.5rem; color: rgba(255, 255, 255, 0.15);">
                                                <i class="bi bi-alphabet"></i>
                                            </div>
                                            <h4 class="h5 mb-0 fw-bold position-relative" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                                                <i class="bi bi-alphabet me-2 fs-5" style="color: #ffffff;"></i>
                                                VOCABULARY - Top tips
                                            </h4>
                                        </div>
                                        <div class="card-body p-4 bg-white">
                                            <h6 class="fw-bold mb-4 pb-2 border-bottom" style="color: var(--theme-gold); font-size: 1rem; letter-spacing: 0.5px;">Why is it important for Reading Comprehension?</h6>
                                            <div class="space-y-4">
                                                <div class="mb-4 p-3 rounded-3" style="background-color: rgba(245, 158, 11, 0.08); border-left: 4px solid var(--theme-gold);">
                                                    <h6 class="fw-semibold mb-2" style="color: var(--theme-gold); font-size: 0.9rem;">Vocabulary as a Foundation:</h6>
                                                    <p class="text-muted mb-0 lh-lg" style="font-size: 0.9rem;">A strong vocabulary is essential for reading comprehension because readers cannot understand what they are reading without knowing the meaning of most of the words.</p>
                                                </div>
                                                <div class="mb-4 p-3 rounded-3" style="background-color: rgba(245, 158, 11, 0.08); border-left: 4px solid var(--theme-gold);">
                                                    <h6 class="fw-semibold mb-2" style="color: var(--theme-gold); font-size: 0.9rem;">Comprehension as a Process:</h6>
                                                    <p class="text-muted mb-0 lh-lg" style="font-size: 0.9rem;">Comprehension involves understanding, analyzing, and synthesizing words, sentences, and ideas.</p>
                                                </div>
                                                <div class="mb-4 p-3 rounded-3" style="background-color: rgba(245, 158, 11, 0.08); border-left: 4px solid var(--theme-gold);">
                                                    <h6 class="fw-semibold mb-2" style="color: var(--theme-gold); font-size: 0.9rem;">Why Vocabulary Matters:</h6>
                                                    <p class="text-muted mb-0 lh-lg" style="font-size: 0.9rem;">A rich vocabulary enables readers to make inferences and thematic links within a text, making it easier to understand even complex material.</p>
                                                </div>
                                                <div class="mb-0 p-3 rounded-3" style="background-color: rgba(245, 158, 11, 0.08); border-left: 4px solid var(--theme-gold);">
                                                    <h6 class="fw-semibold mb-2" style="color: var(--theme-gold); font-size: 0.9rem;">Word Structure and Meaning:</h6>
                                                    <p class="text-muted mb-0 lh-lg" style="font-size: 0.9rem;">Knowledge of word structure and how words are formed is linked to both greater vocabulary development and stronger reading comprehension.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creative Writing Tips -->
                                <div class="col-lg-4">
                                    <div class="card shadow-lg border-0 h-100 overflow-hidden">
                                        <div class="card-header position-relative" style="background: linear-gradient(135deg, #198754, #157347); padding: 1.75rem 1.5rem;">
                                            <div class="position-absolute top-0 end-0" style="font-size: 5rem; line-height: 1; margin-top: -1rem; margin-right: -0.5rem; color: rgba(255, 255, 255, 0.15);">
                                                <i class="bi bi-pencil-square"></i>
                                            </div>
                                            <h4 class="h5 mb-0 fw-bold position-relative" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                                                <i class="bi bi-pencil-square me-2 fs-5" style="color: #ffffff;"></i>
                                                CREATIVE WRITING - Top tips
                                            </h4>
                                        </div>
                                        <div class="card-body p-4 bg-white">
                                            <h6 class="fw-bold mb-3 pb-2 border-bottom text-success" style="font-size: 1rem; letter-spacing: 0.5px;">What do examiners look for in creative writing?</h6>
                                            <p class="text-muted mb-4 lh-lg" style="font-size: 0.9rem; font-style: italic;">Successfully passing your creative writing 11 Plus creative writing exam is a lot less daunting, if you know what the examiners are looking for in your creative writing.</p>
                                            <div class="checklist">
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">A well planned piece of writing</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Strong creativity and good imagination</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">A fluent writing style</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Good and correct use of punctuation</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Good use of English grammar</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Complex sentences that are broken in an easy-to-read way with commas</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Good spelling</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Neat, easy-to-read handwriting</span>
                                                </div>
                                                <div class="mb-2 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Sophisticated Vocabulary</span>
                                                </div>
                                                <div class="mb-0 d-flex align-items-start">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
                                                    <span class="lh-lg" style="font-size: 0.95rem;">Purpose to your story</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reading Guide Section -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-lg border-0 overflow-hidden">
                                        <div class="card-header position-relative" style="background: linear-gradient(135deg, #dc3545, #b02a37); padding: 2.5rem 2rem;">
                                            <div class="position-absolute top-0 end-0" style="font-size: 10rem; line-height: 1; margin-top: -3rem; margin-right: -2rem; color: rgba(255, 255, 255, 0.12);">
                                                <i class="bi bi-heart-fill"></i>
                                            </div>
                                            <div class="text-center position-relative">
                                                <h3 class="h2 mb-0 fw-bold" style="color: #ffffff; text-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);">
                                                    <i class="bi bi-heart-fill me-3 fs-3" style="color: #ffb3ba;"></i>
                                                    Parents guide to help students to love reading!
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body p-5 bg-white">
                                            <div class="row g-5">
                                                <div class="col-lg-6">
                                                    <div class="pe-lg-3">
                                                        <div class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08), rgba(220, 53, 69, 0.05)); border-left: 5px solid #dc3545;">
                                                            <h5 class="fw-bold text-danger mb-3" style="font-size: 1.25rem; letter-spacing: 0.5px;">Here's an 11+ Reading Guide to encourage young readers!</h5>
                                                        </div>
                                                        
                                                        <div class="reading-principles mb-5">
                                                            <div class="mb-3 p-3 rounded-3 bg-light border-start border-4 border-danger">
                                                                <p class="mb-0 lh-lg" style="font-size: 1rem;">Everyone is different. We don't all like the same films, so why should we all like to read and like the same books?</p>
                                                            </div>
                                                            <div class="mb-3 p-3 rounded-3 bg-light border-start border-4 border-danger">
                                                                <p class="mb-0 lh-lg" style="font-size: 1rem;">What's most important is that you enjoy reading and find what makes you tick!</p>
                                                            </div>
                                                            <div class="mb-3 p-3 rounded-3" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05)); border: 2px solid #dc3545;">
                                                                <p class="mb-0 lh-lg fw-bold text-danger" style="font-size: 1.1rem;">Remember, every kind of reading counts!</p>
                                                            </div>
                                                            <div class="mb-3 p-3 rounded-3 bg-light border-start border-4 border-danger">
                                                                <p class="mb-0 lh-lg" style="font-size: 1rem;">Reading improves your comprehension skills, expands your vocabulary, and helps you become a better writer too.</p>
                                                            </div>
                                                            <div class="mb-3 p-3 rounded-3 bg-light border-start border-4 border-danger">
                                                                <p class="mb-0 lh-lg" style="font-size: 1rem;">But, reading has to be purposeful and mindful. Understanding what you have read is key.</p>
                                                            </div>
                                                        </div>

                                                        <div class="reading-types">
                                                            <div class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08), rgba(220, 53, 69, 0.05)); border: 1px solid rgba(220, 53, 69, 0.2);">
                                                                <h6 class="fw-bold text-danger mb-3" style="font-size: 1.1rem; letter-spacing: 0.5px;">Every kind of reading is good reading! Don't just read stories</h6>
                                                                <p class="text-muted mb-3" style="font-size: 1rem;">Why not try the following?</p>
                                                            </div>
                                                            
                                                            <div class="reading-list">
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-book text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Non-fiction books</span> - about science, history, nature, space, sport, or anything else you're curious about</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-newspaper text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Newspapers and magazines</span> - like National Geographic Kids, or magazines about your hobbies</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-person text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Biographies and autobiographies</span> - real-life stories of people that you admire or follow in sports or films perhaps</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-info-circle text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Information texts</span> - travel guides, websites, holiday brochures or leaflets about local attractions in London.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-megaphone text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Persuasive writing</span> - such as adverts for holidays, opinion pieces, or even letters (search internet for examples) or even websites selling your favourite products!</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex align-items-start">
                                                                    <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #dc3545, #b02a37);">
                                                                        <i class="bi bi-list-check text-white" style="font-size: 1.1rem;"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.95rem;"><span class="fw-semibold">Instructions and recipes</span> - cookery or model making kits or how to assemble a piece of furniture. This is great for learning how to follow steps and attention to detail</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="ps-lg-3">
                                                        <div class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08), rgba(220, 53, 69, 0.05)); border-left: 5px solid #dc3545;">
                                                            <h6 class="fw-bold text-danger mb-3" style="font-size: 1.1rem; letter-spacing: 0.5px;">Book Suggestions for Young Readers</h6>
                                                            <p class="text-muted mb-0" style="font-size: 1rem;">It's tough to choose reading books as there are shelves full of thousands of books! So here are some suggestions for young readers.</p>
                                                        </div>

                                                        <div class="book-sections">
                                                            <div class="mb-5">
                                                                <div class="d-flex align-items-center mb-4">
                                                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark)); box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);">
                                                                        <i class="bi bi-book-half text-white" style="font-size: 1.3rem;"></i>
                                                                    </div>
                                                                    <h6 class="fw-bold mb-0 text-primary" style="font-size: 1.15rem; letter-spacing: 0.5px;">Classic Fiction</h6>
                                                                </div>
                                                                <div class="books-list">
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-primary">
                                                                        <h6 class="fw-bold mb-1 text-primary" style="font-size: 0.95rem;">Swallows and Amazons</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Arthur Ransome</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">Children enjoy wild outdoor adventures, sailing and camping in the Lake District.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-primary">
                                                                        <h6 class="fw-bold mb-1 text-primary" style="font-size: 0.95rem;">The Children of the New Forest</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Frederick Marryat</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">Four siblings survive in secret during the English Civil War, learning to live off the land.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-primary">
                                                                        <h6 class="fw-bold mb-1 text-primary" style="font-size: 0.95rem;">Tom's Midnight Garden</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Philippa Pearce</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">A boy finds a magical garden that appears at midnight, where time seems to run in reverse.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-primary">
                                                                        <h6 class="fw-bold mb-1 text-primary" style="font-size: 0.95rem;">The Phoenix and the Carpet</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by E. Nesbit</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">Siblings discover a magical carpet and a talking phoenix that whisk them off on exciting adventures.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-primary">
                                                                        <h6 class="fw-bold mb-1 text-primary" style="font-size: 0.95rem;">The Prince and the Pauper</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Mark Twain</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">Two boys from completely different worlds switch places and experience life through each other's eyes.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-4">
                                                                <div class="d-flex align-items-center mb-4">
                                                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #198754, #157347); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);">
                                                                        <i class="bi bi-compass text-white" style="font-size: 1.3rem;"></i>
                                                                    </div>
                                                                    <h6 class="fw-bold mb-0 text-success" style="font-size: 1.15rem; letter-spacing: 0.5px;">Adventure Fiction</h6>
                                                                </div>
                                                                <div class="books-list">
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-success">
                                                                        <h6 class="fw-bold mb-1 text-success" style="font-size: 0.95rem;">The Explorer</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Katherine Rundell</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">After a plane crash in the Amazon, four children must survive and uncover the secrets of the jungle.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-success">
                                                                        <h6 class="fw-bold mb-1 text-success" style="font-size: 0.95rem;">Running on the Roof of the World</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Jess Butterworth</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">A girl escapes occupied Tibet on a dangerous journey across the Himalayas with a stolen yak.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-success">
                                                                        <h6 class="fw-bold mb-1 text-success" style="font-size: 0.95rem;">The Peculiars</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Kieran Larwood</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">A group of children with unusual abilities escape from a cruel orphanage and go on the run for their lives.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-success">
                                                                        <h6 class="fw-bold mb-1 text-success" style="font-size: 0.95rem;">The Way of Dog</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Zana Fraillon</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">A dog sets out on an epic journey to find his boy, facing wild landscapes and danger.</p>
                                                                    </div>
                                                                    <div class="mb-3 p-3 rounded-3 bg-light border-start border-3 border-success">
                                                                        <h6 class="fw-bold mb-1 text-success" style="font-size: 0.95rem;">Secrets of the Last Spell</h6>
                                                                        <p class="text-muted mb-1" style="font-size: 0.85rem;">by Alex Evelyn</p>
                                                                        <p class="mb-0 lh-lg" style="font-size: 0.9rem;">An urban eco-adventure involving runaway children, ancient trees, and a magical quest to save nature.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!-- Call to Action -->
                                            <div class="text-center mt-5 pt-4" style="border-top: 3px solid rgba(220, 53, 69, 0.1);">
                                                <div class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08), rgba(220, 53, 69, 0.05)); border: 2px solid rgba(220, 53, 69, 0.2);">
                                                    <p class="mb-2 fw-bold text-danger" style="font-size: 1.1rem;">I hope you found these tips valuable.</p>
                                                    <p class="mb-2 lh-lg" style="font-size: 1rem;">Our classes use all of the tips and techniques above, plus many more!</p>
                                                    <p class="mb-0 fw-semibold" style="color: var(--theme-blue); font-size: 1.05rem;">Join our online classes, all year round, to improve your child's English skills for life, not just 11 plus!</p>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-lg shadow-lg hover-lift px-5 py-3" id="sendMeBtn" style="font-size: 1.1rem; font-weight: 600; letter-spacing: 0.5px; border-radius: 50px; box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3) !important;">
                                                    <i class="bi bi-envelope-fill me-3 fs-5"></i> GET YOUR FREE TOP 10 TIPS
                                                </button>
                                            </div>
                                        </div>
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
    <script src="assets/js/index.js"></script>
</body>

</html>