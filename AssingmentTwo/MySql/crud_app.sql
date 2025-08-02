create database crud_app;
use crud_app;

create table users(
id INT auto_increment primary key,
username varchar(255) unique not null,
email varchar(255) unique not null,
password varchar(255) not null,
role enum('users', 'admin') not null default 'users');


create table products(
id INT auto_increment primary key,
name varchar(255) not null,
description TEXT,
price decimal(10,2),
image varchar(255),
created_by INT,
foreign key (created_by) references users(id)
);

insert into users(username, email, password, role) values(
'name',
'name@gmail.com',
'$2y$10$Wksos5Zxr7XF5WppPw1hMudMaA70KfqXHyeY4VfBCzHmqoi86z0bK',
'admin');