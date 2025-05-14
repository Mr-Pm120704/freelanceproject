<?php
// Include database connection
require_once 'db-connection.php';

// Get project ID from URL
$project_id = isset($_GET['id']) ? $_GET['id'] : '';

// Validate project ID to prevent SQL injection
if (!is_numeric($project_id)) {
    // Redirect to projects page if ID is invalid
    header("Location: ../html/projects.html");
    exit();
}

// Fetch project details from database
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if project exists
if ($result->num_rows === 0) {
    // Redirect to projects page if project not found
    header("Location: ../html/projects.html");
    exit();
}

// Get project data
$project = $result->fetch_assoc();

// Fetch project technologies
$tech_sql = "SELECT tech_name FROM project_technologies WHERE project_id = ?";
$tech_stmt = $conn->prepare($tech_sql);
$tech_stmt->bind_param("i", $project_id);
$tech_stmt->execute();
$tech_result = $tech_stmt->get_result();
$technologies = [];
while ($tech = $tech_result->fetch_assoc()) {
    $technologies[] = $tech['tech_name'];
}

// Fetch project features
$features_sql = "SELECT feature_text FROM project_features WHERE project_id = ?";
$features_stmt = $conn->prepare($features_sql);
$features_stmt->bind_param("i", $project_id);
$features_stmt->execute();
$features_result = $features_stmt->get_result();
$features = [];
while ($feature = $features_result->fetch_assoc()) {
    $features[] = $feature['feature_text'];
}

// Get related projects if any
$related_projects = [];
if (!empty($project['related_projects'])) {
    $related_ids = explode(',', $project['related_projects']);
    foreach ($related_ids as $related_id) {
        $related_sql = "SELECT id, title, short_description, image_url, category FROM projects WHERE id = ?";
        $related_stmt = $conn->prepare($related_sql);
        $related_stmt->bind_param("i", $related_id);
        $related_stmt->execute();
        $related_result = $related_stmt->get_result();
        if ($related_result->num_rows > 0) {
            $related_projects[] = $related_result->fetch_assoc();
        }
    }
}

// Close database connection
$stmt->close();
$tech_stmt->close();
$features_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Zara Tech - <?php echo htmlspecialchars($project['title']); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($project['short_description']); ?>">
  <meta name="keywords" content="Zara Tech, projects, <?php echo htmlspecialchars($project['category']); ?>, portfolio">

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
  <!-- Projects CSS File -->
  <link href="../assets/css/projects.css" rel="stylesheet">
  <!-- Project Details CSS File -->
  <link href="../assets/css/project-details.css" rel="stylesheet">
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
        <img src="../assets/img/logo.png" alt="">
        <!-- <h1 class="sitename">Zara Tech</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../html/index.html">Home</a></li>
          <li><a href="../html/index.html#about">About</a></li>
          <li><a href="../html/index.html#features">Our Courses</a></li>
          <li class="dropdown"><a href="#" class="active"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
<<<<<<< HEAD:project_details.php
              <li><a href="all-courses.html">All Courses</a></li>
              <li><a href="internships.html">Internship</a></li>
              <li><a href="all-workshops.html">Workshop</a></li>
              <li><a href="projects.html" class="active">Projects</a></li>
              <li><a href="software_install.html">Software Installation</a></li>
=======
              <li><a href="../html/all-courses.html">All Courses</a></li>
              <li><a href="../html/internships.html">Internship</a></li>
              <li><a href="../html/all-workshops.html">Workshop</a></li>
              <li><a href="../html/projects.html" class="active">Projects</a></li>
              <li><a href="../html/software_install.html">Software Installation</a></li>
