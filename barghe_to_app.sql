-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2023 at 11:36 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barghe_to_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `CityId` bigint NOT NULL AUTO_INCREMENT,
  `CityProvinceId` int NOT NULL COMMENT 'from table state',
  `CityName` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`CityId`)
) ENGINE=InnoDB AUTO_INCREMENT=912 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='فهرست شهر ها';

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CityId`, `CityProvinceId`, `CityName`) VALUES
(444, 1, 'اهر'),
(445, 1, 'هریس'),
(446, 1, 'بستان آباد'),
(447, 1, 'بناب'),
(448, 1, 'تبریز'),
(449, 1, 'آذرشهر'),
(450, 1, 'اسکو'),
(451, 1, 'سراب'),
(452, 1, 'شبستر'),
(453, 1, 'کلیبر'),
(456, 1, 'مراغه'),
(457, 1, 'عجب شیر'),
(458, 1, 'مرند'),
(459, 1, 'جلفا'),
(460, 1, 'ملکان'),
(461, 1, 'میانه'),
(462, 1, 'هشترود'),
(463, 1, 'چارااویماق'),
(464, 1, 'ورزقان'),
(465, 2, 'ارومیه'),
(466, 2, 'بوکان'),
(467, 2, 'پیرانشهر'),
(468, 2, 'سردشت'),
(469, 2, 'خوی'),
(471, 2, 'سلماس'),
(472, 2, 'ماکو'),
(473, 2, 'چالدران'),
(476, 2, 'مهاباد'),
(477, 2, 'میاندوآب'),
(478, 2, 'شاهین دژ'),
(479, 2, 'تکاپ'),
(480, 2, 'نقده'),
(481, 2, 'اشنویه'),
(482, 3, 'اردبیل'),
(483, 3, 'نمین'),
(484, 3, 'نیر'),
(485, 3, 'سرعین'),
(486, 3, 'پارس آباد'),
(487, 3, 'بیله سوار'),
(488, 3, 'خلخال'),
(489, 3, 'کوثر'),
(490, 3, 'گرمی'),
(491, 3, 'مشگین دشت'),
(492, 4, 'اردستان'),
(493, 4, 'شاهین شهر'),
(494, 4, 'میمه'),
(495, 4, 'بربخوار'),
(496, 4, 'خمینی شهر'),
(497, 4, 'سمیرم'),
(498, 4, 'شهرضا'),
(501, 4, 'فریدن'),
(502, 4, 'چادگان'),
(503, 4, 'فریدونشهر'),
(506, 4, 'فلاورجان'),
(507, 4, 'کاشان'),
(508, 4, 'آران و بیدگل'),
(509, 4, 'گلپایگان'),
(510, 4, 'خوانسار'),
(511, 4, 'لنجان'),
(512, 4, 'مبارکه'),
(513, 4, 'نائین'),
(516, 4, 'نجف آباد'),
(517, 4, 'تیران'),
(518, 4, 'کرون'),
(519, 4, 'نطنز'),
(521, 5, 'ساوجبلاغ'),
(522, 5, 'نظر آباد'),
(523, 5, 'طالقان'),
(524, 5, 'کرج'),
(525, 5, 'اشتهارد'),
(526, 5, 'فردیس'),
(527, 6, 'ایلام'),
(528, 6, 'ایوان'),
(529, 6, 'چرداول'),
(530, 6, 'مهران'),
(532, 6, 'شیروان'),
(533, 6, 'دهلران'),
(534, 6, 'دره شهر'),
(535, 6, 'آبدانان'),
(537, 7, 'بوشهر'),
(538, 7, 'گناوه'),
(539, 7, 'دیلم'),
(540, 7, 'دشتستان'),
(541, 7, 'دشتی'),
(542, 7, 'تنگستان'),
(543, 7, 'کنگان'),
(544, 7, 'دیر'),
(545, 7, 'جم'),
(547, 8, 'پاکدشت'),
(548, 8, 'تهران'),
(549, 8, 'ری'),
(550, 8, 'شمیرانات'),
(551, 8, 'اسلامشهر'),
(553, 8, 'دماوند'),
(554, 8, 'فیروزکوه'),
(555, 8, 'رباط کریم'),
(557, 8, 'شهریار'),
(560, 8, 'ورامین'),
(563, 9, 'اردل'),
(564, 9, 'فارسان'),
(565, 9, 'کوهرنگ'),
(568, 9, 'بروجن'),
(569, 9, 'شهرکرد'),
(572, 9, 'لردگان'),
(573, 10, 'بیرجند'),
(574, 10, 'درمیان'),
(576, 10, 'قائنات'),
(578, 10, 'نهبندان'),
(579, 10, 'سربیشه'),
(580, 10, 'فردوس'),
(581, 10, 'سرایان'),
(582, 10, 'طبس'),
(584, 11, 'تربت جام'),
(585, 11, 'تایباد'),
(588, 11, 'تربیت حیدریه'),
(589, 11, 'مه ولات'),
(591, 11, 'چناران'),
(593, 11, 'خواف'),
(594, 11, 'رشتخوار'),
(595, 11, 'درگز'),
(596, 11, 'سبزوار'),
(601, 11, 'فریمان'),
(602, 11, 'سرخس'),
(605, 11, 'قوچان'),
(606, 11, 'فاروج'),
(607, 11, 'کاشمر'),
(608, 11, 'خلیل آباد'),
(610, 11, 'گناباد'),
(612, 11, 'مشهد'),
(613, 11, 'کلات'),
(614, 11, 'نیشابور'),
(616, 12, 'اسفراین'),
(617, 12, 'بجنورد'),
(618, 12, 'مانه'),
(619, 12, 'سملقان'),
(620, 12, 'جاجرم'),
(624, 12, 'شیروان'),
(625, 13, 'آبادن'),
(626, 13, 'اندیمشک'),
(627, 13, 'اهواز'),
(631, 13, 'ایذه'),
(633, 13, 'بندر ماهشهر'),
(634, 13, 'امیدیه'),
(635, 13, 'هندیجان'),
(637, 13, 'بهبهان'),
(639, 13, 'خرمشهر'),
(640, 13, 'دزفول'),
(641, 13, 'دشت آزادگان'),
(643, 13, 'رامهرمز'),
(644, 13, 'رامشیر'),
(645, 13, 'شادگان'),
(646, 13, 'شوش'),
(647, 13, 'شوشتر'),
(648, 13, 'گتوند'),
(649, 13, 'مسجد سلیمان'),
(650, 13, 'لالی'),
(653, 14, 'ابهر'),
(654, 14, 'خرمدره'),
(656, 14, 'خدابنده'),
(657, 14, 'زنجان'),
(658, 14, 'طارم'),
(660, 14, 'ایجرود'),
(663, 15, 'دامغان'),
(664, 15, 'سمنان'),
(665, 15, 'مهدی شهر'),
(668, 15, 'شاهرود'),
(671, 15, 'گرمسار'),
(673, 16, 'ایرانشهر'),
(674, 16, 'سرباز'),
(675, 16, 'دلگان'),
(681, 16, 'چابهار'),
(683, 16, 'کنارک'),
(685, 16, 'خاش'),
(689, 16, 'زابل'),
(690, 16, 'زهک'),
(694, 16, 'زاهدان'),
(695, 16, 'سراوان'),
(699, 17, 'آباده'),
(700, 17, 'بوانات'),
(701, 17, 'خرم بید'),
(702, 17, 'نی ریز'),
(703, 17, 'استهبان'),
(704, 17, 'اقلید'),
(705, 17, 'جهرم'),
(706, 17, 'داراب'),
(707, 17, 'زرین دشت'),
(708, 17, 'سپیدان'),
(712, 17, 'شیراز'),
(713, 17, 'فسا'),
(714, 17, 'فیروزآباد'),
(715, 17, 'فراشبند'),
(716, 17, 'قیر'),
(717, 17, 'کارزین'),
(718, 17, 'کازرون'),
(719, 17, 'لارستان'),
(720, 17, 'خنج'),
(723, 17, 'مهر'),
(724, 17, 'مرودشت'),
(725, 17, 'پاسارگاد'),
(726, 17, 'ارسنجان'),
(727, 17, 'ممسنی'),
(729, 18, 'بوئین زهرا'),
(731, 18, 'تاکستان'),
(732, 18, 'قزوین'),
(733, 18, 'آبیک'),
(734, 18, 'البرز'),
(735, 19, 'قم'),
(736, 20, 'بیجار'),
(737, 20, 'سقز'),
(738, 20, 'بانه'),
(739, 20, 'سنندج'),
(740, 20, 'دیواندره'),
(741, 20, 'کامیاران'),
(742, 20, 'قروه'),
(744, 20, 'مریوان'),
(745, 20, 'سروآباد'),
(746, 21, 'بافت'),
(749, 21, 'بم'),
(753, 21, 'جیرفت'),
(754, 21, 'عنبرآباد'),
(755, 21, 'رفسنجان'),
(757, 21, 'زرند'),
(758, 21, 'کوهبنان'),
(759, 21, 'سیرجان'),
(760, 21, 'بردسیر'),
(761, 21, 'شهر بابک'),
(762, 21, 'کرمان'),
(763, 21, 'راور'),
(764, 21, 'کهنوج'),
(765, 21, 'منوجان'),
(766, 21, 'رودبار جنوب'),
(767, 21, 'قلعه گنج'),
(769, 22, 'اسلام آباد غرب'),
(770, 22, 'دالاهو'),
(771, 22, 'پاوه'),
(772, 22, 'جوانرود'),
(773, 22, 'ثلاث باباجانی'),
(774, 22, 'روانسر'),
(777, 22, 'سنقر'),
(778, 22, 'قصر شیرین'),
(779, 22, 'سرپل ذهاب'),
(780, 22, 'گیلان غرب'),
(781, 22, 'کرمانشاه'),
(782, 22, 'کنگاور'),
(783, 22, 'صحنه'),
(784, 22, 'هرسین'),
(785, 23, 'بویراحمد'),
(786, 23, 'دنا'),
(787, 23, 'کهگیلویه'),
(788, 23, 'بهمئی'),
(791, 23, 'گچساران'),
(793, 24, 'رامیان'),
(794, 24, 'آزادشهر'),
(795, 24, 'علی آباد'),
(796, 24, 'کردکوی'),
(797, 24, 'ترکمن'),
(798, 24, 'بندر گز'),
(800, 24, 'گرگان'),
(801, 24, 'آق قلا'),
(802, 24, 'گنبد کاووس'),
(803, 24, 'مینودشت'),
(804, 24, 'کلاله'),
(805, 24, 'مراوه تپه'),
(807, 25, 'آستارا'),
(808, 25, 'آستانه اشرفیه'),
(809, 25, 'بندر انزلی'),
(810, 25, 'رشت'),
(811, 25, 'رودبار'),
(812, 25, 'رودسر'),
(813, 25, 'املش'),
(814, 25, 'صومعه سرا'),
(815, 25, 'طوالش'),
(816, 25, 'رضوانشهر'),
(817, 25, 'ماسال'),
(818, 25, 'فومن'),
(819, 25, 'شفت'),
(820, 25, 'لاهیجان'),
(821, 25, 'سیاهکل'),
(822, 25, 'لنگرود'),
(823, 26, 'الیگودرز'),
(824, 26, 'بروجرد'),
(825, 26, 'پلدختر'),
(826, 26, 'خرم آباد'),
(828, 26, 'دلفان'),
(829, 26, 'سلسله'),
(830, 26, 'دورود'),
(831, 26, 'ازنا'),
(832, 26, 'کوهدشت'),
(834, 27, 'آمل'),
(835, 27, 'بابل'),
(836, 27, 'بابلسر'),
(838, 27, 'بهشهر'),
(839, 27, 'نکا'),
(840, 27, 'گلوگاه'),
(841, 27, 'تنکابن'),
(842, 27, 'رامسر'),
(844, 27, 'ساری'),
(846, 27, 'قائمشهر'),
(847, 27, 'سوادکوه'),
(848, 27, 'جویبار'),
(851, 27, 'نور'),
(852, 27, 'محمودآباد'),
(853, 27, 'نوشهر'),
(854, 27, 'چالوس'),
(856, 28, 'اراک'),
(857, 28, 'کمیجان'),
(859, 28, 'تفرش'),
(860, 28, 'آشتیان'),
(862, 28, 'خمین'),
(863, 28, 'ساوه'),
(864, 28, 'زرندیه'),
(865, 28, 'شازند'),
(866, 28, 'محلات'),
(867, 28, 'دلیجان'),
(868, 29, 'بندر عباس'),
(869, 29, 'قشم'),
(870, 29, 'ابوموسی'),
(871, 29, 'حاجی آباد'),
(872, 29, 'خمیر'),
(873, 29, 'بندر لنگه'),
(874, 29, 'بستک'),
(876, 29, 'میناب'),
(877, 29, 'رودان'),
(878, 29, 'جاسک'),
(881, 30, 'اسدآباد'),
(882, 30, 'بهار'),
(883, 30, 'کبودرآهنگ'),
(884, 30, 'تویسرکان'),
(885, 30, 'رزن'),
(886, 30, 'ملایر'),
(887, 30, 'نهاوند'),
(888, 30, 'همدان'),
(890, 31, 'اردکان'),
(891, 31, 'تفت'),
(892, 31, 'میبد'),
(893, 31, 'مهریز'),
(894, 31, 'بافق'),
(895, 31, 'ابرکوه'),
(896, 31, 'خاتم'),
(898, 31, 'یزد'),
(902, 4, 'اصفهان'),
(903, 17, 'سروستان'),
(904, 17, 'خرامه'),
(905, 17, 'کوار'),
(906, 32, 'اصفهان، یزد، خوزستان، فارس، کرمان، هرمزگان، سیستان و بلوچستان، لرستان، چهارمحال و بختیاری، بوشهر، کهگیلویه و بویراحمد'),
(907, 32, 'تهران، آذربایجان شرقی، آذربایجان غربی، اردبیل، ایلام، خراسان، زنجان، سمنان، قزوین، قم، کردستان، کرمانشاه، گلستان، گیلان، مازندران، مرکزی، همدان'),
(908, 32, 'زرتشتیان سراسر کشور'),
(909, 32, 'کلیمیان سراسر کشور'),
(910, 32, 'مسیحیان آشوری و کلدانی سراسر کشور'),
(911, 17, 'لامرد');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `CountryId` int NOT NULL AUTO_INCREMENT,
  `ISO` varchar(4) NOT NULL,
  `FaName` varchar(20) NOT NULL,
  PRIMARY KEY (`CountryId`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb3 COMMENT='فهرست کشور ها';

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`CountryId`, `ISO`, `FaName`) VALUES
(1, 'AFG', 'افغانستان'),
(2, 'ALA', 'جزایر آلند'),
(3, 'ALB', 'آلبانی'),
(4, 'DZA', 'الجزایر'),
(5, 'ASM', 'ساموای آمریکا'),
(6, 'AND', 'آندورا'),
(7, 'AGO', 'آنگولا'),
(8, 'AIA', 'آنگویلا'),
(9, 'ATA', 'جنوبگان'),
(10, 'ATG', 'آنتیگوا و باربودا'),
(11, 'ARG', 'آرژانتین'),
(12, 'ARM', 'ارمنستان'),
(13, 'ABW', 'آروبا'),
(14, 'AUS', 'استرالیا'),
(15, 'AUT', 'اتریش'),
(16, 'AZE', 'جمهوری آذربایجان'),
(17, 'BHS', 'باهاما'),
(18, 'BHR', 'بحرین'),
(19, 'BGD', 'بنگلادش'),
(20, 'BRB', 'باربادوس'),
(21, 'BLR', 'بلاروس'),
(22, 'BEL', 'بلژیک'),
(23, 'BLZ', 'بلیز'),
(24, 'BEN', 'بنین'),
(25, 'BMU', 'برمودا'),
(26, 'BTN', 'پادشاهی بوتان'),
(27, 'BOL', 'بولیوی'),
(28, 'BIH', 'بوسنی و هرزگوین'),
(29, 'BWA', 'بوتسوانا'),
(30, 'BVT', 'جزیره بووه'),
(31, 'BRA', 'برزیل'),
(32, 'IOT', 'قلمرو اقیانوس هند بر'),
(33, 'BRN', 'برونئی'),
(34, 'BGR', 'بلغارستان'),
(35, 'BFA', 'بورکینافاسو'),
(36, 'BDI', 'بوروندی'),
(37, 'KHM', 'کامبوج'),
(38, 'CMR', 'کامرون'),
(39, 'CAN', 'کانادا'),
(40, 'CPV', 'کیپ ورد'),
(41, 'CYM', 'جزایر کیمن'),
(42, 'CAF', 'جمهوری آفریقای مرکزی'),
(43, 'TCD', 'چاد'),
(44, 'CHL', 'شیلی'),
(45, 'CHN', 'چین'),
(46, 'CXR', 'جزیره کریسمس'),
(47, 'CCK', 'جزایر کوکوس'),
(48, 'COL', 'کلمبیا'),
(49, 'COM', 'کومور'),
(50, 'COG', 'جمهوری کنگو'),
(51, 'COD', 'جمهوری دموکراتیک کنگ'),
(52, 'COK', 'جزایر کوک'),
(53, 'CRI', 'کاستاریکا'),
(54, 'CIV', 'ساحل عاج'),
(55, 'HRV', 'کرواسی'),
(56, 'CUB', 'کوبا'),
(57, 'CYP', 'قبرس'),
(58, 'CZE', 'جمهوری چک'),
(59, 'DNK', 'دانمارک'),
(60, 'DJI', 'جیبوتی'),
(61, 'DMA', 'دومینیکا'),
(62, 'DOM', 'جمهوری دومینیکن'),
(63, 'ECU', 'اکوادور'),
(64, 'EGY', 'مصر'),
(65, 'SLV', 'السالوادور'),
(66, 'GNQ', 'گینه استوایی'),
(67, 'ERI', 'اریتره'),
(68, 'EST', 'استونی'),
(69, 'ETH', 'اتیوپی'),
(70, 'FLK', 'جزایر فالکند'),
(71, 'FRO', 'جزایر فارو'),
(72, 'FJI', 'فیجی'),
(73, 'FIN', 'فنلاند'),
(74, 'FRA', 'فرانسه'),
(75, 'GUF', 'گویان فرانسه'),
(76, 'PYF', 'پولی‌نزی فرانسه'),
(77, 'ATF', 'سرزمین‌های قطب جنوب '),
(78, 'GAB', 'گابون'),
(79, 'GMB', 'گامبیا'),
(80, 'GEO', 'گرجستان'),
(81, 'DEU', 'آلمان'),
(82, 'GHA', 'غنا'),
(83, 'GIB', 'جبل طارق'),
(84, 'GRC', 'یونان'),
(85, 'GRL', 'گرینلند'),
(86, 'GRD', 'گرنادا'),
(87, 'GLP', 'جزیره گوادلوپ'),
(88, 'GUM', 'گوآم'),
(89, 'GTM', 'گواتمالا'),
(90, 'GGY', 'گرنزی'),
(91, 'GIN', 'گینه'),
(92, 'GNB', 'گینه بیسائو'),
(93, 'GUY', 'گویان'),
(94, 'HTI', 'هائیتی'),
(95, 'HMD', 'جزیره هرد و جزایر مک'),
(96, 'VAT', 'واتیکان'),
(97, 'HND', 'هندوراس'),
(98, 'HKG', 'هنگ کنگ'),
(99, 'HUN', 'مجارستان'),
(100, 'ISL', 'ایسلند'),
(101, 'IND', 'هند'),
(102, 'IDN', 'اندونزی'),
(103, 'IRN', 'ایران'),
(104, 'IRQ', 'عراق'),
(105, 'IRL', 'جمهوری ایرلند'),
(106, 'IMN', 'جزیره من'),
(107, 'ISR', 'اسرائیل'),
(108, 'ITA', 'ایتالیا'),
(109, 'JAM', 'جامائیکا'),
(110, 'JPN', 'ژاپن'),
(111, 'JEY', 'جرسی'),
(112, 'JOR', 'اردن'),
(113, 'KAZ', 'قزاقستان'),
(114, 'KEN', 'کنیا'),
(115, 'KIR', 'کیریباتی'),
(116, 'PRK', 'کره شمالی'),
(117, 'KOR', 'کره جنوبی'),
(118, 'KWT', 'کویت'),
(119, 'KGZ', 'قرقیزستان'),
(120, 'LAO', 'لائوس'),
(121, 'LVA', 'لتونی'),
(122, 'LBN', 'لبنان'),
(123, 'LSO', 'لسوتو'),
(124, 'LBR', 'لیبریا'),
(125, 'LIE', 'لیختن‌اشتاین'),
(126, 'LTU', 'لیتوانی'),
(127, 'LUX', 'لوکزامبورگ'),
(128, 'MAC', 'ماکائو'),
(129, 'MKD', 'مقدونیه'),
(130, 'MDG', 'ماداگاسکار'),
(131, 'MWI', 'مالاوی'),
(132, 'MYS', 'مالزی'),
(133, 'MDV', 'مالدیو'),
(134, 'MLI', 'مالی'),
(135, 'MLT', 'مالت'),
(136, 'MHL', 'جزایر مارشال'),
(137, 'MTQ', 'مارتینیک'),
(138, 'MRT', 'موریتانی'),
(139, 'MUS', 'موریس'),
(140, 'MYT', 'مایوت'),
(141, 'MEX', 'مکزیک'),
(142, 'FSM', 'ایالات فدرال میکرونز'),
(143, 'MDA', 'مولداوی'),
(144, 'MCO', 'موناکو'),
(145, 'MNG', 'مغولستان'),
(146, 'MNE', 'مونته‌نگرو'),
(147, 'MSR', 'مونتسرات'),
(148, 'MAR', 'مراکش'),
(149, 'MOZ', 'موزامبیک'),
(150, 'MMR', 'میانمار'),
(151, 'NAM', 'نامیبیا'),
(152, 'NRU', 'نائورو'),
(153, 'NPL', 'نپال'),
(154, 'NLD', 'هلند'),
(155, 'ANT', 'آنتیل هلند'),
(156, 'NCL', 'کالدونیای جدید'),
(157, 'NZL', 'نیوزیلند'),
(158, 'NIC', 'نیکاراگوئه'),
(159, 'NER', 'نیجر'),
(160, 'NGA', 'نیجریه'),
(161, 'NIU', 'نیووی'),
(162, 'NFK', 'جزیره نورفولک'),
(163, 'MNP', 'جزایر ماریانای شمالی'),
(164, 'NOR', 'نروژ'),
(165, 'OMN', 'عمان'),
(166, 'PAK', 'پاکستان'),
(167, 'PLW', 'پالائو'),
(168, 'PSE', 'فلسطین'),
(169, 'PAN', 'پاناما'),
(170, 'PNG', 'پاپوآ گینه نو'),
(171, 'PRY', 'پاراگوئه'),
(172, 'PER', 'پرو'),
(173, 'PHL', 'فیلیپین'),
(174, 'PCN', 'جزایر پیت‌کرن'),
(175, 'POL', 'لهستان'),
(176, 'PRT', 'پرتغال'),
(177, 'PRI', 'پورتوریکو'),
(178, 'QAT', 'قطر'),
(179, 'REU', 'رئونیون'),
(180, 'ROU', 'رومانی'),
(181, 'RUS', 'روسیه'),
(182, 'RWA', 'رواندا'),
(183, 'BLM', 'سنت بارثلمی'),
(184, 'SHN', 'سینت هلینا'),
(185, 'KNA', 'سنت کیتس و نویس'),
(186, 'LCA', 'سنت لوسیا'),
(187, 'MAF', 'سنت مارتین'),
(188, 'SPM', 'سنت پیر و ماژلان'),
(189, 'VCT', 'سنت وینسنت و گرنادین'),
(190, 'WSM', 'ساموآ'),
(191, 'SMR', 'سن مارینو'),
(192, 'STP', 'سائوتومه و پرنسیپ'),
(193, 'SAU', 'عربستان سعودی'),
(194, 'SEN', 'سنگال'),
(195, 'SRB', 'صربستان'),
(196, 'SYC', 'سیشل'),
(197, 'SLE', 'سیرالئون'),
(198, 'SGP', 'سنگاپور'),
(199, 'SVK', 'اسلواکی'),
(200, 'SVN', 'اسلوونی'),
(201, 'SLB', 'جزایر سلیمان'),
(202, 'SOM', 'سومالی'),
(203, 'ZAF', 'آفریقای جنوبی'),
(204, 'SGS', 'جورجیای جنوبی و جزای'),
(205, 'ESP', 'اسپانیا'),
(206, 'LKA', 'سری‌لانکا'),
(207, 'SDN', 'سودان'),
(208, 'SUR', 'سورینام'),
(209, 'SJM', 'سوالبارد و یان ماین'),
(210, 'SWZ', 'سوازیلند'),
(211, 'SWE', 'سوئد'),
(212, 'CHE', 'سوئیس'),
(213, 'SYR', 'سوریه'),
(214, 'TJK', 'تاجیکستان'),
(215, 'TZA', 'تانزانیا'),
(216, 'THA', 'تایلند'),
(217, 'TLS', 'تیمور شرقی'),
(218, 'TGO', 'توگو'),
(219, 'TKL', 'توکلائو'),
(220, 'TON', 'تونگا'),
(221, 'TTO', 'ترینیداد و توباگو'),
(222, 'TUN', 'تونس'),
(223, 'TUR', 'ترکیه'),
(224, 'TKM', 'ترکمنستان'),
(225, 'TCA', 'جزایر تورکس و کایکوس'),
(226, 'TUV', 'تووالو'),
(227, 'UGA', 'اوگاندا'),
(228, 'UKR', 'اوکراین'),
(229, 'ARE', 'امارات متحده عربی'),
(230, 'GBR', 'بریتانیا'),
(231, 'USA', 'ایالات متحده آمریکا'),
(232, 'UMI', 'جزایر کوچک حاشیه‌ای '),
(233, 'URY', 'اروگوئه'),
(234, 'UZB', 'ازبکستان'),
(235, 'VUT', 'وانواتو'),
(236, 'VEN', 'ونزوئلا'),
(237, 'VNM', 'ویتنام'),
(238, 'VGB', 'جزایر ویرجین انگلستا'),
(239, 'VIR', 'جزایر ویرجین ایالات '),
(240, 'WLF', 'والیس و فوتونا'),
(241, 'ESH', 'صحرای غربی'),
(242, 'YEM', 'یمن'),
(243, 'ZMB', 'زامبیا'),
(244, 'ZWE', 'زیمبابوه');

-- --------------------------------------------------------

--
-- Table structure for table `crawl_token`
--

DROP TABLE IF EXISTS `crawl_token`;
CREATE TABLE IF NOT EXISTS `crawl_token` (
  `TokenId` int NOT NULL AUTO_INCREMENT,
  `Token` text COLLATE utf8mb4_unicode_ci,
  `CreateDateTime` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  PRIMARY KEY (`TokenId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='آخرین توکن جهت کراول دیتا برق تو';

