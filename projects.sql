
USE Xoventa;

-- Create the projects table
CREATE TABLE projects (
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
CREATE TABLE project_technologies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  tech_name VARCHAR(100) NOT NULL,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create the project_features table
CREATE TABLE project_features (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  feature_text TEXT NOT NULL,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
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
