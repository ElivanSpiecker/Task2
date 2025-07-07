arquivo V3__create_categoria.sql

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL
);

ssh univates@177.44.248.59
01082001

mysql -u root -p
123
show databases; 
use meu_banco_homolog;
use meu_banco_prod;
show tables;

http://177.44.248.59:8080/
cd /var/www/homolog
cd Task2
sudo git pull origin main
flyway -configFiles=flyway.conf migrate
sudo systemctl reload apache2


http://177.44.248.59:8081/
cd /var/www/prod
sudo git pull origin main
cd Task2 
flyway -configFiles=flyway.conf migrate
sudo systemctl reload apache2

