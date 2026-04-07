CREATE DATABASE IF NOT EXISTS ebookshop;

USE ebookshop;

CREATE TABLE IF NOT EXISTS ebookshop (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_title VARCHAR(255) NOT NULL,
    book_author VARCHAR(255) NOT NULL,
    book_price DOUBLE NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO ebookshop (book_title, book_author, book_price, quantity)
VALUES
    ('The Alchemist', 'Paulo Coelho', 299.00, 15),
    ('Clean Code', 'Robert C. Martin', 499.00, 8),
    ('Java: The Complete Reference', 'Herbert Schildt', 650.00, 10);
