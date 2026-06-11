-- Loan Management System Database Dump
-- Generated for MySQL Database

-- Create Database
CREATE DATABASE IF NOT EXISTS loan_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE loan_management;

-- Drop existing tables (if any)
DROP TABLE IF EXISTS repayments;
DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS personal_access_tokens;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS migrations;

-- Create users table
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mobile VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create loans table
CREATE TABLE loans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    tenure INT NOT NULL,
    purpose VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create repayments table
CREATE TABLE repayments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    loan_id BIGINT UNSIGNED NOT NULL,
    amount_paid DECIMAL(15, 2) NOT NULL,
    payment_date DATE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sessions table
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create personal_access_tokens table (for Sanctum)
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_tokenable_type_tokenable_id (tokenable_type, tokenable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create migrations table
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert migration records
INSERT INTO migrations (migration, batch) VALUES
('2024_01_01_000000_create_users_table', 1),
('2024_01_01_000001_create_loans_table', 1),
('2024_01_01_000002_create_repayments_table', 1),
('2024_01_01_000003_create_sessions_table', 1),
('2024_01_01_000004_create_personal_access_tokens_table', 1);

-- Insert admin user (password: admin123)
INSERT INTO users (name, email, mobile, password, role, created_at, updated_at) VALUES
('Admin User', 'admin@loan.com', '1234567890', '$2y$12$msqPy9Oskbf40L9sh78rdO3Tpab2N9I/P1K.05bsOyNBP37Po0XMe', 'admin', NOW(), NOW());

-- Insert sample customer users (password: password123)
INSERT INTO users (name, email, mobile, password, role, created_at, updated_at) VALUES
('John Doe', 'john@example.com', '9876543210', '$2y$12$eKXBB2eAk18beiea5Zgv7OP3wWb/77nmuiddI1fcOT8VESmDiIMYC', 'customer', NOW(), NOW()),
('Jane Smith', 'jane@example.com', '5555555555', '$2y$12$eKXBB2eAk18beiea5Zgv7OP3wWb/77nmuiddI1fcOT8VESmDiIMYC', 'customer', NOW(), NOW());

-- Insert sample loan applications
INSERT INTO loans (user_id, amount, tenure, purpose, status, created_at, updated_at) VALUES
(2, 10000.00, 12, 'Home renovation', 'pending', NOW(), NOW()),
(2, 5000.00, 6, 'Car purchase', 'approved', NOW(), NOW()),
(3, 15000.00, 24, 'Business startup', 'rejected', NOW(), NOW());

-- Insert sample repayments
INSERT INTO repayments (loan_id, amount_paid, payment_date, created_at, updated_at) VALUES
(2, 500.00, '2024-01-15', NOW(), NOW()),
(2, 500.00, '2024-02-15', NOW(), NOW());
