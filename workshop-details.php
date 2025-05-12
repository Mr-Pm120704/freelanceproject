<?php
// Include database connection
require_once 'db-connection.php';

// Get workshop ID from URL parameter
$workshop_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If no valid ID provided, redirect to all workshops page
if ($workshop_id <= 0) {
    header("Location: all-workshops.html");
    exit;
}

// Fetch workshop details
$workshop_query = "SELECT * FROM workshops WHERE id = ?";
$stmt = $conn->prepare($workshop_query);
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$workshop_result = $stmt->get_result();
// Check if workshop exists
if ($workshop_result->num_rows === 0) {
    header("Location: all-workshops.html");
    exit;
}

$workshop = $workshop_result->fetch_assoc();

// Fetch workshop syllabus
$syllabus_query = "SELECT * FROM workshop_syllabus WHERE workshop_id = ? ORDER BY section_number";
$stmt = $conn->prepare($syllabus_query);
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$syllabus_result = $stmt->get_result();
$syllabus = [];
while ($row = $syllabus_result->fetch_assoc()) {
    $syllabus[] = $row;
}

// Fetch related workshops
$related_query = "SELECT id, name, icon FROM workshops WHERE duration = ? AND id != ? LIMIT 3";
$stmt = $conn->prepare($related_query);
$stmt->bind_param("si", $workshop['duration'], $workshop_id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_workshops = [];
while ($row = $related_result->fetch_assoc()) {
    $related_workshops[] = $row;
}

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo htmlspecialchars($workshop['name'] ?? 'Workshop Details'); ?> - XOVENTA</title>
  <meta name="description" content="<?php echo htmlspecialchars($workshop['short_description'] ?? ''); ?>">
  <meta name="keywords" content="XOVENTA, <?php echo htmlspecialchars($workshop['name'] ?? 'Workshop'); ?>, workshops, training, education">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-WQ8BY3WBPP"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-WQ8BY3WBPP');
  </script>
  
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-5L345CN4');</script>
  <!-- End Google Tag Manager -->

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <!-- Courses CSS File -->
  <link href="assets/css/courses.css" rel="stylesheet">
  <link href="assets/css/courses-details.css" rel="stylesheet">
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5L345CN4"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="XOVENTA Logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="index.html#about">About</a></li>
          <li><a href="index.html#features">Our Workshops</a></li>
          <li class="dropdown"><a href="#" class="active"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="all-courses.html">All Courses</a></li>
              <li><a href="internships.html">Internship</a></li>
              <li><a href="all-workshops.html" class="active">All Workshops</a></li>
              <li><a href="projects.html">Projects</a></li>
              <li><a href="software_install.html">Software Installation</a></li>
            </ul>
          </li>
          <li><a href="index.html#gallery">Gallery</a></li>
          <li><a href="index.html#team">Team</a></li>          
          <li><a href="index.html#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Page Title Section -->
    <section class="page-title">
      <div class="heading">
        <div class="container">
          <h1 class="animate-title"><?php echo htmlspecialchars($workshop['name'] ?? 'Workshop Details'); ?></h1>
          <p class="animate-subtitle"><?php echo htmlspecialchars($workshop['short_description'] ?? 'Learn and master new skills in workshops'); ?></p>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li><a href="all-workshops.html">All Workshops</a></li>
            <li><?php echo htmlspecialchars($workshop['name'] ?? 'Workshop Details'); ?></li>
          </ol>
        </div>
      </nav>
    </section>

    <!-- Workshop Details Section -->
    <section id="workshop-details" class="workshop-details section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-8">
            <div class="workshop-image animate-image">
              <?php if (!empty($workshop['image'])): ?>
                <img src="assets/img/workshops/<?php echo htmlspecialchars($workshop['image']); ?>" alt="<?php echo htmlspecialchars($workshop['name']); ?>" class="img-fluid">
              <?php else: ?>
                <img src="assets/img/workshops/default-workshop.jpg" alt="<?php echo htmlspecialchars($workshop['name'] ?? 'Workshop'); ?>" class="img-fluid">
              <?php endif; ?>
            </div>

            <div class="workshop-info">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="animate-left"><?php echo htmlspecialchars($workshop['name'] ?? 'Workshop Name'); ?></h2>
                <div class="workshop-duration animate-right">
                  <span class="badge bg-primary"><?php echo htmlspecialchars($workshop['duration'] ?? 'Technology'); ?></span>
                </div>
              </div>
              <div class="workshop-meta animate-up">
                <div class="meta-item">
                  <i class="bi bi-clock"></i>
                  <span>Duration: <?php echo htmlspecialchars($workshop['duration'] ?? '8 hours'); ?></span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-person"></i>
                  <span>Instructor: <?php echo htmlspecialchars($workshop['instructor'] ?? 'Instructor Name'); ?></span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-people"></i>
                  <span>Participants: <?php echo htmlspecialchars($workshop['participants'] ?? '50+'); ?></span>
                </div>
              </div>
            </div>

            <div class="workshop-description animate-fade-in">
              <h3>Workshop Description</h3>
              <div class="description-content">
                <?php 
                if (!empty($workshop['description'])) {
                    echo nl2br(htmlspecialchars($workshop['description']));
                } else {
                    echo '<p>This workshop will help you build the skills necessary for success in this area. Join us for an interactive experience.</p>';
                }
                ?>
              </div>
            </div>

            <div class="workshop-syllabus animate-left">
              <h3>Syllabus</h3>
              <ul>
                <?php if (count($syllabus) > 0): ?>
                  <?php foreach ($syllabus as $index => $section): ?>
                    <div class="accordion-item animate-up" style="--delay: <?php echo ($index + 1) * 0.1; ?>s">
                      <h2 class="accordion-header" id="heading<?php echo $section['section_number']; ?>">
                        <button class="accordion-button <?php echo ($index > 0) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $section['section_number']; ?>" aria-expanded="<?php echo ($index === 0) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $section['section_number']; ?>">
                          Section <?php echo $section['section_number']; ?>: <?php echo htmlspecialchars($section['section_title']); ?>
                        </button>
                      </h2>
                      <div id="collapse<?php echo $section['section_number']; ?>" class="accordion-collapse collapse <?php echo ($index === 0) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $section['section_number']; ?>" data-bs-parent="#syllabusAccordion">
                        <div class="accordion-body">
                          <?php echo nl2br(htmlspecialchars($section['section_content'])); ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                   <?php else: ?>
                  <!-- Default syllabus if none exists in database -->
                  <div class="accordion-item animate-up">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Section 1: Introduction to the Course
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#syllabusAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li>Overview of the course objectives</li>
                          <li>Introduction to key concepts</li>
                          <li>Setting up your development environment</li>
                          <li>Understanding the learning path</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item animate-up" style="--delay: 0.2s">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Section 2: Core Fundamentals
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#syllabusAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li>Understanding the basic principles</li>
                          <li>Working with essential tools</li>
                          <li>Practical exercises and examples</li>
                          <li>Building your first project</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item animate-up" style="--delay: 0.3s">
                    <h2 class="accordion-header" id="headingThree">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Section 3: Advanced Techniques
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#syllabusAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li>Exploring advanced concepts</li>
                          <li>Implementing best practices</li>
                          <li>Optimization strategies</li>
                          <li>Real-world applications</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </ul>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="workshop-sidebar">
              <div class="sidebar-widget animate-fade-in">
                <h3>Apply For An Workshop</h3>
                <p>Join this workshop to learn hands-on skills.</p>
                <a href="apply.php?id=<?php echo $workshop['id']; ?>" class="btn btn-primary w-100">Apply Now</a>
              </div>

              <div class="sidebar-widget animate-fade-in">
                <h3>Related Workshops</h3>
                <div class="related-workshops">
                  <?php if (count($related_workshops) > 0): ?>
                    <?php foreach ($related_workshops as $related): ?>
                      <div class="related-workshop-item">
                        <img src="assets/img/workshops/<?php echo htmlspecialchars($related['icon']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>" class="img-fluid">
                        <div class="related-workshop-info">
                          <h4><?php echo htmlspecialchars($related['name']); ?></h4>
                          <a href="workshop-details.php?id=<?php echo $related['id']; ?>" class="related-workshop-link">View Workshop <i class="bi bi-arrow-right"></i></a>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p>No related workshops found.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta section dark-background">
      <div class="container" data-aos="zoom-in">
        <div class="row g-5">
          <div class="col-lg-8 text-center text-lg-start">
            <h3>Ready to start your learning journey?</h3>
            <p>Join our courses today and take the first step towards a successful career in technology. Our expert instructors and comprehensive curriculum will help you achieve your goals.</p>
          </div>
          <div class="col-lg-4 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="#contact">Enroll Now</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <div class="container section-title text-center" data-aos="fade-up">
        <h2>Contact</h2>
        <div><span>Get in</span> <span class="description-title">Touch</span></div>
      </div>

      <div class="container" data-aos="fade" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Address</h3>
                <p>Perambalur, Tamil Nadu 621212, India</p>
              </div>
            </div>

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>
                  <a href="tel:+919566060511" class="call-link">+91-95660 60511</a>
                </p>
              </div>
            </div>

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>
                  <a href="mailto:zaratechpvt001@gmail.com" class="email-link">zaratechpvt001@gmail.com</a>
                </p>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <form action="contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="text" class="form-control" name="number" id="number" placeholder="Your Number" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-6">
                  <select class="form-control" name="course" id="course" required="">
                    <option value="<?php echo htmlspecialchars($course['name'] ?? 'General Inquiry'); ?>"><?php echo htmlspecialchars($course['name'] ?? 'General Inquiry'); ?></option>
                    <option value="Other">Other Course</option>
                  </select>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" id="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                  <button type="submit" name="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">XOVENTA</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Located in Perambalur</p>
            <p>Tamil Nadu 621212, India</p>
            <p class="mt-3"><strong>Phone:</strong> <a href="tel:+919342938725" class="call-link">+91 9342938725, 9159240651</a></p>
            <p><strong>Email:</strong> <a href="mailto:zaratechpvt001@gmail.com" class="email-link">zaratechpvt001@gmail.com</a></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="https://x.com/ZaraTech"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.facebook.com/ZaraTech/"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/ZaraTech/"><i class="bi bi-instagram"></i></a>
            <a href="https://www.linkedin.com/company/ZaraTech/"><i class="bi bi-linkedin"></i></a>
            <a href="https://wa.me/919566060511?text=I%20got%20your%20contact%20number%20from%20Zara%20Tech"><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="index.html#about">About us</a></li>
            <li><a href="all-courses.html">All Courses</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright 2024</span> <strong class="px-1 sitename">XOVENTA</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="">XOVENTA</a>
      </div>
    </div>
  </footer>


  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
