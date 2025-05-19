<?php
// Include database connection
require_once 'db-connection.php';

// Get course ID from URL parameter
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If no valid ID provided, redirect to all courses page
if ($course_id <= 0) {
    header("Location: ../html/all-courses.html");
    exit;
}

// Fetch course details
$course_query = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();

// Check if course exists
if ($course_result->num_rows === 0) {
    header("Location: ../html/all-courses.html");
    exit;
}

$course = $course_result->fetch_assoc();

// Fetch course syllabus
$syllabus_query = "SELECT * FROM course_syllabus WHERE course_id = ? ORDER BY section_number";
$stmt = $conn->prepare($syllabus_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$syllabus_result = $stmt->get_result();
$syllabus = [];
while ($row = $syllabus_result->fetch_assoc()) {
    $syllabus[] = $row;
}

// Fetch related courses
$related_query = "SELECT id, name, icon FROM courses WHERE category = ? AND id != ? LIMIT 3";
$stmt = $conn->prepare($related_query);
$stmt->bind_param("si", $course['category'], $course_id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_courses = [];
while ($row = $related_result->fetch_assoc()) {
    $related_courses[] = $row;
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
  <title>XOVENTA - <?php echo htmlspecialchars($course['name'] ?? 'Course Details'); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($course['short_description'] ?? ''); ?>">
  <meta name="keywords" content="XOVENTA, <?php echo htmlspecialchars($course['name'] ?? 'Course'); ?>, courses, training, education">

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
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  <!-- Courses CSS File -->
  <link href="../assets/css/courses.css" rel="stylesheet">
  <!-- Course Details CSS File -->
  <link href="../assets/css/course-details.css" rel="stylesheet">
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5L345CN4"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="../html/index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="../assets/img/logo.png" alt="XOVENTA Logo">
        <!-- <h1 class="sitename">XOVENTA</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../html/index.html">Home</a></li>
          <li><a href="../html/index.html#about">About</a></li>
          <li><a href="../html/index.html#features">Our Courses</a></li>
          <li class="dropdown"><a href="#" class="active"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="../html/all-courses.html" class="active">All Courses</a></li>
              <li><a href="../html/internships.html">Internship</a></li>
              <li><a href="../html/all-workshops.html">Workshop</a></li>
              <li><a href="../html/projects.html">Projects</a></li>
              <li><a href="../html/software_install.html">Software Installation</a></li>
            </ul>
          </li>
          <li><a href="../html/index.html#gallery">Gallery</a></li>
          <li><a href="../html/index.html#team">Team</a></li>          
          <li><a href="../html/index.html#contact">Contact</a></li>
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
          <h1 class="animate-title"><?php echo htmlspecialchars($course['name'] ?? 'Course Details'); ?></h1>
          <p class="animate-subtitle"><?php echo htmlspecialchars($course['short_description'] ?? 'Learn and master new skills'); ?></p>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/all-courses.html">All Courses</a></li>
            <li><?php echo htmlspecialchars($course['name'] ?? 'Course Details'); ?></li>
          </ol>
        </div>
      </nav>
    </section>

    <!-- Course Details Section -->
    <section id="course-details" class="course-details section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-8">
            <div class="course-image animate-image">
              <?php if (!empty($course['image'])): ?>
                <img src="../assets/img/courses/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>" class="img-fluid">
              <?php else: ?>
                <img src="../assets/img/courses/default-course.jpg" alt="<?php echo htmlspecialchars($course['name'] ?? 'Course'); ?>" class="img-fluid">
              <?php endif; ?>
            </div>
            
            <div class="course-info">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="animate-left"><?php echo htmlspecialchars($course['name'] ?? 'Course Name'); ?></h2>
                <div class="course-category animate-right">
                  <span class="badge bg-primary"><?php echo htmlspecialchars($course['category'] ?? 'Technology'); ?></span>
                </div>
              </div>
              
              <div class="course-meta animate-up">
                <div class="meta-item">
                  <i class="bi bi-clock"></i>
                  <span>Duration: <?php echo htmlspecialchars($course['duration'] ?? '8 weeks'); ?></span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-bar-chart"></i>
                  <span>Level: <?php echo htmlspecialchars($course['level'] ?? 'All Levels'); ?></span>
                </div>
                <?php if (!empty($course['instructor'])): ?>
                <div class="meta-item">
                  <i class="bi bi-person"></i>
                  <span>Instructor: <?php echo htmlspecialchars($course['instructor']); ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($course['students'])): ?>
                <div class="meta-item">
                  <i class="bi bi-people"></i>
                  <span>Students: <?php echo htmlspecialchars($course['students']); ?>+</span>
                </div>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="course-description animate-fade-in">
              <h3>Course Description</h3>
              <div class="description-content">
                <?php 
                if (!empty($course['description'])) {
                    echo nl2br(htmlspecialchars($course['description']));
                } else {
                    echo '<p>This comprehensive course is designed to provide you with in-depth knowledge and practical skills. 
                    Through a combination of theoretical concepts and hands-on exercises, you\'ll gain the expertise needed to excel in this field.
                    Our experienced instructors will guide you through each topic, ensuring you understand the fundamentals and advanced concepts alike.</p>
                    <p>By the end of this course, you\'ll have developed a strong foundation and be ready to apply your new skills in real-world scenarios.</p>';
                }
                ?>
              </div>
            </div>
            
            <div class="course-syllabus animate-fade-in">
              <h3>Course Syllabus</h3>
              <div class="accordion" id="syllabusAccordion">
                <?php if (count($syllabus) > 0): ?>
                  <?php foreach ($syllabus as $index => $section): ?>
                    <div class="accordion-item animate-up" style="--delay: <?php echo ($index + 1) * 0.1; ?>s">
                      <h2 class="accordion-header" id="heading<?php echo $section['id']; ?>">
                        <button class="accordion-button <?php echo ($index > 0) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $section['id']; ?>" aria-expanded="<?php echo ($index === 0) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $section['id']; ?>">
                          Section <?php echo $section['section_number']; ?>: <?php echo htmlspecialchars($section['section_title']); ?>
                        </button>
                      </h2>
                      <div id="collapse<?php echo $section['id']; ?>" class="accordion-collapse collapse <?php echo ($index === 0) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $section['id']; ?>" data-bs-parent="#syllabusAccordion">
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
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="course-sidebar">
              <div class="sidebar-widget animate-fade-in">
                <h3>Enroll Now</h3>
                <p>Join our <?php echo htmlspecialchars($course['name'] ?? 'course'); ?> and start your journey to becoming a professional.</p>
                <a href="#contact" class="btn btn-primary w-100">Enroll Now</a>
              </div>
              
              <div class="sidebar-widget animate-fade-in">
                <h3>Course Features</h3>
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle"></i> Hands-on practical training</li>
                  <li><i class="bi bi-check-circle"></i> Industry-relevant curriculum</li>
                  <li><i class="bi bi-check-circle"></i> Expert instructors</li>
                  <li><i class="bi bi-check-circle"></i> Placement assistance</li>
                  <li><i class="bi bi-check-circle"></i> Certificate on completion</li>
                  <?php if (!empty($course['features'])): ?>
                    <?php 
                    $features = explode(',', $course['features']);
                    foreach ($features as $feature): 
                      if (trim($feature) !== ''):
                    ?>
                      <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars(trim($feature)); ?></li>
                    <?php 
                      endif;
                    endforeach; 
                    ?>
                  <?php endif; ?>
                </ul>
              </div>
              
              <div class="sidebar-widget animate-fade-in">
                <h3>Related Courses</h3>
                <div class="related-courses">
                  <?php if (count($related_courses) > 0): ?>
                    <?php foreach ($related_courses as $related): ?>
                      <div class="related-course-item">
                        <div class="related-course-icon"><i class="bi <?php echo htmlspecialchars($related['icon'] ?? 'bi-book'); ?>"></i></div>
                        <div class="related-course-info">
                          <h4><?php echo htmlspecialchars($related['name']); ?></h4>
                          <a href="course-details.php?id=<?php echo $related['id']; ?>" class="related-course-link">View Course <i class="bi bi-arrow-right"></i></a>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="related-course-item">
                      <div class="related-course-icon"><i class="bi bi-code-square"></i></div>
                      <div class="related-course-info">
                        <h4>Web Development</h4>
                        <a href="#" class="related-course-link">View Course <i class="bi bi-arrow-right"></i></a>
                      </div>
                    </div>
                    <div class="related-course-item">
                      <div class="related-course-icon"><i class="bi bi-phone"></i></div>
                      <div class="related-course-info">
                        <h4>Mobile App Development</h4>
                        <a href="#" class="related-course-link">View Course <i class="bi bi-arrow-right"></i></a>
                      </div>
                    </div>
                    <div class="related-course-item">
                      <div class="related-course-icon"><i class="bi bi-cloud"></i></div>
                      <div class="related-course-info">
                        <h4>Cloud Computing</h4>
                        <a href="#" class="related-course-link">View Course <i class="bi bi-arrow-right"></i></a>
                      </div>
                    </div>
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
            <form action="../php/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
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

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="../html/index.html" class="logo d-flex align-items-center">
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
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/index.html#about">About us</a></li>
            <li><a href="../html/all-courses.html">All Courses</a></li>
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

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>
  
  <!-- Course Details JS File -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    const animatedElements = document.querySelectorAll('.animate-title, .animate-subtitle, .animate-image, .animate-left, .animate-right, .animate-up, .animate-fade-in');
    
    // Function to check if element is in viewport
    function isInViewport(element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }
    
    // Add visible class when element is in viewport
    function checkVisibility() {
      animatedElements.forEach(element => {
        if (isInViewport(element) && !element.classList.contains('visible')) {
          element.classList.add('visible');
        }
      });
    }
    
    // Initial check
    checkVisibility();
    
    // Check on scroll
    window.addEventListener('scroll', checkVisibility);
    
    // Initialize accordion
    const accordionItems = document.querySelectorAll('.accordion-item');
    accordionItems.forEach(item => {
      const header = item.querySelector('.accordion-header');
      const content = item.querySelector('.accordion-collapse');
      
      header.addEventListener('click', () => {
        // Toggle active class
        const isActive = content.classList.contains('show');
        
        // Close all accordions
        document.querySelectorAll('.accordion-collapse').forEach(el => {
          el.classList.remove('show');
        });
        
        // Open clicked accordion if it was closed
        if (!isActive) {
          content.classList.add('show');
        }
      });
    });
  });
  </script>
</body>

</html>
