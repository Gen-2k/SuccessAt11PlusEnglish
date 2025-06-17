-- ============================================================================
-- SuccessAt11PlusEnglish Database Schema (Production-Ready)
-- ============================================================================

-- --------------------------------------------------------------------------
-- 0. Create and Use Database
-- --------------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS successat11plus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE successat11plus;

-- --------------------------------------------------------------------------
-- 1. Students Table: User Accounts (Students & Admins)
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique user ID
    fname VARCHAR(100) NOT NULL,       -- First name
    surname VARCHAR(100) NOT NULL,     -- Last name
    dob DATE,                         -- Date of birth
    gender VARCHAR(20),               -- Gender 
    parent_firstname VARCHAR(100),    -- Parent/guardian first name 
    parent_surname VARCHAR(100),      -- Parent/guardian last name 
    address TEXT,                     -- Home address
    email VARCHAR(150) NOT NULL,      -- Email (used for login)
    password VARCHAR(100) NOT NULL,   -- Hashed password
    phone VARCHAR(30),                -- Contact phone number
    yesorno ENUM('yes','no') DEFAULT 'yes', -- Terms and conditions
    role ENUM('user','admin') DEFAULT 'user', -- User type: 'user' or 'admin'
    user_session_id VARCHAR(100),     -- For session management/tracking
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record creation time
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, -- Last update
    UNIQUE KEY uq_students_email (email),
    INDEX idx_students_role (role),
    INDEX idx_students_session (user_session_id),
    INDEX idx_students_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- Initial Admin User Insert
-- --------------------------------------------------------------------------
INSERT INTO students (
    fname, surname, dob, gender, parent_firstname, parent_surname, address, email, password, phone, yesorno, role, user_session_id, created_at, updated_at
) VALUES (
    'Admin', 'User', NULL, NULL, NULL, NULL, NULL, 'admin@successat11plus.com', 'adminpassword', NULL, 'yes', 'admin', NULL, CURRENT_TIMESTAMP, NULL
)
ON DUPLICATE KEY UPDATE email=email;

-- --------------------------------------------------------------------------
-- 2. Enrollments Table: Module/Term Purchases & Access
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique enrollment ID
    student_id INT NOT NULL,           -- FK to students.id
    class VARCHAR(30),                 -- Class/year group (year4, year5, year6)
    module VARCHAR(100) NOT NULL,      -- Module name (e.g., "Year 4 - Comprehension Module")
    price DECIMAL(8,2) NOT NULL,       -- Price at time of purchase
    transaction_id VARCHAR(100),       -- Payment processor transaction/session ID
    payment_status ENUM('pending','paid','failed','refunded') DEFAULT 'pending', -- Payment state
    access_start DATE,                 -- Access start date 
    access_end DATE,                   -- Access end date 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record creation time
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, -- Last update
    CONSTRAINT fk_enrollments_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    INDEX idx_enrollments_student (student_id),
    INDEX idx_enrollments_module (module),
    INDEX idx_enrollments_class (class),
    INDEX idx_enrollments_status (payment_status),
    INDEX idx_enrollments_created (created_at),
    INDEX idx_enrollments_transaction (transaction_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- 3. Newsletter Table: Email Subscriptions
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS newsletter (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique subscription ID
    email VARCHAR(150) NOT NULL,      -- Subscriber email
    fname VARCHAR(100),               -- First name 
    lname VARCHAR(100),               -- Last name 
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Subscription time
    UNIQUE KEY uq_newsletter_email (email),
    INDEX idx_newsletter_subscribed (subscribed_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- 4. OTP Table: One-Time Passwords for Account Recovery/Verification
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS otp (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique OTP record ID
    email VARCHAR(150) NOT NULL,       -- Email OTP was sent to
    otp_code VARCHAR(10) NOT NULL,     -- The OTP code
    is_expired BOOLEAN DEFAULT FALSE,  -- Whether the OTP is expired/used
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- OTP creation time
    INDEX idx_otp_email (email),
    INDEX idx_otp_code (otp_code),
    INDEX idx_otp_expired (is_expired),
    INDEX idx_otp_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- 5. Resources Table: Homework, E-Books, and Learning Materials
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,                -- Unique resource ID
    resource_type ENUM('homework','activities','answers') NOT NULL, -- Type of resource (homework, activities, answers)
    class VARCHAR(30),                                -- Class/year group (e.g., year4, year5, year6)
    module VARCHAR(100),                              -- Module name (e.g., "Comprehension", "Creative Writing")
    title VARCHAR(255) NOT NULL,                      -- Resource title
    description TEXT,                                 -- Description/details
    file_name VARCHAR(255),                           -- File name (if any)
    file_path VARCHAR(255),                           -- File path (if any)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   -- Creation time
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP -- Last update
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- 6. E-Books Table: Dedicated Table for E-Books
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS ebooks (
    id INT AUTO_INCREMENT PRIMARY KEY,                -- Unique ebook ID
    class VARCHAR(30),                                -- Class/year group (e.g., year4, year5, year6)
    module VARCHAR(100),                              -- Module name (e.g., "Comprehension", "Creative Writing")
    title VARCHAR(255) NOT NULL,                      -- E-Book title
    description TEXT,                                 -- Description/details
    file_name VARCHAR(255),                           -- File name (if any)
    file_path VARCHAR(255),                           -- File path (if any)
    price DECIMAL(8,2),                               -- Price of the ebook
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   -- Creation time
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP -- Last update
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------------------
-- 7. Purchased E-Books Table: Tracks which students have purchased which ebooks
-- --------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS purchased_ebooks (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique purchase record ID
    student_id INT NOT NULL,                   -- FK to students.id
    ebook_id INT NOT NULL,                     -- FK to ebooks.id
    price DECIMAL(8,2),                        -- Price at time of purchase
    transaction_id VARCHAR(100),               -- Payment processor transaction/session ID
    payment_status ENUM('pending','paid','failed','refunded') DEFAULT 'pending', -- Payment state
    purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Purchase time
    CONSTRAINT fk_purchased_ebooks_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    CONSTRAINT fk_purchased_ebooks_ebook FOREIGN KEY (ebook_id) REFERENCES ebooks(id) ON DELETE CASCADE,
    UNIQUE KEY uq_purchased_ebooks_student_ebook (student_id, ebook_id), -- Prevent duplicate purchases
    INDEX idx_purchased_ebooks_student (student_id),
    INDEX idx_purchased_ebooks_ebook (ebook_id),
    INDEX idx_purchased_ebooks_transaction (transaction_id),
    INDEX idx_purchased_ebooks_status (payment_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- End of Schema
-- ============================================================================


