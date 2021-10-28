ALTER TABLE USER ADD api_key varchar(128);
ALTER TABLE USER ADD group_seq int(20);
ALTER TABLE USER ADD food_company_id int(20);
ALTER TABLE USER ADD is_individual_reg int(1) DEFAULT 0;
ALTER TABLE USER ADD is_reg_payment int(1) DEFAULT 0;


/*************************************************/
CREATE TABLE calendar_events(
   id serial primary key,
   calendar_date date,
   group_id int(12),
   recipes_id text,
   is_delete int(1) default 0,
   logged_user_id int(20)
);

/******************************22/04/2020*******************/

ALTER TABLE `user` ADD `subscription_id` INT(20) NOT NULL AFTER `is_active`;

CREATE TABLE IF NOT EXISTS `user_data` (
   id serial primary key,
   user_data text
);


ALTER TABLE `user` ADD `payment_end_date` date;

/******************************24/04/2020*******************/

ALTER TABLE `recipes` CHANGE `views` `views` INT(20) NOT NULL DEFAULT '0';


/******************************27/04/2020*******************/
ALTER TABLE `recipes` ADD `is_active` INT(1) NOT NULL DEFAULT '1' AFTER `subscription_id`;

/******************************28/04/2020*******************/

ALTER TABLE `user` ADD `countrycode` VARCHAR(32) NOT NULL AFTER `payment_end_date`;

/******************************05/02/2020*******************/
ALTER TABLE `recipes` ADD `recipe_image` varchar(128) NOT NULL DEFAULT 'assets/images/users/5.jpg';

/******************************08/06/2020*******************/
ALTER TABLE `user_data` ADD `link_used` int(1) DEFAULT 0;
ALTER TABLE `user` ADD `forgot_link_used` int(1) DEFAULT 0;

ALTER TABLE `user` ADD `img_url` VARCHAR(255) NULL DEFAULT NULL AFTER `restaurant_name`;

/******************************10/09/2020*******************/
ALTER TABLE `recipes` ADD `declaration_name` TEXT  DEFAULT NULL AFTER `notes`;
ALTER TABLE `recipe_nutritient` ADD `name` VARCHAR(255) NOT NULL AFTER `id`;
ALTER TABLE `recipe_nutritient` DROP `nutritient_id`;
ALTER TABLE `allergens` ADD `image_url` VARCHAR(255) NOT NULL AFTER `title`;
DROP TABLE `ingredient_allergens`;
DROP TABLE `ingredient_nutrients`;
ALTER TABLE `ingredient_items` ADD `long_desc` VARCHAR(255) NOT NULL AFTER `ingredient_id`;
ALTER TABLE `ingredient_items` ADD `declaration_name` VARCHAR(220) NOT NULL AFTER `long_desc`;
ALTER TABLE `ingredient_items` ADD `data_source` VARCHAR(64) NOT NULL AFTER `declaration_name`;
ALTER TABLE `ingredient_items` ADD `shrt_desc` VARCHAR(255) NOT NULL AFTER `long_desc`;

ALTER TABLE `ingredient_items` ADD `quantity_unit` TEXT NULL DEFAULT '' AFTER `quantity`;

/******************************15/09/2020*******************/
ALTER TABLE `recipes` ADD `is_for_restaurant` INT(1) NULL DEFAULT '0' AFTER `recipe_image`;
ALTER TABLE `recipes` ADD `isadded_for_restaurant` INT(1) NULL DEFAULT '0' AFTER `recipe_image`;

ALTER TABLE `user` ADD `latitude` VARCHAR(128) NULL DEFAULT NULL;
ALTER TABLE `user` ADD `longitude` VARCHAR(128) NULL DEFAULT NULL;

/******************************24/09/2020*******************/

ALTER TABLE `recipes` ADD `ref_recipe_id` INT(20) NULL DEFAULT '0' AFTER `isadded_for_restaurant`;

/******************************25/09/2020*******************/

ALTER TABLE `recipes` ADD `is_menu_fromrestaurant` INT(1) NULL DEFAULT '0' AFTER `isadded_for_restaurant`;

/******************************08/10/2020*******************/
ALTER TABLE `recipes`  ADD `best_time_to_eat` VARCHAR(255) NULL DEFAULT ''   AFTER `is_for_restaurant`;

/******************************22/10/2020*******************/

ALTER TABLE `recipes`  ADD `quantity` varchar(128) NULL DEFAULT '' AFTER price;

ALTER TABLE `recipes`  ADD `price1` float(10,2) NULL;
ALTER TABLE `recipes`  ADD `quantity1` varchar(128) NULL DEFAULT '';
ALTER TABLE `recipes`  ADD `price2` float(10,2) NULL;
ALTER TABLE `recipes`  ADD `quantity2` varchar(128) NULL DEFAULT '';
ALTER TABLE `recipes`  ADD `price3` float(10,2) NULL;
ALTER TABLE `recipes`  ADD `quantity3` varchar(128) NULL DEFAULT '';