>>>>>>> dda3426b7d857e5d6e003f66b1e118d2ce8623ec:php/project_details.php
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
          <h1 class="animate-title"><?php echo htmlspecialchars($project['title']); ?></h1>
          <p class="animate-subtitle"><?php echo htmlspecialchars($project['short_description']); ?></p>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/projects.html">Projects</a></li>
            <li><?php echo htmlspecialchars($project['title']); ?></li>
          </ol>
        </div>
      </nav>
    </section>

    <!-- Project Details Section -->
    <section id="project-details" class="project-details section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-6">
            <div class="project-image-container">
              <img src="../<?php echo htmlspecialchars($project['image_url']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="img-fluid project-main-image">
              
              <?php if (!empty($project['gallery_images'])): ?>
              <div class="project-gallery">
                <?php 
                $gallery_images = explode(',', $project['gallery_images']);
                foreach ($gallery_images as $image): 
                ?>
                  <!-- <a href="<?php echo htmlspecialchars(trim($image)); ?>" class="glightbox">
                    <img src="<?php echo htmlspecialchars(trim($image)); ?>" alt="Project Gallery Image" class="img-fluid">
                  </a> -->
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="project-info-container">
              <div class="project-category-badge">
                <?php echo htmlspecialchars($project['category']); ?>
              </div>
              
              <h2 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h2>
              
              <div class="project-description">
                <?php echo nl2br(htmlspecialchars($project['full_description'])); ?>
              </div>
              
              <div class="project-meta">
                <div class="meta-item">
                  <h3><i class="bi bi-calendar3"></i> Completion Date</h3>
                  <p><?php echo htmlspecialchars($project['completion_date']); ?></p>
                </div>
                
                <div class="meta-item">
                  <h3><i class="bi bi-person"></i> Client</h3>
                  <p><?php echo htmlspecialchars($project['client']); ?></p>
                </div>
              </div>
              
              <div class="project-technologies">
                <h3>Technologies Used</h3>
                <div class="tech-tags">
                  <?php foreach ($technologies as $tech): ?>
                  <span class="tech-tag"><?php echo htmlspecialchars($tech); ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row mt-5">
          <div class="col-12">
            <div class="project-features">
              <h3 class="section-title">Key Features</h3>
              <div class="features-grid">
                <?php foreach ($features as $index => $feature): ?>
                <div class="feature-item" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>">
                  <div class="feature-icon">
                    <i class="bi bi-check-circle-fill"></i>
                  </div>
                  <div class="feature-text">
                    <?php echo htmlspecialchars($feature); ?>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        
        <?php if (!empty($project['challenges']) && !empty($project['solutions'])): ?>
        <div class="row mt-5">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="challenges-section">
              <h3 class="section-title">Challenges</h3>
              <div class="content-box">
                <?php echo nl2br(htmlspecialchars($project['challenges'])); ?>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="solutions-section">
              <h3 class="section-title">Solutions</h3>
              <div class="content-box">
                <?php echo nl2br(htmlspecialchars($project['solutions'])); ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($project['outcome'])): ?>
        <div class="row mt-5">
          <div class="col-12" data-aos="fade-up" data-aos-delay="300">
            <div class="outcome-section">
              <h3 class="section-title">Project Outcome</h3>
              <div class="content-box">
                <?php echo nl2br(htmlspecialchars($project['outcome'])); ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Related Projects Section -->
        <?php if (!empty($related_projects)): ?>
        <div class="row mt-5">
          <div class="col-12">
            <div class="related-projects">
              <h3 class="section-title">Related Projects</h3>
              <div class="projects-grid">
                <?php foreach ($related_projects as $related): ?>
                <div class="project-card" data-aos="fade-up" data-aos-delay="100">
                  <div class="project-image">
                    <img src="../<?php echo htmlspecialchars($related['image_url']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>">
                    <div class="project-overlay">
                      <a href="project_details.php?id=<?php echo $related['id']; ?>" class="view-details">View Details</a>
                    </div>
                  </div>
                  <div class="project-info">
                    <h4><?php echo htmlspecialchars($related['title']); ?></h4>
                    <p><?php echo htmlspecialchars($related['short_description']); ?></p>
                    <div class="project-category"><?php echo htmlspecialchars($related['category']); ?></div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- CTA Section -->
        <div class="row mt-5">
          <div class="col-12">
            <div class="project-cta" data-aos="fade-up">
              <div class="cta-content">
                <h3>Interested in a similar project?</h3>
                <p>Let's discuss how we can create a custom solution tailored to your specific needs.</p>
              </div>
              <div class="cta-button">
                <a href="#contact" class="btn-get-started">Contact Us</a>
              </div>
            </div>
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
          <form action="project_contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
              </div>
          
              <div class="col-md-6">
                <input type="text" class="form-control" name="number" id="number" placeholder="Your Number" required="">
              </div>
          
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
              </div>
          
              <div class="col-md-6">
                <select class="form-control" name="project_type" id="project_type" required="">
                  <option value="">Select Project Type</option>
                  <option value="<?php echo htmlspecialchars($project['category']); ?>" selected>
                    <?php echo htmlspecialchars($project['category']); ?>
                  </option>
                  <option value="Custom Project">Custom Project</option>
                </select>
              </div>
          
              <div class="col-md-6">
                <input type="text" class="form-control" name="project_title" id="project_title" placeholder="Project Title" value="<?php echo htmlspecialchars($project['title']); ?>" required="">
              </div>
          
              <div class="col-md-12">
                <textarea class="form-control" name="message" id="message" rows="6" placeholder="Project Details" required="">I'm interested in a project similar to <?php echo htmlspecialchars($project['title']); ?>.</textarea>
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
            <span class="sitename">Zara Tech</span>
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
            <li><a href="../html/projects.html">Projects</a></li>
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
      <p>© <span>Copyright 2024</span> <strong class="px-1 sitename">Zara Tech</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="">Zara Tech</a>
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
</body>

</html>
