CREATE DATABASE Xoventa;
USE Xoventa;

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(100) NOT NULL,
  name VARCHAR(255) NOT NULL,
  short_description TEXT,
  description TEXT,
  image VARCHAR(255),
  icon VARCHAR(100),
  duration VARCHAR(50),
  level VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create course_syllabus table
CREATE TABLE IF NOT EXISTS course_syllabus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  section_number INT NOT NULL,
  section_title VARCHAR(255) NOT NULL,
  section_content TEXT,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- create workshop table
CREATE TABLE IF NOT EXISTS workshops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    duration VARCHAR(50) NOT NULL,              
    name VARCHAR(255) NOT NULL,                   
    short_description TEXT,                       
    description TEXT NOT NULL,                    
    image VARCHAR(255),                           
    icon VARCHAR(50)                              
);

CREATE TABLE IF NOT EXISTS workshop_syllabus (
    workshop_id INT NOT NULL,               
    section_number INT NOT NULL,            
    section_title VARCHAR(255) NOT NULL,    
    section_content TEXT NOT NULL,   
    workshop_type  VARCHAR(25) NOT NULL,     
    PRIMARY KEY (workshop_id, section_number),
    FOREIGN KEY (workshop_id) REFERENCES workshops(id)
);

CREATE TABLE IF NOT EXISTS applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  workshop_id INT,
  name VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(20),
  college VARCHAR(100),
  degree VARCHAR(100),
  graduationYear VARCHAR(20),
  startDate VARCHAR(20),
  whyJoin VARCHAR(500),
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS internship_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    college VARCHAR(100) NOT NULL,
    degree VARCHAR(100) NOT NULL,
    graduation_year INT NOT NULL,
    internship_field VARCHAR(50) NOT NULL,
    specific_program VARCHAR(50) NOT NULL,
    duration VARCHAR(20) NOT NULL,
    start_date DATE NOT NULL,
    skills TEXT NOT NULL,
    experience TEXT,
    resume_path VARCHAR(255) NOT NULL,
    linkedin_url VARCHAR(255),
    portfolio_url VARCHAR(255),
    why_join TEXT NOT NULL,
    terms_agree TINYINT(1) NOT NULL,
    application_date DATETIME NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending'
);