--
-- Dumping data for table `crawl_token`
--

INSERT INTO `crawl_token` (`TokenId`, `Token`, `CreateDateTime`, `CreatePersonId`) VALUES
(1, 'eyJjbGllbnRfaWQiOiJZekV6TUdkb01ISm5PSEJpT0cxaWJEaHlOVEE9IiwicmVzcG9uc2VfdHlwZSI6ImNvZGUiLCJzY29wZSI6ImludHJvc2NwZWN0X3Rva2VucywgcmV2b2tlX3Rva2VucyIsImlzcyI6ImJqaElSak0xY1hwYWEyMXpkV3RJU25wNmVqbE1iazQ0YlRsTlpqazNkWEU9Iiwic3ViIjoiWXpFek1HZG9NSEpuT0hCaU9HMWliRGh5TlRBPSIsImF1ZCI6Imh0dHBzOi8vbG9jYWxob3N0Ojg0NDMve3RpZH0ve2FpZH0vb2F1dGgyL2F1dGhvcml6ZSIsImp0aSI6IjE1MTYyMzkwMjIiLCJleHAiOiIyMDIxLTA1LTE3VDA3OjA5OjQ4LjAwMCswNTQ1In0', 1699884653, 1821),
(2, 'eyJjbGllbnRfaWQiOiJZekV6TUdkb01ISm5PSEJpT0cxaWJEaHlOVEE9IiwicmVzcG9uc2VfdHlwZSI6ImNvZGUiLCJzY29wZSI6ImludHJvc2NwZWN0X3Rva2VucywgcmV2b2tlX3Rva2VucyIsImlzcyI6ImJqaElSak0xY1hwYWEyMXpkV3RJU25wNmVqbE1iazQ0YlRsTlpqazNkWEU9Iiwic3ViIjoiWXpFek1HZG9NSEpuT0hCaU9HMWliRGh5TlRBPSIsImF1ZCI6Imh0dHBzOi8vbG9jYWxob3N0Ojg0NDMve3RpZH0ve2FpZH0vb2F1dGgyL2F1dGhvcml6ZSIsImp0aSI6IjE1MTYyMzkwMjIiLCJleHAiOiIyMDIxLTA1LTE3VDA3OjA5OjQ4LjAwMCswNTQ1In0', 1699884657, 1821),
(3, 'eyJjbGllbnRfaWQiOiJZekV6TUdkb01ISm5PSEJpT0cxaWJEaHlOVEE9IiwicmVzcG9uc2VfdHlwZSI6ImNvZGUiLCJzY29wZSI6ImludHJvc2NwZWN0X3Rva2VucywgcmV2b2tlX3Rva2VucyIsImlzcyI6ImJqaElSak0xY1hwYWEyMXpkV3RJU25wNmVqbE1iazQ0YlRsTlpqazNkWEU9Iiwic3ViIjoiWXpFek1HZG9NSEpuT0hCaU9HMWliRGh5TlRBPSIsImF1ZCI6Imh0dHBzOi8vbG9jYWxob3N0Ojg0NDMve3RpZH0ve2FpZH0vb2F1dGgyL2F1dGhvcml6ZSIsImp0aSI6IjE1MTYyMzkwMjIiLCJleHAiOiIyMDIxLTA1LTE3VDA3OjA5OjQ4LjAwMCswNTQ1In0', 1699884658, 1821);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `LogId` int NOT NULL AUTO_INCREMENT,
  `Action` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'عملیاتی که کاربر انجام میدهد',
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'توصیحات در مورد عملیات',
  `IpAddress` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'آی پی کاربر',
  `Browser` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'مرورگر کاربر',
  `BrowserVersion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ورژن مرورگر',
  `Platform` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'پلتفرم',
  `FullUserAgentString` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'مشخصات کامل مرورگر',
  `CreatePersonId` int NOT NULL COMMENT 'شناسه شخص سازنده',
  `CreateDateTime` int NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`LogId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='لاگ های سیستم';

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`LogId`, `Action`, `Description`, `IpAddress`, `Browser`, `BrowserVersion`, `Platform`, `FullUserAgentString`, `CreatePersonId`, `CreateDateTime`) VALUES
(14, 'Setting_change_user_info', '{\"inputFirstName\":\"\\u0628\\u0647\\u0646\\u0627\\u0645\",\"inputLastName\":\"\\u0645\\u062d\\u0645\\u062f\\u06cc\",\"inputNationalCode\":\"2500354216\",\"inputAddress\":\"\\u062a\\u0647\\u0631\\u0627\\u0646 \\u062e\\u06cc\\u0627\\u0628\\u0627\\u0646 \\u0648\\u0644\\u06cc\\u0639\\u0635\\u0631 \\u0631\\u0648\\u0628\\u0631\\u0648\\u06cc \\u067e\\u0627\\u0631\\u06a9 \\u0645\\u0644\\u062a\",\"inputPersonId\":\"1821\"}', '127.0.0.1', '', '', 'Unknown Platform', '', 1821, 1699096743);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `PersonId` int NOT NULL AUTO_INCREMENT,
  `PersonFirstName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PersonLastName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PersonNationalCode` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PersonPhone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PersonAddress` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsActive` tinyint NOT NULL DEFAULT '0',
  `PersonType` enum('NORMAL','ORGANIZATION') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NORMAL',
  `ActivationCode` int DEFAULT NULL,
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDatetime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`PersonId`),
  UNIQUE KEY `PersonNationalCode` (`PersonNationalCode`),
  KEY `PersonPhone` (`PersonPhone`)
) ENGINE=InnoDB AUTO_INCREMENT=1822 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='فهرست افراد';

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`PersonId`, `PersonFirstName`, `PersonLastName`, `PersonNationalCode`, `PersonPhone`, `PersonAddress`, `Username`, `Password`, `IsActive`, `PersonType`, `ActivationCode`, `CreateDateTime`, `CreatePersonId`, `ModifyDatetime`, `ModifyPersonId`) VALUES
(1820, 'محمدرضا', 'اسماعیلی', '4900354376', '09120572107', 'تهران خیابان ولیعصر روبروی پارک ملت', NULL, '6a5c5436c458438a9f01a3ef4aa1c6f7', 1, 'NORMAL', 3672, 1699089578, NULL, 1699089990, 1820),
(1821, 'بهنام', 'محمدی', '2500354216', '09120570000', 'تهران خیابان ولیعصر روبروی پارک ملت', NULL, '25aae89a65502987e5757eb4144382e5', 1, 'NORMAL', 2196, 1699090803, NULL, 1699096743, 1821);

