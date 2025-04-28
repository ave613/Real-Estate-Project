-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 08:48 AM
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
-- Database: `real_estate`
--

-- --------------------------------------------------------

--
-- Table structure for table `insert_info`
--

CREATE TABLE `insert_info` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `p_id` int(11) NOT NULL,
  `type` enum('rent','sale') NOT NULL,
  `category` enum('apartment','condo','house') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insert_info`
--

INSERT INTO `insert_info` (`id`, `title`, `image`, `firstname`, `lastname`, `email`, `phone`, `message`, `created_at`, `p_id`, `type`, `category`) VALUES
(1, 'Dagon Myothit House', '4.jpg', 'Thu Thu', 'Win', 'thuthuwin123@gmail.com', '0993423553', 'Is the asking price\nfor this property\nnegotiable? Do you\noffer any financing\noptions or\nrecommend\nmortgage lenders?', '2025-02-07 16:45:12', 4, 'sale', 'house'),
(2, 'Sanchaung Garden Condo', '7.jpg', 'Theint', 'Nay Chi', 'theintnaychi345@gmail.com', '09943534535', 'Hi, I\'m interested in\nthis condo. Can you\nprovide more details\nabout the\nneighborhood and\nnearby amenities?', '2025-02-07 17:07:12', 7, 'sale', 'condo'),
(3, 'Apartment', '49.jpg', 'Nann ', 'Khin ', 'Nann1@gmail.com', '0993423553', 'I’m interested in this property. Could you provide more details about the amenities and payment options?', '2025-02-07 18:28:31', 49, 'rent', 'apartment'),
(4, 'Thiri Condo', '1.jpg', 'Theint', 'Nay Chi', 'theintnaychi345@gmail.com', '09943534535', 'Hello, I\'m interested in\nthis condo. Can you\nprovide more details\nabout the\nneighborhood and\nnearby amenities?', '2025-02-07 18:41:15', 1, 'rent', 'apartment'),
(5, 'Apartment', '39.jpg', 'Thu Thu', 'Win', 'thuthuwin123@gmail.com', '0993423553', 'I would like to visit and talk to the seller in person.', '2025-02-11 04:58:20', 39, 'rent', 'apartment'),
(6, 'Condo in Hlaing', '22.jpg', 'MT', 'S', 'maythetswecu@gmail.com', '09943534535', 'Contact me', '2025-03-06 06:56:20', 22, 'rent', 'apartment');

-- --------------------------------------------------------

--
-- Table structure for table `property_details`
--

CREATE TABLE `property_details` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `township` enum('Hlaing','Lanmadaw','Sanchaung','Kamaryut','Dagon','Mayangone','South Dagon','North Dagon','North Okkalapa','South Okkalapa','Kyi Myin Tine','Pazundaung','Bahan','Hlaing Tharyar') NOT NULL,
  `size` int(11) DEFAULT NULL,
  `beds` int(11) NOT NULL,
  `baths` int(11) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `features` text NOT NULL,
  `description` text NOT NULL,
  `type` enum('Sale','Rent') NOT NULL DEFAULT 'Sale',
  `moderation_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` enum('Apartment','Condo','House') NOT NULL DEFAULT 'Apartment',
  `transaction_img` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_details`
--