CREATE TABLE IF NOT EXISTS index_contact (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  number VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_contact (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  number VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  project_type VARCHAR(100) NOT NULL,
  project_title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the projects table
CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  short_description TEXT NOT NULL,
  full_description TEXT NOT NULL,
  category VARCHAR(100) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  gallery_images TEXT,
  completion_date VARCHAR(100),
  client VARCHAR(255),
  challenges TEXT,
  solutions TEXT,
  outcome TEXT,
  related_projects VARCHAR(255)
);

-- Create the project_technologies table
CREATE TABLE IF NOT EXISTS project_technologies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  tech_name VARCHAR(100) NOT NULL,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create the project_features table
CREATE TABLE IF NOT EXISTS project_features (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  feature_text TEXT NOT NULL,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS software_contact (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  number VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  service_category VARCHAR(50) NOT NULL,
  software_option VARCHAR(100),
  custom_service VARCHAR(100),
  message TEXT NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create email verification table
CREATE TABLE IF NOT EXISTS email_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expiry DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create remember me tokens table
CREATE TABLE IF NOT EXISTS remember_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expiry DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create login logs table
CREATE TABLE IF NOT EXISTS login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create password reset table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(64) NOT NULL,
    expiry DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for Web Development projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('E-commerce Website', 'A fully responsive e-commerce platform with product catalog, shopping cart, and payment integration.', 'A fully responsive e-commerce platform designed to provide an exceptional shopping experience. The website includes a comprehensive product catalog, intuitive shopping cart, secure checkout process, and seamless payment integration.', 'Web Development', 'assets/img/projects/E-commerce.avif', '["assets/img/gallery/image1.avif", "assets/img/gallery/image2.avif"]', 'March 2023', 'Fashion Retail Client', 'The client needed a solution that could handle a large product catalog with multiple variations while maintaining fast load times. Additionally, they required a secure payment system that could process international transactions.', 'We implemented a database structure optimized for e-commerce with efficient product categorization. We used lazy loading and image optimization to improve performance. For payments, we integrated a secure gateway with multi-currency support.', 'The e-commerce platform resulted in a 40% increase in online sales and significantly improved user engagement metrics. The responsive design reduced bounce rates on mobile devices by 25%.', '2,3');

-- Insert technologies for E-commerce Website
INSERT INTO project_technologies (project_id, tech_name) VALUES
(1, 'HTML5'),
(1, 'CSS3'),
(1, 'JavaScript'),
(1, 'PHP'),
(1, 'MySQL'),
(1, 'Bootstrap');

-- Insert features for E-commerce Website
INSERT INTO project_features (project_id, feature_text) VALUES
(1, 'Responsive design that works on all devices'),
(1, 'Product search and filtering capabilities'),
(1, 'User account management and order history'),
(1, 'Secure payment processing with multiple options'),
(1, 'Admin dashboard for inventory and order management'),
(1, 'SEO-optimized product pages');

-- Insert sample data for Portfolio Website
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Portfolio Website', 'A modern, responsive portfolio website with smooth animations and interactive elements.', 'A modern, responsive portfolio website designed to showcase creative work with smooth animations and interactive elements. The site features a clean, minimalist design that puts the focus on the content while providing an engaging user experience.', 'Web Development', 'assets/img/projects/Portfolio.jpg', '["assets/img/gallery/image1.jpg", "assets/img/gallery/image2.jpg"]', 'January 2023', 'Freelance Photographer', 'The client needed a visually striking portfolio that would load quickly despite containing many high-resolution images. They also wanted a unique navigation experience that would set their site apart.', 'We implemented lazy loading for images and used WebP format for optimal compression without quality loss. For the navigation, we created custom animations using GSAP that provided smooth transitions between sections.', 'The portfolio website helped the client secure multiple new projects and establish a strong online presence. The engaging design resulted in visitors spending an average of 3.5 minutes on the site, significantly above industry standards.', '1,3');

-- Insert technologies for Portfolio Website
INSERT INTO project_technologies (project_id, tech_name) VALUES
(2, 'HTML5'),
(2, 'CSS3'),
(2, 'JavaScript'),
(2, 'jQuery'),
(2, 'GSAP'),
(2, 'Webpack');

-- Insert features for Portfolio Website
INSERT INTO project_features (project_id, feature_text) VALUES
(2, 'Smooth page transitions and scroll animations'),
(2, 'Interactive project gallery with filtering options'),
(2, 'Lazy loading images for improved performance'),
(2, 'Contact form with validation and email integration'),
(2, 'Dark/light mode toggle'),
(2, 'Fully responsive across all device sizes');

-- Insert sample data for Web Development projects (Blog Platform)
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Blog Platform', 'A feature-rich blog platform with content management system, user authentication, and commenting system.', 'This blog platform was built with a robust content management system allowing users to create, edit, and delete posts. It features secure user authentication, role-based access control, and an interactive commenting system. The admin dashboard enables moderation of content and users.', 'Web Development', 'assets/img/projects/Blog.png', '["assets/img/gallery/image1.png", "assets/img/gallery/image2.png"]', 'January 2024', 'Independent Client', 'The challenge was to create a scalable blogging system that handles content management, user roles, and real-time interactions while ensuring performance and security.', 'Used Laravel for rapid development and scalability. Implemented user authentication using Laravel Breeze and integrated a modular comment system with AJAX updates. The database schema was normalized for efficient content retrieval.', 'The platform has enabled multiple bloggers to manage their content easily. User engagement increased due to the interactive comment system, and the project was successfully deployed with high performance and security.', '1,2');

-- Insert technologies for Blog Platform
INSERT INTO project_technologies (project_id, tech_name) VALUES
(3, 'HTML5'),
(3, 'CSS3'),
(3, 'JavaScript'),
(3, 'PHP'),
(3, 'MySQL'),
(3, 'Laravel');

-- Insert features for Blog Platform
INSERT INTO project_features (project_id, feature_text) VALUES
(3, 'Content management with create/edit/delete functionality'),
(3, 'User authentication and role-based access control'),
(3, 'Real-time AJAX-based commenting system'),
(3, 'Responsive layout and mobile optimization'),
(3, 'Admin dashboard for post and user moderation'),
(3, 'SEO-friendly blog structure and permalinks');

-- Insert sample data for App Development projects (Fitness Tracker App)
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Fitness Tracker App', 'A mobile application for tracking workouts, setting fitness goals, and monitoring progress.', 'The Fitness Tracker App is a cross-platform mobile application that allows users to log workouts, set personalized fitness goals, and monitor progress over time. The app includes features like real-time tracking, goal reminders, activity history, and cloud sync.', 'App Development', 'assets/img/projects/Fitness.webp', '["assets/img/gallery/image1.webp", "assets/img/gallery/image2.webp"]', 'August 2023', 'HealthTech Startup', 'The challenge was to build a real-time, scalable fitness app that could work offline and sync seamlessly across devices using cloud storage.', 'Developed the app using React Native for cross-platform compatibility. Integrated Firebase for authentication and real-time database features. Used Redux for state management and Node.js backend for custom APIs.', 'The app received positive feedback for its performance and usability, with over 10,000 downloads in the first month. Sync reliability and user engagement improved due to real-time tracking and personalized goal features.', '1,2');

-- Insert technologies for Fitness Tracker App
INSERT INTO project_technologies (project_id, tech_name) VALUES
(4, 'React Native'),
(4, 'Firebase'),
(4, 'Redux'),
(4, 'Node.js');

-- Insert features for Fitness Tracker App
INSERT INTO project_features (project_id, feature_text) VALUES
(4, 'Cross-platform support using React Native'),
(4, 'Workout tracking with time, sets, and reps'),
(4, 'Fitness goal setting and daily reminders'),
(4, 'Real-time data sync using Firebase'),
(4, 'Offline access with background sync'),
(4, 'Activity history and progress dashboard');

-- Insert sample data for App Development projects (Food Delivery App)
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Food Delivery App', 'A food delivery application with restaurant listings, menu browsing, order placement, and real-time tracking.', 'The Food Delivery App enables users to browse restaurants, explore menus, place orders, and track delivery status in real time. It offers features like user authentication, in-app payments, location tracking, and estimated delivery time.', 'App Development', 'assets/img/projects/Food.jpeg', '["assets/img/gallery/image1.jpeg", "assets/img/gallery/image2.jpeg"]', 'June 2023', 'Urban FoodTech', 'The challenge was to provide real-time delivery tracking and seamless performance across different devices with minimal latency in map updates.', 'Built using Flutter for native-like performance on both Android and iOS. Integrated Firebase for authentication and backend services. Google Maps API was used for real-time delivery tracking and route optimization.', 'The app was successfully launched and reached over 25,000 users within the first quarter. The real-time tracking and smooth UI significantly improved customer satisfaction and retention.', '1,3');

-- Insert technologies for Food Delivery App
INSERT INTO project_technologies (project_id, tech_name) VALUES
(5, 'Flutter'),
(5, 'Dart'),
(5, 'Firebase'),
(5, 'Google Maps API');

-- Insert features for Food Delivery App
INSERT INTO project_features (project_id, feature_text) VALUES
(5, 'Restaurant listing and menu browsing'),
(5, 'Secure user authentication and in-app payments'),
(5, 'Real-time order tracking with Google Maps'),
(5, 'Push notifications for order updates'),
(5, 'Favorites and order history management'),
(5, 'Cross-platform support with responsive UI');

-- Insert sample data for App Development projects (Task Management App)
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Task Management App', 'A productivity app for managing tasks, setting reminders, and organizing projects with team collaboration features.', 'The Task Management App is a feature-rich Android application that helps individuals and teams manage tasks efficiently. It supports task creation, deadline reminders, project categorization, and collaborative task sharing among team members.', 'App Development', 'assets/img/projects/Task.avif', '["assets/img/gallery/image1.avif", "assets/img/gallery/image2.avif"]', 'May 2023', 'Productivity Solutions Co.', 'The main challenge was to build an offline-capable, secure app with real-time sync for collaborative task updates across users.', 'Developed natively in Kotlin using Android SDK for optimal performance. Implemented Room Database for local storage and designed the app to sync data once online connectivity is restored.', 'The app improved productivity within client teams by 35%, with highly positive feedback for its clean UI, reminder system, and smooth offline support.', '2,4');

-- Insert technologies for Task Management App
INSERT INTO project_technologies (project_id, tech_name) VALUES
(6, 'Kotlin'),
(6, 'Android SDK'),
(6, 'Room Database');

-- Insert features for Task Management App
INSERT INTO project_features (project_id, feature_text) VALUES
(6, 'Task creation and categorization'),
(6, 'Deadline reminders and notifications'),
(6, 'Offline access with auto-sync on reconnect'),
(6, 'Team collaboration with task assignment'),
(6, 'Project organization dashboard'),
(6, 'User-friendly and minimal UI');

-- Insert sample data for Web Development projects (Social Media Platform)
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES 
('Social Media Platform', 'A full-stack social media application with user profiles, posts, comments, and real-time notifications.', 'A full-stack social media application that allows users to create profiles, share posts, comment, and receive real-time notifications. Built using the MERN stack and integrated with Socket.io for seamless real-time features.', 'MERN Stack', 'assets/img/projects/Social.png', '["assets/img/gallery/image1.png", "assets/img/gallery/image2.png"]', 'January 2024', 'Startup SocialTech', 'The main challenge was to implement real-time features at scale and ensure secure user authentication across sessions.', 'We used Socket.io for real-time communication and implemented JWT-based authentication with refresh tokens. MongoDB’s schema flexibility was leveraged for handling complex user data.', 'The platform successfully supported over 10,000 active users during the beta phase and received positive feedback on responsiveness and usability.', '5,8');

-- Insert technologies for Social Media Platform
INSERT INTO project_technologies (project_id, tech_name) VALUES
(7, 'MongoDB'),
(7, 'Express.js'),
(7, 'React'),
(7, 'Node.js'),
(7, 'Socket.io');

-- Insert features for Social Media Platform
INSERT INTO project_features (project_id, feature_text) VALUES
(7, 'Real-time notifications using WebSockets'),
(7, 'User authentication with JWT and refresh tokens'),
(7, 'Profile creation and post sharing'),
(7, 'Comment system with threaded replies'),
(7, 'Responsive UI built with React'),
(7, 'Admin tools for user and content moderation');

-- Insert sample data for Web Development projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Job Portal', 'A job search and application platform with employer and job seeker interfaces, resume uploads, and application tracking.', 'A job search and application platform that allows employers to post jobs, and job seekers to apply, upload resumes, and track applications. Built with the MERN stack for a responsive and scalable platform.', 'MERN Stack', 'assets/img/projects/Job.jpg', '', 'April 2024', 'HR Solutions Group', 'The challenge was to create a seamless interface for both employers and job seekers while implementing secure resume uploads and efficient application tracking.', 'We utilized MongoDB for storing job listings and user data, and integrated Express.js and Node.js to handle API requests. React.js was used for a responsive, dynamic user interface.', 'The portal successfully processed over 2,000 job applications in its first month and helped connect more than 100 employers with qualified candidates.', '3,9');

-- Insert technologies for Job Portal
INSERT INTO project_technologies (project_id, tech_name) VALUES
(8, 'MongoDB'),
(8, 'Express.js'),
(8, 'React'),
(8, 'Node.js');

-- Insert features for Job Portal
INSERT INTO project_features (project_id, feature_text) VALUES
(8, 'Job posting and application submission'),
(8, 'Employer interface for managing job postings'),
(8, 'Job seeker profile with resume upload'),
(8, 'Application tracking for job seekers'),
(8, 'Real-time notifications for application updates'),
(8, 'Responsive user interface for both employers and job seekers');

-- Insert sample data for Web Development projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('E-learning Platform', 'An online learning platform with course creation, enrollment, video lessons, quizzes, and progress tracking.', 'An online learning platform designed to provide a comprehensive learning experience. It supports course creation, student enrollment, video lessons, quizzes, and real-time progress tracking. Built using the MERN stack for scalability and flexibility.', 'MERN Stack', 'assets/img/projects/E-learning.png', '', 'May 2024', 'EdTech Solutions', 'The main challenge was to provide a smooth, engaging experience for users across a variety of devices, as well as manage large course data and student progress.', 'We used MongoDB to store course and student data, while Express.js and Node.js powered the backend API. React was used to deliver a dynamic and responsive user interface with real-time progress tracking.', 'The platform onboarded over 5,000 users in its first three months and facilitated over 200 courses with a high completion rate.', '3,9');

-- Insert technologies for E-learning Platform
INSERT INTO project_technologies (project_id, tech_name) VALUES
(9, 'MongoDB'),
(9, 'Express.js'),
(9, 'React'),
(9, 'Node.js');

-- Insert features for E-learning Platform
INSERT INTO project_features (project_id, feature_text) VALUES
(9, 'Course creation and management for instructors'),
(9, 'Student enrollment and course tracking'),
(9, 'Video lessons with support for embedded content'),
(9, 'Quizzes with real-time grading and feedback'),
(9, 'Real-time progress tracking and achievement badges'),
(9, 'Responsive design optimized for all devices');

-- Insert sample data for MEAN Stack projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Customer Relationship Management', 'A CRM system for managing customer interactions, sales pipelines, and business analytics.', 'A CRM system designed to help businesses manage customer interactions, track sales pipelines, and analyze business data in real-time. Built using the MEAN stack for a responsive and scalable solution.', 'MEAN Stack', 'assets/img/projects/CRM.jpg', '', 'June 2024', 'Business Solutions Inc.', 'The challenge was to develop a CRM that could scale to handle a large customer base while providing real-time analytics and a user-friendly interface.', 'We used MongoDB to store customer and sales data, Express.js for the backend API, Angular for the frontend, and Node.js to power the server.', 'The CRM system improved sales tracking by 50% and enhanced customer retention with streamlined communication features.', '10,11');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Inventory Management System', 'A system for tracking inventory levels, orders, sales, and deliveries with reporting and analytics.', 'An Inventory Management System designed to track inventory levels, manage orders, and generate detailed reports for better business decisions. Built using the MEAN stack for real-time updates and comprehensive analytics.', 'MEAN Stack', 'assets/img/projects/inven.png', '', 'July 2024', 'Retail Solutions Ltd.', 'The main challenge was to build a system that could efficiently track real-time inventory levels and provide detailed reports while ensuring scalability for future growth.', 'MongoDB was used for real-time inventory tracking, Express.js for backend APIs, Angular for a dynamic frontend, and Node.js for server-side functionality.', 'The system reduced inventory discrepancies by 30% and improved order fulfillment time by 25%.', '10,11');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Project Management Tool', 'A collaborative project management application with task assignment, progress tracking, and team communication.', 'A project management tool designed to streamline task assignment, track project progress, and enhance team communication. Built using the MEAN stack for flexibility and scalability.', 'MEAN Stack', 'assets/img/projects/Project.avif', '', 'August 2024', 'TechSolutions Corp.', 'The main challenge was creating an intuitive interface for task management and ensuring real-time collaboration between team members.', 'We used MongoDB for efficient task data storage, Express.js and Node.js for the backend, and Angular for building a dynamic and responsive frontend interface.', 'The tool helped teams improve project completion rates by 40% and enhanced communication efficiency by 30%.', '12');

-- Insert technologies for CRM
INSERT INTO project_technologies (project_id, tech_name) VALUES
(10, 'MongoDB'),
(10, 'Express.js'),
(10, 'Angular'),
(10, 'Node.js');

-- Insert technologies for Inventory Management System
INSERT INTO project_technologies (project_id, tech_name) VALUES
(11, 'MongoDB'),
(11, 'Express.js'),
(11, 'Angular'),
(11, 'Node.js');

-- Insert technologies for Project Management Tool
INSERT INTO project_technologies (project_id, tech_name) VALUES
(12, 'MongoDB'),
(12, 'Express.js'),
(12, 'Angular'),
(12, 'Node.js');

-- Insert features for CRM
INSERT INTO project_features (project_id, feature_text) VALUES
(10, 'Customer interaction management'),
(10, 'Sales pipeline tracking and management'),
(10, 'Real-time business analytics'),
(10, 'User-friendly dashboard for data visualization'),
(10, 'Secure user authentication and role management'),
(10, 'Customizable reporting tools');

-- Insert features for Inventory Management System
INSERT INTO project_features (project_id, feature_text) VALUES
(11, 'Real-time inventory tracking and updates'),
(11, 'Order and sales management'),
(11, 'Automated reporting and analytics'),
(11, 'Low-stock alerts and notifications'),
(11, 'Multi-location inventory support'),
(11, 'Data export and integration options');

-- Insert features for Project Management Tool
INSERT INTO project_features (project_id, feature_text) VALUES
(12, 'Task assignment and progress tracking'),
(12, 'Real-time team communication and collaboration'),
(12, 'Project milestone management'),
(12, 'Customizable task priority and deadlines'),
(12, 'File sharing and document storage'),
(12, 'Responsive design for all devices');

-- Insert Python Full Stack Projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Data Analytics Dashboard', 'An interactive dashboard for visualizing and analyzing business data with customizable reports.', 'A robust data analytics platform that enables users to visualize key business metrics, generate custom reports, and drill down into insights for informed decision-making. Designed using Django and React for a responsive user experience.', 'Python Full Stack', 'assets/img/projects/Data.jpg', '', 'May 2024', 'DataCorp Solutions', 'The key challenge was integrating large datasets into real-time dashboards with performance optimization.', 'We used Django REST Framework for API integration, PostgreSQL for efficient data storage, and React for interactive chart rendering.', 'The dashboard reduced manual reporting by 70% and improved business insights through intuitive visualizations.', '14,15');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Content Management System', 'A flexible CMS for creating, managing, and publishing digital content with user role management.', 'This CMS provides an admin dashboard, multi-role access, and WYSIWYG content editors. It is designed with Flask for lightweight performance and Vue.js for a dynamic UI.', 'Python Full Stack', 'assets/img/projects/Content.jpg', '', 'April 2024', 'CreativeWeb Inc.', 'Ensuring flexible content structures and secure multi-role access.', 'We implemented Flask for routing and API services, SQLAlchemy for ORM, and Vue.js for reactive components.', 'Content delivery was accelerated by 60%, and admin efficiency increased due to intuitive UI tools.', '13,15');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Booking System', 'An online reservation system for appointments, events, or services with calendar integration.', 'This system allows users to book appointments and events via an intuitive interface. It includes calendar syncing, email notifications, and role-based access using Django and MySQL.', 'Python Full Stack', 'assets/img/projects/Booking.jpg', '', 'March 2024', 'EventNow Pvt Ltd.', 'The challenge was integrating seamless calendar sync and managing booking conflicts.', 'Used Django with MySQL for the backend, added calendar.js for frontend scheduling, and built role-based access controls.', 'System improved booking accuracy by 80% and increased user retention due to smooth UX.', '13,14');

-- Technologies for Data Analytics Dashboard
INSERT INTO project_technologies (project_id, tech_name) VALUES
(13, 'Django'),
(13, 'Python'),
(13, 'PostgreSQL'),
(13, 'React');

-- Technologies for Content Management System
INSERT INTO project_technologies (project_id, tech_name) VALUES
(14, 'Flask'),
(14, 'Python'),
(14, 'SQLAlchemy'),
(14, 'Vue.js');

-- Technologies for Booking System
INSERT INTO project_technologies (project_id, tech_name) VALUES
(15, 'Django'),
(15, 'Python'),
(15, 'MySQL'),
(15, 'JavaScript');

-- Features for Data Analytics Dashboard
INSERT INTO project_features (project_id, feature_text) VALUES
(13, 'Customizable data visualization widgets'),
(13, 'Real-time data insights and reporting'),
(13, 'Exportable and schedulable reports'),
(13, 'Role-based dashboard access'),
(13, 'Interactive charts and filters'),
(13, 'Responsive design for all screen sizes');

-- Features for Content Management System
INSERT INTO project_features (project_id, feature_text) VALUES
(14, 'User-friendly WYSIWYG content editor'),
(14, 'Multi-role user management'),
(14, 'SEO-optimized content structure'),
(14, 'Media upload and management'),
(14, 'Page version control and history'),
(14, 'Dynamic Vue.js frontend integration');

-- Features for Booking System
INSERT INTO project_features (project_id, feature_text) VALUES
(15, 'Online booking for appointments and events'),
(15, 'Calendar integration and reminders'),
(15, 'Admin approval and cancellation management'),
(15, 'Email/SMS notification system'),
(15, 'Role-based login and user control'),
(15, 'Mobile-responsive UI');

-- Insert Java Full Stack projects
INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Banking Application', 'A secure banking platform with account management, transactions, and financial reporting.', 'This secure banking platform allows users to manage accounts, perform transactions, and generate detailed financial reports. Built using Spring Boot and Angular for seamless and secure performance.', 'Java Full Stack', 'assets/img/projects/Banking.png', '', 'February 2024', 'SecureBank Corp.', 'Developing a system that ensures data privacy, transaction accuracy, and real-time financial insights.', 'We implemented Spring Boot for secure backend APIs, Angular for a dynamic UI, and Hibernate to manage data persistence.', 'The platform enhanced transaction reliability and improved user trust with secure data handling.', '17,18');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Healthcare Management System', 'A comprehensive system for managing patient records, appointments, billing, and medical history.', 'A robust system for clinics and hospitals to manage patient records, billing, and appointments. Built with Spring MVC and React to ensure ease of use and strong backend architecture.', 'Java Full Stack', 'assets/img/projects/Healthcare.png', '', 'March 2024', 'MediServe Ltd.', 'Building a system that integrates patient data securely while ensuring responsiveness.', 'Used Spring MVC for backend, Oracle DB for data storage, and React for frontend interactivity.', 'Streamlined patient handling, reduced paperwork, and improved data retrieval efficiency.', '16,18');

