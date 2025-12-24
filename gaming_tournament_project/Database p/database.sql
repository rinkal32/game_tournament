
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100) UNIQUE,
 password VARCHAR(255),
 role ENUM('admin','player') DEFAULT 'player',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tournaments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(100),
 game_name VARCHAR(100),
 entry_fee INT,
 prize VARCHAR(100),
 status ENUM('Upcoming','Ongoing','Completed') DEFAULT 'Upcoming',
 created_by INT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tournament_players (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 tournament_id INT,
 joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE payments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 tournament_id INT,
 amount INT,
 payment_status VARCHAR(50),
 paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(100),
 password VARCHAR(255)
);

CREATE TABLE admin_payments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 tournament_id INT,
 amount INT,
 status VARCHAR(50)
);
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tournament_id INT,
    amount DECIMAL(10,2),
    payment_status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
