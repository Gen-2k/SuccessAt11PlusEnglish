<?php
// Define BASE_URL if not already defined globally
if (!defined('BASE_URL')) { define('BASE_URL', '/'); } // Adjust '/' if needed
// Assuming 'year5' is the identifier for this page/language
$languageOrPageId = 'year5'; 
// Or use session if available: $languageOrPageId = $_SESSION['classid'] ?? 'year5'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="Year 5 Tuition, 11 Plus English, Primary School English, Online Tutoring UK, Comprehension, Creative Writing, SPaG, Vocabulary">
    <meta name="description" content="Expert online tuition for Year 5 students focusing on 11 Plus English preparation, Comprehension, Creative Writing, SPaG, Vocabulary, and Verbal Reasoning.">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:site_name" content="Success At 11 Plus English">
    <meta property="og:title" content="Year 5 Online English Tuition | Success At 11 Plus English">
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="og:image" content="<?php echo rtrim(BASE_URL, '/'); ?>/assets/images/logonew.png">
    
    <title>Year 5 English Modules | Success At 11 Plus English</title>
    
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
    --theme-violet: #6e20a7;
    --theme-violet-dark: #5a1a8a;
    --theme-teal: #20c997;
    --theme-teal-dark: #19a479;
    --text-muted-light: #6c757d;
    --heading-color: #343a40;
    --body-bg: #f8f9fa;
    --card-bg: #ffffff;
    --card-border: #dee2e6;
    --light-gray-bg: #f1f4f8;
    --primary-blue: #0d6efd;
}

body {
    background-color: var(--body-bg);
    font-family: 'Lato', sans-serif;
    color: #495057;
    font-size: 1rem;
    line-height: 1.7;
}

h1, h2, h3, h4, h5, h6 {
     font-family: 'Poppins', sans-serif;
     font-weight: 600;
     color: var(--heading-color);
     line-height: 1.4;
}

p {
    font-size: 1.05rem;
    margin-bottom: 1.25rem;
}

.violet { color: var(--theme-violet) !important; }
.text-teal { color: var(--theme-teal) !important; }

.section-padding {
    padding: 4rem 0;
}

.section-heading {
    font-weight: 700;
    font-size: 2.25rem;
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
    color: var(--theme-violet);
}

.section-heading::after {
    content: ''; position: absolute; bottom: -10px; left: 50%;
    transform: translateX(-50%); width: 70px; height: 4px;
    background-color: var(--theme-violet); border-radius: 2px;
}

.pricing-section .card {
    background-color: var(--card-bg);
    border: 1px solid var(--card-border);
    border-top: 4px solid var(--theme-violet);
    border-radius: 0.75rem;
    padding: 0;
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    overflow: hidden;
}

.pricing-section .card-body {
    padding: 2.5rem;
}

.pricing-section .card-body h3 {
    font-weight: 600;
    color: var(--theme-violet);
    margin-bottom: 1.25rem;
    font-size: 1.05rem;
}

.pricing-section .price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0.5rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 1.05rem;
}

.pricing-section .price-item:nth-child(even) {
    background-color: var(--light-gray-bg);
}
.pricing-section .price-item:last-child {
    border-bottom: none;
}
.pricing-section .price-item .item-name {
    color: var(--heading-color);
    font-weight: 600;
}
.pricing-section .price-item .item-details {
    font-size: 0.9rem;
    color: var(--text-muted-light);
    display: block;
}
.pricing-section .price-item .item-price {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--theme-violet); 
    white-space: nowrap;
    margin-left: 1rem;
}
.pricing-section .price-item .item-price .term {
    font-size: 0.85rem;
    font-weight: 400;
    color: var(--text-muted-light);
}

.module-card {
    background-color: var(--card-bg);
    border-radius: 0.75rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 3rem;
}

.module-card .row {
    align-items: stretch;
}

.module-image-col img {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 350px;
    object-fit: cover;
    border-radius: 0.75rem 0 0 0.75rem;
}

