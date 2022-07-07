CREATE TABLE `purchase_type_test` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` char NOT NULL
);
CREATE TABLE `purchase_test` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `purchase_id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `img` varchar(60) NOT NULL,
  `href` varchar(60) NOT NULL
);

ALTER TABLE `purchase_test`
ADD FOREIGN KEY (`purchase_id`) REFERENCES `purchase_type_test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE