create database if not exists hemis_database;

create user if not exists 'hemis_user'@'localhost' identified by 'moshe@hemis';

grant all on hemis_database.* to 'hemis_user'@'localhost';