-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 02:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `id` int(12) NOT NULL,
  `product_id` varchar(40) NOT NULL,
  `vendor_id` varchar(40) NOT NULL,
  `qty` varchar(140) NOT NULL,
  `address` longtext DEFAULT NULL,
  `assigned_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`id`, `product_id`, `vendor_id`, `qty`, `address`, `assigned_at`) VALUES
(1, '4', '15', '1', '2203 Musgrave Street Chandler, OK 74834', '2024-09-14 17:14:43'),
(2, '1', '16', '1', '76 Fox Lane, BODDAM ZE2 0FQ', '2024-09-14 17:18:46'),
(3, '1', '16', '3', '34 Walden Road GREAT WENHAM CO7 5SH', '2024-09-14 17:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `added_by`, `product_id`, `unit_price`, `quantity`, `added_at`, `updated_at`) VALUES
(13, 2, 1, 30.00, 1, '2024-10-16 05:41:02', '2024-10-16 05:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `name`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'Electronics encompasses a wide range of devices and gadgets that are essential in today’s digital world. \r\n This category includes televisions, speakers, smartphones, and computers. \r\n These products often feature advanced technology and innovative designs, \r\n catering to consumers’ needs for entertainment, communication, and productivity. \r\n With regular updates and new releases, electronics is a dynamic and ever-evolving category.', 1, 1, '2024-10-16 09:47:50', '2024-10-16 09:47:50'),
(2, 'Home Appliances', 'Home appliances are essential tools for modern living, designed to make daily tasks easier. \r\n This category includes washing machines, refrigerators, microwaves, and air conditioners. \r\n These appliances not only enhance convenience but also improve energy efficiency in households. \r\n Consumers rely on these products for their functionality and reliability in everyday chores. \r\n Innovations in home appliances continuously shape how we manage our homes.', 1, 1, '2024-10-16 09:47:50', '2024-10-16 09:47:50'),
(3, 'Furniture', 'Furniture refers to movable objects intended to support various human activities, such as sitting or sleeping. \r\n This category includes sofas, chairs, tables, beds, and cabinets. \r\n Furniture design varies widely, influenced by aesthetics, functionality, and comfort. \r\n High-quality furniture enhances living spaces and contributes to the overall ambiance of a home or office. \r\n Durable materials and craftsmanship are key considerations for consumers when selecting furniture.', 0, 1, '2024-10-16 09:47:50', '2024-10-16 10:17:21'),
(4, 'Clothing', 'Clothing includes garments worn on the body, serving both functional and aesthetic purposes. \r\n This category encompasses apparel for men, women, and children, including shirts, pants, and dresses. \r\n Fashion trends and cultural influences greatly affect clothing styles and choices. \r\n Consumers seek comfort, quality, and style when selecting their wardrobe. \r\n Sustainable and ethical fashion practices are becoming increasingly important in the clothing industry.', 1, 1, '2024-10-16 09:47:50', '2024-10-16 09:47:50'),
(5, 'Toys', 'Toys are objects designed for play and entertainment, primarily for children. \r\n This category includes dolls, action figures, puzzles, and educational games. \r\n Toys play a significant role in childhood development, fostering creativity and imagination. \r\n Parents often look for safe, age-appropriate options that encourage learning and fun. \r\n The toy industry continuously evolves, offering innovative products that capture children’s interest.', 0, 1, '2024-10-16 09:47:50', '2024-10-16 10:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(12) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Archie Craven', 'ArchieCraven@armyspy.com', '0158730126', 'I’m interested in learning more about your cloud-based data solutions. Specifically, I would like to know about your platform’s integration capabilities, scalability, analytics features, security measures, and pricing.\r\n\r\nCould you please provide more details or arrange a brief call to discuss further?', '2024-08-13 12:09:08'),
(2, 'James I. Berg', 'JamesIBerg@armyspy.com', '6183282270', 'An electronic product refers to a device that utilizes electronic science and technology, such as microelectronics and electronic computers, to process information, convert energy, and perform various functions like storage, computation, and control.', '2024-09-16 15:57:57'),
(3, 'john', 'john@dayrep.com', '089587335', 'Best Working', '2024-09-20 10:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `address_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `address_added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_address`
--

