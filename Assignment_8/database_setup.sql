CREATE DATABASE IF NOT EXISTS college_portal;

USE college_portal;

CREATE TABLE IF NOT EXISTS students_info (
    stud_id INT PRIMARY KEY,
    stud_name VARCHAR(100) NOT NULL,
    `class` VARCHAR(50) NOT NULL,
    division VARCHAR(10) NOT NULL,
    city VARCHAR(100) NOT NULL
);

INSERT INTO students_info (stud_id, stud_name, `class`, division, city)
VALUES
    (1, 'Aarav Sharma', 'TYBSc', 'A', 'Pune'),
    (2, 'Ananya Patil', 'SYBCA', 'B', 'Mumbai'),
    (3, 'Rohan Deshmukh', 'FYBCom', 'A', 'Nashik'),
    (4, 'Priya Kulkarni', 'TYBCA', 'C', 'Nagpur'),
    (5, 'Kabir Joshi', 'SYBSc', 'B', 'Kolhapur')
ON DUPLICATE KEY UPDATE
    stud_name = VALUES(stud_name),
    `class` = VALUES(`class`),
    division = VALUES(division),
    city = VALUES(city);
