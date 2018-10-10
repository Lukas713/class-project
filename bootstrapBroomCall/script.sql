drop database IF EXISTS 1broomcall;

create database 1broomCall default character set utf8;

/* c:\xampp\mysql\bin\mysql.exe -ulukas -p123456789 --default_character_set=utf8 < C:\xampp\htdocs\bootstrapBroomCall\script.sql*/

USE 1broomCall ;

CREATE TABLE squad 
(
    id INT NOT NULL primary key AUTO_INCREMENT,
    squadNumber INT,
    squadColor VARCHAR(15)
);

create table person
  (
    id int primary key not null auto_increment,
    firstName varchar(50) not null,
    lastName varchar(50) not null,
    email varchar(50) not null,
    passwrd varchar(255) not null,
    roles int not null
  );

create table roles
  (
    id int primary key not null auto_increment,
    roleName varchar(10)
  );


CREATE TABLE  users 
(
  id INT NOT NULL primary key AUTO_INCREMENT,
  phoneNumber varchar(20),
  person int
);

CREATE TABLE services 
(
    id INT NOT NULL primary key AUTO_INCREMENT,
    serviceName VARCHAR(50) not NULL ,
    price DECIMAL(10,0) not NULL
);


CREATE TABLE cleanlevel 
(
    id INT primary key AUTO_INCREMENT,
    levelName VARCHAR(20),
    priceCoeficient decimal(10,2)
);

CREATE TABLE agreement (
  id INT NOT NULL primary key AUTO_INCREMENT,
  orderDate DATETIME,
  approveDate DATETIME,
  serviceDate DATETIME,
  city VARCHAR(20),
  adress VARCHAR(50),
  squad INT,
  users INT,
  cleanLevel INT,
  services int,
  approved boolean DEFAULT false,
  checked boolean DEFAULT false
);

CREATE TABLE department 
(
  id INT NOT NULL primary key AUTO_INCREMENT,
  depName VARCHAR(20)
);

CREATE TABLE employees
 (
  id INT NOT NULL primary key AUTO_INCREMENT,
  phoneNumber VARCHAR(20) NOT NULL,
  city VARCHAR(50) ,
  zipCode VARCHAR(50),
  adress VARCHAR(50),
  oib VARCHAR(15),
  IBAN VARCHAR(50),
  person int,
  squad INT,
  department INT
  );

  alter table person add foreign key(roles) references roles(id); 

  alter table users add foreign key(person) references person(id); 

  alter table employees add foreign key(squad) references squad(id);
  alter table employees add foreign key(department) references department(id);
  alter table employees add foreign key(person) references person(id); 

  alter table agreement add foreign key(squad) references squad(id);
  alter table agreement add foreign key(services) references services(id);
  alter table agreement add foreign key(cleanLevel) references cleanLevel(id);
  alter table agreement add foreign key(users) references users(id);

insert into squad(id, squadNumber, squadColor) values 
(null, 1, "#256645"),
(null, 2, "#AA0000"),
(null, 3, "#0000FF"),
(null, 4, "-");

insert into roles(roleName) VALUES
("admin"),
("operater"),
("user");

insert into department(id, depName) values 
(null, "Cleaners"),
(null, "Logistics"),
(null, "Administration"),
(null, "Technics"),
(null, "No department");

insert into services(id, serviceName, price) values 
(null, "1 bedroom", 100),
(null, "2 bedroom", 200),
(null, "3 bedroom", 300);

insert into cleanlevel(id, levelName, priceCoeficient) values 
(null, "Regular", 1.00),
(null, "Deep cleaning", 1.45),
(null, "Move in/out", 1.75);

insert into person (firstName, lastName, email, passwrd, roles) values ('Fredia', 'McGeever', 'fmcgeever0@issuu.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);
insert into person (firstName, lastName, email, passwrd, roles) values ('Marsiella', 'Yarnold', 'myarnold1@dropbox.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);
insert into person (firstName, lastName, email, passwrd, roles) values ('Penny', 'Bilson', 'pbilson2@chronoengine.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);
insert into person (firstName, lastName, email, passwrd, roles) values ('Kevina', 'Balmadier', 'kbalmadier3@weebly.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);
insert into person (firstName, lastName, email, passwrd, roles) values ('Christen', 'Mills', 'cmills4@bloglines.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);
insert into person (firstName, lastName, email, passwrd,  roles) values ('Ronnica', 'Martill', 'rmartill0@oakley.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('Maxie', 'Sauven', 'msauven1@bing.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('Bridie', 'Krolman', 'bkrolman2@tinyurl.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('Gib', 'McCarver', 'gmccarver3@etsy.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('Tomi', 'Carrabot', 'tcarrabot4@prnewswire.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('admin', 'admin', 'admin@admin.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 1);
insert into person (firstName, lastName, email, passwrd,  roles) values ('user', 'user', 'user@user.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 3);
insert into person (firstName, lastName, email, passwrd,  roles) values ('operater', 'operater', 'operater@operater.com', '$2y$12$dIcWikfkOhvPCOujwNfuDuY1OezqCuU8kbezd8kKqRT.rnQnvMBjK', 2);

insert into employees (phoneNumber, person, squad, department) values ('533-896-0630', 1, 2, 4);
insert into employees (phoneNumber, person, squad, department) values ('871-361-2383', 2, 2, 3);
insert into employees (phoneNumber, person, squad, department) values ('490-273-0700', 3, 1, 1);
insert into employees (phoneNumber, person, squad, department) values ('469-888-7269', 4, 2, 5);
insert into employees (phoneNumber, person, squad, department) values ('721-598-6218', 5, 1, 4);

insert into users (phoneNumber, person) values ('716-347-0997', 6);
insert into users (phoneNumber, person) values ('351-678-7276', 8);
insert into users (phoneNumber, person) values ('740-298-5119', 9);
insert into users (phoneNumber, person) values ('806-271-3412', 7);
insert into users (phoneNumber, person) values ('806-271-3412', 10);
insert into users (person) values (11);
insert into users (person) values (12);
insert into users (person) values (13);


