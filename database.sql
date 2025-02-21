CREATE TABLE `admin` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE,
    `password` VARCHAR(255),
    `email` VARCHAR(100),
    `is_2fa_enabled` TINYINT(1) DEFAULT 0
);

CREATE TABLE `salesperson` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100),
    `phone` VARCHAR(20),
    `email` VARCHAR(100) UNIQUE,
    `address` TEXT,
    `aadhaar_number` VARCHAR(12) UNIQUE,
    `username` VARCHAR(50) UNIQUE,
    `password` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `client_visits` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `salesperson_id` INT,
    `client_name` VARCHAR(100),
    `client_phone` VARCHAR(20),
    `institute_name` VARCHAR(100),
    `visit_description` TEXT,
    `photo_1` VARCHAR(255),
    `photo_2` VARCHAR(255),
    `photo_3` VARCHAR(255),
    `status` ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    `admin_comment` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`salesperson_id`) REFERENCES `salesperson`(`id`) ON DELETE CASCADE
);

CREATE TABLE `login_attempts` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT,
    `role` ENUM('admin', 'salesperson'),
    `ip_address` VARCHAR(45),
    `attempt_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
