-- The drop table queries below are to facilitate testing on my end

DROP TABLE IF EXISTS `employee`;
DROP TABLE IF EXISTS `office`;
DROP TABLE IF EXISTS `project`;
DROP TABLE IF EXISTS `skillSet`;
DROP TABLE IF EXISTS `employee_project`;
DROP TABLE IF EXISTS `employee_supervisor`;
DROP TABLE IF EXISTS `employee_skills`;


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
	startDate date,
	FOREIGN KEY (eid) REFERENCES employee (id),
	FOREIGN KEY (pid) REFERENCES project (id)
);

CREATE TABLE employee_supervisor(
	eid int, 
	sid int,
	FOREIGN KEY (eid) REFERENCES employee (id),
	FOREIGN KEY (sid) REFERENCES employee (id)
);

CREATE TABLE employee_skills(
	eid int, 
	sid int,
	FOREIGN KEY (eid) REFERENCES employee (id),
	FOREIGN KEY (sid) REFERENCES skillSet (id)
);






INSERT INTO office (city, name) values ('London', 'Geronimo Games London');
INSERT INTO office (city, name) values ('Los Angeles', 'Geronimo Games Los Angeles');
INSERT INTO office (city, name) values ('Montreal', 'Geronimo Games Montreal');
INSERT INTO office (city, name) values ('Houston', 'Geronimo Games Houston');
INSERT INTO office (city, name) values ('Boston', 'Geronimo Games Boston');


INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='London'), 'Jonathan', 'Reynolds', '23', 'programmer');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Los Angeles'), 'Chris', 'Brooks', '35', 'artist');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Montreal'), 'Carlos', 'Garcia', '30', '3D animator');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Houston'), 'Judy', 'Flores', '34', 'HR specialist');
INSERT INTO employee (cid, first_name, last_name, age, position) values ((SELECT id FROM office WHERE city='Boston'), 'Bradley', 'Cook', '32', 'game designer');


INSERT INTO skillSet (name, descr) values ('Java Programming', 'knows Java, writes code in game engine');
INSERT INTO skillSet (name, descr) values ('3D Modeling', 'Can create characters and environments');
INSERT INTO skillSet (name, descr) values ('Payroll', 'accounting duties');
INSERT INTO skillSet (name, descr) values ('Hiring', 'interviews and hires new employees');
INSERT INTO skillSet (name, descr) values ('Game Design', 'designs game mechanics and levels');
INSERT INTO skillSet (name, descr) values ('Art', 'Concept art, textures, style and marketing design');


INSERT INTO project (name, descr) values ('Dire Doomlord 2', 'A sequel to Geronimo Games hit game Dire Doomlord, an RPG. Uses Unreal Engine.');
INSERT INTO project (name, descr) values ('Worst Nightmare', 'A First Person Horror game, a first for Geronimo Games. Uses Unreal Engine.');
INSERT INTO project (name, descr) values ('Gunnin Gary', 'A mobile game where you shoot waves of enemies. Uses Unity Engine.');


INSERT INTO employee_project(eid, pid) values ((SELECT id FROM employee WHERE first_name ='Jonathan' AND last_name ='Reynolds'), (SELECT id FROM project WHERE name ='Dire Doomlord 2'));
INSERT INTO employee_project(eid, pid) values ((SELECT id FROM employee WHERE first_name ='Chris' AND last_name ='Brooks'), (SELECT id FROM project WHERE name ='Dire Doomlord 2'));
INSERT INTO employee_project(eid, pid) values ((SELECT id FROM employee WHERE first_name ='Carlos' AND last_name ='Garcia'), (SELECT id FROM project WHERE name ='Dire Doomlord 2'));
INSERT INTO employee_project(eid, pid) values ((SELECT id FROM employee WHERE first_name ='Bradley' AND last_name ='Cook'), (SELECT id FROM project WHERE name ='Dire Doomlord 2'));


INSERT INTO employee_skills(eid, sid) values ((SELECT id FROM employee WHERE first_name ='Bradley' AND last_name ='Cook'), (SELECT id FROM skillSet WHERE name ='Art'));
INSERT INTO employee_skills(eid, sid) values ((SELECT id FROM employee WHERE first_name ='Bradley' AND last_name ='Cook'), (SELECT id FROM skillSet WHERE name ='Game Design'));
INSERT INTO employee_skills(eid, sid) values ((SELECT id FROM employee WHERE first_name ='Jonathan' AND last_name ='Reynolds'), (SELECT id FROM skillSet WHERE name ='Java Programming'));
INSERT INTO employee_skills(eid, sid) values ((SELECT id FROM employee WHERE first_name ='Carlos' AND last_name ='Garcia'), (SELECT id FROM skillSet WHERE name ='3D Modeling'));
INSERT INTO employee_skills(eid, sid) values ((SELECT id FROM employee WHERE first_name ='Chris' AND last_name ='Brooks'), (SELECT id FROM skillSet WHERE name ='Art'));











