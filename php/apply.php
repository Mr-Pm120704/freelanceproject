<?php
$workshopId = $_GET['id'];
require_once 'db-connection.php';
$workshop = $conn->query("SELECT * FROM workshops WHERE id = $workshopId")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>XOVENTA - WorkShop Application</title>
  <meta name="description" content="Apply for internship opportunities at XOVENTA in web development, design, AI, and more.">
  <meta name="keywords" content="XOVENTA, internship, application, tech internship, web development, design, AI, ML">

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
  
  <style>
    .application-form {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-bottom: 30px;
    }
    
    .form-label {
      font-weight: 600;
      color: #444;
      margin-bottom: 8px;
    }
    
    .form-control {
      padding: 12px 15px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: #4154f1;
      box-shadow: 0 0 0 0.2rem rgba(65, 84, 241, 0.25);
    }
    
    .form-select {
      padding: 12px 15px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
      height: auto;
    }
    
    .btn-primary {
      background-color: #4154f1;
      border: none;
      padding: 12px 30px;
      border-radius: 5px;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      background-color: #2a36a0;
      transform: translateY(-2px);
    }
    
    .required-field::after {
      content: "*";
      color: #dc3545;
      margin-left: 4px;
    }
    
    .success-message {
      background-color: #d4edda;
      color: #155724;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .page-title {
      background-color: #4154f1;
      padding: 60px 0;
      text-align: center;
      color: white;
    }
    
    .page-title h1 {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    
    .page-title p {
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto;
    }
    
    .section-title {
      margin-bottom: 40px;
    }
    
    .description-title {
      color: #4154f1;
      font-weight: 700;
    }
  </style>
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
        <!-- <h1 class="sitename">XOVENTA</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../html/index.html">Home</a></li>
          <li><a href="../html/index.html#about">About</a></li>
          <li><a href="../html/index.html#features">Our Courses</a></li>
          <li class="dropdown"><a href="#" class="active"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="../html/all-courses.html">All Courses</a></li>
              <li><a href="../html/internships.html" class="active">Internship</a></li>
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
          <h1>WorkShop Application</h1>
          <p>Take the first step towards your career growth by applying for our WorkShop program. Fill out the form below to get started.</p>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="../html/index.html">Home</a></li>
            <li><a href="../html/all-workshops.html">All-WorkShops</a></li>
            <li>Application Form</li>
          </ol>
        </div>
      </nav>
    </section>

    <!-- Application Form Section -->
    <section id="application" class="section">
      <div class="container" data-aos="fade-up">
        <div class="section-title text-center">
          <h2>Apply Now</h2>
          <div><span>Join Our</span> <span class="description-title">WorkShop Program</span></div>
        </div>

        <?php
        // Display success or error messages if they exist
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo '<div class="success-message">Your application has been submitted successfully! We will contact you soon.</div>';
        } elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
            echo '<div class="error-message">There was an error submitting your application. Please try again.</div>';
        }
        ?>

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="application-form">
              <form action="submit-workshop-application.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="workshop_id" value="<?php echo $workshop['id']; ?>">
                <div class="mb-3">
                  <h2>Apply for <?php echo $workshop['name']; ?> Workshop</h2>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <div class="workshop-info">
                        <p>Workshop: <?php echo $workshop['name']; ?></p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                        <div class="workshop-info">
                          <p>Duration: <?php echo $workshop['duration']; ?></p>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="fullName" class="form-label required-field">Full Name</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="email" class="form-label required-field">Email Address</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="phone" class="form-label required-field">Phone Number</label>
                      <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="college" class="form-label required-field">College/University</label>
                      <input type="text" class="form-control" id="college" name="college" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="degree" class="form-label required-field">Degree/Course</label>
                      <input type="text" class="form-control" id="degree" name="degree" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="graduationYear" class="form-label required-field">Year of Graduation</label>
                      <select class="form-select" id="graduationYear" name="graduationYear" required>
                        <option value="">Select Year</option>
                        <?php
                        $currentYear = date("Y");
                        for ($i = $currentYear; $i <= $currentYear + 5; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="startDate" class="form-label required-field">Preferred Start Date</label>
                      <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="whyJoin" class="form-label required-field">Why do you want to join this WorkShop?</label>
                  <textarea class="form-control" id="whyJoin" name="whyJoin" rows="4" required></textarea>
                </div>

                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="termsAgree" name="termsAgree" required>
                  <label class="form-check-label" for="termsAgree">I agree to the terms and conditions</label>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
              </form>
            </div>
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
  <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
  <script src="../assets/js/main.js"></script>
  
  <script>
    // Dynamic dropdown for specific programs based on internship field
    document.getElementById('internshipField').addEventListener('change', function() {
      const field = this.value;
      const programDropdown = document.getElementById('specificProgram');
      
      // Clear existing options
      programDropdown.innerHTML = '<option value="">Select Program</option>';
      
      // Add options based on selected field
      if (field === 'Full Stack Intern') {
        const programs = ['MERN Stack', 'MEAN Stack', 'Java Full Stack', 'Python Full Stack', 'PHP Full Stack', 'Full Stack'];
        programs.forEach(program => {
          const option = document.createElement('option');
          option.value = program;
          option.textContent = program;
          programDropdown.appendChild(option);
        });
      } else if (field === 'AI ML & Data Intern') {
        const programs = ['Artificial Intelligence', 'Machine Learning', 'Data Science', 'Data Analytics', 'Digital Marketing'];
        programs.forEach(program => {
          const option = document.createElement('option');
          option.value = program;
          option.textContent = program;
          programDropdown.appendChild(option);
        });
      } else if (field === 'Design Intern') {
        const programs = ['UX UI Design', 'Graphic Design', 'Web Design', 'Designer Pro'];
        programs.forEach(program => {
          const option = document.createElement('option');
          option.value = program;
          option.textContent = program;
          programDropdown.appendChild(option);
        });
      } else if (field === 'Digital Marketing') {
        const programs = ['SEO', 'Social Media Marketing', 'Content Marketing', 'Email Marketing', 'PPC Advertising'];
        programs.forEach(program => {
          const option = document.createElement('option');
          option.value = program;
          option.textContent = program;
          programDropdown.appendChild(option);
        });
      } else if (field === 'Other') {
        const option = document.createElement('option');
        option.value = 'Other';
        option.textContent = 'Other';
        programDropdown.appendChild(option);
      }
    });
  </script>
</body>

</html>
