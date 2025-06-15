create database employeeDB;
use employeeDB;

create table employee(
id int primary key auto_increment,
name varchar(100),
email varchar(255) unique,
position varchar(155),
hours int
);