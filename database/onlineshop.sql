-- phpMyAdmin SQL Dump (Cleaned)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- ----------------------------
-- Database: onlineshop
-- ----------------------------

-- ----------------------------
-- Procedure
-- ----------------------------
DELIMITER $$

CREATE PROCEDURE getcat (IN cid INT)
BEGIN
  SELECT * FROM categories WHERE cat_id = cid;
END $$

DELIMITER ;

-- ----------------------------
-- Tables
-- ----------------------------

CREATE TABLE admin_info (
  admin_id int NOT NULL AUTO_INCREMENT,
  admin_name varchar(100) NOT NULL,
  admin_email varchar(300) NOT NULL,
  admin_password varchar(300) NOT NULL,
  PRIMARY KEY (admin_id)
) ENGINE=InnoDB;

INSERT INTO admin_info VALUES
(1, 'admin', 'admin@gmail.com', '25f9e794323b453885f5181f1b624d0b');

-- ----------------------------

CREATE TABLE brands (
  brand_id int NOT NULL AUTO_INCREMENT,
  brand_title text NOT NULL,
  PRIMARY KEY (brand_id)
) ENGINE=InnoDB;

INSERT INTO brands VALUES
(1,'HP'),(2,'Samsung'),(3,'Apple'),(4,'motorolla'),(5,'LG'),(6,'Cloth Brand');

-- ----------------------------

CREATE TABLE categories (
  cat_id int NOT NULL AUTO_INCREMENT,
  cat_title text NOT NULL,
  PRIMARY KEY (cat_id)
) ENGINE=InnoDB;

INSERT INTO categories VALUES
(1,'Electronics'),(2,'Ladies Wears'),(3,'Mens Wear'),
(4,'Kids Wear'),(5,'Furnitures'),(6,'Home Appliances'),
(7,'Electronics Gadgets');

-- ----------------------------

CREATE TABLE products (
  product_id int NOT NULL AUTO_INCREMENT,
  product_cat int NOT NULL,
  product_brand int NOT NULL,
  product_title varchar(255) NOT NULL,
  product_price int NOT NULL,
  product_desc text NOT NULL,
  product_image text NOT NULL,
  product_keywords text NOT NULL,
  PRIMARY KEY (product_id)
) ENGINE=InnoDB;

-- (Data shortened for readability — your original data is fine)
INSERT INTO products VALUES
(1,1,2,'Samsung galaxy s7 edge',5000,'Samsung galaxy s7 edge','product07.png','samsung mobile electronics');

-- ----------------------------

CREATE TABLE user_info (
  user_id int NOT NULL AUTO_INCREMENT,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  email varchar(300) NOT NULL,
  password varchar(300) NOT NULL,
  mobile varchar(15) NOT NULL,
  address1 varchar(300) NOT NULL,
  address2 varchar(100) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB;

INSERT INTO user_info VALUES
(25,'otheruser','user','otheruser@gmail.com','support','12344465767','New York','Kumbalagodu');

-- ----------------------------

CREATE TABLE user_info_backup LIKE user_info;

-- ----------------------------
-- Trigger
-- ----------------------------

DELIMITER $$

CREATE TRIGGER after_user_info_insert
AFTER INSERT ON user_info
FOR EACH ROW
BEGIN
  INSERT INTO user_info_backup VALUES
  (NEW.user_id, NEW.first_name, NEW.last_name, NEW.email,
   NEW.password, NEW.mobile, NEW.address1, NEW.address2);
END $$

DELIMITER ;

-- ----------------------------

CREATE TABLE orders_info (
  order_id int NOT NULL AUTO_INCREMENT,
  user_id int NOT NULL,
  f_name varchar(255),
  email varchar(255),
  address varchar(255),
  city varchar(255),
  state varchar(255),
  zip int,
  cardname varchar(255),
  cardnumber varchar(20),
  expdate varchar(50),
  prod_count int,
  total_amt int,
  cvv int,
  PRIMARY KEY (order_id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE reviews (
  review_id int NOT NULL AUTO_INCREMENT,
  product_id int NOT NULL,
  name varchar(30) NOT NULL,
  email varchar(50) NOT NULL,
  review varchar(255) NOT NULL,
  datetime datetime NOT NULL,
  rating int NOT NULL,
  PRIMARY KEY (review_id)
) ENGINE=InnoDB;

-- ✅ FIXED ERROR HERE
INSERT INTO reviews VALUES
(6,1,'support Reddy H C','puneethreddy951@gmail.com','this is my first review','2020-11-04 19:14:10',2);

-- ----------------------------

CREATE TABLE cart (
  id int NOT NULL AUTO_INCREMENT,
  p_id int NOT NULL,
  ip_add varchar(250) NOT NULL,
  user_id int,
  qty int NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE wishlist (
  id int NOT NULL AUTO_INCREMENT,
  p_id int NOT NULL,
  ip_add varchar(250),
  user_id int,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE orders (
  order_id int NOT NULL AUTO_INCREMENT,
  user_id int,
  product_id int,
  qty int,
  trx_id varchar(255),
  p_status varchar(50),
  PRIMARY KEY (order_id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE order_products (
  order_pro_id int NOT NULL AUTO_INCREMENT,
  order_id int,
  product_id int,
  qty int,
  amt int,
  PRIMARY KEY (order_pro_id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE email_info (
  email_id int NOT NULL AUTO_INCREMENT,
  email text,
  PRIMARY KEY (email_id)
) ENGINE=InnoDB;

-- ----------------------------

CREATE TABLE logs (
  id int NOT NULL AUTO_INCREMENT,
  user_id varchar(50),
  action varchar(50),
  date datetime,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- ----------------------------

COMMIT;