INSERT INTO `property_details` (`id`, `title`, `location`, `township`, `size`, `beds`, `baths`, `price`, `features`, `description`, `type`, `moderation_status`, `created_at`, `category`, `transaction_img`, `phone`, `user_email`) VALUES
(1, 'Thiri Condo', 'Thiri Condo (Ocean), 9 1/2 Mile, Pyay Road, Mayangone', 'Mayangone', 1350, 3, 2, 7, 'Fully-furnished, Air-con in all rooms, Teak parquet floor, 24 Hour Security, Swimming Pool, Garden, Car Parking', 'Welcome to Thiri Condo (Ocean), a luxurious and fully furnished residence located in the prime area of 9 1/2 Mile, Pyay Road, Mayangone. Located in a highly sought-after area, the condo offers easy access to major roads, shopping centers, restaurants, international schools, and other essential services, making daily life hassle-free. Whether you are looking for a long-term rental option or a comfortable space to settle in, Thiri Condo (Ocean) presents an excellent opportunity for luxurious and convenient living in Yangon.', 'Rent', 'Approved', '2025-01-19 12:13:52', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(2, 'Condo in Mayangone', 'Kabaraye Gamone Pwint Condo, Mayangone, Yangon', 'Mayangone', 2000, 3, 2, 6000, 'Spacious Rooms, City View, Convenient Location, Car Parking, 24hr Security', 'This spacious 2,000 sq. ft. apartment for sale offers 3 bedrooms, 2 bathrooms, and stunning city views in a prime Yangon location. With secure parking and 24-hour security, it’s a perfect home for those seeking comfort and convenience.', 'Sale', 'Approved', '2025-01-19 12:13:52', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(3, 'Apartment Near Kawel Chan Bus Stop', 'Near Kawel Chan Bus Stop, Mayangone, Yangon Region', 'Mayangone', 1200, 2, 1, 3, 'Close to Public Transport, Modern Design, Affordable Rent', 'A perfect blend of affordability and convenience in Mayangone. Featuring 2 bedrooms and 1 bathroom, it is designed for comfortable city living. Located just a short walk from Kawel Chan Bus Stop, it provides easy access to public transport, shops, and restaurants. With a modern interior and a budget-friendly rental price, this apartment is an excellent choice for those looking for a well-connected home in Yangon.', 'Rent', 'Approved', '2025-01-19 12:13:52', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(4, 'Dagon Myothit House', 'Dagon Myothit (South), Yangon Region', 'South Dagon', 2500, 4, 3, 1500, 'Private Garden, Spacious Living Room, Two-Storey, Garage, 24/7 Security', 'Located in a peaceful residential area of Dagon Myothit (South), this spacious two-storey house offers a serene living environment. It features a large private garden, an expansive living room, and a well-equipped kitchen. With four bedrooms and three bathrooms, this house is ideal for large families. The property also includes a secure garage and 24/7 security for added peace of mind.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(5, 'Apartment in South Dagon', 'South Dagon Township, Yangon Region', 'South Dagon', 1200, 2, 1, 5, 'Affordable, Well-Ventilated, Near Public Transport, Secure Building', 'This affordable apartment in South Dagon Township is perfect for small families or professionals looking for a well-ventilated and cozy living space. Located near public transportation and local markets, it ensures a convenient lifestyle. The building has good security and essential amenities for a comfortable stay.', 'Rent', 'Approved', '2025-01-20 11:10:45', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(6, 'Luxury Estate near BRP Bus Stop', 'Kamar Yut, BRP Bus Stop, Yangon', 'Kamaryut', 3000, 5, 4, 1500, 'Spacious Lawn, Multiple Balconies, Gated Community, Swimming Pool Access, Backup Generator', 'This stunning estate in Kamar Yut is conveniently located near the BRP Bus Stop, offering easy access to major city areas. The property features a large lawn, multiple balconies, and spacious interiors designed for luxury living. As part of a gated community, residents have access to a swimming pool, a fitness center, and a backup generator for uninterrupted power supply.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(7, 'Sanchaung Garden Condo', 'Sanchaung Garden 10th Floor, Sanchaung, Yangon', 'Sanchaung', 1600, 1, 2, 2950, 'Swimming Pool, Gym, Children’s Play Area, Fully Furnished, Secure Parking', 'This luxury condo at Sanchaung Garden offers a blend of elegance and convenience. The spacious apartment is fully furnished with high-end fittings, a well-equipped kitchen, and modern bathrooms. Residents can enjoy premium facilities such as a swimming pool, gym, and children’s play area, making it a perfect home for those who appreciate a luxurious lifestyle.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(8, 'Estate in South Dagon', '55th Quarter, South Dagon, Yangon', 'South Dagon', 1800, 2, 1, 1600, 'Modern Design, Private Garden, Safe Neighborhood, Gated Community', 'A beautiful estate located in a peaceful neighborhood of South Dagon. The property features a modern design with a private garden and spacious interiors. Ideal for families looking for a secure and comfortable home. The gated community offers added security and privacy.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(9, 'Pazundaung Apartment', 'Pazundaung Township, Yangon Region', 'Pazundaung', 1300, 1, 1, 5, 'Affordable, Near Market and Schools, Public Transport Access', 'This well-located apartment in Pazundaung offers an affordable rental option with easy access to markets, schools, and public transportation. Perfect for working professionals or small families looking for a budget-friendly and convenient place to stay.', 'Rent', 'Approved', '2025-01-20 11:10:45', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(10, 'Dagon Myothit Apartment', 'Dagon Myothit (South), Yangon Region', 'South Dagon', 1400, 2, 2, 1500, 'Modern Facilities, Close to Shopping Malls, 24/7 Security', 'A stylish apartment in Dagon Myothit (South) with modern facilities, spacious rooms, and a well-planned layout. The property is conveniently located near major shopping centers and comes with 24/7 security for added peace of mind.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(11, 'North Okkalapa Apartment', 'North Okkalapa, Yangon Region', 'North Okkalapa', 1500, 2, 2, 2500, 'Newly Renovated, Secure Parking, Spacious Interior, Prime Location', 'This newly renovated apartment in North Okkalapa is perfect for families looking for a spacious and modern home. With secure parking and a prime location, it offers convenience and comfort in one package.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(12, 'Luxury Home in South Dagon', 'No. 531B, Shwe Kan Kaw 3rd Street, 55th Quarter, South Dagon, Yangon', 'South Dagon', 2000, 1, 3, 2100, 'Elegant Design, High-End Interiors, Fully Furnished, Large Living Area', 'An exquisite luxury home located in the 55th Quarter of South Dagon. This beautifully designed property features high-end interiors, spacious living areas, and is fully furnished for a move-in-ready experience. A perfect choice for buyers seeking elegance and comfort.', 'Sale', 'Approved', '2025-01-20 11:10:45', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(13, 'San Chaung Apartment', 'Thandandar Road, near ABC mart, San Chaung', 'Sanchaung', 1200, 3, 2, 6, 'Luxury interior desing with 2 aircon, has a great car-parking', 'Nestled in a prime location, this apartment features contemporary interiors, abundant natural light, and all the amenities you need for a vibrant lifestyle.', 'Rent', 'Approved', '2025-01-25 23:07:15', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(14, 'Beautiful Condo in SanChanung', 'SanChaung Garden,10th floor', 'Sanchaung', 1056, 2, 2, 8, 'with breath-taking views and wide balcony and ar Parking ,24hr Security,Lift , Swimming Pool , GYM ,\r\n24hr M&E Team', 'This condo offers state-of-the-art appliances, designer touches, and access to premium amenities like a fitness center and rooftop lounge.', 'Rent', 'Approved', '2025-01-25 23:23:27', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(15, 'House in Sanchaung', '566 ,Baho Road, Sanchaung', 'Sanchaung', 2300, 3, 1, 15000, 'Family-friendly features with Customizable  spaces, has a premium finish', 'Located in the prime location and With ample space, a functional layout, and a safe neighborhood, this apartment is perfect for creating lasting moments with your loved ones.', 'Sale', 'Approved', '2025-01-25 23:52:46', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(16, 'Apartment in Kamaryut', '12, Padanmyar street,  Kamaryut', 'Kamaryut', 12, 1, 1, 4, '1 aircon and decorated celling, morden toilet and open-concept living areas', 'Thoughtfully crafted with comfort in mind, this apartment offers spacious layouts, modern finishes, and a welcoming atmosphere.\r\n\r\n\r\n\r\n', 'Rent', 'Approved', '2025-01-26 00:07:07', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(17, 'high-quality house in Kamaryut', '5th street, Kamaryut', 'Kamaryut', 3200, 5, 3, 32000, 'A spacious 5-bedroom house featuring 4 bathrooms and a total area of 3,200 square feet. Ideal for large families seeking ample living space.', 'This modern house is a perfect blend of contemporary design and functionality. Featuring open-concept layouts, clean lines, and high-end finishes, it offers a space that feels both elegant and welcoming.', 'Sale', 'Approved', '2025-01-26 00:46:50', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(18, '3-bedroom condo in Kamaryut', 'No .1/3 , ShwegonDiang  4th st, Kamaryut', 'Kamaryut', 1700, 3, 2, 4500, 'A 1,700 square feet condo comprising one master bedroom with an ensuite and two single bedrooms. Fully furnished with essentials like a TV, sofa set, dining table, beds, washing machine, and refrigerator', 'Experience a condo that celebrates natural light and airy interiors. With large windows, neutral palettes, and seamless indoor-outdoor flow, this modern house creates a serene environment for living and entertaining.', 'Sale', 'Approved', '2025-01-26 00:50:38', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(19, '3-bedroom condo in Time-city', 'Time city, Kamayut', 'Kamaryut', 1695, 3, 2, 15000, 'A condo comprising one master bedroom with an ensuite and two single bedrooms. Fully furnished with essentials like a TV, sofa set, dining table, beds, washing machine, and refrigerator.', 'Nestled in a prime urban location, this modern condo offers a private sanctuary. With sleek designs and tranquil outdoor spaces, it\'s perfect for balancing city living with peaceful retreat vibes.', 'Sale', 'Approved', '2025-01-26 01:07:17', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(20, 'House in Kamaryut', ' Near M tower , Hlaedan', 'Kamaryut', 1000, 2, 2, 8, 'has 3 aircons and fully furnished with High ceilings and large windows for natural light.', 'Experience a home that celebrates natural light and airy interiors. With large windows, neutral palettes, and seamless indoor-outdoor flow, this modern house creates a serene environment for living and entertaining.', 'Rent', 'Approved', '2025-01-26 01:13:40', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(21, 'Apartment in Mayangone', 'Near Khawaechan Bustop, Mayangone', 'Mayangone', 2500, 3, 1, 9, 'Near with EV charging stations and bike storag and Bus-stop', 'From exposed brick walls to vintage fixtures, this apartment combines old-world charm with modern conveniences.', 'Rent', 'Approved', '2025-01-26 01:19:41', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(22, 'Condo in Hlaing', 'No.204 Dhama Thukha Kyaung Street, Yangon ', 'Hlaing', 972, 1, 2, 4200, 'Includes polished hardwood or laminate floors, sleek tiles, and high-quality wall finishes like textured or painted surfaces.also has 24/7 on-site security personnel and surveillance cameras.', 'Often located in urban or suburban areas with easy access to:\r\nShopping malls, restaurants, and cafes.\r\nPublic transportation hubs.\r\nSchools, hospitals, and other essential services.', 'Sale', 'Approved', '2025-01-27 06:35:48', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(23, 'Luxury Condo in Hlaing', 'No. 51 Pyay Road, 6 1/2 Miles, 12a Shwe Hintha Rd, Yangon', 'Hlaing', 1350, 3, 2, 9500, 'This condo has large, floor-to-ceiling windows that allow residents to enjoy panoramic city views, outdoor scenery, or waterfront vistas. Also has High-end, energy-efficient appliances like built-in dishwashers, refrigerators, and microwaves are a staple in modern condos.', 'Easy access to highways and public transit hubs.\r\nSoundproof walls and flooring to ensure a peaceful environment.', 'Sale', 'Approved', '2025-01-27 06:43:06', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(24, 'Apartment in Hlaing', 'Bawga Road, Hlaing', 'Hlaing', 1200, 2, 1, 3000, 'This spacious ground-floor unit is ideal for families seeking ample living space. Clever design elements like built-in storage, multifunctional furniture, and optimized room arrangements.', ' Equipped with updated appliances (e.g., refrigerator, oven, microwave), sleek countertops (granite, quartz), and ample storage space.\r\n', 'Sale', 'Approved', '2025-01-27 06:54:24', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(25, 'Home Rental in Hlaing', 'Aye Yeik Mon Housing, Hlaing', 'Hlaing', 1500, 2, 3, 25, 'Home automation for lighting, climate control, and security systems.\r\nEnergy-efficient appliances and systems.\r\n', 'Central air conditioning and heating for year-round comfort.\r\nWell-insulated windows and walls to maintain indoor temperatures.', 'Rent', 'Approved', '2025-01-27 07:10:24', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(26, 'Apartment on Damayone Road', 'Damayone Road, Hlaing', 'Hlaing', 2200, 3, 2, 3, 'Proximity to city centers and essential services.', 'A well-maintained apartment located on Damayone Road, offering comfortable living spaces. ', 'Rent', 'Approved', '2025-01-27 07:17:38', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(27, 'Two-storey Home in Hlaing', 'Myakantha (1) Road, Hlaing', 'Hlaing', 2000, 3, 2, 2900, 'a large compound, 3 aircons and with friendly neighbours', 'A well-designed house enhances everyday comfort and convenience.', 'Sale', 'Approved', '2025-01-27 09:10:23', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(28, 'Three-storey house renting in Mayangone', 'Aungthikedi street, Mayangone', 'Mayangone', 3000, 3, 3, 35, 'Spacious layout with three large bedrooms.\r\nWell-maintained interiors with modern finishes.\r\nPerfect for families or professionals.\r\nLocated in a quiet neighborhood with easy access to amenities.\r\n', 'Modern designs with functional layouts.\r\nParking spaces for cars and motorbikes.\r\nEasy access to main roads like Pyay Road or Insein Road.', 'Rent', 'Approved', '2025-01-27 09:19:32', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(29, 'House sale in Mayangone', 'Near Gabaraye Pagoda, Mayangone', 'Mayangone', 1100, 3, 2, 2200, 'A single-storey house with a spacious private yard.\r\nThree bedrooms, perfect for a family.\r\nLocated in the 8 Mile area, near restaurants and shopping centers.\r\nPeaceful environment with greenery.', 'A house in prime locations with modern feature', 'Sale', 'Approved', '2025-01-27 09:29:02', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(30, 'Apartment near Junction 8 Shopping Center', '8 Miles, Mayangone', 'Mayangone', 3250, 3, 2, 4500, '', '', 'Sale', 'Approved', '2025-01-27 09:34:32', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(31, 'Condo in Kyimyintine', 'Kyi Myin Tine, Near Nat Sin Lan Bus stop, U Phoe Htoo Road', 'Kyi Myin Tine', 1900, 2, 2, 14, 'Fully facilities,24 hours security, Car parking, air cons for all bedroom', 'Near supermarket, good environment, A bright and airy living space with large windows, allowing natural light to flood in.', 'Rent', 'Approved', '2025-01-27 14:20:39', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(32, 'Great Apartment in Kan Nar Lan', 'Kyi Myin Tine, Kan Nar Lan,Near Sin min Zay Bus stop', 'Kyi Myin Tine', 1334, 1, 1, 15, 'kitchen, some facilities, 1 air con', 'near Kyi Myin Tai Nya Zay', 'Rent', 'Approved', '2025-01-27 14:20:39', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(33, 'Apartment sale in North Oakkalapa', 'North Oakkalapa, Thu Damar Road', 'North Okkalapa', 600, 2, 1, 1655, 'living room, 2 Aircons, sofa, kitchen', 'perfect for professionals, families, or investors looking for a prime property in a vibrant area', 'Sale', 'Approved', '2025-01-27 15:28:52', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(34, 'Mordern Apartment in North Oakkalapa', 'North Oakkalapa, Thu Nandar Road, Near BEHS 1', 'North Okkalapa', 650, 1, 1, 5, 'hot water\\cold water,2 Aircons, kitchen', 'Fully equipped with modern appliances, sleek countertops, and ample storage.', 'Rent', 'Approved', '2025-01-27 15:28:52', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(35, 'House Sale in North Oakkalapa ', 'North Oakkalapa, Khaymar Thi Road', 'North Okkalapa', 750, 3, 2, 2100, 'Open-plan layout for living and dining areas, living room, dinning room, valued celing ', 'Quiet, family-friendly neighborhood, Proximity to schools, shopping, parks, and public transport', 'Sale', 'Approved', '2025-01-27 15:50:54', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(36, 'Luxury House in Kyi Myin Tine', 'Kyi Myin Tine, Near Htee Den Market, Pann Hlaing Road', 'Kyi Myin Tine', 1800, 4, 3, 7200, '2 floors, rooftop, Luxurious Bedrooms, Private Balcony, kitchen ', 'Four spacious bedrooms, including a lavish master suit, Step into a breathtaking foyer with soaring ceilings, a sweeping staircase, and designer lighting', 'Sale', 'Approved', '2025-01-27 15:50:54', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(37, 'Great Apartment Rental in Bahan', 'Bahan,4th Street, Near Aung Pan Monastery', 'Bahan', 825, 2, 1, 8, 'facilities, sofa, kitchen, 2 Aircons,\r\nbalcony', 'Luxurious features like soaking tubs, double vanities, rainfall showers', 'Rent', 'Approved', '2025-01-27 16:37:29', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(38, 'Well-bulit House in Bahan', 'Bahan, 1st road,Near Thiriyadanr Park\r\n', 'Bahan', 3000, 3, 2, 1450, 'Hardwood, tile, or carpet with details (e.g., \"polished oak floors\"), good environment', 'Year built or recently renovated, Architectural style (e.g., \"Craftsman-style home with timeless charm\")', 'Sale', 'Approved', '2025-01-27 16:37:29', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(39, 'Apartment in South Oakkalapa', 'South Oakkalapa, Thisar Road, Near Pagoda Road bus-stop', 'South Okkalapa', 600, 2, 1, 5, 'Elevator service, kitchen, 24 hours security,1 aircon, front and back balcony  ', 'Quiet neighborhood or vibrant city center setting and near supermarket. ', 'Rent', 'Approved', '2025-01-27 16:55:23', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(40, 'Mordern Condo in BaHan', 'Bahan, U Chit Maung Road', 'Bahan', 1250, 3, 2, 8, 'Gourmet Kitchen, Comfortable Bedrooms, 3 aircons, elevator service, car parking', 'Two generously sized bedrooms with ample closet space. Rooftop terrace with BBQ facilities and stunning city views.', 'Rent', 'Approved', '2025-01-27 16:55:23', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(41, 'Apartment Sale in LanMaDaw', 'Lan Ma Daw, Bo Gyoke Aung San Road', 'Lanmadaw', 600, 1, 1, 1100, '1 Aircon, kitchen, balcony, Unit Laundry', 'Includes three well-sized bedrooms, perfect for a growing family or shared living.24/7 security, CCTV surveillance', 'Sale', 'Approved', '2025-01-28 15:54:56', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(42, 'Modern Apartment in Lan Ma Daw', 'Lan Ma Daw, Near Sein John City Mall, Min Ye Kyawsyr Road', 'Lanmadaw', 765, 2, 1, 1500, 'Modern kitchen, Elevactor service, dinning room, Front and back balcony', 'Offers a private balcony with stunning city or nature views, both bedrooms are generously sized, with the master bedroom including an en-suite bathroom for added privacy', 'Sale', 'Approved', '2025-01-28 15:54:56', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(43, 'Luxury Condo in Lan Ma Daw', 'Lan Ma Daw, Lan Thit Road, Near Juction Mawtin', 'Lanmadaw', 1200, 4, 2, 2550, 'Fitness Center, Swimming Pool, Swimming Pool, Multiple Bedrooms, Unit Laundry, Smart Lock System, Parking', 'Equipped with a digital lock system for secure and keyless entry. Reserved covered parking available, with options for visitor parking.\r\n', 'Sale', 'Approved', '2025-01-28 16:17:00', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(44, 'Apartment Sale in Hlaind Thar Yar', 'Hlaing Tharyar, Ayeyarwaddy Road', 'Hlaing Tharyar', 600, 2, 1, 1320, 'Solar Panels, Rooftop Garden, Balcony, High-Speed Internet, kitchen, good ceiling', 'Green spaces with seating and stunning views, Sustainable energy solutions', 'Sale', 'Approved', '2025-01-28 16:17:00', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(45, 'Apartment For Sale Near Mee Khwat Market ', 'Hlaing Tharyar, Near Mee Khwat Market, Bo Aung Kyaw Road', 'Hlaing Tharyar', 765, 3, 2, 1500, 'Solar Panels, kitchen, Rooftop Garden, Balcony, Storage Units, 2 Aircons', 'Green spaces with seating and stunning views. Private outdoor space with scenic views.\r\n', 'Sale', 'Approved', '2025-01-28 16:30:20', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(46, 'Well-desinged Apartment in Hlaing Thar Yar', 'Hlaing Tharyar, Mandalay Road', 'Hlaing Tharyar', 600, 2, 2, 1280, 'balcony, designed ceiling, 3 Aircons, Tile floor, elevator service, modern interior design ', 'spacious open-plan living and dining area boasts premium finishes, including hardwood flooring, designer light fixtures, and expansive windows that allow natural light to flood the space.', 'Sale', 'Approved', '2025-01-28 16:30:20', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(47, 'House sale in Kamayut', 'Kamaryut, Near Gwa Market, Thayattaw Road', 'Kamaryut', 967, 4, 3, 2500, 'Garage, Spacious Front Yard, Modern Kitchen, Multiple Bedrooms and Bathrooms, Laundry ,3 aircons', 'A two-car garage with ample storage space and automatic doors, beautifully landscaped front yard with a manicured lawn, colorful flower beds, and a paved pathway leading to the entrance.', 'Sale', 'Approved', '2025-01-28 16:39:30', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(48, 'Two-storey House in Kamayut', 'Kamaryut, Natnattaw Road', 'Kamaryut', 850, 3, 2, 20, 'good 2 floors, modern design, kitchen, 3 aircons, large yard, Outdoor Living Space', 'Includes a large patio with a pergola, ideal for barbecues and family gatherings.', 'Rent', 'Approved', '2025-01-28 16:39:30', 'House', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(49, 'Beautiful Apartment for sale in Kamayut', 'Kamaryut, Yan Pyo Road', 'Kamaryut', 660, 2, 2, 1480, 'balcony, beautiful-designed ceiling, modern kitchen, tile floor, 2 aircons', 'Equipped with top-of-the-line appliances, quartz countertops, a spacious island, and custom cabinetry.', 'Sale', 'Approved', '2025-01-28 16:50:51', 'Apartment', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(50, 'Well-desinged Condo in Kamayut', 'Kamaryut, Sangyaung Garden', 'Kamaryut', 900, 4, 3, 20, 'good-designed floor, gym, spa, swimming pool, 24-hour security, car parking, hot and cold water', 'A sparkling outdoor pool with a surrounding deck, perfect for relaxation and entertainment, the modern kitchen is a masterpiece of design and efficiency, featuring sleek cabinetry, high-end stainless-steel appliances,', 'Rent', 'Approved', '2025-01-28 16:50:51', 'Condo', NULL, '09697922356', 'nextdoor101r@gmail.com'),
(51, 'House for Sale in Dagon Myothit (South) ', 'Nin Si Myine Street, Ward (17), South Dagon Township, Yangon ', 'South Dagon', 4720, 5, 4, 13000, 'Fully Furnished, Good Ventilation, Reliable electricity and water supply, Car park, Private Garden', 'This stunning property offers a generous 4,720 sq. ft. of living space on an 80 ft x 59 ft plot, perfect for families or investment opportunities. This home provides ample space and comfort for a luxurious lifestyle.\nLocated in a prime area of Dagon Myothit (South), the house boasts modern architecture, spacious interiors, and high-quality finishes. With a well-designed layout, it offers excellent ventilation and natural lighting throughout.', 'Sale', 'Pending', '2025-02-01 17:48:58', 'House', NULL, '09234567890', 'htetyupar456@gmail.com'),
(52, 'Residence in Karmayut', 'Diamond Condo, Kamaryut Township, Yangon', 'Kamaryut', 1500, 3, 2, 2000, 'aaa, sss, ddd, fff, ggg', 'This home provides ample space and comfort for a luxurious lifestyle.\nLocated in a prime area of Karmayut, the house boasts modern architecture, spacious interiors, and high-quality finishes. With a well-designed layout, it offers excellent ventilation and natural lighting throughout.', 'Sale', 'Pending', '2025-02-02 06:20:24', 'Condo', '1738477224_wp1.jpg', '09989878787', 'theintnaychik@gmail.com'),
(53, 'aaaaaaaa', 'aaa', '', 1000, 2, 2, 10, 'aa, vv, vv,dd,fdd', 'asf sfs sdf sdf', 'Rent', 'Pending', '2025-02-02 17:07:27', 'Apartment', 'payments/1738518685_proof.jpg', '09934235530', 'thuthuwin583@gmail.com'),
(54, 'zzzz', 'zzzzzzz', '', 1300, 3, 2, 3000, 'aa, bb, cc, dd', 'af dkfj skdjfks fskdjf', 'Sale', 'Pending', '2025-02-02 17:23:20', 'Apartment', 'payments/1738517000_UIT.png', '09234567890', 'htetyupar456@gmail.com'),
(55, 'qqqqqq', 'qqqqq', '', 1000, 1, 1, 10, 'qq,qq,qq,qq', 'asfd adf sd f sdfsdf', 'Sale', 'Pending', '2025-02-02 17:48:51', 'Condo', 'payments/1738518531_uit(h).png', '09934235530', 'thuthuwin583@gmail.com'),
(56, 'Luxury House for Sale', 'Bahan, Yangon', 'Bahan', 5000, 4, 5, 40000, ' fully-furnished,gym, lift, car-parking, good neighborhood', 'Discover an exceptional living experience in this elegant 4-bedroom, 5-bathroom luxury home located in one of Yangon’s most prestigious neighborhoods – Bahan. This stunning residence is designed for comfort, convenience, and style, offering spacious interiors and premium furnishings.This property is perfect for those seeking a blend of luxury and tranquility while being close to Yangon’s top dining, shopping, and entertainment destinations.Enjoy a hassle-free urban living experience in one of Yangon\'s most sought-after locations.', 'Sale', 'Approved', '2025-03-05 09:06:11', 'House', 'payments/1741165571_t1.jpg', '09444069979', 'phoopyaesone135@gmail.com'),
(57, '2-bed condo for rent', '161,Wa Dan Street, Lanmadaw Tsp, Yangon', 'Lanmadaw', 1500, 2, 2, 13, 'well-equipped, gym, lift, car-parking, close to public transportation', 'Discover the perfect blend of comfort and convenience in this well-equipped 2-bedroom condo located in the heart of Lanmadaw Township. Ideal for professionals, families, or expatriates, this stylish residence offers a modern lifestyle with top-notch amenities. Enjoy a hassle-free urban living experience in one of Yangon\'s most sought-after locations.', 'Rent', 'Pending', '2025-03-05 09:42:08', 'Condo', 'payments/1741167728_q1.jpg', '09444069979', 'phoopyaesone135@gmail.com'),
(58, 'Inley', 'Thamine Kawlate Street', 'Hlaing', 3000, 20, 20, 10000, 'Convenient transport, Good security, 24hrs electricity', 'cccccccc', 'Sale', 'Approved', '2025-03-06 07:09:11', 'Apartment', '1741244951_t1.jpg', '993423553', 'maythetswecu@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image`) VALUES
(1, 1, '1.jpg'),
(2, 1, '1.2.jpg'),
(3, 1, '1.3.jpg'),
(4, 1, '1.4.jpg'),
(5, 2, '2.jpg'),
(6, 2, '2.2.jpg'),
(7, 2, '2.3.jpg'),
(8, 2, '2.4.jpg'),
(9, 3, '3.jpg'),
(10, 3, '3.2.jpg'),
(11, 3, '3.3.jpg'),
(12, 3, '3.4.jpg'),
(13, 4, '4.jpg'),
(14, 4, '4.2.jpg'),
(15, 4, '4.3.jpg'),
(16, 4, '4.4.jpg'),
(17, 5, '5.jpg'),
(18, 5, '5.2.jpg'),
(19, 5, '5.3.jpg'),
(20, 5, '5.4.jpg'),
(21, 6, '6.jpg'),
(22, 6, '6.2.jpg'),
(23, 6, '6.3.jpg'),
(24, 6, '6.4.jpg'),
(25, 7, '7.jpg'),
(26, 7, '7.2.jpg'),
(27, 7, '7.3.jpg'),
(28, 7, '7.4.jpg'),
(29, 8, '8.jpg'),
(30, 8, '8.2.jpg'),
(31, 8, '8.3.jpg'),
(32, 8, '8.4.jpg'),
(33, 9, '9.jpg'),
(34, 9, '9.2.jpg'),
(35, 9, '9.3.jpg'),
(36, 9, '9.4.jpg'),
(37, 10, '10.jpg'),
(38, 10, '10.2.jpg'),
(39, 10, '10.3.jpg'),
(40, 10, '10.4.jpg'),
(41, 11, '11.jpg'),
(42, 11, '11.2.jpg'),
(43, 11, '11.3.jpg'),
(44, 11, '11.4.jpg'),
(45, 12, '12.jpg'),
(46, 12, '12.2.jpg'),
(47, 12, '12.3.jpg'),
(48, 12, '12.4.jpg'),
(49, 13, '13.jpg'),
(50, 13, '13.2.jpg'),
(51, 13, '13.3.jpg'),
(52, 13, '13.4.jpg'),
(53, 14, '14.jpg'),
(54, 14, '14.2.jpg'),
(55, 14, '14.3.jpg'),
(56, 14, '14.4.jpg'),
(57, 15, '15.jpg'),
(58, 15, '15.2.jpg'),
(59, 15, '15.3.jpg'),
(60, 15, '15.4.jpg'),
(61, 16, '16.jpg'),
(62, 16, '16.2.jpg'),
(63, 16, '16.3.jpg'),
(64, 16, '16.4.jpg'),
(65, 17, '17.jpg'),
(66, 17, '17.2.jpg'),
(67, 17, '17.3.jpg'),
(68, 17, '17.4.jpg'),
(69, 18, '18.jpg'),
(70, 18, '18.2.jpg'),
(71, 18, '18.3.jpg'),
(72, 18, '18.4.jpg'),
(73, 19, '19.jpg'),
(74, 19, '19.2.jpg'),
(75, 19, '19.3.jpg'),
(76, 19, '19.4.jpg'),
(77, 20, '20.jpg'),
(78, 20, '20.2.jpg'),
(79, 20, '20.3.jpg'),
(80, 20, '20.4.jpg'),
(81, 21, '21.jpg'),
(82, 21, '21.2.jpg'),
(83, 21, '21.3.jpg'),
(84, 21, '21.4.jpg'),
(85, 22, '22.jpg'),
(86, 22, '22.2.jpg'),
(87, 22, '22.3.jpg'),
(88, 22, '22.4.jpg'),
(89, 23, '23.jpg'),
(90, 23, '23.2.jpg'),
(91, 23, '23.3.jpg'),
(92, 23, '23.4.jpg'),
(93, 24, '24.jpg'),
(94, 24, '24.2.jpg'),
(95, 24, '24.3.jpg'),
(96, 24, '24.4.jpg'),
(97, 25, '25.jpg'),
(98, 25, '25.2.jpg'),
(99, 25, '25.3.jpg'),
(100, 25, '25.4.jpg'),
(101, 26, '26.jpg'),
(102, 26, '26.2.jpg'),
(103, 26, '26.3.jpg'),
(104, 26, '26.4.jpg'),
(105, 27, '27.jpg'),
(106, 27, '27.2.jpg'),
(107, 27, '27.3.jpg'),
(108, 27, '27.4.jpg'),
(109, 28, '28.jpg'),
(110, 28, '28.2.jpg'),
(111, 28, '28.3.jpg'),
(112, 28, '28.4.jpg'),
(113, 29, '29.jpg'),
(114, 29, '29.2.jpg'),
(115, 29, '29.3.jpg'),
(116, 29, '29.4.jpg'),
(117, 30, '30.jpg'),
(118, 30, '30.2.jpg'),
(119, 30, '30.3.jpg'),
(120, 30, '30.4.jpg'),
(121, 31, '31.jpg'),
(122, 31, '31.2.jpg'),
(123, 31, '31.3.jpg'),
(124, 31, '31.4.jpg'),
(125, 32, '32.jpg'),
(126, 32, '32.2.jpg'),
(127, 32, '32.3.jpg'),
(128, 32, '32.4.jpg'),
(129, 33, '33.jpg'),
(130, 33, '33.2.jpg'),
(131, 33, '33.3.jpg'),
(132, 33, '33.4.jpg'),
(133, 34, '34.jpg'),
(134, 34, '34.2.jpg'),
(135, 34, '34.3.jpg'),
(136, 34, '34.4.jpg'),
(137, 35, '35.jpg'),
(138, 35, '35.2.jpg'),
(139, 35, '35.3.jpg'),
(140, 35, '35.4.jpg'),
(141, 36, '36.jpg'),
(142, 36, '36.2.jpg'),
(143, 36, '36.3.jpg'),
(144, 36, '36.4.jpg'),
(145, 37, '37.jpg'),
(146, 37, '37.2.jpg'),
(147, 37, '37.3.jpg'),
(148, 37, '37.4.jpg'),
(149, 38, '38.jpg'),
(150, 38, '38.2.jpg'),
(151, 38, '38.3.jpg'),
(152, 38, '38.4.jpg'),
(153, 39, '39.jpg'),
(154, 39, '39.2.jpg'),
(155, 39, '39.3.jpg'),
(156, 39, '39.4.jpg'),
(157, 40, '40.jpg'),
(158, 40, '40.2.jpg'),
(159, 40, '40.3.jpg'),
(160, 40, '40.4.jpg'),
(161, 41, '41.jpg'),
(162, 41, '41.2.jpg'),
(163, 41, '41.3.jpg'),
(164, 41, '41.4.jpg'),
(165, 42, '42.jpg'),
(166, 42, '42.2.jpg'),
(167, 42, '42.3.jpg'),
(168, 42, '42.4.jpg'),
(169, 43, '43.jpg'),
(170, 43, '43.2.jpg'),
(171, 43, '43.3.jpg'),
(172, 43, '43.4.jpg'),
(173, 44, '44.jpg'),
(174, 44, '44.2.jpg'),
(175, 44, '44.3.jpg'),
(176, 44, '44.4.jpg'),
(177, 45, '45.jpg'),
(178, 45, '45.2.jpg'),
(179, 45, '45.3.jpg'),
(180, 45, '45.4.jpg'),
(181, 46, '46.jpg'),
(182, 46, '46.2.jpg'),
(183, 46, '46.3.jpg'),
(184, 46, '46.4.jpg'),
(185, 47, '47.jpg'),
(186, 47, '47.2.jpg'),
(187, 47, '47.3.jpg'),
(188, 47, '47.4.jpg'),
(189, 48, '48.jpg'),
(190, 48, '48.2.jpg'),
(191, 48, '48.3.jpg'),
(192, 48, '48.4.jpg'),
(193, 49, '49.jpg'),
(194, 49, '49.2.jpg'),
(195, 49, '49.3.jpg'),
(196, 49, '49.4.jpg'),
(197, 50, '50.jpg'),
(198, 50, '50.2.jpg'),
(199, 50, '50.3.jpg'),
(200, 50, '50.4.jpg'),
(201, 51, '51_1738432138_southdagon_h1.jpg'),
(202, 51, '51_1738432138_southdagon_h2.jpg'),
(203, 51, '51_1738432138_southdagon_h3.jpg'),
(204, 51, '51_1738432138_southdagon_h4.jpg'),
(205, 52, '52_1738477224_house-in-golden-valley.jpg'),
(206, 52, '52_1738477224_landscape.jpg'),
(207, 52, '52_1738477224_colorful_meadow.jpg'),
(208, 52, '52_1738477224_onTwitter.jpg'),
(217, 55, '55_1738518531_Exterior1.jpg'),
(218, 55, '55_1738518531_Exterior1.jpg'),
(219, 55, '55_1738518531_Exterior1.jpg'),
(220, 55, '55_1738518531_Exterior1.jpg'),
(23614, 54, '1741004493_1_gg1.jpg'),
(23615, 54, '1741004493_2_gg2.jpg'),
(23616, 54, '1741004493_3_gg3.jpg'),
(23617, 54, '1741004493_4_gg4.jpg'),
(23622, 56, '60_1741165571_p1.jpg'),
(23623, 56, '60_1741165571_p2.jpg'),
(23624, 56, '60_1741165571_p3.jpg'),
(23625, 56, '60_1741165571_p4.jpg'),
(23626, 57, '1741195606_1_q1.jpg'),
(23627, 57, '1741195644_2_p2.jpg'),
(23628, 57, '1741195700_3_q1.jpg'),
(23629, 57, '1741185315_4_p4.jpg'),
(23630, 58, '58_1741244951_q1.jpg'),
(23631, 58, '58_1741244951_p4.jpg'),
(23632, 58, '58_1741244951_p3.jpg'),
(23633, 58, '58_1741244951_p2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` varchar(500) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `profile_image` varchar(255) DEFAULT 'User_Img/default.png',
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_users`
--

INSERT INTO `registered_users` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`, `message`, `phone`, `profile_image`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Next', 'Door', 'nextdoor101r@gmail.com', '$2y$10$nxNvT9.kSP9./CuGet8OuOPQ226cEb6btP.Y/qyzJXvYR8rziP672', '2025-02-22 18:52:20', '', '09697922356', 'User_Img/default.png', NULL, NULL),
(2, 'Nann', 'Khin', 'Nann1@gmail.com', 'dd674cc43badec8069749f11d14ebdc7', '2025-01-05 08:03:33', '', '09456782321', 'User_Img/default.png', NULL, NULL),
(3, 'Thu Thu', 'Win', 'thuthuwin583@gmail.com', '$2y$10$si59yxjkmpsNsHkD6TTwKeZ7/dL5nkVOsBSJT7GWATPJM.lExBCMG', '2025-02-03 03:24:14', '', '09934235530', 'User_Img/default.png', '64af6f7c04aa867b06aa974306b9d3a7f8f4864ef555193933c21838b2a636e0', '2025-03-04 16:12:03'),
(4, 'Theint', 'Nay Chi', 'theintnaychi345@gmail.com', '$2y$10$qVYPO0CDbU/pNdL/hM6owORpILwzAd8eYpg/aS7.RZYdZq4aVXmgW', '2025-02-07 16:38:37', '', '09943534535', 'User_Img/default.png', NULL, NULL),
(5, 'Aye', 'Aye', 'ayeaye789@gmail.com', '$2y$10$OQiNso6GjLCiNgyfsQYt6eDkS8vNUZIeYjkE8UTlqar3hyLieatni', '2025-02-19 13:48:37', '', '09894834234', 'User_Img/default.png', NULL, NULL),
(6, 'Htet', 'Yupar', 'htetyupar456@gmail.com', '$2y$10$WjWOZGebj8K8nmjfwx6tDuFHTDOoIHwgSqFXz.5YvutdiSWeUcUeu', '2025-02-22 19:16:04', '', '09234567890', 'User_Img/default.png', NULL, NULL),
(7, 'Phoo', 'Pyae', 'phoopyaesone135@gmail.com', '$2y$10$gjBwTBSxMkwGHzQsBazLZOL8fnQjbD15xXGTAR2mz8dwFMAe.wgVK', '2025-02-22 19:18:13', '', '09444069979', 'User_Img/default.png', '4b5637f4235ddf937c6e11527629685e6fefc39984bdaec0fe26b36b1e573fbd', '2025-03-04 16:04:45'),
(8, 'Theint', 'Theint', 'theintnaychik@gmail.com', '$2y$10$AC3sfZbS96Fb1rUlNUwZf.b.xDIJIujVwOAM8yEwVcFa0W5NVVvVu', '2025-02-27 07:07:11', '', '09989878787', 'User_Img/default.png', '24e348a73e1829396ff0016d3d07eecc8e4b4dbb0ca95d4b52a0fd7212e24a27', '2025-03-04 15:59:46'),
(9, 'MT', 'S', 'maythetswecu@gmail.com', '$2y$10$USQLz3aZFw30VU0dAlO9/Ovq5cpMf8ciKKuHLI4mQ0xJsvSxW.DSO', '2025-03-06 06:52:21', '', '0993423553', 'User_Img/default.png', 'f27e01509863d91738d73ca9c53f89dabed1722c6c418c589244ad9acb08a0cf', '2025-03-06 09:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_email`, `property_id`, `created_at`) VALUES
(204, 'thuthuwin123@gmail.com', 7, '2025-03-02 16:54:33'),
(207, 'htetyupar456@gmail.com', 1, '2025-03-03 13:22:55'),
(225, 'thuthuwin123@gmail.com', 6, '2025-03-04 04:39:11'),
(227, 'theintnaychi345@gmail.com', 8, '2025-03-04 04:42:12'),
(235, 'theintnaychi345@gmail.com', 2, '2025-03-04 04:49:31'),
(236, 'theintnaychi345@gmail.com', 6, '2025-03-04 04:50:00'),
(241, 'thuthuwin123@gmail.com', 1, '2025-03-04 10:03:52'),
(242, 'thuthuwin123@gmail.com', 41, '2025-03-04 13:18:02'),
(243, 'thuthuwin583@gmail.com', 1, '2025-03-04 15:58:20'),
(244, 'thuthuwin583@gmail.com', 8, '2025-03-04 15:59:05'),
(254, 'phoopyaesone135@gmail.com', 6, '2025-03-05 14:14:32'),
(259, 'phoopyaesone135@gmail.com', 2, '2025-03-05 14:19:48'),
(260, 'phoopyaesone135@gmail.com', 16, '2025-03-05 14:21:21'),
(261, 'phoopyaesone135@gmail.com', 28, '2025-03-05 14:22:12'),
(263, 'maythetswecu@gmail.com', 1, '2025-03-06 07:14:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `insert_info`
--
ALTER TABLE `insert_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_insert_info_property` (`p_id`);

--
-- Indexes for table `property_details`
--
ALTER TABLE `property_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_email`,`property_id`),
  ADD KEY `property_id` (`property_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `insert_info`
--
ALTER TABLE `insert_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property_details`
--
ALTER TABLE `property_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23634;

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `insert_info`
--
ALTER TABLE `insert_info`
  ADD CONSTRAINT `fk_insert_info_property` FOREIGN KEY (`p_id`) REFERENCES `property_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property_details` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
