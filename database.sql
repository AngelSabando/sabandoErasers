CREATE TABLE IF NOT EXISTS professors (
    id SERIAL PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(50),
    salary DECIMAL(10, 2) NOT NULL,
    department VARCHAR(100) NOT NULL,
    hireDate DATE NOT NULL,
    officeLocation VARCHAR(100)
);

INSERT INTO professors (fullName, age, email, phone, salary, department, hireDate, officeLocation) VALUES 
('Alan Turing', 41, 'alan.turing@univ.edu', '555-0101', 85000.00, 'Computer Science', '2015-08-15', 'Building A, Room 101'),
('Ada Lovelace', 36, 'ada.lovelace@univ.edu', '555-0102', 92000.00, 'Mathematics', '2018-01-10', 'Building B, Room 205'),
('Grace Hopper', 45, 'grace.hopper@univ.edu', '555-0103', 88000.00, 'Computer Science', '2010-09-01', 'Building A, Room 102');
