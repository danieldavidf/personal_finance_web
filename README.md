# Finan

Finanças pessoais

## Step 1: Install Apache

sudo apt-get install apache2

sudo apt-get install mysql-server


## Step 2: Install PHP e packages

sudo apt-get install php libapache2-mod-php

sudo apt-get install php-mysql


### Step 3: Access mysql server without using sudo

sudo mysql -u root

DROP USER 'root'@'localhost';

CREATE USER 'root'@'%' IDENTIFIED BY '';

GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

### Step 4: Create Database

DROP DATABASE financas;
CREATE DATABASE financas CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE financas;

CREATE TABLE transacoes (
	transacao_id INT PRIMARY KEY AUTO_INCREMENT,
	oque VARCHAR(50) NOT NULL,
	onde VARCHAR(50),
	valor FLOAT NOT NULL,
	pgto VARCHAR(50) NOT NULL,
	data DATE NOT NULL
);

### Step 5: Restart Apache

service apache2 restart

### Step 6: Open in your browser: localhost