create database if not exists project_db;
use project_db;

create table users(
id int auto_increment primary key,
user_name varchar(255)not null,
email varchar(255) not null unique,
password varchar(255) not null,
profile_image varchar(255)default null,
created_at timestamp default current_timestamp)engine=innoDB default charset=utf8mb4;

create table contents(
id int auto_increment primary key,
title varchar(255)not null,
body varchar(255) not null unique,
author_id int not null,
image varchar(255)default null,
created_at timestamp default current_timestamp,
updated_at timestamp null default null,
foreign key(author_id) references users(id) on delete cascade) engine=innoDB default charset=utf8mb4;


