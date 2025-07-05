-- Script SQLite AstroGuida

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE NOT NULL,
    password TEXT,
    name TEXT NOT NULL,
    google_id TEXT,
    avatar TEXT,
    role TEXT DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT OR IGNORE INTO users (email, password, name, role) VALUES
('admin@astroguida.com', 'testhash', 'Admin', 'admin'),
('utente@astroguida.com', 'testhash', 'Utente Demo', 'user');

CREATE TABLE IF NOT EXISTS gallery_images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    filename TEXT NOT NULL,
    title TEXT,
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_size INTEGER,
    is_featured INTEGER DEFAULT 0
);

CREATE TABLE IF NOT EXISTS bookings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    service_name TEXT NOT NULL,
    booking_date DATE NOT NULL,
    contact_info TEXT,
    status TEXT DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    setting_key TEXT PRIMARY KEY,
    setting_value TEXT
);

INSERT OR IGNORE INTO gallery_images (filename, title) VALUES
('m31.jpg', 'Galassia di Andromeda'),
('ngc7000.jpg', 'Nebulosa Nord America'),
('rosetta.jpg', 'Nebulosa Rosetta'); 