-- --------------------------------------------------------

--
-- Table structure for table `person_account_balance`
--

DROP TABLE IF EXISTS `person_account_balance`;
CREATE TABLE IF NOT EXISTS `person_account_balance` (
  `RowId` int NOT NULL AUTO_INCREMENT,
  `PersonId` int NOT NULL COMMENT 'شناسه شخص',
  `AccountBalance` int NOT NULL DEFAULT '0' COMMENT 'مقدار اعتبار',
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL COMMENT 'زمان خرید آپدیت می شود',
  `ModifyDatetime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL COMMENT 'زمان ویرایش توسط ادمین آپدیت می شود',
  PRIMARY KEY (`RowId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='موجودی حساب هر شخص';

--
-- Dumping data for table `person_account_balance`
--

INSERT INTO `person_account_balance` (`RowId`, `PersonId`, `AccountBalance`, `CreateDateTime`, `CreatePersonId`, `ModifyDatetime`, `ModifyPersonId`) VALUES
(13, 1820, 0, 1699089578, 1820, NULL, NULL),
(14, 1821, 0, 1699090803, 1821, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_bill`
--

DROP TABLE IF EXISTS `person_bill`;
CREATE TABLE IF NOT EXISTS `person_bill` (
  `BillGUID` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BillTitle` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'عنوان قبض',
  `BillNumberId` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه قبض / شماره پرونده',
  `BillPersonId` int NOT NULL,
  `SoftDelete` tinyint NOT NULL DEFAULT '0',
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDateTime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`BillGUID`),
  KEY `BillNumberId` (`BillNumberId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='قبض های کاربران';

--
-- Dumping data for table `person_bill`
--

INSERT INTO `person_bill` (`BillGUID`, `BillTitle`, `BillNumberId`, `BillPersonId`, `SoftDelete`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
('3302d7e2-0717-405b-9367-60fadf46a573', 'قبض خانه شماره 21', '2254210234', 1821, 0, 1699101440, 1821, 1699257079, 1821),
('e4c2ed78-0fd9-4fe9-9fcf-9225661167d2', 'قبض خانه شماره 1', '2254210233', 1822, 1, 1699101458, 1821, NULL, NULL),
('98461e6f-cf9d-49a5-bc7e-2fc097dd507b', 'قبض خانه شماره 21', '2254210234', 1820, 0, 1699706000, 1821, 1699706063, 1821);

-- --------------------------------------------------------

--
-- Table structure for table `person_bill_legal_info`
--

DROP TABLE IF EXISTS `person_bill_legal_info`;
CREATE TABLE IF NOT EXISTS `person_bill_legal_info` (
  `RowId` int NOT NULL AUTO_INCREMENT,
  `PersonId` int NOT NULL,
  `BillGUID` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RealName` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RealLastName` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RealNationalCode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RealPhone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RealProvinceId` int DEFAULT NULL,
  `RealCityId` int DEFAULT NULL,
  `RealAddress` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LegalOrganizationName` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'نام سازمان',
  `LegalFinanceCode` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'کد اقتصادی',
  `LegalCompanyId` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه ملی',
  `LegalRegisterNumber` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه ثبت',
  `LegalPhone` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'تلفن ثابت دفتر مرکزی',
  `LegalProvinceId` int DEFAULT NULL COMMENT 'استان دفتر مرکزی',
  `LegalCityId` int DEFAULT NULL COMMENT 'شهر دفتر مرکزی',
  `LegalAddress` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'آدرس دفتر مرکزی',
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDateTime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`RowId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='اطلاعات حقیقی یا حقوقی قبض ها';

--
-- Dumping data for table `person_bill_legal_info`
--

INSERT INTO `person_bill_legal_info` (`RowId`, `PersonId`, `BillGUID`, `RealName`, `RealLastName`, `RealNationalCode`, `RealPhone`, `RealProvinceId`, `RealCityId`, `RealAddress`, `LegalOrganizationName`, `LegalFinanceCode`, `LegalCompanyId`, `LegalRegisterNumber`, `LegalPhone`, `LegalProvinceId`, `LegalCityId`, `LegalAddress`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
(4, 1821, '3302d7e2-0717-405b-9367-60fadf46a573', 'پدرام', 'محمدی', '2541224518', '09125745214', 8, 450, 'تهران شهریار خیابان ولیعصر عج الله تعالی فرجه الشریف', 'سازمان آب و فاضله ی آب', '5541245', '12355001', '2258', '02155442211', 1, 459, 'تهران شهریار خیابان ', 1699425852, 1821, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_legal_info`
--

DROP TABLE IF EXISTS `person_legal_info`;
CREATE TABLE IF NOT EXISTS `person_legal_info` (
  `RowId` int NOT NULL AUTO_INCREMENT,
  `PersonId` int NOT NULL,
  `LegalOrganizationName` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'نام سازمان',
  `LegalFinanceCode` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'کد اقتصادی',
  `LegalCompanyId` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه ملی',
  `LegalRegisterNumber` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'شناسه ثبت',
  `LegalPhone` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'تلفن ثابت دفتر مرکزی',
  `LegalProvinceId` int DEFAULT NULL COMMENT 'استان دفتر مرکزی',
  `LegalCityId` int DEFAULT NULL COMMENT 'شهر دفتر مرکزی',
  `LegalAddress` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'آدرس دفتر مرکزی',
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDateTime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`RowId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='اطلاعات حقیقی یا حقوقی افراد';

--
-- Dumping data for table `person_legal_info`
--

INSERT INTO `person_legal_info` (`RowId`, `PersonId`, `LegalOrganizationName`, `LegalFinanceCode`, `LegalCompanyId`, `LegalRegisterNumber`, `LegalPhone`, `LegalProvinceId`, `LegalCityId`, `LegalAddress`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
(1, 1821, 'سازمان شماره 1 ', '1258003', '215002100', '13548', '02165225522', 1, 459, 'تهران خیابان نیایش جنب پاساژ مرکزی', 1636959469, 1821, 1699096886, 1821);

-- --------------------------------------------------------

--
-- Table structure for table `person_roles`
--

DROP TABLE IF EXISTS `person_roles`;
CREATE TABLE IF NOT EXISTS `person_roles` (
  `RoleId` int NOT NULL AUTO_INCREMENT,
  `PersonId` int NOT NULL,
  `Role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreateDateTime` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='نقش های افراد';

--
-- Dumping data for table `person_roles`
--

INSERT INTO `person_roles` (`RoleId`, `PersonId`, `Role`, `CreateDateTime`, `CreatePersonId`) VALUES
(305, 1, 'Admin', 1644387206, 103);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `ProvinceId` int NOT NULL AUTO_INCREMENT,
  `ProvinceName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ProvinceId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='فهرست استان ها';

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`ProvinceId`, `ProvinceName`) VALUES
(1, 'آذربایجان شرقی'),
(2, 'آذربایجان غربی'),
(3, 'اردبيل'),
(4, 'اصفهان'),
(5, 'البرز'),
(6, 'ايلام'),
(7, 'بوشهر'),
(8, 'تهران'),
(9, 'چهارمحال و بختیاری'),
(10, 'خراسان جنوبی'),
(11, 'خراسان رضوی'),
(12, 'خراسان شمالی'),
(13, 'خوزستان'),
(14, 'زنجان'),
(15, 'سمنان'),
(16, 'سیستان و بلوچستان'),
(17, 'فارس'),
(18, 'قزوين'),
(19, 'قم'),
(20, 'كردستان'),
(21, 'كرمان'),
(22, 'كرمانشاه'),
(23, 'کهگیلویه و بویراحمد'),
(24, 'گلستان'),
(25, 'گيلان'),
(26, 'لرستان'),
(27, 'مازندران'),
(28, 'مرکزی'),
(29, 'هرمزگان'),
(30, 'همدان'),
(31, 'يزد');

-- --------------------------------------------------------

--
-- Table structure for table `province_electricity_tariff`
--

DROP TABLE IF EXISTS `province_electricity_tariff`;
CREATE TABLE IF NOT EXISTS `province_electricity_tariff` (
  `ProvinceTariffId` int NOT NULL AUTO_INCREMENT,
  `ProvinceId` int NOT NULL,
  `LowPowerFromHour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LowPowerToHour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MiddlePowerFromHour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MiddlePowerToHour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PeakPowerFromHour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PeakPowerToHour` int NOT NULL,
  `CreateDateTime` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  `ModifyDateTime` int NOT NULL,
  `ModifyPersonId` int NOT NULL,
  PRIMARY KEY (`ProvinceTariffId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='تعرفه برق منطقه ای';

--
-- Dumping data for table `province_electricity_tariff`
--

INSERT INTO `province_electricity_tariff` (`ProvinceTariffId`, `ProvinceId`, `LowPowerFromHour`, `LowPowerToHour`, `MiddlePowerFromHour`, `MiddlePowerToHour`, `PeakPowerFromHour`, `PeakPowerToHour`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
(1, 1, '7', '100', '140', '170', '200', 220, 1699879471, 1821, 1699880305, 1821);

-- --------------------------------------------------------

--
-- Table structure for table `roles_group`
--

DROP TABLE IF EXISTS `roles_group`;
CREATE TABLE IF NOT EXISTS `roles_group` (
  `RoleGroupId` int NOT NULL AUTO_INCREMENT,
  `RoleGroupTitle` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDatetime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`RoleGroupId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_group`
--

INSERT INTO `roles_group` (`RoleGroupId`, `RoleGroupTitle`, `CreateDateTime`, `CreatePersonId`, `ModifyDatetime`, `ModifyPersonId`) VALUES
(1, 'گروه ادمین', 1657315931, 1, 1657316667, 1),
(2, 'گروه مالی', 1657315939, 1, 1659248895, 1),
(3, 'گروه پشتیبانی همه تیکت', 1657315947, 1, 1657780678, 1),
(4, 'گروه تعمیرات', 1657315966, 1, 1657316684, 1),
(5, 'گروه تست کننده ها', 1657780795, 1, NULL, NULL),
(6, 'امور مشتریان', 1657780878, 1, 1671361654, 1396),
(7, 'سرپرست تعمیرات', 1659174245, 1, 1659785074, 1),
(8, 'شبه ادمین', 1659787278, 1, 1687774985, 1396),
(9, 'دسترسی موقت', 1670238914, 1396, 1690357667, 1396),
(10, 'گروه مارکتینگ', 1670238929, 1396, 1674640943, 1396),
(11, 'مدیریت شرکت', 1671371600, 1396, 1681221103, 1396);

-- --------------------------------------------------------

--
-- Table structure for table `roles_group_permission`
--

DROP TABLE IF EXISTS `roles_group_permission`;
CREATE TABLE IF NOT EXISTS `roles_group_permission` (
  `PermissionId` int NOT NULL AUTO_INCREMENT,
  `PermissionKey` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RoleGroupId` int NOT NULL,
  `CreateDateTime` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  PRIMARY KEY (`PermissionId`)
) ENGINE=InnoDB AUTO_INCREMENT=15327 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_group_person`
--

DROP TABLE IF EXISTS `roles_group_person`;
CREATE TABLE IF NOT EXISTS `roles_group_person` (
  `RowId` int NOT NULL AUTO_INCREMENT,
  `PersonId` int NOT NULL,
  `RoleGroupId` int NOT NULL,
  `CreateDateTime` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  PRIMARY KEY (`RowId`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `shift_work`
--

DROP TABLE IF EXISTS `shift_work`;
CREATE TABLE IF NOT EXISTS `shift_work` (
  `ShiftWorkId` int NOT NULL AUTO_INCREMENT,
  `ShiftWorkTitle` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShiftWorkFromDate` int DEFAULT NULL,
  `ShiftWorkToDate` int DEFAULT NULL,
  `ShiftWorkBillGUID` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDateTime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`ShiftWorkId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='فهرست شیفت کاری شرکت ها جهت استفاده در محاسبه برق';

--
-- Dumping data for table `shift_work`
--

INSERT INTO `shift_work` (`ShiftWorkId`, `ShiftWorkTitle`, `ShiftWorkFromDate`, `ShiftWorkToDate`, `ShiftWorkBillGUID`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
(10, 'شیفت کاری شماره 1', 1698006600, 1700598600, '3302d7e2-0717-405b-9367-60fadf46a573', 1700044194, 1821, NULL, NULL),
(9, 'شیفت کاری شماره 1', 1402, 1402, '3302d7e2-0717-405b-9367-60fadf46a573', 1700044106, 1821, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift_work_days`
--

DROP TABLE IF EXISTS `shift_work_days`;
CREATE TABLE IF NOT EXISTS `shift_work_days` (
  `ShiftWorkDayId` int NOT NULL AUTO_INCREMENT,
  `ShiftWorkId` int NOT NULL,
  `ShiftWorkDayTitle` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShiftWorkDayValue` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateDateTime` int DEFAULT NULL,
  `CreatePersonId` int DEFAULT NULL,
  `ModifyDateTime` int DEFAULT NULL,
  `ModifyPersonId` int DEFAULT NULL,
  PRIMARY KEY (`ShiftWorkDayId`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='روزهایی که به شیف کاری وصل هستند';

--
-- Dumping data for table `shift_work_days`
--

INSERT INTO `shift_work_days` (`ShiftWorkDayId`, `ShiftWorkId`, `ShiftWorkDayTitle`, `ShiftWorkDayValue`, `CreateDateTime`, `CreatePersonId`, `ModifyDateTime`, `ModifyPersonId`) VALUES
(22, 10, 'چهارشنبه', '5', 1700044194, 1821, NULL, NULL),
(21, 10, 'دوشنبه', '3', 1700044194, 1821, NULL, NULL),
(20, 10, 'شنبه', '1', 1700044194, 1821, NULL, NULL),
(19, 9, 'چهارشنبه', '5', 1700044106, 1821, NULL, NULL),
(18, 9, 'دوشنبه', '3', 1700044106, 1821, NULL, NULL),
(17, 9, 'شنبه', '1', 1700044106, 1821, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift_work_day_hours`
--

DROP TABLE IF EXISTS `shift_work_day_hours`;
CREATE TABLE IF NOT EXISTS `shift_work_day_hours` (
  `ShiftHourId` int NOT NULL AUTO_INCREMENT,
  `ShiftWorkId` int NOT NULL,
  `ShiftWorkDayId` int NOT NULL,
  `FromHour` int NOT NULL,
  `ToHour` int NOT NULL,
  `CreatePersonId` int NOT NULL,
  `CreateDateTime` int NOT NULL,
  `ModifyPersonId` int NOT NULL,
  `ModifyDateTime` int NOT NULL,
  PRIMARY KEY (`ShiftHourId`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ساعات روز کاری';

--
-- Dumping data for table `shift_work_day_hours`
--

INSERT INTO `shift_work_day_hours` (`ShiftHourId`, `ShiftWorkId`, `ShiftWorkDayId`, `FromHour`, `ToHour`, `CreatePersonId`, `CreateDateTime`, `ModifyPersonId`, `ModifyDateTime`) VALUES
(6, 9, 17, 16, 20, 1821, 1700044106, 0, 0),
(5, 9, 17, 12, 14, 1821, 1700044106, 0, 0),
(4, 9, 17, 8, 10, 1821, 1700044106, 0, 0),
(7, 9, 18, 8, 10, 1821, 1700044106, 0, 0),
(8, 9, 18, 12, 14, 1821, 1700044106, 0, 0),
(9, 9, 18, 16, 20, 1821, 1700044106, 0, 0),
(10, 9, 19, 8, 10, 1821, 1700044106, 0, 0),
(11, 9, 19, 12, 14, 1821, 1700044106, 0, 0),
(12, 9, 19, 16, 20, 1821, 1700044106, 0, 0),
(13, 10, 20, 8, 10, 1821, 1700044194, 0, 0),
(14, 10, 20, 12, 14, 1821, 1700044194, 0, 0),
(15, 10, 20, 16, 20, 1821, 1700044194, 0, 0),
(16, 10, 21, 8, 10, 1821, 1700044194, 0, 0),
(17, 10, 21, 12, 14, 1821, 1700044194, 0, 0),
(18, 10, 21, 16, 20, 1821, 1700044194, 0, 0),
(19, 10, 22, 8, 10, 1821, 1700044194, 0, 0),
(20, 10, 22, 12, 14, 1821, 1700044194, 0, 0),
(21, 10, 22, 16, 20, 1821, 1700044194, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
