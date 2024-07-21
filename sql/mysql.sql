-- CREATE DATABASE test

-- USE UniversityManagement

CREATE TABLE admin(
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    gender VARCHAR(10),
    dateOfBirth DATE,
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    role VARCHAR(40),
    password VARCHAR(225),
    profile VARCHAR(225)
)

CREATE TABLE teacher(
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    gender VARCHAR(30),
    email VARCHAR(100),
    password VARCHAR(255),
    phone VARCHAR(20),
    dateOfBirth DATE,
    address VARCHAR(255),
    role VARCHAR(40),
    hiredDate DATE,
    profile VARCHAR(225)
)

CREATE TABLE student(
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    gender VARCHAR(15),
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    enroll_date DATE,
    class_id INT,
    department_id INT,
    paymentType VARCHAR(20),
    amount FLOAT,
    profile VARCHAR(225),
    CONSTRAINT FK_class_id FOREIGN KEY (class_id) REFERENCES class (class_id),
    CONSTRAINT FK_department_id FOREIGN KEY (department_id) REFERENCES department (department_id)
)

CREATE TABLE department(
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    departmentName VARCHAR(200),
    departmentHead INT,
    create_date DATE,
    CONSTRAINT FK_teacher_id FOREIGN KEY (teacher_id) REFERENCES teacher (teacher_id)
)

CREATE TABLE class(
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    className VARCHAR(100),
    department_id INT,
    studyTime VARCHAR(20),
    create_date DATE,
    CONSTRAINT FK_department_id FOREIGN KEY (department_id) REFERENCES department (department_id)
)

CREATE TABLE event(
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    eventName VARCHAR(200),
    eventDis VARCHAR(255),
    eventSD DATE,
    eventST TIME,
    eventED DATE,
    eventET TIME
)