-- Script SQL AstroGuida - Struttura base e seed dati

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    google_id VARCHAR(100),
    avatar VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (email, password, name, role) VALUES
('admin@astroguida.com', '$2y$10$testhash', 'Admin', 'admin'),
('utente@astroguida.com', '$2y$10$testhash', 'Utente Demo', 'user');

CREATE TABLE IF NOT EXISTS gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_size INT,
    is_featured BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_name VARCHAR(255) NOT NULL,
    booking_date DATE NOT NULL,
    contact_info TEXT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT
);

-- Seed dati gallery
INSERT INTO gallery_images (filename, title) VALUES
('m31.jpg', 'Galassia di Andromeda'),
('ngc7000.jpg', 'Nebulosa Nord America'),
('rosetta.jpg', 'Nebulosa Rosetta'); 