-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS business_card_db;
USE business_card_db;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    Organisation_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create the business_cards table
CREATE TABLE IF NOT EXISTS business_cards (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    company VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    website VARCHAR(100) NOT NULL,
    color VARCHAR(20) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the email_verification table
CREATE TABLE IF NOT EXISTS email_verification (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    otp VARCHAR(6) NOT NULL,
    verified TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);