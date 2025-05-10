
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
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE internship_applications (
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


