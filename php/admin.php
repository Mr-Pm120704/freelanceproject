<?php
  session_start();
  
// Check if user is logged in and is an admin
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//   header("Location: login.php");
//   exit();
// }

// Include database connection
require_once 'db-connection.php';

// Get counts for dashboard
$userCount = 0;
$internshipCount = 0;
$projectCount = 0;
$workshopCount = 0;
$contactCount = 0;

// Get counts for new items (last 24 hours)
$newUserCount = 0;
$newInternshipCount = 0;
$newProjectCount = 0;
$newWorkshopCount = 0;
$newContactCount = 0;


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Optional: helps with debugging

try {
  // Count users
  $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
  $stmt->execute();
  $stmt->bind_result($userCount);
  $stmt->fetch();
  $stmt->close();

  // Count new users (last 24 hours)
  $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE created_at >= NOW() - INTERVAL 24 HOUR");
  $stmt->execute();
  $stmt->bind_result($newUserCount);
  $stmt->fetch();
  $stmt->close();

  // Count internship applications
  $stmt = $conn->prepare("SELECT COUNT(*) FROM internship_applications");
  $stmt->execute();
  $stmt->bind_result($internshipCount);
  $stmt->fetch();
  $stmt->close();

  // Count new internship applications (last 24 hours)
  $stmt = $conn->prepare("SELECT COUNT(*) FROM internship_applications WHERE created_at >= NOW() - INTERVAL 24 HOUR");
  $stmt->execute();
  $stmt->bind_result($newInternshipCount);
  $stmt->fetch();
  $stmt->close();

  // Count project applications
  $stmt = $conn->prepare("SELECT COUNT(*) FROM project_contact");
  $stmt->execute();
  $stmt->bind_result($projectCount);
  $stmt->fetch();
  $stmt->close();

  // Count new project applications (last 24 hours)
  $stmt = $conn->prepare("SELECT COUNT(*) FROM project_contact WHERE created_at >= NOW() - INTERVAL 24 HOUR");
  $stmt->execute();
  $stmt->bind_result($newProjectCount);
  $stmt->fetch();
  $stmt->close();

  // Count workshop applications
  $stmt = $conn->prepare("SELECT COUNT(*) FROM applications");
  $stmt->execute();
  $stmt->bind_result($workshopCount);
  $stmt->fetch();
  $stmt->close();

  // Count new workshop applications (last 24 hours)
  $stmt = $conn->prepare("SELECT COUNT(*) FROM applications WHERE created_at >= NOW() - INTERVAL 24 HOUR");
  $stmt->execute();
  $stmt->bind_result($newWorkshopCount);
  $stmt->fetch();
  $stmt->close();

  // Count contact submissions
  $stmt = $conn->prepare("SELECT COUNT(*) FROM index_contact");
  $stmt->execute();
  $stmt->bind_result($contactCount);
  $stmt->fetch();
  $stmt->close();

  // Count new contact submissions (last 24 hours)
  $stmt = $conn->prepare("SELECT COUNT(*) FROM index_contact WHERE created_at >= NOW() - INTERVAL 24 HOUR");
  $stmt->execute();
  $stmt->bind_result($newContactCount);
  $stmt->fetch();
  $stmt->close();

  // Get recent applications for dashboard
  $recentApplications = [];

  // Helper to fetch recent rows
  function fetchRecent($conn, $sql, $typeLabel) {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
      $row['type'] = $typeLabel;
      $rows[] = $row;
    }
    $stmt->close();
    return $rows;
  }

  // Fetch recent entries
  $recentApplications = array_merge(
    fetchRecent($conn, "SELECT id, name, email, created_at AS date, status FROM internship_applications ORDER BY created_at DESC LIMIT 2", 'Internship'),
    fetchRecent($conn, "SELECT id, name, email, created_at AS date, status FROM project_applications ORDER BY created_at DESC LIMIT 2", 'Project'),
    fetchRecent($conn, "SELECT id, name, email, created_at AS date, status FROM workshop_applications ORDER BY created_at DESC LIMIT 2", 'Workshop'),
    fetchRecent($conn, "SELECT id, name, email, created_at AS date,
                        CASE WHEN is_responded = 1 THEN 'Responded' ELSE 'New' END AS status 
                        FROM contact_submissions ORDER BY created_at DESC LIMIT 2", 'Contact')
  );

  // Sort and limit
  usort($recentApplications, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
  });
  $recentApplications = array_slice($recentApplications, 0, 5);

} catch (mysqli_sql_exception $e) {
  // Handle DB errors
  $errorMessage = "Database error: " . $e->getMessage();

  // Fallback dummy data
  $userCount = 25; $internshipCount = 12; $projectCount = 8;
  $workshopCount = 15; $contactCount = 10;
  $newUserCount = 3; $newInternshipCount = 2;
  $newProjectCount = 1; $newWorkshopCount = 4; $newContactCount = 2;

  $recentApplications = [
    ['id' => 1, 'name' => 'John Doe', 'type' => 'Internship', 'date' => '2023-05-15', 'status' => 'Pending'],
    ['id' => 2, 'name' => 'Jane Smith', 'type' => 'Project', 'date' => '2023-05-14', 'status' => 'Approved'],
    ['id' => 3, 'name' => 'Mike Johnson', 'type' => 'Workshop', 'date' => '2023-05-13', 'status' => 'Rejected'],
    ['id' => 4, 'name' => 'Sarah Williams', 'type' => 'Internship', 'date' => '2023-05-12', 'status' => 'Pending'],
    ['id' => 5, 'name' => 'David Brown', 'type' => 'Contact', 'date' => '2023-05-11', 'status' => 'Responded']
  ];

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Zara Tech - Admin Dashboard</title>
  <meta name="description" content="Admin dashboard for Zara Tech to manage applications and users.">

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #4154f1;
      --secondary-color: #6c757d;
      --success-color: #28a745;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
      --info-color: #17a2b8;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
      --transition-speed: 0.3s;
      --box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f6f9ff;
      color: #444444;
    }
    
    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 280px;
      z-index: 996;
      transition: all 0.3s;
      padding: 20px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #aab7cf transparent;
      box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);
      background-color: #fff;
    }
    
    .sidebar-nav {
      padding: 0;
      margin: 0;
      list-style: none;
    }
    
    .sidebar-nav li {
      padding: 0;
      margin: 0;
      list-style: none;
    }
    
    .sidebar-nav .nav-item {
      margin-bottom: 5px;
    }
    
    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      font-size: 15px;
      font-weight: 600;
      color: #012970;
      transition: 0.3s;
      padding: 10px 15px;
      border-radius: 4px;
    }
    
    .sidebar-nav .nav-link i {
      font-size: 16px;
      margin-right: 10px;
      color: #4154f1;
    }
    
    .sidebar-nav .nav-link:hover,
    .sidebar-nav .nav-link.active {
      color: #4154f1;
      background: #f6f9ff;
    }
    
    .sidebar-nav .nav-link.active i {
      color: #4154f1;
    }
    
    .sidebar-nav .nav-content {
      padding: 5px 0 0 0;
      margin: 0;
      list-style: none;
    }
    
    .sidebar-nav .nav-content a {
      display: flex;
      align-items: center;
      font-size: 14px;
      font-weight: 400;
      color: #012970;
      padding: 10px 0 10px 40px;
      transition: 0.3s;
    }
    
    .sidebar-nav .nav-content a i {
      font-size: 6px;
      margin-right: 8px;
      line-height: 0;
      border-radius: 50%;
    }
    
    .sidebar-nav .nav-content a:hover,
    .sidebar-nav .nav-content a.active {
      color: #4154f1;
    }
    
    /* Main Content Styles */
    .main {
      margin-left: 280px;
      padding: 20px;
      transition: all 0.3s;
    }
    
    .pagetitle {
      margin-bottom: 10px;
    }
    
    .pagetitle h1 {
      font-size: 24px;
      margin-bottom: 0;
      font-weight: 600;
      color: #012970;
    }
    
    /* Card Styles */
    .card {
      margin-bottom: 30px;
      border: none;
      border-radius: 10px;
      box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0 30px rgba(1, 41, 112, 0.2);
    }
    
    .card-header, .card-footer {
      border-color: #ebeef4;
      background-color: #fff;
      color: #798eb3;
      padding: 15px;
    }
    
    .card-title {
      padding: 20px 0 15px 0;
      font-size: 18px;
      font-weight: 600;
      color: #012970;
      font-family: "Poppins", sans-serif;
      margin-bottom: 0;
    }
    
    .card-title span {
      color: #899bbd;
      font-size: 14px;
      font-weight: 400;
    }
    
    .card-body {
      padding: 20px;
    }
    
    /* Dashboard Info Cards */
    .dashboard-card {
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(1, 41, 112, 0.1);
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      cursor: pointer;
    }
    
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(1, 41, 112, 0.15);
    }
    
    .dashboard-card .card-icon {
      font-size: 32px;
      line-height: 1;
      width: 64px;
      height: 64px;
      flex-shrink: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 15px;
      border-radius: 50%;
      color: #fff;
      background-color: var(--primary-color);
      transition: all 0.3s ease;
    }
    
    .dashboard-card:hover .card-icon {
      transform: scale(1.1);
    }
    
    .dashboard-card h3 {
      font-size: 28px;
      color: #012970;
      font-weight: 700;
      margin: 0;
    }
    
    .dashboard-card p {
      color: #6c757d;
      margin: 5px 0 0 0;
    }
    
    /* Color variations */
    .card-users .card-icon {
      background: linear-gradient(135deg, #65b2ff 0%, #0d6efd 100%);
    }
    
    .card-internships .card-icon {
      background: linear-gradient(135deg, #5ddab4 0%, #1db954 100%);
    }
    
    .card-projects .card-icon {
      background: linear-gradient(135deg, #ff7eb3 0%, #e83e8c 100%);
    }
    
    .card-workshops .card-icon {
      background: linear-gradient(135deg, #ffd76e 0%, #ffc107 100%);
    }
    
    .card-contacts .card-icon {
      background: linear-gradient(135deg, #b197fc 0%, #6f42c1 100%);
    }
    
    /* Table Styles */
    .table {
      border-collapse: collapse;
      width: 100%;
    }
    
    .table thead th {
      background-color: #f6f9ff;
      color: #012970;
      font-weight: 600;
      border-bottom: 2px solid #ebeef4;
    }
    
    .table tbody tr:hover {
      background-color: #f6f9ff;
    }
    
    /* Button Styles */
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: #fff;
      padding: 8px 16px;
      border-radius: 4px;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      background-color: #3445e5;
      border-color: #3445e5;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(65, 84, 241, 0.3);
    }
    
    .btn-outline-primary {
      color: var(--primary-color);
      border-color: var(--primary-color);
      background-color: transparent;
      padding: 8px 16px;
      border-radius: 4px;
      transition: all 0.3s;
    }
    
    .btn-outline-primary:hover {
      background-color: var(--primary-color);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(65, 84, 241, 0.3);
    }
    
    /* Navigation Pills */
    .nav-pills .nav-link {
      background: none;
      border: 0;
      border-radius: 4px;
      padding: 10px 15px;
      color: #6c757d;
      font-weight: 500;
      transition: all 0.3s;
    }
    
    .nav-pills .nav-link.active, 
    .nav-pills .show > .nav-link {
      color: #fff;
      background-color: var(--primary-color);
      box-shadow: 0 5px 10px rgba(65, 84, 241, 0.2);
    }
    
    .nav-pills .nav-link:hover:not(.active) {
      color: var(--primary-color);
      background-color: rgba(65, 84, 241, 0.1);
    }
    
    /* Content Sections */
    .content-section {
      display: none;
      animation: fadeIn 0.5s ease;
    }
    
    .content-section.active {
      display: block;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Chart Container */
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
    
    /* Responsive */
    @media (max-width: 1199px) {
      .sidebar {
        left: -280px;
      }
      
      .sidebar.active {
        left: 0;
      }
      
      .main {
        margin-left: 0;
      }
      
      .toggle-sidebar-btn {
        display: block;
      }
    }
    
    .toggle-sidebar-btn {
      font-size: 24px;
      cursor: pointer;
      color: #012970;
      margin-right: 15px;
    }
    
    /* Animation for cards */
    .dashboard-card {
      animation: slideUp 0.5s ease;
    }
    
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Status badges */
    .badge {
      padding: 6px 10px;
      font-size: 12px;
      font-weight: 500;
      border-radius: 20px;
    }
    
    .badge-success {
      background-color: rgba(40, 167, 69, 0.1);
      color: #28a745;
    }
    
    .badge-warning {
      background-color: rgba(255, 193, 7, 0.1);
      color: #ffc107;
    }
    
    .badge-danger {
      background-color: rgba(220, 53, 69, 0.1);
      color: #dc3545;
    }
    
    .badge-info {
      background-color: rgba(23, 162, 184, 0.1);
      color: #17a2b8;
    }
    
    /* Search box */
    .search-form {
      position: relative;
      margin-bottom: 20px;
    }
    
    .search-form input {
      border: 1px solid #ebeef4;
      border-radius: 4px;
      padding: 10px 15px 10px 40px;
      width: 100%;
      font-size: 14px;
      color: #012970;
      transition: all 0.3s;
    }
    
    .search-form input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 10px rgba(65, 84, 241, 0.2);
    }
    
    .search-form button {
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      border: 0;
      background: none;
      font-size: 16px;
      padding: 0 15px;
      color: #6c757d;
      transition: all 0.3s;
    }
    
    .search-form button:hover {
      color: var(--primary-color);
    }

    /* Notification badge for new items */
    .notification-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 20px;
      height: 20px;
      background-color: #dc3545;
      color: white;
      font-size: 11px;
      font-weight: bold;
      border-radius: 50%;
      margin-left: 5px;
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        opacity: 1;
      }
      50% {
        transform: scale(1.1);
        opacity: 0.8;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* Card action buttons */
    .card-actions {
      width: 100%;
      display: flex;
      justify-content: center;
    }

    .dashboard-card {
      position: relative;
      padding-bottom: 60px;
    }

    .dashboard-card .card-actions {
      position: absolute;
      bottom: 20px;
      left: 0;
      right: 0;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../assets/img/logo.png" alt="Xoventa Logo">
        <span class="d-none d-lg-block">Xoventa</span>
      </a>
      <i class="bi bi-x d-xl-none toggle-sidebar-btn" onclick="toggleSidebar()"></i>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#dashboard" onclick="showSection('dashboard')">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#users" onclick="showSection('users')">
          <i class="bi bi-people"></i>
          <span>User Management</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#applications-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-text"></i><span>Applications</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="applications-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#internship-applications" onclick="showSection('internship-applications')">
              <i class="bi bi-circle"></i><span>Internship Applications</span>
            </a>
          </li>
          <li>
            <a href="#project-applications" onclick="showSection('project-applications')">
              <i class="bi bi-circle"></i><span>Project Applications</span>
            </a>
          </li>
          <li>
            <a href="#workshop-applications" onclick="showSection('workshop-applications')">
              <i class="bi bi-circle"></i><span>Workshop Applications</span>
            </a>
          </li>
          <li>
            <a href="#contact-submissions" onclick="showSection('contact-submissions')">
              <i class="bi bi-circle"></i><span>Contact Submissions</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#visualization" onclick="showSection('visualization')">
          <i class="bi bi-bar-chart"></i>
          <span>Data Visualization</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#settings" onclick="showSection('settings')">
          <i class="bi bi-gear"></i>
          <span>Settings</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
      </li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main id="main" class="main">
    <div class="pagetitle d-flex align-items-center">
      <i class="bi bi-list toggle-sidebar-btn d-xl-none" onclick="toggleSidebar()"></i>
      <h1>Admin Dashboard</h1>
      <nav class="ms-auto">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <!-- Dashboard Section -->
    <section id="dashboard" class="content-section active">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Welcome to Zara Tech Admin Panel</h5>
              <p>Manage users, applications, and view analytics from this dashboard.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Users Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card card-users">
            <div class="card-icon">
              <i class="bi bi-people"></i>
            </div>
            <h3><?php echo $userCount; ?></h3>
            <p>Registered Users</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('users', 'recent')">
                Recent
                <?php if (isset($newUserCount) && $newUserCount > 0): ?>
                <span class="notification-badge"><?php echo $newUserCount; ?></span>
                <?php endif; ?>
              </button>
              <button class="btn btn-sm btn-primary" onclick="showSection('users', 'all')">View All</button>
            </div>
          </div>
        </div>

        <!-- Internship Applications Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card card-internships">
            <div class="card-icon">
              <i class="bi bi-briefcase"></i>
            </div>
            <h3><?php echo $internshipCount; ?></h3>
            <p>Internship Applications</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('internship-applications', 'recent')">
                Recent
                <?php if (isset($newInternshipCount) && $newInternshipCount > 0): ?>
                <span class="notification-badge"><?php echo $newInternshipCount; ?></span>
                <?php endif; ?>
              </button>
              <button class="btn btn-sm btn-primary" onclick="showSection('internship-applications', 'all')">View All</button>
            </div>
          </div>
        </div>

        <!-- Project Applications Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card card-projects">
            <div class="card-icon">
              <i class="bi bi-kanban"></i>
            </div>
            <h3><?php echo $projectCount; ?></h3>
            <p>Project Applications</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('project-applications', 'recent')">
                Recent
                <?php if (isset($newProjectCount) && $newProjectCount > 0): ?>
                <span class="notification-badge"><?php echo $newProjectCount; ?></span>
                <?php endif; ?>
              </button>
              <button class="btn btn-sm btn-primary" onclick="showSection('project-applications', 'all')">View All</button>
            </div>
          </div>
        </div>

        <!-- Workshop Applications Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card card-workshops">
            <div class="card-icon">
              <i class="bi bi-easel"></i>
            </div>
            <h3><?php echo $workshopCount; ?></h3>
            <p>Workshop Applications</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('workshop-applications', 'recent')">
                Recent
                <?php if (isset($newWorkshopCount) && $newWorkshopCount > 0): ?>
                <span class="notification-badge"><?php echo $newWorkshopCount; ?></span>
                <?php endif; ?>
              </button>
              <button class="btn btn-sm btn-primary" onclick="showSection('workshop-applications', 'all')">View All</button>
            </div>
          </div>
        </div>

        <!-- Contact Submissions Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card card-contacts">
            <div class="card-icon">
              <i class="bi bi-chat-dots"></i>
            </div>
            <h3><?php echo $contactCount; ?></h3>
            <p>Contact Submissions</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('contact-submissions', 'recent')">
                Recent
                <?php if (isset($newContactCount) && $newContactCount > 0): ?>
                <span class="notification-badge"><?php echo $newContactCount; ?></span>
                <?php endif; ?>
              </button>
              <button class="btn btn-sm btn-primary" onclick="showSection('contact-submissions', 'all')">View All</button>
            </div>
          </div>
        </div>

        <!-- Visualization Card -->
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="dashboard-card">
            <div class="card-icon" style="background: linear-gradient(135deg, #6edff6 0%, #0dcaf0 100%);">
              <i class="bi bi-bar-chart"></i>
            </div>
            <h3>Analytics</h3>
            <p>Data Visualization</p>
            <div class="card-actions mt-3">
              <button class="btn btn-sm btn-primary" onclick="showSection('visualization')">View Charts</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Recent Applications -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Recent Applications</h5>
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // This would be populated from your database
                  
                  foreach ($recentApplications as $app) {
                    $statusClass = '';
                    switch ($app['status']) {
                      case 'Approved':
                        $statusClass = 'badge-success';
                        break;
                      case 'Pending':
                        $statusClass = 'badge-warning';
                        break;
                      case 'Rejected':
                        $statusClass = 'badge-danger';
                        break;
                      case 'Responded':
                        $statusClass = 'badge-success';
                        break;
                      case 'New':
                        $statusClass = 'badge-warning';
                        break;
                      default:
                        $statusClass = 'badge-info';
                    }
                    
                    echo '<tr>';
                    echo '<th scope="row"><a href="#">#' . $app['id'] . '</a></th>';
                    echo '<td>' . $app['name'] . '</td>';
                    echo '<td>' . $app['type'] . '</td>';
                    echo '<td>' . $app['date'] . '</td>';
                    echo '<td><span class="badge ' . $statusClass . '">' . $app['status'] . '</span></td>';
                    echo '</tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Users Section -->
    <section id="users" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">User Management</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                  <i class="bi bi-plus"></i> Add User
                </button>
              </div>
              
              <div class="search-form mb-4">
                <button type="submit"><i class="bi bi-search"></i></button>
                <input type="text" id="userSearchInput" placeholder="Search users..." onkeyup="searchUsers()">
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover" id="usersTable">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Role</th>
                      <th scope="col">Registered Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // This would be populated from your database
                    $users = [
                      ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'date' => '2023-01-15', 'status' => 'Active'],
                      ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'User', 'date' => '2023-02-20', 'status' => 'Active'],
                      ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'role' => 'User', 'date' => '2023-03-10', 'status' => 'Inactive'],
                      ['id' => 4, 'name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'role' => 'User', 'date' => '2023-04-05', 'status' => 'Active'],
                      ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'role' => 'User', 'date' => '2023-05-01', 'status' => 'Active']
                    ];
                    
                    foreach ($users as $user) {
                      $statusClass = $user['status'] === 'Active' ? 'badge-success' : 'badge-danger';
                      
                      echo '<tr>';
                      echo '<th scope="row">' . $user['id'] . '</th>';
                      echo '<td>' . $user['name'] . '</td>';
                      echo '<td>' . $user['email'] . '</td>';
                      echo '<td>' . $user['role'] . '</td>';
                      echo '<td>' . $user['date'] . '</td>';
                      echo '<td><span class="badge ' . $statusClass . '">' . $user['status'] . '</span></td>';
                      echo '<td>';
                      echo '<button class="btn btn-sm btn-outline-primary me-1" onclick="editUser(' . $user['id'] . ')"><i class="bi bi-pencil"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-danger" onclick="deleteUser(' . $user['id'] . ')"><i class="bi bi-trash"></i></button>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Internship Applications Section -->
    <section id="internship-applications" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Internship Applications</h5>
              
              <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="filter-status text-muted">Showing all items</p>
                <div>
                  <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('internship-applications', 'recent')">
                    Recent
                    <?php if (isset($newInternshipApplicationsCount) && $newInternshipApplicationsCount > 0): ?>
                    <span class="notification-badge"><?php echo $newInternshipApplicationsCount; ?></span>
                    <?php endif; ?>
                  </button>
                  <button class="btn btn-sm btn-primary" onclick="showSection('internship-applications', 'all')">View All</button>
                </div>
              </div>
              
              <div class="search-form mb-4">
                <button type="submit"><i class="bi bi-search"></i></button>
                <input type="text" placeholder="Search applications...">
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Position</th>
                      <th scope="col">Applied Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // This would be populated from your database
                    $internships = [
                      ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'position' => 'Web Developer', 'date' => '2023-05-15', 'status' => 'Pending'],
                      ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'position' => 'UI/UX Designer', 'date' => '2023-05-14', 'status' => 'Approved'],
                      ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'position' => 'Data Analyst', 'date' => '2023-05-13', 'status' => 'Rejected'],
                      ['id' => 4, 'name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'position' => 'Mobile Developer', 'date' => '2023-05-12', 'status' => 'Pending'],
                      ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'position' => 'Backend Developer', 'date' => '2023-05-11', 'status' => 'Approved']
                    ];
                    
                    foreach ($internships as $app) {
                      $statusClass = '';
                      switch ($app['status']) {
                        case 'Approved':
                          $statusClass = 'badge-success';
                          break;
                        case 'Pending':
                          $statusClass = 'badge-warning';
                          break;
                        case 'Rejected':
                          $statusClass = 'badge-danger';
                          break;
                      }
                      
                      echo '<tr>';
                      echo '<th scope="row">' . $app['id'] . '</th>';
                      echo '<td>' . $app['name'] . '</td>';
                      echo '<td>' . $app['email'] . '</td>';
                      echo '<td>' . $app['position'] . '</td>';
                      echo '<td>' . $app['date'] . '</td>';
                      echo '<td><span class="badge ' . $statusClass . '">' . $app['status'] . '</span></td>';
                      echo '<td>';
                      echo '<button class="btn btn-sm btn-outline-primary me-1" onclick="viewApplication(' . $app['id'] . ', \'internship\')"><i class="bi bi-eye"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-success me-1" onclick="approveApplication(' . $app['id'] . ', \'internship\')"><i class="bi bi-check-lg"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-danger" onclick="rejectApplication(' . $app['id'] . ', \'internship\')"><i class="bi bi-x-lg"></i></button>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Applications Section -->
    <section id="project-applications" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Project Applications</h5>
              
              <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="filter-status text-muted">Showing all items</p>
                <div>
                  <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('project-applications', 'recent')">
                    Recent
                    <?php if (isset($newProjectApplicationsCount) && $newProjectApplicationsCount > 0): ?>
                    <span class="notification-badge"><?php echo $newProjectApplicationsCount; ?></span>
                    <?php endif; ?>
                  </button>
                  <button class="btn btn-sm btn-primary" onclick="showSection('project-applications', 'all')">View All</button>
                </div>
              </div>
              
              <div class="search-form mb-4">
                <button type="submit"><i class="bi bi-search"></i></button>
                <input type="text" placeholder="Search applications...">
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Project</th>
                      <th scope="col">Applied Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // This would be populated from your database
                    $projects = [
                      ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'project' => 'E-commerce Website', 'date' => '2023-05-15', 'status' => 'Pending'],
                      ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'project' => 'Mobile App', 'date' => '2023-05-14', 'status' => 'Approved'],
                      ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'project' => 'Data Analysis', 'date' => '2023-05-13', 'status' => 'Rejected'],
                      ['id' => 4, 'name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'project' => 'Web Portal', 'date' => '2023-05-12', 'status' => 'Pending'],
                      ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'project' => 'CRM System', 'date' => '2023-05-11', 'status' => 'Approved']
                    ];
                    
                    foreach ($projects as $app) {
                      $statusClass = '';
                      switch ($app['status']) {
                        case 'Approved':
                          $statusClass = 'badge-success';
                          break;
                        case 'Pending':
                          $statusClass = 'badge-warning';
                          break;
                        case 'Rejected':
                          $statusClass = 'badge-danger';
                          break;
                      }
                      
                      echo '<tr>';
                      echo '<th scope="row">' . $app['id'] . '</th>';
                      echo '<td>' . $app['name'] . '</td>';
                      echo '<td>' . $app['email'] . '</td>';
                      echo '<td>' . $app['project'] . '</td>';
                      echo '<td>' . $app['date'] . '</td>';
                      echo '<td><span class="badge ' . $statusClass . '">' . $app['status'] . '</span></td>';
                      echo '<td>';
                      echo '<button class="btn btn-sm btn-outline-primary me-1" onclick="viewApplication(' . $app['id'] . ', \'project\')"><i class="bi bi-eye"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-success me-1" onclick="approveApplication(' . $app['id'] . ', \'project\')"><i class="bi bi-check-lg"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-danger" onclick="rejectApplication(' . $app['id'] . ', \'project\')"><i class="bi bi-x-lg"></i></button>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Workshop Applications Section -->
    <section id="workshop-applications" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Workshop Applications</h5>
              
              <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="filter-status text-muted">Showing all items</p>
                <div>
                  <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('workshop-applications', 'recent')">
                    Recent
                    <?php if (isset($newWorkshopApplicationsCount) && $newWorkshopApplicationsCount > 0): ?>
                    <span class="notification-badge"><?php echo $newWorkshopApplicationsCount; ?></span>
                    <?php endif; ?>
                  </button>
                  <button class="btn btn-sm btn-primary" onclick="showSection('workshop-applications', 'all')">View All</button>
                </div>
              </div>
              
              <div class="search-form mb-4">
                <button type="submit"><i class="bi bi-search"></i></button>
                <input type="text" placeholder="Search applications...">
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Workshop</th>
                      <th scope="col">Applied Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // This would be populated from your database
                    $workshops = [
                      ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'workshop' => 'Web Development', 'date' => '2023-05-15', 'status' => 'Pending'],
                      ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'workshop' => 'UI/UX Design', 'date' => '2023-05-14', 'status' => 'Approved'],
                      ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'workshop' => 'Data Science', 'date' => '2023-05-13', 'status' => 'Rejected'],
                      ['id' => 4, 'name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'workshop' => 'Mobile Development', 'date' => '2023-05-12', 'status' => 'Pending'],
                      ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'workshop' => 'Cloud Computing', 'date' => '2023-05-11', 'status' => 'Approved']
                    ];
                    
                    foreach ($workshops as $app) {
                      $statusClass = '';
                      switch ($app['status']) {
                        case 'Approved':
                          $statusClass = 'badge-success';
                          break;
                        case 'Pending':
                          $statusClass = 'badge-warning';
                          break;
                        case 'Rejected':
                          $statusClass = 'badge-danger';
                          break;
                      }
                      
                      echo '<tr>';
                      echo '<th scope="row">' . $app['id'] . '</th>';
                      echo '<td>' . $app['name'] . '</td>';
                      echo '<td>' . $app['email'] . '</td>';
                      echo '<td>' . $app['workshop'] . '</td>';
                      echo '<td>' . $app['date'] . '</td>';
                      echo '<td><span class="badge ' . $statusClass . '">' . $app['status'] . '</span></td>';
                      echo '<td>';
                      echo '<button class="btn btn-sm btn-outline-primary me-1" onclick="viewApplication(' . $app['id'] . ', \'workshop\')"><i class="bi bi-eye"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-success me-1" onclick="approveApplication(' . $app['id'] . ', \'workshop\')"><i class="bi bi-check-lg"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-danger" onclick="rejectApplication(' . $app['id'] . ', \'workshop\')"><i class="bi bi-x-lg"></i></button>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Submissions Section -->
    <section id="contact-submissions" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Contact Submissions</h5>
              
              <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="filter-status text-muted">Showing all items</p>
                <div>
                  <button class="btn btn-sm btn-outline-primary me-2" onclick="showSection('contact-submissions', 'recent')">
                    Recent
                    <?php if (isset($newContactSubmissionsCount) && $newContactSubmissionsCount > 0): ?>
                    <span class="notification-badge"><?php echo $newContactSubmissionsCount; ?></span>
                    <?php endif; ?>
                  </button>
                  <button class="btn btn-sm btn-primary" onclick="showSection('contact-submissions', 'all')">View All</button>
                </div>
              </div>
              
              <div class="search-form mb-4">
                <button type="submit"><i class="bi bi-search"></i></button>
                <input type="text" placeholder="Search submissions...">
              </div>
              
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // This would be populated from your database
                    $contacts = [
                      ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'subject' => 'General Inquiry', 'date' => '2023-05-15', 'status' => 'New'],
                      ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'subject' => 'Partnership Opportunity', 'date' => '2023-05-14', 'status' => 'Responded'],
                      ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'subject' => 'Technical Support', 'date' => '2023-05-13', 'status' => 'New'],
                      ['id' => 4, 'name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'subject' => 'Feedback', 'date' => '2023-05-12', 'status' => 'Responded'],
                      ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'subject' => 'Job Inquiry', 'date' => '2023-05-11', 'status' => 'New']
                    ];
                    
                    foreach ($contacts as $contact) {
                      $statusClass = $contact['status'] === 'New' ? 'badge-warning' : 'badge-success';
                      
                      echo '<tr>';
                      echo '<th scope="row">' . $contact['id'] . '</th>';
                      echo '<td>' . $contact['name'] . '</td>';
                      echo '<td>' . $contact['email'] . '</td>';
                      echo '<td>' . $contact['subject'] . '</td>';
                      echo '<td>' . $contact['date'] . '</td>';
                      echo '<td><span class="badge ' . $statusClass . '">' . $contact['status'] . '</span></td>';
                      echo '<td>';
                      echo '<button class="btn btn-sm btn-outline-primary me-1" onclick="viewContact(' . $contact['id'] . ')"><i class="bi bi-eye"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-success me-1" onclick="respondToContact(' . $contact['id'] . ')"><i class="bi bi-reply"></i></button>';
                      echo '<button class="btn btn-sm btn-outline-danger" onclick="deleteContact(' . $contact['id'] . ')"><i class="bi bi-trash"></i></button>';
                      echo '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Data Visualization Section -->
    <section id="visualization" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Visualization</h5>
              
              <ul class="nav nav-pills mb-3" id="visualization-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="applications-tab" data-bs-toggle="pill" data-bs-target="#applications-chart" type="button" role="tab" aria-controls="applications-chart" aria-selected="true">Applications</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="users-tab" data-bs-toggle="pill" data-bs-target="#users-chart" type="button" role="tab" aria-controls="users-chart" aria-selected="false">Users</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="trends-tab" data-bs-toggle="pill" data-bs-target="#trends-chart" type="button" role="tab" aria-controls="trends-chart" aria-selected="false">Trends</button>
                </li>
              </ul>
              
              <div class="tab-content" id="visualization-tabContent">
                <div class="tab-pane fade show active" id="applications-chart" role="tabpanel" aria-labelledby="applications-tab">
                  <div class="chart-container">
                    <canvas id="applicationsChart"></canvas>
                  </div>
                </div>
                <div class="tab-pane fade" id="users-chart" role="tabpanel" aria-labelledby="users-tab">
                  <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                  </div>
                </div>
                <div class="tab-pane fade" id="trends-chart" role="tabpanel" aria-labelledby="trends-tab">
                  <div class="chart-container">
                    <canvas id="trendsChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Application Status Distribution</h5>
              <div class="chart-container">
                <canvas id="statusChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Monthly Applications</h5>
              <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Settings Section -->
    <section id="settings" class="content-section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admin Settings</h5>
              
              <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Security</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">Notifications</button>
                </li>
              </ul>
              
              <div class="tab-content pt-4" id="settingsTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <form>
                    <div class="row mb-3">
                      <label for="profileName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="profileName" value="Admin User">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="profileEmail" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="profileEmail" value="admin@zaratech.com">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="profilePhone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="profilePhone" value="+1 (123) 456-7890">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
                
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                  <form>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="confirmpassword" type="password" class="form-control" id="confirmPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form>
                </div>
                
                <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                  <form>
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" id="newApplications" checked>
                      <label class="form-check-label" for="newApplications">
                        New Application Notifications
                      </label>
                    </div>
                    
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" id="newUsers" checked>
                      <label class="form-check-label" for="newUsers">
                        New User Registrations
                      </label>
                    </div>
                    
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" id="contactMessages" checked>
                      <label class="form-check-label" for="contactMessages">
                        Contact Form Submissions
                      </label>
                    </div>
                    
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" id="systemUpdates">
                      <label class="form-check-label" for="systemUpdates">
                        System Updates
                      </label>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Preferences</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="userName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="userName" placeholder="Enter full name">
            </div>
            <div class="mb-3">
              <label for="userEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="userEmail" placeholder="Enter email">
            </div>
            <div class="mb-3">
              <label for="userPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="userPassword" placeholder="Password">
            </div>
            <div class="mb-3">
              <label for="userRole" class="form-label">Role</label>
              <select class="form-select" id="userRole">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Add User</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

  <script>
  // Function to show section with filter for recent or all items
  function showSection(sectionId, filter = null) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.remove('active');
    });
    
    // Show the selected section
    const section = document.getElementById(sectionId);
    if (section) {
      section.classList.add('active');
      
      // Update sidebar active state
      document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
        link.classList.remove('active');
      });
      
      const navLink = document.querySelector(`.sidebar-nav .nav-link[href="#${sectionId}"]`);
      if (navLink) {
        navLink.classList.add('active');
      }
      
      // Handle filter if provided
      if (filter && (filter === 'recent' || filter === 'all')) {
        // Show/hide rows based on filter
        const tableRows = section.querySelectorAll('table tbody tr');
        
        if (tableRows.length > 0) {
          if (filter === 'recent') {
            // Show only recent items (first 5 rows or those with 'new' class)
            tableRows.forEach((row, index) => {
              if (index < 5 || row.classList.contains('new-item')) {
                row.style.display = '';
              } else {
                row.style.display = 'none';
              }
            });
            
            // Update filter status in section
            const filterStatus = section.querySelector('.filter-status');
            if (filterStatus) {
              filterStatus.textContent = 'Showing recent items';
            }
          } else {
            // Show all items
            tableRows.forEach(row => {
              row.style.display = '';
            });
            
            // Update filter status in section
            const filterStatus = section.querySelector('.filter-status');
            if (filterStatus) {
              filterStatus.textContent = 'Showing all items';
            }
          }
        }
      }
    }
    
    // Update breadcrumb
    const breadcrumbActive = document.querySelector('.breadcrumb-item.active');
    if (breadcrumbActive) {
      breadcrumbActive.textContent = sectionId.split('-').map(word => 
        word.charAt(0).toUpperCase() + word.slice(1)
      ).join(' ');
    }
  }

  // Function to toggle sidebar on mobile
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }
  
  // Search users function
  function searchUsers() {
    const input = document.getElementById('userSearchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('usersTable');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
      let found = false;
      const td = tr[i].getElementsByTagName('td');
      
      for (let j = 0; j < td.length; j++) {
        if (td[j]) {
          const txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            found = true;
            break;
          }
        }
      }
      
      if (found) {
        tr[i].style.display = '';
      } else {
        tr[i].style.display = 'none';
      }
    }
  }
  
  // Functions for application management
  function viewApplication(id, type) {
    alert(`Viewing ${type} application #${id}`);
    // Implement modal or redirect to view application details
  }
  
  function approveApplication(id, type) {
    if (confirm(`Are you sure you want to approve this ${type} application?`)) {
      alert(`${type.charAt(0).toUpperCase() + type.slice(1)} application #${id} approved!`);
      // Implement AJAX call to update status
    }
  }
  
  function rejectApplication(id, type) {
    if (confirm(`Are you sure you want to reject this ${type} application?`)) {
      alert(`${type.charAt(0).toUpperCase() + type.slice(1)} application #${id} rejected!`);
      // Implement AJAX call to update status
    }
  }
  
  // Functions for user management
  function editUser(id) {
    alert(`Editing user #${id}`);
    // Implement modal or redirect to edit user
  }
  
  function deleteUser(id) {
    if (confirm(`Are you sure you want to delete user #${id}?`)) {
      alert(`User #${id} deleted!`);
      // Implement AJAX call to delete user
    }
  }
  
  // Functions for contact management
  function viewContact(id) {
    alert(`Viewing contact submission #${id}`);
    // Implement modal or redirect to view contact details
  }
  
  function respondToContact(id) {
    alert(`Responding to contact submission #${id}`);
    // Implement modal for response
  }
  
  function deleteContact(id) {
    if (confirm(`Are you sure you want to delete contact submission #${id}?`)) {
      alert(`Contact submission #${id} deleted!`);
      // Implement AJAX call to delete contact
    }
  }
  
  // Initialize charts when visualization tab is shown
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    initCharts();
    
    // Add 'new-item' class to recent items
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    
    document.querySelectorAll('table tbody tr').forEach(row => {
      const dateCell = row.querySelector('td:nth-child(5)');
      if (dateCell) {
        const itemDate = new Date(dateCell.textContent);
        if (itemDate >= yesterday) {
          row.classList.add('new-item');
          row.style.backgroundColor = 'rgba(255, 243, 205, 0.2)';
        }
      }
    });
  });
  
  function initCharts() {
    // Load Chart.js from CDN if not already loaded
    if (typeof Chart === 'undefined') {
      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js';
      script.onload = createCharts;
      document.head.appendChild(script);
    } else {
      createCharts();
    }
  }
  
  function createCharts() {
    // Applications Chart
    const applicationsCtx = document.getElementById('applicationsChart');
    if (applicationsCtx) {
      new Chart(applicationsCtx, {
        type: 'bar',
        data: {
          labels: ['Internships', 'Projects', 'Workshops', 'Contacts'],
          datasets: [{
            label: 'Total Applications',
            data: [<?php echo $internshipCount; ?>, <?php echo $projectCount; ?>, <?php echo $workshopCount; ?>, <?php echo $contactCount; ?>],
            backgroundColor: [
              'rgba(29, 185, 84, 0.6)',
              'rgba(232, 62, 140, 0.6)',
              'rgba(255, 193, 7, 0.6)',
              'rgba(111, 66, 193, 0.6)'
            ],
            borderColor: [
              'rgb(29, 185, 84)',
              'rgb(232, 62, 140)',
              'rgb(255, 193, 7)',
              'rgb(111, 66, 193)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
    
    // Users Chart
    const usersCtx = document.getElementById('usersChart');
    if (usersCtx) {
      new Chart(usersCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'User Growth',
            data: [5, 10, 15, 18, 22, <?php echo $userCount; ?>],
            fill: true,
            backgroundColor: 'rgba(13, 110, 253, 0.2)',
            borderColor: 'rgb(13, 110, 253)',
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
    
    // Status Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
      new Chart(statusCtx, {
        type: 'doughnut',
        data: {
          labels: ['Approved', 'Pending', 'Rejected'],
          datasets: [{
            data: [15, 25, 8],
            backgroundColor: [
              'rgba(40, 167, 69, 0.6)',
              'rgba(255, 193, 7, 0.6)',
              'rgba(220, 53, 69, 0.6)'
            ],
            borderColor: [
              'rgb(40, 167, 69)',
              'rgb(255, 193, 7)',
              'rgb(220, 53, 69)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
    
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
      new Chart(monthlyCtx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'Internships',
              data: [3, 5, 8, 10, 12, <?php echo $internshipCount; ?>],
              backgroundColor: 'rgba(29, 185, 84, 0.6)',
              borderColor: 'rgb(29, 185, 84)',
              borderWidth: 1
            },
            {
              label: 'Projects',
              data: [2, 3, 4, 5, 6, <?php echo $projectCount; ?>],
              backgroundColor: 'rgba(232, 62, 140, 0.6)',
              borderColor: 'rgb(232, 62, 140)',
              borderWidth: 1
            },
            {
              label: 'Workshops',
              data: [4, 6, 8, 10, 12, <?php echo $workshopCount; ?>],
              backgroundColor: 'rgba(255, 193, 7, 0.6)',
              borderColor: 'rgb(255, 193, 7)',
              borderWidth: 1
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
    
    // Trends Chart
    const trendsCtx = document.getElementById('trendsChart');
    if (trendsCtx) {
      new Chart(trendsCtx, {
        type: 'line',
        data: {
          labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
          datasets: [
            {
              label: 'Internships',
              data: [5, 8, 10, 14, 18, 22],
              borderColor: 'rgb(29, 185, 84)',
              tension: 0.3,
              fill: false
            },
            {
              label: 'Projects',
              data: [3, 5, 8, 10, 12, 15],
              borderColor: 'rgb(232, 62, 140)',
              tension: 0.3,
              fill: false
            },
            {
              label: 'Workshops',
              data: [8, 12, 15, 18, 22, 25],
              borderColor: 'rgb(255, 193, 7)',
              tension: 0.3,
              fill: false
            },
            {
              label: 'Contacts',
              data: [2, 4, 6, 8, 10, 12],
              borderColor: 'rgb(111, 66, 193)',
              tension: 0.3,
              fill: false
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
  }
</script>
</body>

</html>
