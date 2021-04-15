-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2021 at 04:51 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocerymart1`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7EA244341C52F958` (`brand`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand`, `brand_image`, `updated_at`) VALUES
(3, 'Nestle', 'Nestle.jfif', '2021-02-26 11:28:03'),
(4, 'Britannia', 'Britannia.png', '2021-02-26 11:28:19'),
(5, 'Cadbury', 'Cadbury.jpg', '2021-02-26 11:31:20'),
(6, 'Balaji Wafers & Namkeen', 'Balaji.jpg', '2021-02-26 11:28:52'),
(7, 'Saffola', 'Saffola.png', '2021-02-26 11:29:04'),
(8, 'Fortune', 'Fortune.png', '2021-02-26 11:29:15'),
(9, 'Del Monte', 'DelMonte.png', '2021-02-26 11:29:25'),
(10, 'Patanjali', 'Patanjali.png', '2021-02-26 11:29:41'),
(11, 'Kohinoor rice', 'Kohinoor.png', '2021-02-26 11:29:52'),
(12, 'Madhur', 'Madhur.png', '2021-02-26 11:30:02'),
(13, 'Tata', 'Tata.png', '2021-02-26 11:30:16'),
(15, 'Nescafe', 'nescafe.png', '2021-03-19 05:11:45'),
(16, 'Kissan', 'kissan.png', '2021-03-19 05:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C19C164C19C1` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(14, 'Atta'),
(1, 'Biscuits'),
(21, 'Chocolate'),
(5, 'Chocolates'),
(16, 'Dal'),
(19, 'Drink'),
(11, 'Ghee'),
(4, 'Grains'),
(20, 'Jams, sauces & honey'),
(18, 'Noodle'),
(10, 'Oil'),
(12, 'Rice'),
(15, 'Salt'),
(17, 'Snacks'),
(9, 'soap'),
(13, 'Sugar');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5373C9665373C966` (`country`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country`) VALUES
(3, 'Australia'),
(4, 'china'),
(1, 'India'),
(7, 'NewCountry'),
(9, 'NewCountry2'),
(5, 'Switzerland'),
(2, 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210112111818', '2021-01-12 11:18:51', 1924),
('DoctrineMigrations\\Version20210112121445', '2021-01-12 12:16:30', 2249),
('DoctrineMigrations\\Version20210129100136', '2021-01-29 10:02:01', 765),
('DoctrineMigrations\\Version20210129151502', '2021-01-29 15:15:38', 3032),
('DoctrineMigrations\\Version20210201085047', '2021-02-01 08:51:25', 396);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `total_price` int(11) NOT NULL,
  `user_id_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F52993989D86650F` (`user_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `status`, `created_at`, `updated_at`, `total_price`, `user_id_id`) VALUES
(1, 'placed', '2021-04-02 10:12:24', '2021-04-02 11:32:27', 553, 12),
(2, 'cart', '2021-04-02 10:13:42', '2021-04-02 10:46:25', 2898, 18),
(3, 'placed', '2021-04-09 15:26:33', '2021-04-09 15:35:03', 485, 12),
(4, 'cart', '2021-04-10 11:39:28', '2021-04-10 11:39:28', 158, 12);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_ref_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52EA1F094584665A` (`product_id`),
  KEY `IDX_52EA1F09E238517C` (`order_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `product_id`, `order_ref_id`, `quantity`) VALUES
(1, 3, 1, 3),
(2, 6, 2, 2),
(3, 12, 1, 1),
(4, 31, 2, 2),
(6, 34, 3, 1),
(7, 3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `product_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_before` bigint(20) NOT NULL,
  `price_after` bigint(20) NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_status` tinyint(1) NOT NULL,
  `product_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_brand_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `country_of_origin_id` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B3BA5A5A6ABFFFB6` (`product_key`),
  KEY `IDX_B3BA5A5A12469DE2` (`category_id`),
  KEY `IDX_B3BA5A5AF7BFE87C` (`sub_category_id`),
  KEY `IDX_B3BA5A5A8F45BA9F` (`product_brand_id`),
  KEY `IDX_B3BA5A5A6D655FD8` (`country_of_origin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sub_category_id`, `product_key`, `product_name`, `price_before`, `price_after`, `product_image`, `product_status`, `product_description`, `product_brand_id`, `updated_at`, `country_of_origin_id`, `expiry_date`) VALUES
(3, 5, 7, 'CDMSF&N137', 'Cadbury DAIRY MILK SILK FRUIT & NUT 137 GM Bars  (137 g)', 17500, 15800, 'CDMSF_N137.png', 1, '<div>Cadbury Dairy Milk Silk is all about regaling in the chocolate\'s richness and creaminess. The classic taste of Cadbury chocolates enriched with the real goodness of cashews, raisins and apricots, offers you the reason to celebrate every small and big occasion of happiness.</div><ul><li>Milk Chocolate</li><li>Fruit &amp; Nut Flavor</li><li>Ingredients : COCOA SOLIDS, COCOA BUTTER, MILK SOLIDS</li><li>Nutrient Content : PROTEIN G 7.9, CARBOHYDRATE G 58.1</li><li>Generic Name : Chocolate</li></ul>', 5, '2021-02-04 09:01:48', 1, '2021-10-16'),
(4, 5, 5, 'CDM50%DC', 'Cadbury 50% DARK CHOCOLATE', 10000, 8000, 'CDM50_DC.png', 1, '<div>Bournville Rich Cocoa Chocolate is irresistible and specially created to savour the palate with 50% cocoa and an ever so smooth texture, each little chunk is dark and undeniably good!</div><ul><li>Dark Chocolate</li><li>Cocoa Flavor</li><li>Caloric Value : 556</li><li>Ingredients : COCOA SOLIDS, COCOA BUTTER, MILK SOLIDS</li><li>Nutrient Content : PROTEIN G, FAT G, SODIUM MG</li></ul>', 5, '2021-02-04 09:03:39', 1, '2021-06-27'),
(5, 10, 14, 'oil_soya_1', 'Fortune Soya Bean Oil, Refined 5L Can', 70500, 67500, 'oil_soya_1_1.jpg', 1, '<div>Soybean oil is a common type of <strong>cooking</strong> oil that has been associated with several <strong>health benefits</strong>. In particular, it may help promote <strong>skin health</strong>, reduce <strong>cholesterol</strong> levels, prevent bone loss, and provide important <strong>omega</strong>-3 fatty acids</div><ul><li>Vegetarian<strong> </strong>product.</li><li>Fortified</li><li>Contains vitamin a and vitamin D</li><li>Zero cholesterol</li><li>Zero trans fat</li><li>Country of Origin: India</li></ul><div><br></div>', 8, '2021-02-26 05:49:21', 1, '2021-12-31'),
(6, 10, 16, 'oil_olive_1', 'Del Monte Extra Light Olive Oil PET, 2L', 150000, 119900, 'oil_olive_1.jpg', 1, '<div><strong>Extra</strong>-<strong>light olive oil</strong> is often pale and mild, as it\'s been <strong>ultra</strong>-refined. <strong>Extra</strong>-<strong>light olive oil</strong> has a higher smoke point than regular or <strong>extra</strong>-virgin <strong>olive oil</strong>, so it can withstand hotter temperatures before breaking down and is best suited for use in baking, or types of cooking where a neutral-tasting <strong>oil</strong> is needed</div><ul><li>Brought to you from the house of Del Monte imported especially from Italy and Spain</li><li>Has light flavor &amp; aroma, ensures minimal change in the taste of preparation</li><li>Ideal for Indian cooking, including sauteing and deep frying</li></ul><div><br></div>', 9, '2021-02-26 06:03:59', 2, '2022-01-01'),
(7, 10, 15, 'oil_sunflower_1', 'Fortune Sunlite Refined Sunflower Oil, 5L Can', 120000, 99900, 'oil_sunflower_1.jpg', 1, '<div>High oleic <strong>sunflower oil</strong> is thought to provide some benefits for heart <strong>health</strong>. However, <strong>sunflower oil</strong> has been shown to release toxic compounds when heated to higher temperatures over time. Some varieties are also high in omega-6 and may contribute to inflammation in the body when consumed in excess.</div><ul><li>Light and healthy that is easy to digest</li><li>Rich in vitamins, which keeps skin healthy</li><li>Strengthens the immune system</li><li>Good for the heart</li><li>Country of Origin: India</li></ul>', 8, '2021-02-26 06:08:06', 1, '2022-01-15'),
(8, 10, 18, 'oil_cooking_1', 'Saffola Gold, Pro Healthy Lifestyle Cooking Oil, 5 L Jar', 79900, 59900, 'oil_cooking_1.jpg', 1, '<div><strong>Saffola Gold</strong> helps keep your <strong>cholesterol</strong> in check and ensures that your family stays heart-<strong>healthy</strong>. <strong>Saffola Gold\'s</strong> dual seed technology helps you achieve a <strong>good</strong> balance of <strong>healthy</strong> fatty acids like MUFA and PUFA for <strong>better</strong> nutrition through fats, unlike single seed <strong>oils</strong>.</div><ul><li>Saffola Gold’s Dual Seed Technology with goodness of 2 oils in 1, rice bran oil and sunflower oil, ensures a good balance of MUFA, PUFA for better nutrition through fats, compared to single seed oils</li><li>Get the power of immunity everyday with natural anti-oxidants in Saffola Gold that help build immunity</li><li>Saffola Gold blended edible oil helps keep your cholesterol in check</li><li>With Oryzanol that helps maintain healthy cholesterol levels</li><li>With LOSORB Technology that ensures your food absorbs upto 33% less oil, as compared to other commonly consumed cooking oils, basis frying studies on potato, 2019</li><li>This vegetable oil brings alive the natural flavour of the food cooked &amp; spices used, without altering any flavour</li></ul>', 7, '2021-02-26 06:12:34', 1, '2022-11-11'),
(9, 10, 17, 'oil_ricebran_1', 'Fortune Rice Bran Health Oil, 5L', 79900, 69500, 'oil_ricebran_1.jpg', 1, '<div><strong>Rice bran oil</strong> is also an excellent source of poly- and mono-unsaturated fats (the “<strong>good</strong> fats”). Studies have shown that consuming these unsaturated fats can improve blood <strong>cholesterol</strong> levels, which can decrease your risk of heart disease and type 2 diabetes.</div><ul><li>BLR/BOM</li><li>Fortified</li><li>Cholesterol lowering oil, heart friendly</li><li>Improves hdl and ldl ratio, healthier heart</li><li>Balanced pufa and mufa ratio, cleaner blood vessels</li><li>Country of Origin: India</li></ul><div><br></div>', 8, '2021-02-26 06:15:31', 1, '2022-12-31'),
(10, 11, 19, 'ghee_cow_1', 'Patanjali Cow\'s Ghee, 1L', 59900, 56500, 'ghee_cow_1.jpg', 1, '<div><strong>Patanjali cow ghee</strong> is ultimate in its <strong>pure</strong> quality and is advantageous to your whole family.</div><ul><li>Ghee calms Pitta and Vata. Hence, it is ideal for people with Vata-Pitta body type and for those suffering from Vata and Pitta imbalance disorders</li><li>Oral consumption of Cow Ghee to relieve dryness</li><li>Cow ghee is better for heart compares to other buffalo ghee</li><li>Patanjali Cow ghee contains only those fatty acids or saturated fat that are primarily 89% short chain fatty acids, compared with the longer chain with other animal fats. it is the long chain fatty acid that is associated with blood clotting and thrombosis</li><li>Patanjali Cow milk is easy to digestive and help hormone production and strengthening the cells membranes</li><li>It Helps in increasing intelligence and memory power</li><li>Boost body energy and detoxify the body</li><li>Country of Origin: India</li></ul>', 10, '2021-02-26 06:25:25', 1, '2021-12-31'),
(11, 12, 20, 'rice_basmati_1', 'Fortune Hamesha Basmati Rice, 5kg', 40000, 29500, 'rice_basmati_1.jpg', 1, '<ul><li>Vegetarian product.</li><li>Country of Origin: India</li></ul>', 8, '2021-02-26 06:38:04', 1, '2023-01-01'),
(12, 12, 21, 'rice_brown_1', 'Kohinoor Charminar Brown Rice, 1 Kg Pack', 10900, 7900, 'rice_brown_1.jpg', 1, '<div><strong>Brown rice</strong> is a highly nutritious, gluten-free grain that contains an impressive amount of vitamins, minerals and beneficial compounds. Consuming whole grains like <strong>brown rice</strong> can help prevent or improve several <strong>health</strong> conditions,</div><ul><li>[NUTRITIOUS BROWN RICE]: Charminar Brown Rice has long, delicate and soft grains that are full of flavor and aroma of the good old days.</li><li>[HEALTHY DISH]: Brown rice with low GI level and high fibre makes it a healthier option than regular rice</li><li>[RICE FOR HEALTH CONSCIOUS]: Tasty as well as nutritious, it’s the new choice of the health- conscious families of today</li><li>[EVERYDAY CONSUMPTION RICE]: Ideal for dishes prepared regularly in households like biryani, pulao &amp; steam rice</li><li>[VALUE FOR MONEY]: Affordable healthy rice from your favourite brand ‘Charminar’ by Kohinoor</li><li>[AVAILABLE IN]: Kohinoor Charminar Brown Rice also available in 5 Kg pack</li><li>[COMMONLY SEARCHED TOPICS]: real brown, real brown rice, authentic brown basmati rice, brown basmati, Charminar, Charminar rice, basmati rice, basmati rice recipe, rice recipe, fried rice, chawal recipe, chawal recipe, rice online, brown rice, brown rice 1kg pantry, kohinoor basmati rice, rice, kohinoor rice, brown rice for weight loss</li><li>Country of Origin: India</li></ul><div><br></div>', 11, '2021-02-26 06:40:27', 1, '2023-01-01'),
(13, 13, 23, 'sugar_white_1', 'Madhur Pure Sugar Bag, 5kg', 27000, 21900, 'sugar_white_1.jpg', 1, '<div><strong>Madhur sugar</strong> is of <strong>good</strong> quality.The grain size of <strong>sugar</strong> is big.</div><ul><li>Made of superior quality sugarcane</li><li>Sulphur free process</li><li>Natural sweetness</li><li>Untouched by hand</li><li>Country of Origin: India</li></ul><div><br></div>', 12, '2021-02-26 06:50:04', 1, '2022-01-01'),
(14, 14, 25, 'atta_wheat_1', 'Fortune Chakki Fresh Atta, 10kg', 41000, 35000, 'atta_wheat_1.jpg', 1, '<div>the perfect combo of taste and texture that fulfils the promise of soft roti. The <strong>Fortune</strong> Chakki <strong>Atta</strong> is made from some of the finest fields of handpicked wheat. It is made from 100% <strong>atta</strong> with 0% maida. We recommend <strong>Fortune</strong> as one of the <strong>Best</strong> Wheat <strong>Flour</strong> Brands in India.</div><ul><li>BOM</li><li>100 percent Atta 0 percent Maida</li><li>Natural chakki process retains the goodness and natural taste</li><li>Rich in dietary fibre</li></ul><div><br></div>', 8, '2021-02-26 07:22:33', 1, '2022-01-01'),
(15, 14, 24, 'atta_besan_1', 'Fortune Besan, 500g', 10000, 7500, 'atta_besan_1.jpg', 1, '<div>4.0 out of 5 stars <strong>Good</strong> everyday <strong>besan</strong> by <strong>Fortune</strong>!!! <strong>Fortune</strong> Chana <strong>Besan</strong> is very <strong>good</strong> for pakoda or any other cooking purposes.&nbsp;</div><ul><li>Processed from the best quality chana dal</li><li>Absolutely untouched by hands to maintain 100 percent hygiene</li><li>Advanced grinding process retains the aroma</li><li>Country of Origin: India</li></ul><div><br></div>', 8, '2021-02-26 07:24:59', 1, '2022-01-01'),
(16, 15, 27, 'salt_rock_1', 'TATA Salt Rock Salt, 1kg', 11000, 9900, 'salt_rock_1.jpg', 1, '<div><strong>Rock salt</strong> contains impurities, mostly minerals that are removed from <strong>salt</strong> that <strong>we use</strong> in our <strong>everyday cooking</strong></div><ul><li>Enjoy a fresh burst of flavour in every meal with TATA salt rock salt</li><li>It provides necessary nourishment for you and your family</li><li>Rich in natural trace minerals like potassium, calcium and magnesium</li><li>Country of Origin: India</li></ul><div><br></div>', 13, '2021-02-26 07:36:26', 1, '2022-01-01'),
(17, 15, 26, 'salt_simple_1', 'Tata Salt, 1kg', 2000, 1800, 'salt_simple_1.jpg', 1, '<div>Tata Salt&nbsp; contains 15% lower <strong>sodium</strong> content which will help regulate high <strong>blood pressure</strong>. This, however, does not change the taste of the food preparation</div><ul><li>Vacuum evaporated iodised salt</li><li>Lodine helps in mental development of children and prevents iodine deficiency disorders in adults</li><li>Tata salt has ventured into new product segments to meet the changing needs of its customers, adding tata salt lite, tata salt plus, sprinklers, tata black salt and tata rock salt to its repertoire</li></ul><div><br></div>', 13, '2021-02-26 07:38:14', 1, '2022-01-01'),
(18, 16, 28, 'dal_moong_1', 'Tata Sampann Moong Dal Split, 1kg', 16500, 15300, 'dal_moong_1.jpg', 1, '<div><strong>5.0 out of 5 stars</strong> Top quality. This mongdal is of best quality i have tasted so far. Good fragrance. Plus trust of tata product also matters.</div><ul><li>Aids in weight loss</li><li>Available Sizes: 200 gm, 500 gm and 1 kg</li><li>Packed with protein ; Product outer packaging may vary as per stock availability</li></ul>', 13, '2021-02-26 07:46:39', 1, '2022-01-01'),
(19, 1, 2, 'biscuits_glucose_1', 'Britannia Good Day', 12000, 11800, 'biscuits_glucose_1.jpg', 1, '<div>Britannia <strong>Good Day Biscuit</strong>, launched in 1986, is one of the company\'s flagship products. The recipe used in its preparation is purportedly wholesome with nuts and butter</div><ul><li>net weight: 600g</li><li>best relished in the company of your craziest, naughtiest friends</li><li>britannia biscuits are a great combination of taste and nutrition</li><li>Country string: India</li></ul>', 4, '2021-03-19 04:36:53', 1, '2021-03-19'),
(20, 18, 33, 'noodle_maggi_1', 'Maggi', 15000, 13000, 'noodle_maggi_1.jpg', 1, '<div>We cherish this trust shown by you and assure you that <strong>MAGGI</strong>® Noodles are completely safe for consumption. And we recommend you to enjoy your favourite <strong>MAGGI</strong>® Noodles as a light meal, as part of a balanced diet and an active lifestyle.</div><ul><li>MAGGI 2-Minute Masala Noodles is an instant noodles brand manufactured by Nestle</li><li>Made with the finest quality spices and ingredients</li><li>Each portion (70g) provides 15% of your daily Iron requirement</li><li>Ready in 2 minutes, perfect meal for a hang out or house party</li><li>Contains a noodle cake and the Favourite Masala Tastemaker inside, for a quick 2 minute preparation</li><li>Toll Free Number:1800-103-1947</li></ul>', 3, '2021-03-19 04:45:55', 1, '2021-07-06'),
(21, 17, 31, 'snacks_snacks_1', 'Balaji Waffer', 1500, 1000, 'snacks_snacks_1.png', 1, '<div>Balajee wafers is very tasty chips brand. Few flavours are available in the market. Best things of this brand is value of money. Balajee provides more chips in less price. Balajee chips healthy for every person. Packaging of this product is very good</div>', 6, '2021-03-19 04:49:40', 1, '2022-03-19'),
(22, 19, 34, 'drink_cofee_1', 'NESCAFÉ Classic Instant Coffee, 200g Dawn Jar', 50000, 45000, 'drink_cofee_1.jpg', 1, '<div>This saves you the trouble of going out to get delicious <strong>coffee</strong>. You can enjoy aromatic and rich <strong>coffee</strong> with your loved ones as this <strong>Nescafe instant coffee</strong> is made with carefully selected and roasted <strong>coffee</strong> beans.</div><ul><li>Start your day right with the first sip of this classic that awakens your senses to new opportunities</li><li>Premium frothy instant coffee right at home; a must try for all coffee-lovers</li><li>Made using specially selected and carefully roasted beans to create a captivating coffee experience</li><li>Flavourful and 100% pure coffee that is perfect for any time of the day. Maximum Shelf Life 24 Months</li><li>Specially designed NESCAFÉ glass jar keeps your coffee tasting delicious until the last drop</li></ul><div><br></div>', 15, '2021-03-19 04:57:05', 5, '2023-01-01'),
(23, 19, 35, 'drink_tea_1', 'Tata Tea Agni, 250g', 16000, 14900, 'drink_tea_1.jpg', 1, '<ul><li>With 10 percent Extra long leaves</li><li>Tata Tea Agni gives price-sensitive consumers a strong tea</li></ul>', 13, '2021-03-19 04:59:40', 1, '2022-01-19'),
(24, 20, 36, 'jam_jam_1', 'Kissan Mixed Fruit Jam 1 Kg', 50000, 45000, 'jam_jam_1.jpg', 1, '<ul><li>Kissan Mixed Fruit Jam is made with 100% real fruit ingredients</li><li>It is a delicious blend of fine fruits</li><li>Spreads easily with a spoon or a knife</li><li>Carefully sealed in an impermeable plastic packaging to retain the best flavour and taste of the product</li><li>Enjoy it best with Bread, Roti, Paratha or Dosa for a wholesome meal</li><li>It is easy to store, serve and use</li></ul>', 16, '2021-03-19 05:14:18', 1, '2022-02-19'),
(25, 20, 37, 'sauces_sauces_1', 'Kissan Fresh Tomato Ketchup, with 100% Real Tomatoes, 950 g Brand: Kissan', 25000, 20000, 'sauces_sauces_1.jpg', 1, '<ul><li>Kissan sources 100% of its tomatoes from sustainable sources thereby helping create and support several local smallholder farmers\' livelihoods</li><li>Is easy to pour and use and can be enjoyed with every snack</li><li>Made with 100% real tomatoes</li><li>Turns a boring meal into an empty tiffin</li><li>Enjoy it best with samosas, pakodas, noodles or Roti roll for an interesting tiffin meal</li><li>Carefully sealed in impermeable glass packaging to retain the best flavour and taste of product</li></ul>', 16, '2021-03-19 05:16:31', 1, '2022-01-02'),
(26, 10, 17, 'oil_ricebran_2', 'Fortune Rice Bran Health Oil, Cooking Oil for Healthier Heart, 1l Pouch', 25000, 25000, 'oil_ricebran_2.jpg', 1, '<ul><li>Cholesterol lowering, heart healthy cooking oil</li><li>Improves hdl and ldl ratio, healthier heart</li><li>Balanced pufa and mufa ratio, cleaner blood vessels</li><li>Rich in Natural Antioxidants: Boosts Immunity</li><li>[Commonly searched topics] rice bran oil, oil, edible oil, cooking oil, heart healthy oil</li></ul>', 8, '2021-03-27 15:54:57', 1, '2021-03-23'),
(27, 10, 15, 'oil_sunflower_2', 'Fortune Sunlite Refined Sunflower Oil, 1L', 50000, 44900, 'oil_sunflower_2.jpg', 1, '<ul><li>A light, healthy and nutritious oil that is easy to digest</li><li>Low in saturated fats and rich in natural vitamins</li><li>Rich in vitamins, which keeps skin healthy. Maximum Shelf Life 9 Months</li></ul>', 8, '2021-03-27 15:57:54', 1, '2023-11-30'),
(28, 10, 18, 'oil_cooking_2', 'Saffola Gold, Pro Healthy Lifestyle Cooking Oil, 1 L Pouch', 30000, 34600, 'oil_cooking_2.jpg', 1, '<ul><li>Saffola Gold, Pro Healthy Lifestyle, edible oil, is a blend of 70% refined rice bran oil and 30% imported refined sunflower oil</li><li>MUFA and PUFA: Saffola Gold edible oil has a good balance of MUFA &amp; PUFA as advised by NIN/ICMR</li><li>Dual Seed Technology: Gives you the goodness of two oils in one</li><li>LOSORB Technology: Results in upto 35%* lesser oil absorption in your fried food (*Basis frying studies on potato, 2018)</li><li>Saffola Gold blended cooking oil contains the power of natural anti-oxidants that helps reduce free radicals and thus helps keeps your heart healthy</li><li>Saffola Edible Oils are fortified with Vitamin A, D which helps against night blindness and supports strong bones</li></ul>', 7, '2021-03-27 16:00:06', 1, '2022-01-01'),
(29, 10, 14, 'oil_cooking_3', 'Saffola Tasty, Pro Fitness Conscious Cooking Oil, 1 L Pouch', 45000, 40000, 'oil_cooking_3.jpg', 1, '<ul><li>With LOSORB Technology that ensures your food absorbs upto 29% less oil</li><li>Saffola Tasty’s Dual Seed Technology gives you the goodness of 2 oils in 1. It ensures a good balance of MUFA and PUFA for better nutrition through fats, compared to single seed oils</li><li>With Oryzanol that helps maintain healthy cholesterol levels</li><li>Fortified with Vitamin A which helps against night blindness &amp; Vitamin D which supports strong bones</li><li>This vegetable oil brings alive the natural flavour of the food cooked &amp; spices used, without altering any flavour</li><li>High smoke point which is ideal for all types of cooking</li></ul><div><br></div>', 7, '2021-03-27 16:11:15', 1, '2022-01-18'),
(30, 10, 18, 'oil_cooking_4', 'Saffola Active, Pro Weight Watchers Cooking Oil, 1 L Pouch', 25000, 45000, 'oil_cooking_4.jpg', 1, '<ul><li>Saffola Active, Pro weight Watchers, edible oil is a unique blend of 80% refined rice bran oil and 20% soybean oil</li><li>Dual Seed Technology: Gives you the goodness of two oils in one</li><li>Saffola Active blended cooking oil has the combined benefits of Antioxidants and LOSORB Technology</li><li>LOSORB Technology: Results in upto 27%* lesser oil absorption in your fried food (*Basis frying studies on potato, 2018)</li><li>Since the quantity of oil consumed every day is as important as the right quality of oil you choose for daily cooking, Saffola Active, blended edible oil, helps you ensure both</li><li>Saffola Edible Oils are fortified with Vitamin A, D which helps against night blindness and supports strong bones. Maximum Shelf Life 8 Months</li></ul>', 7, '2021-03-27 16:13:00', 1, '2022-01-28'),
(31, 5, 5, 'chocolate_coco_1', 'Cadbury Celebrations Premium Assorted Chocolate Gift Pack, 281 g', 30000, 25000, 'chocolate_coco_1.jpg', 1, '<ul><li>Product packed and delivered with frozen gel packs (reusable) to maintain temperature &amp; quality during transit</li><li>Celebrate your special occasions with your favourite chocolates- Cadbury Dairy Milk, Cadbury 5 Star 3D, Cadbury Dairy Milk Fruit &amp; Nut, Cadbury Dairy Milk Roast Almond and Cadbury Dairy Milk Crackle</li><li>It stands for goodness. A moment of pure magic and unforgettable feeling!</li><li>Enrich festival celebrations with your friends and family with this special assorted chocolate box</li></ul><div><br></div>', 5, '2021-03-27 16:16:04', 1, '2021-03-31'),
(32, 5, 5, 'chocolate_coco_2', 'Cadbury Dairy Milk Chocolate Bar, 13.2 g', 5000, 2500, 'chocolate_coco_2.jpg', 1, '<ul><li>Delightfully rich, smooth and delicious chocolate with melt-in-the-mouth texture</li><li>Cadbury stands for goodness and a moment of pure magic!</li><li>Hurry up! Order now to experience the luscious taste of the classic Cadbury dairy milk chocolate bar</li></ul><div><br></div>', 5, '2021-03-27 16:18:15', 1, '2021-10-19'),
(33, 5, 5, 'chocolate_coco_3', 'Cadbury Dairy Milk Chocolate Bar, 24 g', 2000, 1500, 'chocolate_coco_3.jpg', 1, '<ul><li>Delightfully rich, smooth and delicious chocolate with melt-in-the-mouth texture</li><li>Cadbury stands for goodness and a moment of pure magic!</li><li>Hurry up! Order now to experience the luscious taste of the classic Cadbury dairy milk chocolate bar</li></ul><div><br></div>', 5, '2021-03-27 16:20:31', 1, '2022-01-01'),
(34, 5, 7, 'chocolate_coco_4', 'Cadbury Dairy Milk Silk Mousse Chocolate Bar, 3 x 116 g', 52500, 48500, 'chocolate_coco_4.jpg', 1, '<ul><li>Cadbury dairy milk silk is all about regaling in the chocolate\'s richness and creaminess</li><li>It has mousse bubbles with soft creamy chocolate inside</li><li>The exquisite taste of softer, smoother and silkier silk lasts in your mouth longer than anything else</li><li>This pack contains 3 units of Cadbury dairy milk mousse chocolate bar, 116g</li></ul><div><br></div>', 5, '2021-03-27 16:22:25', 1, '2022-01-01'),
(35, 5, 5, 'chocolate_coco_5', 'Cadbury Silk Special Potli, 343g', 65000, 64000, 'chocolate_coco_5.jpg', 1, '<ul><li>This potli contains 1 x Silk Bubbly 50g, 1 x Silk Fruit &amp; Nut 55g, 1 x Silk Oreo 60g, 1 x Silk Roast Almond 58g, 2 x Silk Plain 60g and a beautiful brass diya</li><li>Product packed and delivered with frozen gel packs (reusable) to maintain temperature &amp; quality during transit</li><li>Surprise your friends with this elegant Diwali Potli</li><li>Share the joy with this scrumptious pack of goodness. An ideal gift for your friends &amp; family on Diwali</li><li>Delicious gifting option of indulgent treats</li><li>Country of Origin: India</li></ul>', 5, '2021-03-27 16:24:01', 1, '2021-06-14'),
(36, 5, 6, 'chocolate_coco_6', 'Cadbury Dairy Milk Silk Roasted Almonds Chocolate Bar, 143g (Pack of 3)', 52500, 48500, 'chocolate_coco_6.jpg', 1, '<ul><li>Rich, smooth and creamy chocolate with more roasted almonds to make every bite nuttier and unforgettable</li><li>It\'s appeal lies in its easier to melt in the mouth quality</li><li>It stands for goodness, a moment of pure magic</li><li>Contains 3 packs of Cadbury dairy milk roasted almonds chocolate bar 137 gm each</li></ul><div><br></div>', 5, '2021-03-27 16:25:53', 1, '2021-10-05'),
(37, 5, 6, 'chocolate_coco_7', 'Cadbury Dairy Milk Silk Bubbly Chocolate bar, 120g (Pack of 3)', 52500, 47500, 'chocolate_coco_7.jpg', 1, '<ul><li>It is shaped like little bubbles with soft creamy chocolate inside</li><li>The soft and round chocolate bubbles on the outside sit deliciously in the roof of your mouth, whilst the bubbly centre melts into a smooth and creamy chocolate taste you will love</li><li>It stands for goodness, a moment of pure magic</li><li>Contains 3 packs of Cadbury dairy milk silk bubbly 120g each</li><li>Country of Origin: India</li></ul><div><br></div>', 5, '2021-03-27 16:27:20', 1, '2021-09-15'),
(38, 5, 6, 'chocolate_coco_8', 'Cadbury Dairy Milk Chocolate Home Treats Pack, 126 g', 10000, 7500, 'chocolate_coco_8.jpg', 1, '<ul><li>A bite for each one in the family</li><li>Cadbury Dairy Milk chocolate is for those everyday moments of joy that you want to share with your near and dear ones with something sweet</li><li>It stands for goodness a moment of pure magic</li></ul><div><br></div>', 5, '2021-03-27 16:29:32', 1, '2022-02-18'),
(39, 12, 20, 'rice_basmati_2', 'Fortune Rozana Basmati Rice, 1kg', 13000, 12400, 'rice_basmati_2.jpg', 1, '<ul><li>Enticing aroma</li><li>Suitable for all recipes</li><li>Hygienically packed</li><li>Budget friendly</li><li>Non-sticky after cooking</li><li>Cuisine: Basmati for daily use, for all rice dishes. Maximum Shelf Life : 24 Months. Color: White</li></ul><div><br></div>', 8, '2021-03-27 16:33:19', 1, '2021-06-15'),
(40, 12, 20, 'rice_basmati_3', 'Fortune Sona Masoori Rice, 5 kg', 50000, 45000, 'rice_basmati_3.jpg', 1, '<ul><li>Sona masoori raw rice from the house of Fortune</li><li>Aromatic rice</li><li>Best for making south Indian preparation like lemon rice</li><li>Curd rice</li><li>Tamarind rice etc</li></ul><div><br></div>', 8, '2021-03-27 16:38:29', 1, '2022-06-08'),
(41, 12, 20, 'rice_basmati_4', 'Fortune Special Biryani Basmati Rice, 5kg', 45000, 40000, 'rice_basmati_4.jpg', 1, '<ul><li>Longest basmati grain</li><li>Enticing aroma</li><li>Non-sticky after cooking</li><li>Fluffy long grain. Maximum Shelf Life 24 Months</li><li>Hygienically packed</li><li>Cuisine: All biryani</li></ul><div><br></div>', 8, '2021-03-27 16:40:18', 1, '2022-02-15'),
(42, 12, 20, 'rice_basmati_5', 'Kohinoor Authentic Royale Biryani Basmati Rice 5 Kg | Special Biryani Rice', 45000, 40000, 'rice_basmati_5.jpg', 1, '<ul><li>Best for preparation of biryani, pulao and jeera rice</li><li>More rice post cooking</li><li>Classic taste and pure eating pleasure</li></ul><div><br></div>', 11, '2021-03-27 16:41:54', 1, '2022-07-21'),
(43, 12, 20, 'rice_basmati_6', 'Kohinoor Super Value Basmati Rice, 1 Kg + 20% Extra | Authentic Basmati Rice', 50000, 45000, 'rice_basmati_6.jpg', 1, '<ul><li>[Authentic basmati rice]: Naturally curated and nurtured with the utmost care</li><li>[Value for money]: Extra value basmati rice with super aroma, superior length and supreme taste</li><li>[Flavourful and aromatic]: Ultimate taste and sweet earthy aroma enhance the rice-eating experience</li><li>[Everyday consumption rice]: Ideal for dishes prepared regularly in households like biryani, pulao &amp; steam rice</li><li>[Selected with care]: Carefully processed in a world class manufacturing facility for daily consumption</li><li>[Available in]: Kohinoor Super Value Authentic basmati rice also Available in 5 Kg pack</li><li>[Commonly seached topics]: real basmati, super value basmati, Authentic basmati rice, value basmati rice, basmati rice kohinoor, basmati rice, basmati rice recipe, rice recipe, fried rice, chawal recipe, chawal recipe, rice online, basmati, biryani rice, basmati rice 1kg pantry, kohinoor basmati rice, long grain rice</li></ul><div><br></div>', 11, '2021-03-27 16:43:26', 1, '2022-06-15'),
(44, 12, 20, 'rice_basmati_7', 'Charminar Select Basmati Rice 5 KG | Value Basmati rice', 80000, 75000, 'rice_basmati_7.jpg', 1, '<ul><li>Best value basmati</li><li>Everyday use basmati rice</li><li>Non-sticky</li><li>Delightful taste</li><li>Ideal for everyday dishes like steam rice, jeera rice, pulao, khichdi and kheer</li></ul><div><br></div>', 11, '2021-03-27 16:45:15', 1, '2022-03-27'),
(45, 12, 20, 'rice_basmati_8', 'Fortune Everyday Basmati Rice, 1kg', 45000, 40000, 'rice_basmati_8.jpg', 1, '<ul><li>Suitable for all recipes</li><li>Hygienically packed</li><li>Enticing aroma</li><li>Fluffy long grain</li><li>Slender long grain</li><li>Cuisine: Plain rice, jeera rice, fried rice, kheer and khichdi</li></ul><div><br></div>', 8, '2021-03-27 16:46:37', 1, '2022-01-18'),
(46, 12, 21, 'rice_basmati_9', 'FORTUNE Hamesha Basmati Rice, 5kg', 30000, 29900, 'rice_basmati_9.jpg', 1, '<ul><li>Suitable for everyday cooking</li><li>Smooth and slendor grain</li><li>Hygienically packed</li></ul><div><br></div>', 8, '2021-03-27 16:48:30', 1, '2023-01-27'),
(47, 17, 31, 'snacks_snacks_2', 'Balaji Wafers Stack Up (Pack of 4) (Simply Salted)', 3500, 3000, 'snacks_snacks_2.png', 1, '<div><br>This is a <strong>Vegetarian</strong> product</div>', 6, '2021-03-27 16:55:56', 1, '2023-01-09'),
(48, 17, 31, 'snacks_snacks_3', 'Balaji Waffer Masala Masti', 1500, 1000, 'snacks_snacks_3.png', 1, '<ul><li>very good taste with many flavor</li></ul><div><br><br></div>', 6, '2021-03-27 16:59:22', 1, '2021-03-30'),
(49, 17, 31, 'snacks_snacks_4', 'Balaji Cream Onion Wafers-135gm', 1500, 1000, 'snacks_snacks_4.png', 1, '<ul><li>Very Good Tasty</li><li>with good affordable price tag.</li></ul>', 6, '2021-03-27 17:01:27', 1, '2021-03-31'),
(50, 17, 31, 'snacks_snacks_5', 'Balaji Wafers Simply Salted 18 g', 1500, 1000, 'snacks_snacks_5.png', 1, '<ul><li>very good product with many taste</li></ul>', 6, '2021-03-27 17:05:02', 1, '2021-03-31'),
(51, 17, 31, 'snacks_snacks_6', 'Chips & Crisps Potato Chips and Crisps from Balaji', 1500, 1000, 'snacks_snacks_6.png', 1, '<ul><li>very good product</li><li>food taste</li></ul>', 6, '2021-03-27 17:06:34', 1, '2021-03-31'),
(52, 17, 31, 'snacks_snacks_7', 'Balaji Wafers', 1500, 1000, 'snacks_snacks_7.png', 1, '<ul><li>very good taste</li></ul>', 6, '2021-03-27 17:09:17', 1, '2021-03-31'),
(53, 17, 31, 'snacks_snacks_8', 'Balaji Wafers', 1500, 1000, 'snacks_snacks_8.png', 1, '<ul><li>very good taste</li></ul>', 6, '2021-03-27 17:10:16', 1, '2021-03-31'),
(54, 17, 31, 'snacks_snacks_9', 'Balaji Wafers', 1500, 1000, 'snacks_snacks_9.png', 1, '<ul><li>very good taste</li></ul>', 6, '2021-03-27 17:11:09', 1, '2021-04-01'),
(55, 17, 31, 'snacks_snacks_10', 'Balaji Wafers', 1500, 1000, 'snacks_snacks_10.png', 1, '<ul><li>very good product</li></ul>', 6, '2021-03-27 17:12:05', 1, '2021-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `products_tags`
--

DROP TABLE IF EXISTS `products_tags`;
CREATE TABLE IF NOT EXISTS `products_tags` (
  `products_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`products_id`,`tags_id`),
  KEY `IDX_E3AB5A2C6C8A81A9` (`products_id`),
  KEY `IDX_E3AB5A2C8D7B4FB4` (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_tags`
--

INSERT INTO `products_tags` (`products_id`, `tags_id`) VALUES
(3, 2),
(4, 2),
(4, 3),
(5, 5),
(5, 6),
(6, 5),
(6, 6),
(7, 5),
(7, 6),
(8, 5),
(8, 6),
(9, 5),
(9, 6),
(10, 5),
(10, 7),
(11, 1),
(11, 5),
(12, 1),
(12, 5),
(13, 5),
(13, 9),
(14, 5),
(14, 10),
(15, 5),
(15, 10),
(16, 5),
(16, 11),
(17, 5),
(17, 11),
(18, 5),
(18, 12),
(19, 13),
(20, 5),
(20, 13),
(21, 13),
(21, 14),
(22, 15),
(23, 15),
(24, 5),
(24, 13),
(25, 5),
(26, 5),
(26, 6),
(27, 5),
(27, 6),
(28, 5),
(28, 6),
(29, 5),
(29, 6),
(30, 5),
(30, 6),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 3),
(36, 2),
(37, 2),
(38, 2),
(39, 1),
(39, 5),
(40, 1),
(40, 5),
(41, 1),
(41, 5),
(42, 1),
(42, 5),
(43, 5),
(44, 1),
(44, 5),
(45, 1),
(45, 5),
(46, 1),
(47, 14),
(48, 14),
(49, 14),
(50, 14),
(51, 14),
(52, 14),
(53, 14),
(54, 14),
(55, 14);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BCE3F798BCE3F798` (`sub_category`),
  KEY `IDX_BCE3F79812469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `sub_category`) VALUES
(1, 1, 'Cream'),
(2, 1, 'Glucose'),
(5, 5, 'Dark Coco'),
(6, 5, 'White Coco'),
(7, 5, 'Medium Coco'),
(8, 1, 'Choco-chips'),
(12, 9, 'bar'),
(13, 9, 'liquid'),
(14, 10, 'SoyaBeanOil'),
(15, 10, 'SunFlowerOil'),
(16, 10, 'OliveOil'),
(17, 10, 'RiceBranOil'),
(18, 10, 'Cooking oil'),
(19, 11, 'Cow\'s Ghee'),
(20, 12, 'Basmati Rice'),
(21, 12, 'Brown Rice'),
(23, 13, 'White Sugar'),
(24, 14, 'Besan'),
(25, 14, 'Wheat'),
(26, 15, 'Simple'),
(27, 15, 'Rock'),
(28, 16, 'Moong'),
(29, 16, 'Chana'),
(30, 16, 'Masoor'),
(31, 17, 'Snacks'),
(33, 18, 'Noodle'),
(34, 19, 'Cofee'),
(35, 19, 'Tea'),
(36, 20, 'jam'),
(37, 20, 'sauces'),
(38, 21, 'Chocolate');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6FBC9426389B783` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(10, 'Atta'),
(16, 'Choco'),
(2, 'Chocolets'),
(5, 'Cooking Essentials'),
(12, 'Dal'),
(17, 'Dark'),
(3, 'Dark Chocolate'),
(15, 'Drink'),
(13, 'Food'),
(7, 'Ghee'),
(22, 'nSC1'),
(23, 'nSC2'),
(6, 'Oil'),
(1, 'Rice'),
(11, 'Salt'),
(14, 'Snacks'),
(9, 'Sugar'),
(4, 'White Coco');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_data_files`
--

DROP TABLE IF EXISTS `uploaded_data_files`;
CREATE TABLE IF NOT EXISTS `uploaded_data_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `uploaded_data` int(11) DEFAULT NULL,
  `error_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `already_in_database` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1208C918A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploaded_data_files`
--

INSERT INTO `uploaded_data_files` (`id`, `user_id`, `file_name`, `updated_at`, `uploaded_data`, `error_data`, `already_in_database`, `status`) VALUES
(12, 7, 'Book1.xlsx', '2021-04-13 13:30:15', 495, 'a:5:{i:0;i:12;i:1;i:103;i:2;i:110;i:3;i:164;i:4;i:326;}', 0, 'Under Process');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`) VALUES
(1, 'dhamimeet@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$MTVrNXhLcTRLdDlIbUlJdw$2IJHilBXpcWGlabYA+va2gA6STXnOXyAk3zp9rKczMU', 1),
(7, 'parthdadhaniya12345@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$b3AvLkpqTkxSZFNmYXBUbA$vZRritURAAp+k4J45g4ZunseIPwj+THeiGhJS3IDDTM', 1),
(10, 'meet@dhami.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$UHl6VldEUGI4N1d4c3Z2Rg$CB3pRGsfA+eaI7VvlAaPmxGcjIebtv7pax6LzJUM+LM', 1),
(12, 'noone@no.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$ODZsT0w1d3ZDbzdGY2JwRQ$thogcoV4lbULWFgptvryivg2hojUEuXqHFQhQNtwWhU', 1),
(18, 'parth@pd.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$QzBlRlBZOTR5TnBIRlQ3Vw$qxlZqgMMR1tJs7fPqXCahJNFo+BfgecGwgYOyrEVCkc', 1),
(22, 'abc@abc.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$V01FbW16VVRoTHM3NjNFag$xFwf7gSUs/4UAzw5+dneFgyF2bWKj30D4qhVvHbD8ek', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993989D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `FK_52EA1F094584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `FK_52EA1F09E238517C` FOREIGN KEY (`order_ref_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_B3BA5A5A12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_B3BA5A5A6D655FD8` FOREIGN KEY (`country_of_origin_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `FK_B3BA5A5A8F45BA9F` FOREIGN KEY (`product_brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `FK_B3BA5A5AF7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`);

--
-- Constraints for table `products_tags`
--
ALTER TABLE `products_tags`
  ADD CONSTRAINT `FK_E3AB5A2C6C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E3AB5A2C8D7B4FB4` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `FK_BCE3F79812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_data_files`
--
ALTER TABLE `uploaded_data_files`
  ADD CONSTRAINT `FK_1208C918A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
