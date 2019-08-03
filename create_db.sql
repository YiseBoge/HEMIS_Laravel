create database if not exists hemis_database;

create user if not exists 'hemis_user'@'localhost' identified by 'moe@hemis';

grant all on hemis_database.* to 'hemis_user'@'localhost';