CREATE TABLE `purchase_type_test` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(35) NOT NULL
) COLLATE utf8mb4_unicode_ci;
CREATE TABLE `city_test` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(35) NOT NULL,
  `url` varchar(35) NOT NULL
) COLLATE utf8mb4_unicode_ci;
CREATE TABLE `purchase_test` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `purchase_type_id` int unsigned NOT NULL,
  `city_id` int unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `img` varchar(60) NOT NULL,
  `href` varchar(60) NOT NULL
) COLLATE utf8mb4_unicode_ci;

ALTER TABLE `purchase_test`
ADD FOREIGN KEY (`city_id`) REFERENCES `city_test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;