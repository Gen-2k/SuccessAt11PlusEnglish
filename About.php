<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Success At 11 Plus English - About Us">
    <title>Success At 11 Plus English | About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&family=Source+Serif+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="indexStyles.css">
    <style>
    .mission-section {
        background-color: #f8f5fd;
        border-radius: 0.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .mission-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .about-image {
        border-radius: 0.5rem;
        box-shadow: 0 5px 15px rgba(110, 32, 167, 0.2);
        transition: transform 0.3s ease;
    }
    
    .about-image:hover {
        transform: scale(1.02);
    }

    .about-section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        padding: 2rem;
        margin-bottom: 3rem;
    }

    .section-heading {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    
    .section-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 50px;
        height: 3px;
        background-color: var(--theme-violet);
    }

    .about-content p {
        font-size: 1.05rem;
        line-height: 1.7;
        color: #4a4a4a;
    }
    </style>
</head>

<body>
    <div class="mt-0">
        <?php include('navbar2.php') ?>
    </div>

    <!-- Mission Section -->
    <div class="container py-5">
        <div class="mission-section p-4 p-md-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-5 fw-bold text-violet mb-4">Our Mission</h1>
                    <p class="lead fs-4">
                        "We ignite a love for learning and empower students to reach their full potential. Our expert-led, interactive lessons build confidence and academic success in a safe, nurturing, and inclusive environment."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Me Section -->
    <div class="container pb-5">
        <div class="about-section">
            <div class="row align-items-center">
                <div class="col-lg-8 order-lg-1 order-2">
                    <h2 class="section-heading text-violet fw-bold">ABOUT ME</h2>
                    <div class="about-content">
                        <p class="mb-4">
                            I'm Safrina Sidhu Saran, a qualified teacher with over 17 years of experience in Kent schools. Teaching
                            isn't just my job—it's my passion, and parents often tell me, "It shows."
                        </p>
                        <p class="mb-4">
                            As a mother of two—including a daughter at Dartford Grammar for Girls and another preparing for the 11+
                            exam—I understand this journey from both sides: as a tutor and as a parent.
                        </p>
                        <p class="mb-4">
                            Over the years, I've developed step-by-step English programs that break down complex concepts,
                            making them easy to grasp. Many students struggle with English simply because it's not taught
                            methodically. When they finally get it, their confidence soars.
                        </p>
                        <p class="mb-4">
                            I don't just teach students—I support parents too. I know how stressful this process can be, which is
                            why I make myself available to answer questions whenever needed (except when I'm teaching, of course!).
                        </p>
                        <p>
                            I've helped countless students secure places at top grammar and independent schools—and I can help yours
                            too.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-2 order-1 mb-4 mb-lg-0 text-center">
                    <img src="assets/images/safrina1.jpg" alt="Safrina Sidhu Saran" class="about-image img-fluid" style="max-height: 450px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>