.module-content-col {
    padding: 2.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.module-content-col h3 {
    color: var(--theme-violet);
    font-weight: 700;
    font-size: 1.85rem;
    margin-bottom: 1rem;
}

.module-content-col p {
     font-size: 1.05rem;
     line-height: 1.75;
     color: var(--text-muted-light);
     margin-bottom: 2rem;
}

.module-buttons .btn {
    padding: 0.75rem 1.75rem;
    font-size: 0.95rem;
    font-weight: 700;
    margin-right: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 50px;
    transition: all 0.3s ease;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    line-height: 1.5;
}
.module-buttons .btn i {
    margin-right: 0.6rem;
    font-size: 1.2em;
}

.module-buttons .btn.btn-apply {
    background-color: transparent;
    border: 1px solid var(--theme-violet) !important;
    color: var(--theme-violet);
    box-shadow: none;
    transition: all 0.2s ease-in-out;
}
.module-buttons .btn.btn-apply:hover {
    background-color: var(--theme-violet);
    border-color: var(--theme-violet);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(110, 32, 167, 0.15);
}

.module-buttons .btn.btn-syllabus {
    background-color: transparent;
    border: 1px solid var(--theme-teal) !important;
    color: var(--theme-teal);
    box-shadow: none;
    transition: all 0.2s ease-in-out;
}
.module-buttons .btn.btn-syllabus:hover {
    background-color: var(--theme-teal);
    border-color: var(--theme-teal);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(32, 201, 151, 0.15);
}

.module-buttons .btn.btn-apply i {
    color: var(--theme-violet);
}
.module-buttons .btn.btn-syllabus i {
    color: var(--theme-teal);
}

.module-buttons .btn.btn-apply:hover i,
.module-buttons .btn.btn-syllabus:hover i {
    color: white;
}

.notes-card {
    border: 1px solid #e0e0e0;
    background-color: var(--light-gray-bg);
    border-radius: 0.5rem;
    height: 100%;
    box-shadow: 0 4px 10px rgba(0,0,0,0.04);
}

.notes-card .card-header {
    background-color: #e9ecef;
    color: var(--heading-color);
    font-weight: 600;
    border-bottom: 1px solid #d1d9e1;
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    padding: 1rem 1.25rem;
}
.notes-card .card-header i {
    margin-right: 0.6rem;
    color: var(--theme-violet);
    font-size: 1.2em;
}

.notes-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.notes-card li {
    padding: 0.85rem 1.25rem 0.85rem 2.75em;
    position: relative;
    border-bottom: 1px solid #e9ecef;
    font-size: 1rem;
    color: #555;
}
.notes-card li:last-child {
    border-bottom: none;
}
.notes-card li::before {
    content: '\F28A';
    font-family: 'bootstrap-icons';
    position: absolute;
    left: 1.1em;
    top: 0.95em;
    color: var(--theme-violet);
    font-weight: bold;
    font-size: 1em;
}

.conduct-warning {
    border: 1px solid #f5c2c7;
    background-color: #f8d7da;
    padding: 1.25rem 1.5rem;
    color: #842029;
    border-radius: 0.375rem;
    margin-top: 2rem;
    display: flex;
    align-items: center;
    font-size: 1.05rem;
}
.conduct-warning i {
    margin-right: 0.85rem;
    font-size: 1.4em;
}

@media (max-width: 991.98px) {
    .module-content-col { padding: 2rem 2.5rem; }
    .pricing-section .card-body { padding: 1.75rem; }
}

@media (max-width: 767.98px) {
    .section-padding { padding: 2.5rem 0; }
    .section-heading { font-size: 1.8rem; margin-bottom: 2rem; }
    h1.display-4 { font-size: 2.5rem; }

    .module-card .row { flex-direction: column; }
    .module-image-col img {
        height: 250px;
        min-height: auto;
        max-height: none;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        width: 100%;
    }
    .module-content-col {
        text-align: center;
        border-radius: 0 0 0.75rem 0.75rem !important;
        padding: 2rem 1.5rem;
    }
    .module-buttons { text-align: center; }

    .pricing-section .card { margin-bottom: 1.5rem; }
    .notes-card { margin-bottom: 1.5rem; }
}

@media (max-width: 575.98px) {
     .module-buttons .btn {
        display: block;
        width: 100%;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 0.75rem;
     }
     .module-content-col { padding: 1.5rem; }
     .module-content-col h3 { font-size: 1.5rem; }
     .module-content-col p { font-size: 1rem; }

     .pricing-section .card-body { padding: 1.25rem; }
     .notes-card .card-body { padding: 1rem; }
     .notes-card li { padding: 0.7rem 0.75rem 0.7rem 2.2em; font-size: 0.95rem; }
     .notes-card li::before { left: 0.8em; top: 0.75em;}

     .conduct-warning { padding: 1rem; text-align: center; flex-direction: column; font-size: 1rem; }
     .conduct-warning i { margin-right: 0; margin-bottom: 0.5rem; }
}

</style>

</head>

<body>

    <div class="container section-padding">
        <header class="text-center mb-5">
            <div class="mb-3">
                <i class="bi bi-pencil-square display-4 violet"></i>
            </div>
            <h1 class="display-4 violet mb-3">Year 5 Modules</h1>
            <p class="lead text-muted col-lg-9 mx-auto" style="font-size: 1.1rem;">
                Comprehension / Creative Writing / Vocabulary / SPaG / VR
            </p>
            <hr class="mx-auto mt-4" style="width: 80px; border-top: 3px solid var(--theme-violet); opacity: 0.5;">
        </header>

        <section id="pricing" class="mb-5 pb-4 pricing-section">
            <h2 class="section-heading violet">Flexible Pricing Options</h2>
            <div class="card shadow-lg mx-auto" style="max-width: 800px;">
                 <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <h3 class="mb-4"><i class="bi bi-grid-1x2-fill me-2"></i>Modules & Tuition</h3>
                        <p class="text-muted mb-3 small">Choose from dedicated modules or flexible tuition options.</p>
                        <div class="price-list">
                            <div class="price-item">
                                <div>
                                    <span class="item-name">Comprehension</span>
                                    <span class="item-details">6 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£115</span>
                            </div>
                            <div class="price-item">
                                <div>
                                    <span class="item-name">Creative Writing</span>
                                    <span class="item-details">8 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£165</span>
                            </div>
                            <div class="price-item">
                                <div>
                                    <span class="item-name">SPaG</span>
                                    <span class="item-details">8 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£125</span>
                            </div>
                            <div class="price-item">
                                <div>
                                    <span class="item-name">English Vocabulary</span>
                                    <span class="item-details">8 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£125</span>
                            </div>
                            <div class="price-item">
                                <div>
                                    <span class="item-name">Verbal Reasoning</span>
                                    <span class="item-details">12 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£210</span>
                            </div>
                            <!-- <div class="price-item">
                                <div>
                                    <span class="item-name">English Practice & Technique</span>
                                    <span class="item-details">8 Classes (one class/1 hour per week)</span>
                                </div>
                                <span class="item-price">£150</span>
                            </div> -->
                            <div class="price-item">
                                <div>
                                    <span class="item-name"><i class="bi bi-arrow-repeat me-2 text-primary"></i>Carousel Course</span>
                                    <span class="item-details">Years 4/5 - includes all 4 modules</span>
                                </div>
                                <span class="item-price">£68 <span class="term">/ month</span></span>
            </div>
                            <div class="price-item">
                                <div>
                                    <span class="item-name"><i class="bi bi-person-fill me-2 text-success"></i>1:1 Tutoring</span>
                                    <span class="item-details">Personalized support</span>
        </div>
                                <span class="item-price">£45 <span class="term">/ hour</span></span>
            </div>
        </div>
    </div>
            </div>
            </div>
        </section>

        <section class="mb-5 pb-4">
             <h2 class="section-heading violet">Year 5 Module Details</h2>

            <div class="module-card" id="comprehension">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-5 module-image-col">
                        <img src="assets/images/success/img13" alt="Comprehension skills" />
        </div>
                    <div class="col-lg-7 module-content-col text-center text-lg-start">
                        <h3>COMPREHENSION</h3>
                    <p>Teaching Skills / Techniques to improve speed and accuracy of answering multiple choice and worded questions.</p>                        <div class="module-buttons mt-auto pt-3">
                            <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=Comprehension" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                            <a href="<?php echo BASE_URL ?>syllabus_juniorteensh" class="btn btn-syllabus"><i class="bi bi-book-fill"></i>Syllabus</a>
                        </div>
                </div>
                </div>
            </div>             <div class="module-card" id="creative-writing">
                 <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                          <img src="assets/images/success/creative-writing.png" alt="Creative writing practice" />
                </div>
                     <div class="col-lg-7 module-content-col text-center text-lg-start">
                        <h3>CREATIVE WRITING</h3>
                        <p>Comprehensive 8-week program covering descriptive writing, persuasive writing, and diary entries. Each class includes detailed notes and weekly marked assignments with personalized feedback.</p>
                        <div class="module-buttons mt-auto pt-3">
                              <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=Creative Writing" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="<?php echo BASE_URL; ?>syllabus_creative_writing.php" class="btn btn-syllabus"><i class="bi bi-book-fill"></i>Syllabus</a>
                         </div>
                    </div>
                </div>
            </div>

            <div class="module-card" id="spag">
                 <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                          <img src="assets/images/success/img15" alt="Learning SPaG" />
                     </div>
                    <div class="col-lg-7 module-content-col text-center text-lg-start">
                        <h3>SPaG</h3>
                        <p>Spelling, Punctuation and Grammar - complete syllabus with guided tests and revision.</p>                        <div class="module-buttons mt-auto pt-3">                              <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=SPaG" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="<?php echo BASE_URL; ?>syllabus_spag.php" class="btn btn-syllabus"><i class="bi bi-book-fill"></i>Syllabus</a>
                         </div>
                </div>
                </div>
            </div>             <div class="module-card" id="vocabulary">
                  <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                           <img src="assets/images/success/vocabulary.png" alt="Vocabulary learning" />
                </div>
                     <div class="col-lg-7 module-content-col text-center text-lg-start">
                         <h3>VOCABULARY</h3>
                        <p>Teaching through animated slide shows covering antonyms and synonyms. Students write personal sentences in class with daily reminders to use 2 words per day. Repetition reinforces 10 words weekly.</p>
                        <div class="module-buttons mt-auto pt-3">
                               <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=English Vocabulary" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="<?php echo BASE_URL; ?>syllabus_adultsh" class="btn btn-syllabus"><i class="bi bi-book-fill"></i>Syllabus</a>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="module-card" id="verbal-reasoning">
                  <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                           <img src="assets/images/success/verbal-reasoning.png" alt="Verbal reasoning practice" />
                     </div>
                     <div class="col-lg-7 module-content-col text-center text-lg-start">
                         <h3>VERBAL REASONING</h3>
                         <p>Comprehensive verbal reasoning training covering all question types. Develop logical thinking skills and pattern recognition essential for 11 Plus verbal reasoning success.</p>
                         <div class="module-buttons mt-auto pt-3">
                               <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=Verbal Reasoning" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="<?php echo BASE_URL; ?>syllabus_juniorteenss" class="btn btn-syllabus"><i class="bi bi-book-fill"></i>Syllabus</a>
                         </div>
                     </div>
            </div>
        </div>

        <!-- Carousel Course Module -->
            <div class="module-card" id="carousel-course">
                  <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                           <img src="assets/images/success/carousel-course.png" alt="Carousel Course comprehensive learning" />
                     </div>
                     <div class="col-lg-7 module-content-col text-center text-lg-start">
                         <h3>CAROUSEL COURSE</h3>
                         <p>Comprehensive rotating course covering all 11 Plus English areas. Students experience different modules in rotation, ensuring well-rounded preparation across all subject areas.</p>
                         <div class="module-buttons mt-auto pt-3">
                               <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=Carousel Course" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="#" class="btn btn-syllabus" onclick="alert('Syllabus covers all modules in rotation')"><i class="bi bi-book-fill"></i>Course Info</a>
                         </div>
                     </div>
            </div>
        </div>

            <!-- 1:1 Tutoring Module -->
            <div class="module-card" id="one-to-one">
                  <div class="row g-4 align-items-stretch">
                     <div class="col-lg-5 module-image-col">
                           <img src="assets/images/success/one-to-one.png" alt="One to one personalized tutoring" />
                     </div>
                     <div class="col-lg-7 module-content-col text-center text-lg-start">
                         <h3>1:1 TUTORING</h3>
                         <p>Personalized one-to-one tutoring sessions tailored to individual student needs. Focused attention on specific areas requiring improvement for maximum progress.</p>
                         <div class="module-buttons mt-auto pt-3">
                               <a href="<?php echo BASE_URL; ?>applyForm.php?class=year5&module=1:1 Tutoring" class="btn btn-apply"><i class="bi bi-check-circle-fill"></i>Apply Now</a>
                             <a href="#" class="btn btn-syllabus" onclick="alert('Personalized curriculum based on individual needs')"><i class="bi bi-book-fill"></i>Learn More</a>
                         </div>
                     </div>
            </div>        </div>

        </section>

        <section class="mb-5 pb-4 notes-section">
             <h2 class="section-heading violet">Important Notes & Class Rules</h2>
             <div class="row g-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="notes-card h-100 shadow-sm">
                        <div class="card-header"><i class="bi bi-camera-reels me-2"></i>Photo/Video Policy</div>
                        <div class="card-body p-4">
                            <ul>
                                <li>Occasional classes may be recorded for monitoring purposes.</li>
                                <li>Parental consent is asked, prior to use of photo/video footage, from Zoom classes.</li>
                                <li>These may be used for Promotional purposes, with consent.</li>
                            </ul>
                        </div>
                    </div>
                 </div>
                  <div class="col-lg-6">
                     <div class="notes-card h-100 shadow-sm">
                         <div class="card-header"><i class="bi bi-cup-straw me-2"></i>Classroom Etiquette</div>
                         <div class="card-body p-4">
                            <ul>
                                <li>Students are not allowed to use mobile phones during lessons.</li>
                                <li>No eating during classes.</li>
                                <li>Only water is permitted.</li>
                            </ul>
                        </div>
                </div>
            </div>
    </div>
             <div class="conduct-warning text-center mt-4">
                 <p class="mb-0 fw-bold"><i class="bi bi-shield-exclamation me-2"></i><strong class="text-danger">Conduct Policy:</strong> Success at 11 Plus English will not tolerate any form of violence or aggression, against staff or any student.</p>
             </div>
    </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>