-- The drop table queries below are to facilitate testing on my end

DROP TABLE IF EXISTS `employee`;
DROP TABLE IF EXISTS `office`;
DROP TABLE IF EXISTS `project`;
DROP TABLE IF EXISTS `skillSet`;
DROP TABLE IF EXISTS `employee_project`;

CREATE TABLE project(
	id int AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	descr VARCHAR(255) NOT NULL,
	CONSTRAINT nameDesc UNIQUE (name, descr)
);

CREATE TABLE skillSet(
	id int AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	descr VARCHAR(255) NOT NULL,
	CONSTRAINT nameDesc UNIQUE (name, descr)
);



CREATE TABLE office(
	id int AUTO_INCREMENT PRIMARY KEY,
	city VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,
	CONSTRAINT cityName UNIQUE (city, name)
);


-- Create a table called employee with the following properties:
-- id - an auto incrementing integer which is the primary key
-- first_name, last_name - a varchar with a maximum length of 255 characters, cannot be null
-- position - a varchar with a maximum length of 255 characters, cannot be null
-- the combination of a name and position must be unique

CREATE TABLE employee(
	id int AUTO_INCREMENT PRIMARY KEY,
	cid int,
	age int NOT NULL, 
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	position VARCHAR(255) NOT NULL,
	CONSTRAINT name UNIQUE (first_name, last_name),
	FOREIGN KEY (cid) REFERENCES office (id)
);

CREATE TABLE employee_project(
	eid int, 
	pid int,
	FOREIGN KEY (eid) REFERENCES employee (id),
	FOREIGN KEY (pid) REFERENCES project (id)
);




INSERT INTO office (city, name) values ('London', 'Geronimo Games London');
INSERT INTO office (city, name) values ('Los Angeles', 'Geronimo Games Los Angeles');
INSERT INTO office (city, name) values ('Montreal', 'Geronimo Games Montreal');
INSERT INTO office (city, name) values ('Houston', 'Geronimo Games Houston');
INSERT INTO office (city, name) values ('Boston', 'Geronimo Games Boston');


INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='London'), 'Jonathan', 'Reynolds', '23', 'programmer');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Los Angeles'), 'Chris', 'Brooks', '35', 'artist');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Montreal'), 'Carlos', 'Garcia', '30', '3D animator');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Houston'), 'Judy', 'Flores', '34', 'HR Specialist');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Boston'), 'Bradley', 'Cook', '32', 'game designer');