INSERT INTO projects (title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
('Supply Chain Management', 'A system for managing the flow of goods and services, including procurement, inventory, and logistics.', 'An end-to-end solution for overseeing procurement, inventory, and logistics processes in real-time. Developed using Spring Boot and Vue.js.', 'Java Full Stack', 'assets/img/projects/Supply.jpg', '', 'April 2024', 'LogiTrack Pvt. Ltd.', 'Coordinating real-time updates across procurement, inventory, and delivery channels.', 'Integrated PostgreSQL with Spring Boot for robust backend, and Vue.js for a modern front-end interface.', 'Reduced delivery delays and optimized stock usage by 35%.', '16,17');

-- Technologies for Banking Application (id = 16)
INSERT INTO project_technologies (project_id, tech_name) VALUES
(16, 'Spring Boot'),
(16, 'Java'),
(16, 'Hibernate'),
(16, 'Angular');

-- Technologies for Healthcare Management System (id = 17)
INSERT INTO project_technologies (project_id, tech_name) VALUES
(17, 'Spring MVC'),
(17, 'Java'),
(17, 'Oracle DB'),
(17, 'React');

-- Technologies for Supply Chain Management (id = 18)
INSERT INTO project_technologies (project_id, tech_name) VALUES
(18, 'Spring Boot'),
(18, 'Java'),
(18, 'PostgreSQL'),
(18, 'Vue.js');

-- Features for Banking Application
INSERT INTO project_features (project_id, feature_text) VALUES
(16, 'Secure user authentication and role-based access'),
(16, 'Account management and transaction history'),
(16, 'Real-time transaction processing'),
(16, 'Automated financial reporting'),
(16, 'Admin panel for auditing and monitoring');

-- Features for Healthcare Management System
INSERT INTO project_features (project_id, feature_text) VALUES
(17, 'Electronic medical records management'),
(17, 'Online appointment scheduling'),
(17, 'Billing and invoice generation'),
(17, 'Patient history and analytics dashboard'),
(17, 'Doctor and admin role control');

-- Features for Supply Chain Management
INSERT INTO project_features (project_id, feature_text) VALUES
(18, 'Inventory and procurement tracking'),
(18, 'Logistics and delivery management'),
(18, 'Supplier and vendor integration'),
(18, 'Real-time data dashboard'),
(18, 'Multi-level user roles for operations');

-- UX UI Design Projects
INSERT INTO projects (id, title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
(19, 'Mobile App Redesign', 'A complete redesign of a mobile application with improved user experience, accessibility, and visual appeal.', 'The project involved a full redesign of an existing mobile app to enhance usability and aesthetics. By leveraging Figma, Adobe XD, and Sketch, the design was modernized with an intuitive layout and better accessibility features.', 'UX UI Design', 'assets/img/projects/Mobile.jpg', '', '2024-01-10', 'AppStream Inc.', 'Revamping the user interface without disrupting existing functionality.', 'Conducted user research, created wireframes and prototypes, and iterated designs based on user feedback.', 'Achieved a 30% increase in user engagement and higher app store ratings.', '20,21');

INSERT INTO projects (id, title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
(20, 'E-commerce UX Design', 'A user-centered design for an e-commerce platform with optimized user flows and conversion-focused interfaces.', 'Focused on creating a seamless shopping experience through optimized navigation, checkout flow, and mobile responsiveness. Tools like Adobe XD, InVision, and Photoshop were used to design and test the user interface.', 'UX UI Design', 'assets/img/projects/E-commerce_UX.jpg', '', '2024-02-05', 'ShopSphere', 'Reducing cart abandonment and improving mobile experience.', 'Designed wireframes and tested prototypes with users to optimize the purchasing journey.', 'Reduced bounce rate and improved sales conversion by 22%.', '19,21');

INSERT INTO projects (id, title, short_description, full_description, category, image_url, gallery_images, completion_date, client, challenges, solutions, outcome, related_projects) VALUES
(21, 'Dashboard UI Design', 'A clean, intuitive dashboard interface design for data visualization and business analytics.', 'Designed a responsive dashboard interface for data visualization using tools like Figma, Illustrator, and Protopie. The UI focused on clarity, responsiveness, and quick insights for business decision-making.', 'UX UI Design', 'assets/img/projects/Dashboard_UI.avif', '', '2024-03-15', 'Insight360', 'Creating a dashboard that displays complex data in an easy-to-understand layout.', 'Developed component-based designs with consistent color schemes and iconography.', 'Improved data interpretation time and received positive client feedback on usability.', '19,20');

-- Technologies for UX UI Design projects
INSERT INTO project_technologies (project_id, tech_name) VALUES
(19, 'Figma'),
(19, 'Adobe XD'),
(19, 'Sketch'),

(20, 'Adobe XD'),
(20, 'InVision'),
(20, 'Photoshop'),

(21, 'Figma'),
(21, 'Illustrator'),
(21, 'Protopie');

-- Features for UX UI Design projects
INSERT INTO project_features (project_id, feature_text) VALUES
(19, 'User-centered design approach'),
(19, 'High-fidelity prototypes'),
(19, 'Enhanced accessibility compliance'),

(20, 'Optimized checkout flow'),
(20, 'Responsive design for mobile'),
(20, 'Conversion-optimized layouts'),

(21, 'Data visualization widgets'),
(21, 'Interactive dashboard elements'),
(21, 'Component-based scalable design');


-- Insert sample data for courses
INSERT INTO courses (category, name, short_description, description, image, icon, duration, level) VALUES
('Programming', 'Python', 'Learn Python programming from basics to advanced concepts', 'Python is a high-level, interpreted programming language known for its readability and versatility. This comprehensive course covers everything from basic syntax to advanced concepts like object-oriented programming, data analysis, and web development with Python frameworks. You ll learn through hands-on projects and real-world applications.', 'python-course.jpg', 'bi-filetype-py', '12 Weeks', 'Beginner to Advanced'),
('Development', 'Web Development', 'Master front-end and back-end web development technologies', 'Our Web Development course provides a comprehensive introduction to both front-end and back-end technologies. You ll learn HTML, CSS, JavaScript for creating responsive and interactive user interfaces. On the back-end, you ll explore server-side programming, database integration, and API development. By the end of this course, you ll be able to build complete, functional websites from scratch.', 'web-development.jpg', 'bi-globe', '16 Weeks', 'Intermediate'),
('Full Stack', 'MERN Stack', 'Build full-stack applications with MongoDB, Express, React, and Node.js', 'The MERN Stack course teaches you how to build modern web applications using MongoDB, Express.js, React, and Node.js. This powerful combination allows you to create dynamic, data-driven applications with a JavaScript-based technology stack. You ll learn state management, RESTful API design, authentication, and deployment strategies for full-stack applications.', 'mern-stack.jpg', 'bi-stack', '20 Weeks', 'Advanced'),
('Programming', 'JavaScript', 'Master the fundamentals of JavaScript for dynamic web development', 'This course covers JavaScript from the basics to advanced topics. You will learn about data types, functions, objects, DOM manipulation, event handling, asynchronous programming with promises and async/await, and more. Hands-on projects will solidify your understanding.', 'javascript-course.jpg', 'bi-filetype-js', '10 Weeks', 'Beginner to Intermediate'),
('Programming', 'PHP & MySQL', 'Build dynamic websites with PHP and MySQL', 'Learn how to create dynamic web pages using PHP for server-side logic and MySQL for data storage. This course covers syntax, form handling, sessions, database connections, CRUD operations, and security best practices.', 'php-mysql-course.jpg', 'bi-database', '12 Weeks', 'Beginner to Intermediate'),
('Programming', 'React JS', 'Learn to build reactive user interfaces with React', 'React JS is a powerful front-end library for building user interfaces. This course covers JSX, components, props, state, lifecycle methods, hooks, and integrating APIs. You will build interactive SPAs with best practices and modern tools.', 'react-course.jpg', 'bi-filetype-jsx', '10 Weeks', 'Intermediate'),
('Programming', 'Angular JS', 'Develop scalable applications using Angular JS framework', 'Explore AngularJS and build structured web applications. You’ll learn about modules, controllers, directives, two-way data binding, services, and routing. The course also introduces RESTful communication and form validation.', 'angular-course.jpg', 'bi-code-slash', '10 Weeks', 'Intermediate'),
('Programming', 'Java', 'Comprehensive Java programming course for building robust applications', 'This Java course covers the fundamentals of object-oriented programming using Java. You will learn syntax, classes, inheritance, interfaces, exception handling, collections, file I/O, and multithreading. The course also introduces GUI development and JDBC for database interaction.', 'java-course.jpg', 'bi-cup-hot', '14 Weeks', 'Beginner to Intermediate'),
('Programming', 'C & C++', 'Master C and C++ programming for system-level and application development', 'Learn both C and C++ from the ground up. This course covers C basics like pointers, memory management, and file handling, and C++ features such as classes, objects, templates, and the Standard Template Library (STL). Ideal for understanding low-level programming and object-oriented concepts.', 'c-cpp-course.jpg', 'bi-terminal', '14 Weeks', 'Beginner to Intermediate'),
('Development', 'App Development', 'Design and build mobile applications for Android and iOS', 'This course covers the fundamentals of mobile app development using tools like Flutter and React Native. You will learn UI/UX design principles, app architecture, state management, API integration, and deployment to app stores.', 'app-development.jpg', 'bi-phone', '14 Weeks', 'Intermediate'),
('Development', 'Front End Development', 'Master the art of crafting user interfaces with HTML, CSS, and JavaScript', 'Front End Development course focuses on building modern, responsive, and interactive user interfaces using HTML5, CSS3, JavaScript, and popular frameworks like Bootstrap. You ll also explore UI/UX principles, accessibility, and performance optimization.', 'front-end.jpg', 'bi-layers', '12 Weeks', 'Beginner to Intermediate'),
('Development', 'Backend Development (PHP)', 'Learn server-side development using PHP and MySQL', 'This course teaches how to handle server-side operations using PHP. You will build dynamic websites, perform database operations with MySQL, manage sessions, handle file uploads, and implement security best practices.', 'backend-php.jpg', 'bi-hdd-network', '12 Weeks', 'Intermediate'),
('Development', 'Backend Development (Python)', 'Develop robust backend systems using Python frameworks like Django and Flask', 'This course introduces Python backend development using frameworks such as Flask and Django. You’ll learn routing, database integration, user authentication, REST API creation, and deployment strategies.', 'backend-python.jpg', 'bi-server', '12 Weeks', 'Intermediate'),
('Full Stack', 'MEAN Stack', 'Build full-stack apps using MongoDB, Express, Angular, and Node.js', 'The MEAN Stack course teaches you to develop modern, scalable applications using Angular for front-end and Node.js/Express for back-end with MongoDB as the database. Learn routing, services, REST API, JWT authentication, and deployment.', 'mean-stack.jpg', 'bi-bricks', '20 Weeks', 'Advanced'),
('Full Stack', 'Python Full Stack', 'Develop full-stack apps with Python, Django/Flask, and modern front-end tools', 'Learn both front-end and back-end development using HTML, CSS, JavaScript, along with Python-based frameworks like Django or Flask. Topics include ORM, authentication, REST APIs, and deploying complete applications.', 'python-fullstack.jpg', 'bi-diagram-3', '20 Weeks', 'Intermediate to Advanced'),
('Full Stack', 'PHP Full Stack', 'End-to-end web development using PHP, MySQL, HTML, CSS, and JS', 'This course covers building dynamic web apps using PHP and MySQL for the backend and HTML, CSS, JS (with frameworks) for the frontend. Includes session management, MVC architecture, and deployment.', 'php-fullstack.jpg', 'bi-layers-half', '18 Weeks', 'Intermediate'),
('Full Stack', 'Java Full Stack', 'Full-stack web development with Java Spring Boot and modern front-end', 'Master full-stack development using Java (Spring Boot) for backend, with frontend technologies like Angular or React. Includes database connectivity, REST API development, security, and deployment.', 'java-fullstack.jpg', 'bi-collection', '20 Weeks', 'Advanced'),
('Design', 'UX UI Design', 'Design user-friendly and visually appealing interfaces', 'Learn the principles of user experience and user interface design. This course covers wireframing, prototyping, design systems, usability testing, and tools like Figma and Adobe XD.', 'ux-ui.jpg', 'bi-layout-text-window-reverse', '10 Weeks', 'Beginner to Intermediate'),
('Design', 'Graphic Design', 'Master the art of visual communication', 'This course teaches the fundamentals of graphic design including typography, color theory, composition, branding, and visual storytelling using tools like Adobe Photoshop, Illustrator, and Canva.', 'graphic-design.jpg', 'bi-palette', '12 Weeks', 'Beginner'),
('Design', 'Web Design', 'Design modern, responsive, and accessible websites', 'This course focuses on designing websites with a balance of functionality and aesthetics. Learn layout principles, responsive design, HTML/CSS basics, and web design tools.', 'web-design.jpg', 'bi-pc-display-horizontal', '10 Weeks', 'Beginner to Intermediate'),
('Professional', 'Digital Marketing', 'Learn SEO, SEM, social media, and online strategy', 'This comprehensive course covers digital marketing strategies such as search engine optimization (SEO), pay-per-click (PPC), email marketing, social media, and analytics using tools like Google Ads and Meta Business Suite.', 'digital-marketing.jpg', 'bi-broadcast', '10 Weeks', 'Intermediate'),
('Professional', 'Data Science', 'Extract insights from data using Python, statistics, and machine learning', 'Learn to clean, analyze, and visualize data using Python libraries like Pandas, NumPy, and Matplotlib. Build predictive models using machine learning techniques with scikit-learn.', 'data-science.jpg', 'bi-bar-chart', '16 Weeks', 'Advanced');

-- Insert sample data for course syllabus
INSERT INTO course_syllabus (course_id, section_number, section_title, section_content) VALUES
(1, 1, 'Introduction to Python', 'Overview of Python, Installation and setup, Basic syntax, Variables and data types, Control structures'),
(1, 2, 'Data Structures in Python', 'Lists, Tuples, Dictionaries, Sets, Working with collections'),
(1, 3, 'Functions and Modules', 'Defining functions, Parameters and return values, Lambda functions, Creating and importing modules'),
(1, 4, 'Object-Oriented Programming', 'Classes and objects, Inheritance, Polymorphism, Encapsulation, Magic methods'),
(1, 5, 'File Handling and Exception Management', 'Reading and writing files, Working with CSV and JSON, Exception handling, Custom exceptions'),

(2, 1, 'HTML Fundamentals', 'Document structure, Elements and attributes, Forms, Semantic HTML, Accessibility'),
(2, 2, 'CSS', 'Selectors, Box model, Flexbox, Grid, Responsive design, CSS frameworks'),
(2, 3, 'JavaScript', 'Syntax, DOM manipulation, Events, Asynchronous JavaScript, ES6+ features'),
(2, 4, 'Backend Development', 'Server-side programming, RESTful APIs, Database integration, Authentication'),
(2, 5, 'Web Hosting', 'Deployment options, Domain management, SSL certificates, Performance optimization'),

(3, 1, 'MongoDB', 'NoSQL databases, CRUD operations, Schema design, Aggregation framework, Indexing'),
(3, 2, 'Express.js', 'Server setup, Routing, Middleware, Error handling, API development'),
(3, 3, 'React', 'Components, JSX, State and props, Hooks, Context API, Redux'),
(3, 4, 'Node.js', 'Event loop, Modules, File system, Streams, Authentication'),
(3, 5, 'Project - Designing A Complete Website', 'Full-stack application development, State management, Authentication, Deployment, Testing'),

(4, 1, 'JavaScript Basics', 'Variables, Data types, Operators, Control flow'),
(4, 2, 'Functions and Objects', 'Function declarations, Arrow functions, Object creation and manipulation'),
(4, 3, 'DOM Manipulation', 'Selecting elements, Modifying DOM, Event handling'),
(4, 4, 'Advanced JavaScript', 'Closures, Scope, Prototypes, this keyword, ES6+ features'),
(4, 5, 'Asynchronous JavaScript', 'Callbacks, Promises, Async/Await, Fetch API'),

-- PHP & MySQL Course Syllabus
(5, 1, 'PHP Basics', 'Syntax, Variables, Control structures, Functions'),
(5, 2, 'Forms and Sessions', 'Form handling, Sessions, Cookies'),
(5, 3, 'MySQL Integration', 'Connecting to database, SELECT, INSERT, UPDATE, DELETE queries'),
(5, 4, 'CRUD Operations', 'Building a complete CRUD app with PHP & MySQL'),
(5, 5, 'Security and Deployment', 'Input validation, SQL injection prevention, Hosting PHP apps'),

-- React JS Course Syllabus
(6, 1, 'Introduction to React', 'JSX, Components, Props, State'),
(6, 2, 'Hooks and Lifecycle', 'useState, useEffect, useRef, Custom hooks'),
(6, 3, 'Routing and Forms', 'React Router, Form handling, Controlled components'),
(6, 4, 'State Management', 'Context API, Redux basics, useReducer'),
(6, 5, 'API Integration and Deployment', 'Fetching data, Error handling, Build and deploy'),

-- Angular JS Course Syllabus
(7, 1, 'AngularJS Basics', 'Introduction, MVC architecture, Setup and structure'),
(7, 2, 'Controllers and Directives', 'ng-controller, Custom directives, Templates'),
(7, 3, 'Data Binding and Services', 'Two-way binding, Dependency Injection, Services'),
(7, 4, 'Routing and Forms', 'ngRoute module, Single Page Applications, Form validation'),
(7, 5, 'REST APIs and Deployment', 'HTTP requests, Interacting with REST APIs, Deployment techniques'),

(8, 1, 'Java Basics', 'Syntax, Variables, Data types, Operators, Control flow'),
(8, 2, 'Object-Oriented Programming', 'Classes, Objects, Inheritance, Interfaces, Polymorphism'),
(8, 3, 'Exception Handling and Collections', 'Try-catch blocks, Custom exceptions, ArrayList, HashMap'),
(8, 4, 'File Handling and Multithreading', 'FileReader, FileWriter, Threads, Synchronization'),
(8, 5, 'GUI and Database', 'Swing/AWT basics, JDBC connection, SQL operations'),

-- C & C++ Course Syllabus
(9, 1, 'C Fundamentals', 'Syntax, Data types, Operators, Control statements'),
(9, 2, 'Pointers and Memory Management', 'Pointers, Dynamic memory, malloc/free'),
(9, 3, 'Structures and File Handling', 'Structs, File I/O operations'),
(9, 4, 'C++ OOP Concepts', 'Classes, Constructors, Inheritance, Polymorphism'),
(9, 5, 'Templates and STL', 'Function templates, Class templates, Vector, Map, Set from STL'),

(10, 1, 'Introduction to App Development', 'Platforms, Tools (Flutter/React Native), Environment Setup'),
(10, 2, 'UI Design and Components', 'Widgets, Layouts, Navigation, Styling'),
(10, 3, 'State Management and Storage', 'Provider, Redux, Local Storage, Shared Preferences'),
(10, 4, 'API Integration and Firebase', 'Fetching data, Firebase setup, Authentication'),
(10, 5, 'Testing and Deployment', 'Debugging, Testing, Publishing to Play Store and App Store'),

-- Front End Development Syllabus
(11, 1, 'HTML & CSS', 'Semantic HTML, Forms, Layouts, Flexbox, Grid'),
(11, 2, 'JavaScript Basics', 'Variables, Functions, DOM Manipulation, Events'),
(11, 3, 'Advanced JavaScript & ES6', 'Arrow functions, Promises, Modules'),
(11, 4, 'Front-End Frameworks', 'Bootstrap, Tailwind, Material Design'),
(11, 5, 'UI/UX & Accessibility', 'Design principles, Responsive design, ARIA, Performance'),

-- Backend Development (PHP) Syllabus
(12, 1, 'PHP Basics and Syntax', 'Variables, Arrays, Control Flow, Functions'),
(12, 2, 'Working with Forms and Sessions', 'GET/POST, Validation, Sessions, Cookies'),
(12, 3, 'Database with MySQL', 'CRUD operations, Joins, Queries, PDO/MySQLi'),
(12, 4, 'Authentication and Security', 'Login systems, Hashing, CSRF, SQL Injection prevention'),
(12, 5, 'REST API and Hosting', 'Creating APIs with PHP, JSON, Deployment'),

-- Backend Development (Python) Syllabus
(13, 1, 'Python and Flask/Django Basics', 'Introduction, Project setup, Views and URLs'),
(13, 2, 'Templates and Static Files', 'Jinja templating, Forms, Bootstrap integration'),
(13, 3, 'Models and Databases', 'ORM, Migrations, SQLLite/PostgreSQL'),
(13, 4, 'Authentication and Authorization', 'User login, Sessions, Permissions'),
(13, 5, 'REST APIs and Deployment', 'Django REST Framework/Flask API, Hosting on Heroku/VPS'),

(14, 1, 'MongoDB', 'Schema design, CRUD operations, Aggregation, Indexing'),
(14, 2, 'Express.js', 'Routing, Middleware, REST APIs, JWT Authentication'),
(14, 3, 'Angular', 'Components, Data binding, Services, Routing, Forms'),
(14, 4, 'Node.js', 'File handling, Events, Modules, Server creation'),
(14, 5, 'Project Deployment', 'Full-stack integration, Hosting, Testing, CI/CD'),

-- Python Full Stack Syllabus
(15, 1, 'Front-End Basics', 'HTML, CSS, JavaScript fundamentals, Responsive design'),
(15, 2, 'Python and Django/Flask', 'Routing, Templates, ORM, Views'),
(15, 3, 'User Management and Security', 'Authentication, Sessions, CSRF, Permissions'),
(15, 4, 'REST API with DRF/Flask API', 'API development, Serializers, JSON, JWT'),
(15, 5, 'Deployment and DevOps', 'Using Heroku/VPS, Docker, GitHub Actions'),

-- PHP Full Stack Syllabus
(16, 1, 'Frontend Technologies', 'HTML, CSS, JavaScript, jQuery, Bootstrap'),
(16, 2, 'PHP Backend Basics', 'Syntax, Forms, Sessions, File Handling'),
(16, 3, 'Database with MySQL', 'CRUD operations, Joins, Security'),
(16, 4, 'MVC with PHP', 'Custom MVC structure, Routing, Controllers, Views'),
(16, 5, 'Final Project and Deployment', 'Building and deploying a full app, cPanel/VPS'),

-- Java Full Stack Syllabus
(17, 1, 'Frontend with Angular/React', 'Components, Services, Routing, State management'),
(17, 2, 'Java and Spring Boot', 'Controllers, Services, Repositories, Spring Security'),
(17, 3, 'Database Integration', 'JPA, Hibernate, MySQL/PostgreSQL'),
(17, 4, 'RESTful Web Services', 'CRUD API, JWT authentication, Error handling'),
(17, 5, 'Full-stack Integration and Deployment', 'API consumption, CI/CD, Docker, Cloud hosting'),

(18, 1, 'UX Foundations', 'User research, Personas, Information architecture, User flows'),
(18, 2, 'UI Principles', 'Layout, Typography, Color theory, Grids'),
(18, 3, 'Wireframing & Prototyping', 'Low to high fidelity designs, Tools: Figma, Adobe XD'),
(18, 4, 'Usability Testing', 'A/B Testing, Heuristics, Feedback collection'),
(18, 5, 'Project Work', 'End-to-end UX/UI case study project'),

-- Graphic Design
(19, 1, 'Design Basics', 'Elements of design, Visual hierarchy, Color theory'),
(19, 2, 'Typography & Branding', 'Fonts, Logo design, Brand guidelines'),
(19, 3, 'Image Editing & Illustration', 'Photoshop, Illustrator tools and techniques'),
(19, 4, 'Print & Digital Media', 'Posters, Brochures, Social media content'),
(19, 5, 'Portfolio Creation', 'Building a graphic design portfolio'),

-- Web Design
(20, 1, 'HTML & CSS Basics', 'Structure, Semantic HTML, Responsive CSS'),
(20, 2, 'Web Layouts', 'Flexbox, Grid, Component design'),
(20, 3, 'Design Tools', 'Figma, Adobe XD, Canva'),
(20, 4, 'UX Considerations', 'Navigation, Accessibility, Mobile-first'),
(20, 5, 'Website Mockup Project', 'Create a full responsive website design'),

-- Digital Marketing
(21, 1, 'Digital Marketing Overview', 'Inbound/Outbound, Strategy building'),
(21, 2, 'SEO & SEM', 'On-page/off-page SEO, Google Ads, Keyword research'),
(21, 3, 'Social Media Marketing', 'Meta Ads, Instagram, LinkedIn, YouTube strategies'),
(21, 4, 'Email Marketing & Analytics', 'Email campaigns, Google Analytics, ROI tracking'),
(21, 5, 'Capstone Project', 'Develop a full campaign strategy'),

-- Data Science
(22, 1, 'Python for Data Analysis', 'NumPy, Pandas, Data wrangling'),
(22, 2, 'Data Visualization', 'Matplotlib, Seaborn, Plotly'),
(22, 3, 'Statistics & Probability', 'Descriptive stats, Hypothesis testing, Distributions'),
(22, 4, 'Machine Learning Basics', 'Regression, Classification, Clustering'),
(22, 5, 'Final Project', 'Build and present a complete data science pipeline');




-- Insert data for Workshop topics
-- Insert sample data for 1-Day Workshop topics
INSERT INTO workshops (duration, name, short_description, description, image, icon) VALUES
('1-Day', 'Full Stack Introduction', 'An introduction to full-stack web development.', 'This workshop will provide an overview of full-stack web development, including front-end and back-end technologies. You will get hands-on experience with basic HTML, CSS, JavaScript, and an introduction to server-side programming.', 'full-stack-intro.jpg', 'bi-layers-half'),
('1-Day', 'Data Analytics Basics', 'Learn the fundamentals of data analytics and visualization.', 'In this session, we will cover the basics of data analytics, including data cleaning, analysis, and visualization. You will get hands-on experience with tools like Excel, Google Analytics, and Tableau.', 'data-analytics-basics.jpg', 'bi-bar-chart'),
('1-Day', 'Intro to Cybersecurity', 'A beginner’s guide to cybersecurity essentials.', 'This workshop will introduce key cybersecurity concepts such as encryption, network security, and threat detection. You will learn about common cyber threats and ways to protect your devices and systems.', 'intro-cybersecurity.jpg', 'bi-shield-lock'),
('1-Day', 'UI/UX Design Basics', 'Learn the fundamental principles of UI/UX design.', 'This workshop will cover the essential principles of user interface and user experience design. You will learn how to design intuitive and attractive user interfaces, as well as how to prototype using tools like Figma and Adobe XD.', 'ui-ux-basics.jpg', 'bi-layout-text-window-reverse'),
('1-Day', 'Digital Marketing Overview', 'Get an overview of digital marketing strategies and tools.', 'In this introductory workshop, you will learn about various digital marketing techniques such as SEO, PPC, and social media marketing. We will also explore analytics tools to track performance and conversions.', 'digital-marketing-overview.jpg', 'bi-broadcast'),

-- Insert sample data for 2-Day Workshop topics
('2-Days', 'Intro to Machine Learning', 'Introduction to basic machine learning algorithms and models.', 'In this two-day workshop, you will be introduced to machine learning concepts such as supervised and unsupervised learning. Learn to implement models using Python and libraries like Scikit-learn and TensorFlow.', 'intro-machine-learning.jpg', 'bi-lightbulb'),
('2-Days', 'IOT Fundamentals', 'Understand the core concepts of IoT systems and devices.', 'This workshop covers the fundamentals of the Internet of Things (IoT). You will learn about IoT devices, sensors, and protocols. Hands-on experience with IoT platforms and building simple connected devices will be part of the workshop.', 'iot-fundamentals.jpg', 'bi-plug'),
('2-Days', 'Cloud Computing Intro', 'A basic introduction to cloud computing concepts and services.', 'This two-day workshop will cover cloud computing essentials, including virtual machines, cloud storage, and compute resources. You will learn about key platforms like AWS and Google Cloud.', 'cloud-computing-intro.jpg', 'bi-cloud'),
('2-Days', 'Web Development Essentials', 'Learn the fundamentals of building dynamic web applications.', 'This workshop introduces you to the basics of web development, including HTML, CSS, and JavaScript. You will also explore the fundamentals of responsive design and basic web frameworks like React or Angular.', 'web-development-essentials.jpg', 'bi-laptop'),
('2-Days', 'App Development Crash Course', 'Learn the basics of mobile app development for Android and iOS.', 'In this crash course, you will learn the basics of mobile app development, including how to use React Native or Flutter for cross-platform development. You will build simple apps and get familiar with deployment.', 'app-development-crash.jpg', 'bi-phone'),

-- Insert sample data for 5-Day Workshop topics
('5-Days', 'Full Stack Crash Course', 'Dive deep into full-stack web development and build a complete app.', 'This intensive workshop will take you through the essentials of both front-end and back-end development. You will work with HTML, CSS, JavaScript, Node.js, Express, and MongoDB to create a fully functioning web application.', 'full-stack-crash.jpg', 'bi-layers'),
('5-Days', 'Data Science Toolkit', 'Learn the tools and techniques for effective data science projects.', 'This workshop will introduce you to the essential data science tools and techniques, including data cleaning, visualization, and machine learning models. You will use Python, Pandas, Matplotlib, and Scikit-learn.', 'data-science-toolkit.jpg', 'bi-bar-chart-line'),
('5-Days', 'Advanced AI and ML', 'Explore deep learning, neural networks, and advanced ML techniques.', 'This workshop covers advanced topics in artificial intelligence and machine learning, including neural networks, deep learning models, and reinforcement learning. You will work with libraries such as TensorFlow and PyTorch.', 'advanced-ai-ml.jpg', 'bi-robot'),
('5-Days', 'Blockchain Development', 'Learn to develop decentralized applications using blockchain.', 'In this workshop, you will dive into blockchain technology, including smart contracts and decentralized applications (dApps). You will learn to use Ethereum and Solidity to create smart contracts and deploy them to the blockchain.', 'blockchain-dev.jpg', 'bi-pc-display-horizontal'),
('5-Days', 'DevOps Fundamentals', 'Learn the basics of DevOps and automation tools for CI/CD.', 'This workshop focuses on the fundamentals of DevOps, including continuous integration (CI), continuous delivery (CD), and automation tools like Docker, Kubernetes, and Jenkins. You will build and deploy applications using DevOps best practices.', 'devops-fundamentals.jpg', 'bi-cogs'),

-- Insert sample data for 1-Week Workshop topics
('1-Week', 'Full Stack Development Project', 'Build a real-world full-stack application with front-end and back-end integration.', 'In this one-week workshop, you will work on building a full-stack web application. You will use front-end technologies like React or Angular, and back-end tools like Node.js, Express, and MongoDB. Deploy your project to the cloud.', 'full-stack-project.jpg', 'bi-layers-half'),
('1-Week', 'Data Analytics with Real Datasets', 'Work with real-world datasets and gain hands-on experience in data analysis.', 'In this workshop, you will work with real-world datasets to perform data cleaning, analysis, and visualization using tools like Excel, Python, and Tableau. You will also learn to present your findings effectively.', 'data-analytics-real.jpg', 'bi-graph-up'),

-- Insert sample data for 2-Week Workshop topics
('2-Weeks', 'Applied Machine Learning Projects', 'Work on real-world ML projects using Python and libraries.', 'In this two-week workshop, you will apply machine learning techniques to solve real-world problems. You will build models using Scikit-learn and TensorFlow, focusing on projects such as classification, regression, and clustering.', 'applied-ml-projects.jpg', 'bi-lightbulb'),
('2-Weeks', 'Cybersecurity Lab Intensive', 'Hands-on cybersecurity training and real-world defense techniques.', 'This workshop will provide you with hands-on experience in defending against cyber threats. You will work on practical exercises involving penetration testing, network security, and ethical hacking.', 'cybersecurity-lab.jpg', 'bi-shield-lock'),

-- Insert sample data for 3-Week Workshop topics
('3-Weeks', 'Data Science & AI Capstone', 'Develop and present a comprehensive data science or AI project.', 'In this three-week workshop, you will work on a data science or AI project from start to finish. You will gather and preprocess data, build machine learning models, and present your findings using advanced techniques in Python and AI frameworks.', 'data-science-ai-capstone.jpg', 'bi-bar-chart-line'),
('3-Weeks', 'DevOps in Practice', 'Apply DevOps practices to real-world development and operations tasks.', 'This intensive workshop will immerse you in the practices of DevOps, including automation, CI/CD pipelines, and deployment strategies. You will work with Docker, Kubernetes, Jenkins, and GitHub Actions to deploy real-world applications.', 'devops-in-practice.jpg', 'bi-layers'),
('3-Weeks', 'Cloud + IoT Integration Project', 'Build cloud-connected IoT systems for data collection and control.', 'In this workshop, you will work on an IoT project integrated with cloud services. You will learn how to collect data from IoT devices, analyze it on cloud platforms, and create real-time data dashboards using AWS or Google Cloud.', 'cloud-iot-integration.jpg', 'bi-cloud');



INSERT INTO workshop_syllabus (workshop_id, section_number, section_title, section_content, workshop_type) VALUES 
('1', '1', 'Full Stack Introduction - Part 1', 'Content for Full Stack Introduction session 1 (duration: 1-day)', '1-day'),
('1', '2', 'Full Stack Introduction - Part 2', 'Content for Full Stack Introduction session 2 (duration: 1-day)', '1-day'),
('1', '3', 'Full Stack Introduction - Part 3', 'Content for Full Stack Introduction session 3 (duration: 1-day)', '1-day'),
('1', '4', 'Full Stack Introduction - Part 4', 'Content for Full Stack Introduction session 4 (duration: 1-day)', '1-day'),
('1', '5', 'Full Stack Introduction - Part 5', 'Content for Full Stack Introduction session 5 (duration: 1-day)', '1-day'),
('2', '1', 'Data Analytics Basics - Part 1', 'Content for Data Analytics Basics session 1 (duration: 1-day)', '1-day'),
('2', '2', 'Data Analytics Basics - Part 2', 'Content for Data Analytics Basics session 2 (duration: 1-day)', '1-day'),
('2', '3', 'Data Analytics Basics - Part 3', 'Content for Data Analytics Basics session 3 (duration: 1-day)', '1-day'),
('2', '4', 'Data Analytics Basics - Part 4', 'Content for Data Analytics Basics session 4 (duration: 1-day)', '1-day'),
('2', '5', 'Data Analytics Basics - Part 5', 'Content for Data Analytics Basics session 5 (duration: 1-day)', '1-day'),
('3', '1', 'Intro to Cybersecurity - Part 1', 'Content for Intro to Cybersecurity session 1 (duration: 1-day)', '1-day'),
('3', '2', 'Intro to Cybersecurity - Part 2', 'Content for Intro to Cybersecurity session 2 (duration: 1-day)', '1-day'),
('3', '3', 'Intro to Cybersecurity - Part 3', 'Content for Intro to Cybersecurity session 3 (duration: 1-day)', '1-day'),
('3', '4', 'Intro to Cybersecurity - Part 4', 'Content for Intro to Cybersecurity session 4 (duration: 1-day)', '1-day'),
('3', '5', 'Intro to Cybersecurity - Part 5', 'Content for Intro to Cybersecurity session 5 (duration: 1-day)', '1-day'),
('4', '1', 'UI/UX Design Basics - Part 1', 'Content for UI/UX Design Basics session 1 (duration: 1-day)', '1-day'),
('4', '2', 'UI/UX Design Basics - Part 2', 'Content for UI/UX Design Basics session 2 (duration: 1-day)', '1-day'),
('4', '3', 'UI/UX Design Basics - Part 3', 'Content for UI/UX Design Basics session 3 (duration: 1-day)', '1-day'),
('4', '4', 'UI/UX Design Basics - Part 4', 'Content for UI/UX Design Basics session 4 (duration: 1-day)', '1-day'),
('4', '5', 'UI/UX Design Basics - Part 5', 'Content for UI/UX Design Basics session 5 (duration: 1-day)', '1-day'),
('5', '1', 'Digital Marketing Overview - Part 1', 'Content for Digital Marketing Overview session 1 (duration: 1-day)', '1-day'),
('5', '2', 'Digital Marketing Overview - Part 2', 'Content for Digital Marketing Overview session 2 (duration: 1-day)', '1-day'),
('5', '3', 'Digital Marketing Overview - Part 3', 'Content for Digital Marketing Overview session 3 (duration: 1-day)', '1-day'),
('5', '4', 'Digital Marketing Overview - Part 4', 'Content for Digital Marketing Overview session 4 (duration: 1-day)', '1-day'),
('5', '5', 'Digital Marketing Overview - Part 5', 'Content for Digital Marketing Overview session 5 (duration: 1-day)', '1-day'),
('6', '1', 'Intro to Machine Learning - Part 1', 'Content for Intro to Machine Learning session 1 (duration: 2-day)', '2-day'),
('6', '2', 'Intro to Machine Learning - Part 2', 'Content for Intro to Machine Learning session 2 (duration: 2-day)', '2-day'),
('6', '3', 'Intro to Machine Learning - Part 3', 'Content for Intro to Machine Learning session 3 (duration: 2-day)', '2-day'),
('6', '4', 'Intro to Machine Learning - Part 4', 'Content for Intro to Machine Learning session 4 (duration: 2-day)', '2-day'),
('6', '5', 'Intro to Machine Learning - Part 5', 'Content for Intro to Machine Learning session 5 (duration: 2-day)', '2-day'),
('7', '1', 'IOT Fundamentals - Part 1', 'Content for IOT Fundamentals session 1 (duration: 2-day)', '2-day'),
('7', '2', 'IOT Fundamentals - Part 2', 'Content for IOT Fundamentals session 2 (duration: 2-day)', '2-day'),
('7', '3', 'IOT Fundamentals - Part 3', 'Content for IOT Fundamentals session 3 (duration: 2-day)', '2-day'),
('7', '4', 'IOT Fundamentals - Part 4', 'Content for IOT Fundamentals session 4 (duration: 2-day)', '2-day'),
('7', '5', 'IOT Fundamentals - Part 5', 'Content for IOT Fundamentals session 5 (duration: 2-day)', '2-day'),
('8', '1', 'Cloud Computing Intro - Part 1', 'Content for Cloud Computing Intro session 1 (duration: 2-day)', '2-day'),
('8', '2', 'Cloud Computing Intro - Part 2', 'Content for Cloud Computing Intro session 2 (duration: 2-day)', '2-day'),
('8', '3', 'Cloud Computing Intro - Part 3', 'Content for Cloud Computing Intro session 3 (duration: 2-day)', '2-day'),
('8', '4', 'Cloud Computing Intro - Part 4', 'Content for Cloud Computing Intro session 4 (duration: 2-day)', '2-day'),
('8', '5', 'Cloud Computing Intro - Part 5', 'Content for Cloud Computing Intro session 5 (duration: 2-day)', '2-day'),
('9', '1', 'Web Development Essentials - Part 1', 'Content for Web Development Essentials session 1 (duration: 2-day)', '2-day'),
('9', '2', 'Web Development Essentials - Part 2', 'Content for Web Development Essentials session 2 (duration: 2-day)', '2-day'),
('9', '3', 'Web Development Essentials - Part 3', 'Content for Web Development Essentials session 3 (duration: 2-day)', '2-day'),
('9', '4', 'Web Development Essentials - Part 4', 'Content for Web Development Essentials session 4 (duration: 2-day)', '2-day'),
('9', '5', 'Web Development Essentials - Part 5', 'Content for Web Development Essentials session 5 (duration: 2-day)', '2-day'),
('10', '1', 'App Development Crash Course - Part 1', 'Content for App Development Crash Course session 1 (duration: 2-day)', '2-day'),
('10', '2', 'App Development Crash Course - Part 2', 'Content for App Development Crash Course session 2 (duration: 2-day)', '2-day'),
('10', '3', 'App Development Crash Course - Part 3', 'Content for App Development Crash Course session 3 (duration: 2-day)', '2-day'),
('10', '4', 'App Development Crash Course - Part 4', 'Content for App Development Crash Course session 4 (duration: 2-day)', '2-day'),
('10', '5', 'App Development Crash Course - Part 5', 'Content for App Development Crash Course session 5 (duration: 2-day)', '2-day'),
('11', '1', 'Full Stack Crash Course - Part 1', 'Content for Full Stack Crash Course session 1 (duration: 5-day)', '5-day'),
('11', '2', 'Full Stack Crash Course - Part 2', 'Content for Full Stack Crash Course session 2 (duration: 5-day)', '5-day'),
('11', '3', 'Full Stack Crash Course - Part 3', 'Content for Full Stack Crash Course session 3 (duration: 5-day)', '5-day'),
('11', '4', 'Full Stack Crash Course - Part 4', 'Content for Full Stack Crash Course session 4 (duration: 5-day)', '5-day'),
('11', '5', 'Full Stack Crash Course - Part 5', 'Content for Full Stack Crash Course session 5 (duration: 5-day)', '5-day'),
('12', '1', 'Data Science Toolkit - Part 1', 'Content for Data Science Toolkit session 1 (duration: 5-day)', '5-day'),
('12', '2', 'Data Science Toolkit - Part 2', 'Content for Data Science Toolkit session 2 (duration: 5-day)', '5-day'),
('12', '3', 'Data Science Toolkit - Part 3', 'Content for Data Science Toolkit session 3 (duration: 5-day)', '5-day'),
('12', '4', 'Data Science Toolkit - Part 4', 'Content for Data Science Toolkit session 4 (duration: 5-day)', '5-day'),
('12', '5', 'Data Science Toolkit - Part 5', 'Content for Data Science Toolkit session 5 (duration: 5-day)', '5-day'),
('13', '1', 'Advanced AI and ML - Part 1', 'Content for Advanced AI and ML session 1 (duration: 5-day)', '5-day'),
('13', '2', 'Advanced AI and ML - Part 2', 'Content for Advanced AI and ML session 2 (duration: 5-day)', '5-day'),
('13', '3', 'Advanced AI and ML - Part 3', 'Content for Advanced AI and ML session 3 (duration: 5-day)', '5-day'),
('13', '4', 'Advanced AI and ML - Part 4', 'Content for Advanced AI and ML session 4 (duration: 5-day)', '5-day'),
('13', '5', 'Advanced AI and ML - Part 5', 'Content for Advanced AI and ML session 5 (duration: 5-day)', '5-day'),
('14', '1', 'Blockchain Development - Part 1', 'Content for Blockchain Development session 1 (duration: 5-day)', '5-day'),
('14', '2', 'Blockchain Development - Part 2', 'Content for Blockchain Development session 2 (duration: 5-day)', '5-day'),
('14', '3', 'Blockchain Development - Part 3', 'Content for Blockchain Development session 3 (duration: 5-day)', '5-day'),
('14', '4', 'Blockchain Development - Part 4', 'Content for Blockchain Development session 4 (duration: 5-day)', '5-day'),
('14', '5', 'Blockchain Development - Part 5', 'Content for Blockchain Development session 5 (duration: 5-day)', '5-day'),
('15', '1', 'DevOps Fundamentals - Part 1', 'Content for DevOps Fundamentals session 1 (duration: 5-day)', '5-day'),
('15', '2', 'DevOps Fundamentals - Part 2', 'Content for DevOps Fundamentals session 2 (duration: 5-day)', '5-day'),
('15', '3', 'DevOps Fundamentals - Part 3', 'Content for DevOps Fundamentals session 3 (duration: 5-day)', '5-day'),
('15', '4', 'DevOps Fundamentals - Part 4', 'Content for DevOps Fundamentals session 4 (duration: 5-day)', '5-day'),
('15', '5', 'DevOps Fundamentals - Part 5', 'Content for DevOps Fundamentals session 5 (duration: 5-day)', '5-day'),
('16', '1', 'Full Stack Development Project - Part 1', 'Content for Full Stack Development Project session 1 (duration: 1-week)', '1-week'),
('16', '2', 'Full Stack Development Project - Part 2', 'Content for Full Stack Development Project session 2 (duration: 1-week)', '1-week'),
('16', '3', 'Full Stack Development Project - Part 3', 'Content for Full Stack Development Project session 3 (duration: 1-week)', '1-week'),
('16', '4', 'Full Stack Development Project - Part 4', 'Content for Full Stack Development Project session 4 (duration: 1-week)', '1-week'),
('16', '5', 'Full Stack Development Project - Part 5', 'Content for Full Stack Development Project session 5 (duration: 1-week)', '1-week'),
('17', '1', 'Data Analytics with Real Datasets - Part 1', 'Content for Data Analytics with Real Datasets session 1 (duration: 1-week)', '1-week'),
('17', '2', 'Data Analytics with Real Datasets - Part 2', 'Content for Data Analytics with Real Datasets session 2 (duration: 1-week)', '1-week'),
('17', '3', 'Data Analytics with Real Datasets - Part 3', 'Content for Data Analytics with Real Datasets session 3 (duration: 1-week)', '1-week'),
('17', '4', 'Data Analytics with Real Datasets - Part 4', 'Content for Data Analytics with Real Datasets session 4 (duration: 1-week)', '1-week'),
('17', '5', 'Data Analytics with Real Datasets - Part 5', 'Content for Data Analytics with Real Datasets session 5 (duration: 1-week)', '1-week'),
('18', '1', 'Applied Machine Learning Projects - Part 1', 'Content for Applied Machine Learning Projects session 1 (duration: 2-week)', '2-week'),
('18', '2', 'Applied Machine Learning Projects - Part 2', 'Content for Applied Machine Learning Projects session 2 (duration: 2-week)', '2-week'),
('18', '3', 'Applied Machine Learning Projects - Part 3', 'Content for Applied Machine Learning Projects session 3 (duration: 2-week)', '2-week'),
('18', '4', 'Applied Machine Learning Projects - Part 4', 'Content for Applied Machine Learning Projects session 4 (duration: 2-week)', '2-week'),
('18', '5', 'Applied Machine Learning Projects - Part 5', 'Content for Applied Machine Learning Projects session 5 (duration: 2-week)', '2-week'),
('19', '1', 'Cybersecurity Lab Intensive - Part 1', 'Content for Cybersecurity Lab Intensive session 1 (duration: 2-week)', '2-week'),
('19', '2', 'Cybersecurity Lab Intensive - Part 2', 'Content for Cybersecurity Lab Intensive session 2 (duration: 2-week)', '2-week'),
('19', '3', 'Cybersecurity Lab Intensive - Part 3', 'Content for Cybersecurity Lab Intensive session 3 (duration: 2-week)', '2-week'),
('19', '4', 'Cybersecurity Lab Intensive - Part 4', 'Content for Cybersecurity Lab Intensive session 4 (duration: 2-week)', '2-week'),
('19', '5', 'Cybersecurity Lab Intensive - Part 5', 'Content for Cybersecurity Lab Intensive session 5 (duration: 2-week)', '2-week'),
('20', '1', 'Data Science & AI Capstone - Part 1', 'Content for Data Science & AI Capstone session 1 (duration: 3-week)', '3-week'),
('20', '2', 'Data Science & AI Capstone - Part 2', 'Content for Data Science & AI Capstone session 2 (duration: 3-week)', '3-week'),
('20', '3', 'Data Science & AI Capstone - Part 3', 'Content for Data Science & AI Capstone session 3 (duration: 3-week)', '3-week'),
('20', '4', 'Data Science & AI Capstone - Part 4', 'Content for Data Science & AI Capstone session 4 (duration: 3-week)', '3-week'),
('20', '5', 'Data Science & AI Capstone - Part 5', 'Content for Data Science & AI Capstone session 5 (duration: 3-week)', '3-week'),
('21', '1', 'DevOps in Practice - Part 1', 'Content for DevOps in Practice session 1 (duration: 3-week)', '3-week'),
('21', '2', 'DevOps in Practice - Part 2', 'Content for DevOps in Practice session 2 (duration: 3-week)', '3-week'),
('21', '3', 'DevOps in Practice - Part 3', 'Content for DevOps in Practice session 3 (duration: 3-week)', '3-week'),
('21', '4', 'DevOps in Practice - Part 4', 'Content for DevOps in Practice session 4 (duration: 3-week)', '3-week'),
('21', '5', 'DevOps in Practice - Part 5', 'Content for DevOps in Practice session 5 (duration: 3-week)', '3-week'),
('22', '1', 'Cloud + IoT Integration Project - Part 1', 'Content for Cloud + IoT Integration Project session 1 (duration: 3-week)', '3-week'),
('22', '2', 'Cloud + IoT Integration Project - Part 2', 'Content for Cloud + IoT Integration Project session 2 (duration: 3-week)', '3-week'),
('22', '3', 'Cloud + IoT Integration Project - Part 3', 'Content for Cloud + IoT Integration Project session 3 (duration: 3-week)', '3-week'),
('22', '4', 'Cloud + IoT Integration Project - Part 4', 'Content for Cloud + IoT Integration Project session 4 (duration: 3-week)', '3-week'),
('22', '5', 'Cloud + IoT Integration Project - Part 5', 'Content for Cloud + IoT Integration Project session 5 (duration: 3-week)', '3-week');


