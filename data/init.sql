CREATE DATABASE sprint2;

use sprint2;

-- Create tables

CREATE TABLE employees (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    position VARCHAR(50) NOT NULL
);


CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    customer VARCHAR(100) NOT NULL,
    budget VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE project_employee (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    employee_id INT NOT NULL
);

-- Seed database tables

INSERT INTO employees (firstname, lastname, email, position)  
    VALUES ('Petras', 'Petrauskas', 'petras@mail.com', 'Account Coordinator'),
        ('Ignas', 'Ignauskas', 'ignas@mail.com', 'UX / UI Designer'),
        ('Mingaile', 'Mindd', 'mingaile@mail.com', 'Copywriter'),
        ('Rasa', 'Rasaite', 'rasa@mail.com', 'Developer'),
        ('Egle', 'Egalite', 'egle@mail.com', 'Developer'),
        ('Antanas', 'Antanauskas', 'antanas@mail.com', 'Team Lead'),
        ('Kristina', 'Krista', 'kristina@mail.com', 'Customer service manager'),
        ('John', 'Doe', 'john@mail.com', 'Developer'),
        ('Jonas', 'Jonaitisi', 'jonas@mail.com', 'QA');


INSERT INTO projects (title, customer, budget, description)
    VALUES ('Barbora.lt', 'UAB Maxima', '$ 10000', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida semper maximus. Aliquam at purus eros. Vivamus egestas laoreet nisi, eu hendrerit est molestie nec. Duis bibendum nulla orci, at porttitor nisi sollicitudin sed. Nullam scelerisque elit vel cursus convallis. Morbi vel magna nec felis finibus bibendum ut sit amet lectus. Ut hendrerit sollicitudin ultricies. Aliquam ultrices eleifend pulvinar. Curabitur vestibulum elit iaculis dictum dapibus. Quisque semper mollis arcu, ac congue massa dictum quis. Vivamus rutrum tincidunt eleifend. Phasellus ac nisi nec nulla maximus lacinia at non augue. Nam viverra eleifend nibh, eu feugiat nunc elementum quis. '),
        ('Pigu.lt', 'Pigu.lt', '$ 15000', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida semper maximus. Aliquam at purus eros. Vivamus egestas laoreet nisi, eu hendrerit est molestie nec. Duis bibendum nulla orci, at porttitor nisi sollicitudin sed. Nullam scelerisque elit vel cursus convallis. Morbi vel magna nec felis finibus bibendum ut sit amet lectus. Ut hendrerit sollicitudin ultricies. Aliquam ultrices eleifend pulvinar. Curabitur vestibulum elit iaculis dictum dapibus. Quisque semper mollis arcu, ac congue massa dictum quis. Vivamus rutrum tincidunt eleifend. Phasellus ac nisi nec nulla maximus lacinia at non augue. Nam viverra eleifend nibh, eu feugiat nunc elementum quis. '),
        ('Aliexpress', 'Alibaba', '$ 100000',  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean gravida semper maximus. Aliquam at purus eros. Vivamus egestas laoreet nisi, eu hendrerit est molestie nec. Duis bibendum nulla orci, at porttitor nisi sollicitudin sed. Nullam scelerisque elit vel cursus convallis. Morbi vel magna nec felis finibus bibendum ut sit amet lectus. Ut hendrerit sollicitudin ultricies. Aliquam ultrices eleifend pulvinar. Curabitur vestibulum elit iaculis dictum dapibus. Quisque semper mollis arcu, ac congue massa dictum quis. Vivamus rutrum tincidunt eleifend. Phasellus ac nisi nec nulla maximus lacinia at non augue. Nam viverra eleifend nibh, eu feugiat nunc elementum quis. ');

INSERT INTO project_employee (project_id, employee_id)
    VALUES (1, 1),
        (1,2),
        (1,5),
        (2,4),
        (2,7),
        (3,9),
        (3,2);
