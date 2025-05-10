
USE Xoventa;

CREATE TABLE software_contact (
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
