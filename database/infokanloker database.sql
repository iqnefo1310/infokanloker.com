-- Create the database
CREATE DATABASE infokanlokerdotcom;

USE infokanlokerdotcom;

-- Tabel untuk detail pengguna (general users)
CREATE TABLE detail_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk login pengguna
CREATE TABLE user_logins (
    id INT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL,
    FOREIGN KEY (id) REFERENCES detail_users(id) ON DELETE CASCADE
);

-- Tabel untuk admin
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL
);

-- Tabel untuk perusahaan (companies)
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL
);

ALTER TABLE companies ADD COLUMN email VARCHAR(255) NOT NULL;

-- Tabel untuk kategori pekerjaan (job categories)
CREATE TABLE job_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Tabel untuk lowongan pekerjaan (job postings)
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100),
    salary DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES job_categories(id) ON DELETE CASCADE
);

-- Tabel untuk lamaran pekerjaan (job applications)
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    applicant_id INT NOT NULL,
    RESUME VARCHAR(255) NOT NULL,
    STATUS ENUM('dalam_proses', 'diterima', 'ditolak') DEFAULT 'dalam_proses',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (applicant_id) REFERENCES detail_users(id) ON DELETE CASCADE
);
