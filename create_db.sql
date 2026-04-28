-- إنشاء قاعدة البيانات e_library
CREATE DATABASE IF NOT EXISTS e_library;
USE e_library;

-- جدول المستخدمين
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- جدول المكتبات
CREATE TABLE IF NOT EXISTS libraries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- جدول الكتب
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    library_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    image VARCHAR(255),
    pdf VARCHAR(255),
    FOREIGN KEY (library_id) REFERENCES libraries(id) ON DELETE CASCADE
);

-- إدراج بيانات تجريبية
INSERT INTO libraries (name) VALUES ('الروايات'), ('العلوم'), ('التاريخ'), ('الطب'), ('الدين');

INSERT INTO books (library_id, title, author, image, pdf) VALUES
(1, 'رواية 1', 'مؤلف 1', 'imag/book1.jpg', 'book/book1.pdf'),
(2, 'كتاب علمي 1', 'مؤلف 2', 'imag/book2.jpg', 'book/book2.pdf');