/******************************22/10/2020*******************/

ALTER TABLE `recipes`  ADD `is_todays_special` INT(1) NULL DEFAULT '0';


 alter table `recipes` modify column recipe_date 
timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE `menu_group` ADD `sequence` INT(20) NULL DEFAULT NULL AFTER `logged_user_id`;

/******************************24/10/2020*******************/


ALTER TABLE `recipes`  ADD `is_bar_menu` INT(1) NULL DEFAULT '0';


/******************************27/10/2020*******************/

CREATE TABLE IF NOT EXISTS `recipes_copy_users` (
   id serial primary key,
   logged_user_id int(20) NOT NULL,
   recipe_id int(20) NOT NULL
);

ALTER TABLE `recipes`  ADD `is_recipe_active` INT(1) NULL DEFAULT '1';

/******************************29/10/2020*******************/

ALTER TABLE `user`  ADD `is_alacalc_recipe` INT(1) NULL DEFAULT '1';


/******************************02/11/2020*******************/
UPDATE `recipes` SET `price`=0.00 WHERE `price` = '';

/******************************20/11/2020*******************/
ALTER TABLE `menu_group`  ADD `image_path` varchar(128) NULL DEFAULT '';

ALTER TABLE `recipe_images_master` ADD `thumb_path` varchar(256) NULL DEFAULT '';

/******************************24/11/2020*******************/

/*UPDATE recipes SET recipe_image=REPLACE(recipe_image,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');*/

