<?php
/**
 * Created by PhpStorm.
 * User: Tran Quang Long
 * Date: 12/10/2020
 * Time: 4:27 PM
 */
?>
CREATE TABLE Menu(
    menu_id INT NOT NULL AUTO_INCREMENT,
    menu_name VARCHAR(30) NOT NULL ,
    link VARCHAR(100) NOT NULL,
    parent_menu VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(0),
    update_at DATETIME NOT NULL,
     PRIMARY KEY(menu_id)
);

CREATE TABLE Roles(
    roles_id TINYINT NOT NULL,
    roles_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
    updated_at DATETIME,
    PRIMARY KEY(roles_id)
);
CREATE TABLE Users(
user_id INT AUTO_INCREMENT NOT NULL,
roles_id TINYINT NOT NULL,
status TINYINT NOT NULL,
username VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL,
fullname VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci,
phone_number VARCHAR(11),
address VARCHAR(40),
email VARCHAR(100),
created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(0),
update_at DATETIME,
PRIMARY KEY(user_id),
CONSTRAINT FK_roles FOREIGN KEY(roles_id) REFERENCES roles(roles_id)
ON UPDATE CASCADE
ON DELETE CASCADE
);

CREATE TABLE Orders(
order_id INT NOT NULL AUTO_INCREMENT,
user_id INT,
status TINYINT NOT NULL,
payment VARCHAR(20) NOT NULL,
amount FLOAT NOT NULL,
fullname VARCHAR(40) NOT NULL,
phone VARCHAR(11) NOT NULL,
address VARCHAR(40) NOT NULL,
email VARCHAR(40) NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
updated_at DATETIME,
PRIMARY KEY(order_id),
CONSTRAINT FK_users FOREIGN KEY(user_id) REFERENCES users(user_id)
ON UPDATE CASCADE
ON DELETE CASCADE
);

CREATE TABLE Brands(
brand_id INT NOT NULL AUTO_INCREMENT,
brand_name VARCHAR(30) NOT NULL,
created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
update_at DATETIME,
PRIMARY KEY(brand_id)
);

CREATE TABLE Product(
product_id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
avatar VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
price FLOAT NOT NULL,
title VARCHAR(100),
description VARCHAR(100),
amount INT NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
updated_at DATETIME,
brand_id INT NOT NULL,
PRIMARY KEY(product_id),
CONSTRAINT FK_brand FOREIGN KEY(brand_id) REFERENCES brands(brand_id)
ON UPDATE CASCADE
ON DELETE CASCADE
);


CREATE TABLE Orders_Details(
product_id INT AUTO_INCREMENT NOT NULL,
order_id INT NOT NULL,
quantity INT NOT NULL,
price FLOAT NOT NULL,
PRIMARY KEY(product_id, order_id),
CONSTRAINT FK_products FOREIGN KEY(product_id) REFERENCES product(product_id),
CONSTRAINT FK_orders FOREIGN KEY(order_id) REFERENCES orders(order_id)
ON UPDATE CASCADE
ON DELETE CASCADE
);
