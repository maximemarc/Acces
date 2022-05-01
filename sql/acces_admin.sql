create database acces;
create role acces_admin password 'admin' login;
grant all on database acces to acces_admin;