/*Test Server*/
UPDATE recipes SET recipe_image=REPLACE(recipe_image,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/test/');
UPDATE recipe_images_master SET img_path=REPLACE(img_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/test/');
UPDATE recipe_images_master SET thumb_path=REPLACE(thumb_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/test/');


UPDATE menu_group SET image_path=REPLACE(image_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/test/');
UPDATE user SET profile_photo=REPLACE(profile_photo,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/test/');

/*Live Server*/
UPDATE recipes SET recipe_image=REPLACE(recipe_image,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');
UPDATE recipe_images_master SET img_path=REPLACE(img_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');
UPDATE recipe_images_master SET thumb_path=REPLACE(thumb_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');

UPDATE menu_group SET image_path=REPLACE(image_path,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');
UPDATE user SET profile_photo=REPLACE(profile_photo,'uploads/','https://d24h2kiavvgpl8.cloudfront.net/');

/******************************30/11/2020*******************/
ALTER TABLE `recipes` CHANGE `recipe_image` `recipe_image` VARCHAR(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'assets/images/users/menu.png';
UPDATE recipes SET recipe_image=REPLACE(recipe_image,'assets/images/users/5.jpg','assets/images/users/menu.png');
UPDATE recipe_images_master SET img_path=REPLACE(img_path,'assets/images/users/5.jpg','assets/images/users/menu.png');
UPDATE recipe_images_master SET thumb_path=REPLACE(thumb_path,'assets/images/users/5.jpg','assets/images/users/menu.png');

/******************************03/12/2020*******************/
UPDATE user SET profile_photo=REPLACE(profile_photo,'assets/images/users/5.jpg','assets/images/users/user.png');
ALTER TABLE `user` CHANGE `profile_photo` `profile_photo` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'assets/images/users/user.png';

/******************************04/12/2020*******************/
ALTER TABLE `user` ADD `is_category_prices`  INT(1) NULL DEFAULT '0';

/******************************07/12/2020*******************/
ALTER TABLE `recipes` ADD `ingredients_name` VARCHAR(255) NULL DEFAULT '' AFTER `is_recipe_active`;

/******************************16/12/2020*******************/

CREATE TABLE customer(
   id serial primary key,
   name varchar(128),
   contact_no varchar(12),
   email varchar(128)
);


ALTER TABLE `user` CHANGE `usertype` `usertype` ENUM('Admin','Individual User','Individual Restaurants','Food Company','School','Restaurant','Restaurant chain','Burger and Sandwich','Waitinglist manager','Restaurant manager') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
/******************************23/12/2020*******************/

CREATE TABLE `orders` (
  `id`serial primary key,
  `order_no` varchar(128) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `table_id` BIGINT(20) NULL DEFAULT NULL,
  `rest_id` BIGINT(20) NULL DEFAULT NULL,
  `loyalty_points` double(10,2),
  `sub_total` double(10,2) NOT NULL,
  `disc_total` double(10,2) NOT NULL,
  `net_total` double(10,2) NOT NULL,
  `suggetion` text default null,
  `status` ENUM('New','Confirmed','Assigned To Kitchen','Canceled','Completed') NOT NULL,
  `created_at` datetime default null,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `order_items` (
  `id`serial primary key,
  `order_id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `qty` double(10,2) NOT NULL,
  `price` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `disc` double(10,2) NOT NULL,
  `disc_amt` double(10,2) NOT NULL,
  `sub_total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
);


/******************************24/12/2020*******************/
ALTER TABLE `orders` ADD `status` ENUM('Pending','Accepted','Assigned To Kitchen','Cancel') NOT NULL AFTER `suggetion`;

/******************************30/12/2020*******************/
ALTER TABLE `orders` CHANGE `status` `status` ENUM('New','Confirmed','Assigned To Kitchen','Canceled','Completed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/******************************31/12/2020*******************/

CREATE TABLE `restaurant_setting` (
  `id` serial primary key,
  `whatsapp_message` text NOT NULL,
  `text_message` text NOT NULL,
  `restaurant_id` int(11) NOT NULL
);

ALTER TABLE `waitinglist_details` CHANGE `action_taken` `action_taken` VARCHAR(255) NULL DEFAULT NULL;

/******************************02/01/2021*******************/

ALTER TABLE `order_items` CHANGE `qty` `qty` int(12) NOT NULL;

/******************************08/01/2021*******************/

CREATE TABLE `recipe_prices` (
  `id` serial primary key,
  `recipe_id` int(12),
  `table_category_id` int(12),
  `price` float(10,2),
  is_default int(1) default 0
);

/******************************11/01/2021*******************/

ALTER TABLE customer ADD is_block int(1) DEFAULT 0;
ALTER TABLE table_details ADD is_available int(1) DEFAULT 1;

ALTER TABLE `orders` CHANGE `status` `status` ENUM('New','Confirmed','Assigned To Kitchen','Canceled','Completed','Blocked') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/******************************18/01/2021*******************/

ALTER TABLE `orders` CHANGE `status` `status` ENUM('New','Confirmed','Assigned To Kitchen','Food Served','Canceled','Completed','Blocked') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


CREATE TABLE `table_orders` (
  `id` serial primary key,
  `table_orderno` varchar(64),
  `table_id` int(20),
  `flag` ENUM('Y','N') DEFAULT 'N',
   restaurant_id int(20),
  `insert_date` date,
  `insert_time` time
);

ALTER TABLE `orders` ADD table_orders_id int(20);

/******************************21/01/2021*******************/
ALTER TABLE `orders` ADD is_invoiced int(1) DEFAULT 0;


CREATE TABLE `invoices` (
  `id`serial primary key,
  `invoice_no` varchar(128) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `table_id` BIGINT(20) NULL DEFAULT NULL,
  `rest_id` BIGINT(20) NULL DEFAULT NULL,
  `loyalty_points` double(10,2),
  `sub_total` double(10,2) NOT NULL,
  `disc_total` double(10,2) NOT NULL,
  `net_total` double(10,2) NOT NULL,
  `suggetion` text default null,
  `status` ENUM('Unpaid','Paid') NOT NULL,
   table_order_id int(20),
  `created_at` datetime default null,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `invoice_items` (
  `id`serial primary key,
  `invoice_id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `qty` double(10,2) NOT NULL,
  `price` double(10,2) NOT NULL,
  `sub_total` double(10,2) NOT NULL,
  `disc` double(10,2) NOT NULL,
  `disc_amt` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT null,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `table_orders` ADD invoice_ids varchar(128);


/******************************09/02/2021*******************/

ALTER TABLE `admin_offer` CHANGE `discount` `discount` DECIMAL(10,2) NOT NULL;

/******************************13/02/2021*******************/

ALTER TABLE `order_items` ADD special_notes varchar(255) NOT NULL DEFAULT '' AFTER `sub_total`;
ALTER TABLE `orders` CHANGE `order_no` `order_no` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

/******************************14/02/2021*******************/

CREATE TABLE `invoice_payment` (
  `id`serial primary key,
  `invoice_id`  bigint(20) NOT NULL,
  `payment_type` ENUM('CASH','CARD','UPI','NET BANKING') NOT NULL,
  `payment_amount` float(10,2) NULL DEFAULT 0.00,
  `created_at` datetime default null,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `invoices` ADD (cgst_total float(10,2) NULL DEFAULT 0.00,
sgst_total float(10,2) NULL DEFAULT 0.00,
cash_payment float(10,2) NULL DEFAULT 0.00,
card_payment float(10,2) NULL DEFAULT 0.00,
upi_payment float(10,2) NULL DEFAULT 0.00,
net_banking float(10,2) NULL DEFAULT 0.00);



/******************************17/02/2021*******************/
ALTER TABLE `orders` ADD invoice_id bigint(20) NULL DEFAULT NULL;
ALTER TABLE `orders` ADD (cgst_per float(10,2) NULL DEFAULT 0.00, sgst_per float(10,2) NULL DEFAULT 0.00);

/******************************18/02/2021*******************/

ALTER TABLE `table_orders` ADD `order_type` ENUM('Online','Billing') NOT NULL DEFAULT 'Online' AFTER `invoice_ids`;