INSERT INTO `delivery_address` (`address_id`, `client_id`, `fullname`, `email`, `phone`, `address`, `city`, `state`, `country`, `zipcode`, `address_added_at`, `updated_at`) VALUES
(5, 3, 'John Doe', 'john@gmail.com', '01234567890', '123 Main St', 'London', 'England', 'United Kingdom', 'E1 6AN', '2024-10-16 11:01:29', '2024-10-16 11:01:29'),
(6, 3, 'Jane Smith', 'jane@gmail.com', '09876543210', '456 High St', 'Manchester', 'England', 'United Kingdom', 'M1 2BG', '2024-10-16 11:01:29', '2024-10-16 11:01:29'),
(8, 3, 'Emily Johnson', 'emily@gmail.com', '+441234987654', 'Flat 5, 15 High Street', 'Manchester', 'England', 'United Kingdom', '123456', '2024-10-17 05:24:20', '2024-10-17 05:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `offer_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `offer_title`, `description`, `discount_percentage`, `start_date`, `end_date`, `created_by`, `status`, `created_at`) VALUES
(1, 'Summer Sale', 'Enjoy a massive discount on all summer products!', 20.00, '2024-10-01 00:00:00', '2024-10-31 23:59:59', 1, 1, '2024-10-17 11:01:19'),
(2, 'Black Friday Deal', 'Get ready for the biggest sale of the year!', 30.00, '2024-11-24 00:00:00', '2024-11-25 23:59:59', 1, 1, '2024-10-17 11:01:19'),
(3, 'New Year Clearance', 'Clearance sale to kick off the new year with great savings!', 15.00, '2024-12-31 00:00:00', '2025-01-10 23:59:59', 1, 1, '2024-10-17 11:01:19'),
(4, 'Valentine Special', 'Special discounts on gifts for your loved ones.', 25.00, '2025-02-01 00:00:00', '2025-02-14 23:59:59', 1, 1, '2024-10-17 11:01:19'),
(5, 'Spring Collection Launch', 'Exclusive launch offers on our new spring collection.', 18.00, '2025-03-01 00:00:00', '2025-03-15 23:59:59', 1, 1, '2024-10-17 11:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `offer_products`
--

CREATE TABLE `offer_products` (
  `offer_product_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `product_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offer_products`
--

INSERT INTO `offer_products` (`offer_product_id`, `offer_id`, `product_id`) VALUES
(41, 1, 1),
(42, 1, 4),
(43, 2, 6),
(44, 2, 7),
(45, 3, 8),
(46, 3, 9),
(47, 4, 10),
(48, 4, 11),
(49, 5, 12),
(50, 5, 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(12) NOT NULL,
  `client_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_product` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Canceled','Placed','Pending','Delivered') NOT NULL,
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `address_id`, `total_product`, `total_amount`, `status`, `placed_at`, `updated_at`) VALUES
(24, 3, 6, 1, 55.00, 'Canceled', '2024-10-16 11:03:22', '2024-10-16 11:38:40'),
(25, 3, 5, 2, 109.00, 'Canceled', '2024-10-17 05:27:21', '2024-10-17 05:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `unit_price`, `quantity`, `total_amount`) VALUES
(32, 24, 1, 30.00, 1, 30.00),
(33, 25, 1, 30.00, 1, 30.00),
(34, 25, 25, 54.00, 1, 54.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(12) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `product_name` varchar(155) NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` longtext DEFAULT NULL,
  `storage_level` varchar(60) NOT NULL,
  `status` int(12) NOT NULL DEFAULT 1,
  `product_quantity` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `product_name`, `image`, `product_price`, `product_description`, `storage_level`, `status`, `product_quantity`, `created_at`) VALUES
(1, 1, 'SuperFlex Insulation Tape', '1725258924.png', 30.00, 'A high-performance insulation tape designed to withstand extreme temperatures, ensuring durability and reliability in demanding environments', 'High-Temperature Storage', 1, '200', '2024-09-02 12:05:24'),
(4, 1, 'Precision Air Filter', '1725264665.png', 545.00, 'A high-efficiency air filter that maintains optimal air quality by removing fine particulate matter, ideal for sensitive environments', 'Climate Controlled Rack', 1, '60', '2024-09-02 13:41:05'),
(6, 1, 'TV ', '1727168194.png', 945.00, 'Vivid crystal colors come to life, PurColor expresses the content you watch in vivid colors. It enables the TV to express a huge range of colors for optimal picture performance that translates into an immersive viewing experience.\r\n\r\n', 'D Series Crystal 4K Vivid Ultra HD Smart LED TV UA43DUE70BKL', 1, '56', '2024-09-24 14:26:34'),
(7, 1, 'LED', '1727171236.png', 786.00, 'With The Excellent Samsung Tv, Which Recognises Your Mood And Aims To Keep You Delighted Continually, You Can Take Advantage Of Rich, Clear, And Original Audiovisual Material In Its True Form. With Its Real 4k Resolution, The Samsung 138 Cm 55 Ultra Hd Led Smart Tizen Tv Allows You To See Every Hue. Thanks To The Potent 4k Upscaling, You Can Watch Your Preferred Entertainment In Excellent Quality And With Lifelike Visuals. The Tv Can Also Express A Wide Range Of Colours Thanks To Purcolor For The Best Possible Image Quality And An Enjoyable Watching Experience. Additionally, You Can Select Your Preferred Genres, Tv Shows, And Much More With The Smart Hub That Is Integrated Into This Tv So That You Can Spend More Time Enjoying Your Favourite Films And Games And Less Time Browsing.', 'Samsung 138 cm ,55 inches, Crystal iSmart 4K Ultra', 1, '32', '2024-09-24 15:17:16'),
(8, 2, 'Washing Machine', '1727171541.png', 677.00, 'The Washing Machine is a versatile and essential home appliance designed to automate the process of laundry. Featuring advanced technology, it efficiently cleans a variety of fabrics while conserving water and energy.', 'Samsung 8.0 kg Ecobubble™ Top Load Washing Machine, WA80BG44', 1, '76', '2024-09-24 15:22:21'),
(9, 2, 'Pigeon Oven', '1727171664.png', 344.00, 'The Oven is a fundamental kitchen appliance designed for baking, roasting, and cooking a variety of dishes. With advanced technology and user-friendly features, it enhances culinary experiences for home cooks and professional chefs alike.', '9-litre 12381 Oven Toaster Grill Otg', 1, '54', '2024-09-24 15:24:24'),
(10, 2, 'Mitsubishi AC', '1727171787.png', 896.00, 'The Air Conditioner is a vital appliance designed to regulate indoor temperature, humidity, and air quality, providing comfort in homes and commercial spaces. With advanced cooling technology, it creates a pleasant environment, especially in hot climates.', 'Heavy Duty SRK20CSS-S6 Split 3 Star 1.6 Ton Air Conditioner', 1, '67', '2024-09-24 15:26:27'),
(11, 2, 'AC', '1727171907.png', 667.00, 'Air conditioners come in various designs and finishes to blend seamlessly with home or office interiors. Wall-mounted units and sleek portable designs provide flexibility in placement.', 'Voltas 1 Ton (3 Star) Fixed speed Window AC with Copper Cond', 1, '56', '2024-09-24 15:28:27'),
(12, 2, 'VOLTZ VZ', '1727172490.png', 809.00, 'VOLTZ tools Product description It is up to 4000 kg capacity hydraulic shop press. Space saving desktop type compact, another pump put in. Features -Lightweight, compact even capacity 4000 kg (4 tons) -Hydraulic pump by putting type in a space-saving. -Working stroke is 120 mm -Work space is the room height 330 mm, width 350 mm -Working height can be adjusted in two types of extension bar -With a press plate -In a stylish red, a garage. Specifications', 'Hydraulic shop press Workshop Hand Press 4 ton Capacity Floo', 1, '76', '2024-09-24 15:38:10'),
(13, 1, 'HP Printer', '1727172805.png', 890.00, 'A Color Printer is a versatile device designed to produce high-quality color prints for documents, photos, and graphics. Ideal for both home and office use, it combines functionality with efficiency to meet various printing needs', '2331 Multi-function Color Inkjet Printer', 1, '88', '2024-09-24 15:43:25'),
(14, 1, 'Samsung', '1727173094.png', 789.00, 'The Washing Machine is a vital home appliance designed to simplify the laundry process by automating washing and rinsing of clothes. With a variety of features and technologies, it ensures efficient cleaning while being user-friendly.', '12.0 kg Front Load Washing Machine with SmartThings AI & Ene', 1, '65', '2024-09-24 15:48:14'),
(15, 1, 'Black Decker', '1727173819.png', 345.00, 'A Clothes Press is an appliance designed specifically to remove wrinkles and creases from garments, ensuring they look neat and polished. It can refer to both traditional irons and more specialized garment steamers', 'Typically measured in kilograms, ranging from 6kg for compac', 1, '223', '2024-09-24 16:00:19'),
(16, 2, 'LG Refrigerator', '1727174397.png', 890.00, '\r\nAll of your vegetables, fruits, dairy products, beverages, and more can be accommodated with ease in the LG 674 L Frost-free Side-by-side Refrigerator. Boasting InstaView Door-in-Door, it is made with a thin mirrored glass panel that gets lit up when you knock on it twice, letting you see the contents without opening the door. Also, this refrigerator features DoorCooling+ and Multi Air Flow that helps cool air to spread to areas that usually lose air soon, thereby ensuring cooling everywhere. Moreover, UV Nano, a self-cleaning water dispenser cleans inside its nozzle on its own every hour for up to 10 minutes to ensure hygiene.', 'LG 674 L Frost Free Inverter Linear Thinq InstaView Door in ', 1, '8', '2024-09-24 16:09:57'),
(17, 2, 'Whirlpool Refrigerator', '1727175029.png', 856.00, 'The Whirlpool 327 L Frost Free Double Door Refrigerator combines modern technology, ample storage, and energy efficiency, making it a great addition to any kitchen. Its stylish design and practical features ensure that your food stays fresh and your kitchen remains organized.', 'Whirlpool 308 Litre 2 Star Convertible Frost Free Double Doo', 1, '23', '2024-09-24 16:20:29'),
(18, 1, 'Marshall Speakers', '1727176302.png', 965.00, 'Marshall Speakers are renowned for their iconic design, powerful sound quality, and portability, making them a popular choice for music enthusiasts. Inspired by the classic Marshall amplifiers, these speakers blend retro aesthetics with modern technology.', 'Marshall Acton III Wired Connectivity Stereo Home Speakers w', 1, '87', '2024-09-24 16:41:42'),
(19, 1, 'Zebronics Speaker', '1727176401.png', 256.00, 'Zeb-Warrior is a USB powered 2.0 speaker best fit for your gaming experience as it comes in a modern design and adds an element with its breathing RGB LED lights', 'Zebronics Zeb-Warrior 2.0 Multimedia Speaker With Aux Connec', 1, '56', '2024-09-24 16:43:21'),
(20, 1, 'Apple iPhone ', '1727176525.png', 456.00, 'Dive into a world of crystal-clear visuals with this iPhone’s Super Retina XDR Display. This beast of a smartphone packs the A14 Bionic chip to make for blazing-fast performance speeds. On top of that, its Dual-camera System, along with Night Mode, helps you click amazing pictures and selfies even when the lighting isn’t as good as you’d want it to be.', 'Apple iPhone 12', 1, '67', '2024-09-24 16:45:25'),
(21, 1, 'OnePlus', '1727176667.png', 1898.00, 'OnePlus is a renowned technology brand known for its high-performance smartphones and accessories, offering premium features at competitive prices. Their devices are designed with a focus on speed, quality, and user experience.', '16 GB RAM + 512 GB StorageEmerald Dusk', 1, '5', '2024-09-24 16:47:47'),
(22, 2, ' Vacuum Cleaner', '1727176789.png', 876.00, 'A Vacuum Cleaner is an essential household appliance designed to remove dirt, dust, and debris from floors and other surfaces, contributing to a cleaner and healthier living environment. Modern vacuum cleaners come in various types and styles, each tailored for specific cleaning needs.', 'Philips PowerPro FC9352/01 Compact Bagless Vacuum Cleaner', 1, '76', '2024-09-24 16:49:49'),
(23, 2, 'Vacuum Cleaner', '1727176882.png', 768.00, 'Vacuum cleaners are invaluable for maintaining cleanliness and hygiene in your home. With various types and features available, there’s a vacuum cleaner suited for every cleaning need, whether for carpets, hard floors, or tight spaces.', 'Eureka Forbes Super Clean Vacuum Cleaner (Red & Black)', 1, '17', '2024-09-24 16:51:22'),
(24, 2, 'Marks  Spencer', '1727178296.png', 35.00, 'The Boys Abstract Printed Long Sleeves Pure Cotton T-shirt is a stylish and comfortable wardrobe essential designed for toddlers aged 2-3 years. Perfect for casual outings or playtime, this T-shirt combines playful design with soft, breathable fabric.', 'Boys Abstract Printed Long Sleeves Pure Cotton T-shirt', 1, '677', '2024-09-24 17:14:56'),
(25, 4, 'Marvel by Wear Your Mind', '1727178415.png', 54.00, 'Marvel by Wear Your Mind is a unique clothing line that merges fandom with fashion, offering a range of stylish apparel and accessories inspired by beloved Marvel characters and stories. This collection is designed for fans who want to express their love for the Marvel universe while staying trendy.', 'Boys Pack Of 2 Spiderman Printed Round Neck T-shirt', 1, '645', '2024-09-24 17:16:55'),
(26, 4, 'Maniac T shirt', '1727178555.png', 67.00, 'Beige Tshirt for men\r\nprinted\r\nLongline length\r\nRound neck\r\nShort, regular sleeves\r\nKnitted cotton fabric', 'Striped Round Neck T-shirt', 1, '66', '2024-09-24 17:19:15'),
(27, 4, 'RCode by The Roadster Life Co', '1727178637.png', 44.00, 'Steel T-shirt for men\r\nPrinted\r\nRegular length\r\nRound neck\r\nLong, Extended sleeves\r\nKnitted', 'Men Typography Printed Round Neck Cotton Oversized T-shirt', 1, '33', '2024-09-24 17:20:37'),
(29, 3, 'VStar', '1727178787.png', 23.00, 'lack solid stretchable blouse has a scoop neck in front & closed neck at back, short sleeves and slip on closure', 'Stretchable Saree Blouse', 1, '54', '2024-09-24 17:23:07'),
(30, 3, 'Anayna', '1727178863.png', 454.00, 'Maroon, Beige & Black Printed A-Line Flared Cotton Maxi Skirt', 'Anayna Women Printed A-Line Flared Cotton Maxi Skirt', 1, '56', '2024-09-24 17:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(12) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `product_name` varchar(155) NOT NULL,
  `customer_phone` varchar(80) NOT NULL,
  `review` longtext DEFAULT NULL,
  `created_by` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_name`, `product_name`, `customer_phone`, `review`, `created_by`) VALUES
(1, 'Connor Marsh', 'SuperFlex Insulation Tape', '092 851 536', 'SuperFlex Insulation Tape works great for keeping things insulated and is easy to apply. It sticks well and performs as advertised. My only gripe is that it’s a bit pricey and sometimes doesn’t stick to rough surfaces. Overall, a solid choice for insulation needs.', '2024-09-14 14:05:11'),
(2, 'Max Leonard', 'Precision Air Filter', '05 3833 6132', 'The Precision Air Filter does an excellent job of capturing dust and allergens, significantly improving air quality. It fits perfectly and is easy to install. My only issue is that it’s a bit more expensive than other filters, but the performance makes it worth the extra cost. Overall, it’s a great choice for anyone looking to enhance their indoor air quality.', '2024-09-14 14:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('1','2','3','4') NOT NULL COMMENT '1=Admin,2=User,3=staff,4=vendor\r\n',
  `name` varchar(80) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` int(12) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `contact`, `email`, `password`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Manager', '07 3803 6136', 'Manager@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Address', 1, '2024-04-14 20:10:42', '2024-09-24 07:44:00'),
(2, '2', 'Connor Marsh', '092 851 536', 'ConnorMarsh@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '52 Cheriton Rd, WEST STONESDALE DL11 6PE', 1, '2024-04-15 19:41:08', '2024-09-03 05:24:10'),
(3, '2', 'Jayden Young', '078 349 066', 'JaydenYoung@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '76 Fox Lane, BODDAM ZE2 0FQ', 1, '2024-04-15 19:42:45', '2024-09-02 05:28:32'),
(5, '2', 'Noah Dean', '07 3803 6139', 'NoahDean@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '34 Walden Road GREAT WENHAM CO7 5SH', 1, '2024-08-12 03:17:44', '2024-09-02 05:24:01'),
(6, '2', 'Max Leonard', '05 3833 6132', 'MaxLeonard@jourrapid0.com', '25d55ad283aa400af464c76d713c07ad', '2203 Musgrave Street\nChandler, OK 74834', 1, '2024-08-12 03:28:01', '2024-09-02 05:24:18'),
(8, '2', 'Venessa G. Conner', '09 3803 6136', 'VenessaGConner@teleworm.us', '25d55ad283aa400af464c76d713c07ad', '766 Davis Place Lima, OH 45801', 1, '2024-08-12 04:32:21', '2024-09-02 05:24:29'),
(9, '2', 'Archie Craven', '03 3853 6139', 'ArchieCraven@armyspy.com', '25d55ad283aa400af464c76d713c07ad', '92 Ross Street NATURAL BRIDGE QLD 4211', 1, '2024-08-12 06:59:30', '2024-09-03 05:21:40'),
(10, '3', 'Cornelius G Tripp', '636-299-5837', 'CorneliusGTripp@dayrep.com', '25d55ad283aa400af464c76d713c07ad', '922 Ross Street NATURAL BRIDGE QLD 4211', 1, '2024-09-02 07:25:15', '2024-09-03 05:12:11'),
(11, '3', 'Riley Seekamp', '586-771-1774', 'RileySeekamp@dayrep.com', '25d55ad283aa400af464c76d713c07ad', '2265 Ritter Avenue Roseville, MI 48066', 1, '2024-09-02 08:08:02', '2024-09-02 08:08:59'),
(12, '3', 'Joel Forro', '915-873-0126', 'JoelForro@teleworm.us', '25d55ad283aa400af464c76d713c07ad', '4352 Frederick Street\r\nEl Paso, TX 79906', 1, '2024-09-02 08:09:38', '2024-09-02 10:51:11'),
(15, '4', 'Isabel Shea', '(02) 6111 1170', 'IsabelOShea@armyspy.com', '25d55ad283aa400af464c76d713c07ad', '68 Scenic Road\r\nPRIMROSE VALLEY NSW 2621', 1, '2024-09-14 06:40:02', '2024-09-16 12:07:04'),
(16, '4', 'Claire Levvy', '(03) 5305 8657', 'ClaireLevvy@jourrapide.com', '25d55ad283aa400af464c76d713c07ad', '36 Bourke Crescent\r\nVASEY VIC 3407', 1, '2024-09-14 11:47:51', '2024-09-14 11:47:51'),
(17, '2', 'Eun Hunter', '2294206117', 'EunTHunter@jourrapide.com', '25d55ad283aa400af464c76d713c07ad', '3959 Duck Creek Road San Francisco, CA 94108', 1, '2024-09-16 05:55:24', '2024-09-16 06:07:41'),
(18, '2', 'Jennifer Creasey', '7062867508', 'JenniferLCreasey@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '4659 Holly Street Athens, GA 30608', 1, '2024-09-16 06:03:43', '2024-09-16 06:03:43'),
(19, '2', 'Hiram  Ester', '6175003630', 'HiramLEster@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '2796 Hinkle Lake Road Cambridge, MA 02141', 1, '2024-09-16 11:53:05', '2024-09-16 11:53:05'),
(20, '4', 'ClaireLevvy', '(03) 5305 8657', 'ClaireLessvvy@jourrapide.com', '25d55ad283aa400af464c76d713c07ad', '36 Bourke Crescent\r\nVASEY VIC 3407S', 1, '2024-09-16 12:06:15', '2024-09-16 12:06:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk5` (`added_by`),
  ADD KEY `fk6` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `fk21` (`created_by`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `fk13` (`client_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD PRIMARY KEY (`offer_product_id`),
  ADD KEY `offer_id` (`offer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk9` (`client_id`),
  ADD KEY `fk10` (`address_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `fk7` (`order_id`),
  ADD KEY `fk8` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned`
--
ALTER TABLE `assigned`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `offer_products`
--
ALTER TABLE `offer_products`
  MODIFY `offer_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk5` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk6` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk21` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD CONSTRAINT `fk13` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD CONSTRAINT `offer_products_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`offer_id`),
  ADD CONSTRAINT `offer_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk10` FOREIGN KEY (`address_id`) REFERENCES `delivery_address` (`address_id`),
  ADD CONSTRAINT `fk9` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk7` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk8` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
