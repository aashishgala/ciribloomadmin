-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2023 at 10:10 PM
-- Server version: 10.6.9-MariaDB
-- PHP Version: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aditee_quizz`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `aid` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `assignname` varchar(150) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`aid`, `cid`, `mid`, `assignname`, `status`) VALUES
(3, 4, 3, 'L01 - Metacognition Skills', 1),
(4, 4, 4, 'LO1 - Signature Pedagogies', 1),
(5, 5, 5, 'L01- Metacognition Skills', 1),
(6, 5, 6, 'LO1 - Signature Pedagogies', 1),
(7, 6, 7, 'L01- Metacognition Skills', 1),
(8, 6, 8, 'LO1 - Signature Pedagogies', 1),
(15, 2, 1, 'Quiz 1', 1),
(16, 2, 2, 'Assignment 1', 1),
(17, 2, 2, 'Assignment 2', 1),
(18, 2, 9, 'Assignment 1', 1),
(19, 2, 9, 'Assignment 2', 1),
(20, 2, 10, 'Quiz 2', 1),
(21, 6, 7, 'LO2 - Computational Thinking', 1),
(22, 6, 7, 'LO3 - Programming Concepts', 1),
(23, 6, 7, 'LO4 - From Consumer to Creator', 1),
(24, 6, 7, 'LO5 - Critical Evaluation of Computational Thinking Skills', 1),
(25, 6, 8, 'LO2 - Critical Analysis of Signature Pedagogies', 1),
(26, 6, 8, 'LO3 - Progression in Programming Concepts', 1),
(27, 6, 8, 'LO4 - Progression In Metacognition', 1),
(28, 6, 11, 'LO1 - Programming in Scratch', 1),
(29, 6, 11, 'LO2 - Programming in Python', 1),
(30, 6, 12, 'LO1 - Reflective Practice and Bringing it All Together', 1),
(31, 6, 12, 'LO2 - Metacognitive Computer Science Lesson Plans', 1),
(32, 6, 12, 'LO3 - Implementation and Evaluation of Lesson Plans', 1),
(33, 6, 12, 'LO4 - Reflection on Overall Course Learning and Future Planning', 1),
(35, 5, 5, 'LO2 - Analyse Application of Metacognition', 1),
(36, 5, 5, 'LO3 - Habits of Mind', 1),
(37, 5, 6, 'LO2 - Critical Analysis of Signature Pedagogies', 1),
(38, 5, 6, 'LO3 - Lesson Plans', 1),
(39, 5, 13, 'LO1 - Assessment and Marking Guidelines', 1),
(40, 5, 13, 'LO2 - Metacognitive STEM Lesson Plans', 1),
(41, 5, 13, 'LO3 - Implementation and Evaluation of Lesson Plans', 1),
(42, 4, 3, 'LO2 - Worldwide STEM Curriculums - Design & Analysis', 1),
(43, 4, 3, 'LO3 - STEM Habits of Mind', 1),
(44, 4, 3, 'LO4 - Critical Evaluation of STEM HOMs & Metacogitive Skills', 1),
(45, 4, 4, 'LO2 - Critical Analysis of Signature Pedagogies', 1),
(46, 4, 4, 'LO3 - STEM Enquiry Processes ', 1),
(47, 4, 4, 'LO4 - Progression Metacognition', 1),
(48, 4, 14, 'LO1 - Reflective Practice and Bringing it All Together', 1),
(49, 4, 14, 'LO2 - Metacognitive STEM Lesson Plans', 1),
(50, 4, 14, 'LO3 - Implementation and Evaluation of Lesson Plans', 1),
(51, 4, 14, 'LO4 - Reflection on Overall Course Learning and Future Planning', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assign_course`
--

CREATE TABLE `assign_course` (
  `caid` int(11) NOT NULL,
  `tid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `mid` varchar(100) DEFAULT NULL,
  `aid` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'virtual delete',
  `date_assigned` timestamp NULL DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_course`
--

INSERT INTO `assign_course` (`caid`, `tid`, `cid`, `mid`, `aid`, `status`, `date_assigned`, `date_modified`) VALUES
(10, 15, 2, '|1|2|9|10|', '|15|16|17|18|19|20|', 1, '2022-12-11 11:18:19', '2022-12-11 11:18:19'),
(11, 16, 5, '|5|6|', '|5|6|', 1, '2022-12-11 11:21:09', '2022-12-11 11:21:09'),
(12, 17, 6, '|7|8|', '|7|8|', 1, '2022-12-11 11:22:31', '2022-12-11 11:22:31'),
(13, 18, 4, '|3|4|', '|3|4|', 1, '2022-12-11 11:24:21', '2022-12-11 11:24:21'),
(17, 23, 6, '|7|8|11|12|', '|7|8|21|22|23|24|25|26|27|28|29|30|31|32|33|', 0, '2023-02-26 10:01:28', '2023-02-26 10:02:49'),
(18, 23, 5, '|5|6|13|', '|5|6|35|36|37|38|39|40|41|', 0, '2023-02-26 10:05:37', '2023-02-26 10:07:37'),
(19, 23, 4, '|3|4|14|', '|3|4|42|43|44|45|46|47|48|49|50|51|', 1, '2023-03-02 10:29:00', '2023-03-02 10:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `cid` int(11) NOT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `is_quiz` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`cid`, `course_name`, `is_quiz`, `status`) VALUES
(2, 'Metacognition in Graphic Design', 1, 1),
(4, 'Metacognition in Stem Teaching', 0, 1),
(5, 'Metacognition in Language Learning', 0, 1),
(6, 'Metacognition in Computer', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `mid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `modulename` varchar(50) DEFAULT NULL,
  `modcolor` varchar(11) NOT NULL DEFAULT '#4066D4' COMMENT 'Set Different colour for background',
  `is_quiz_mod` int(1) NOT NULL DEFAULT 0 COMMENT '	Is this quiz module, if yes then show data from quiz table data.',
  `stage` int(2) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `sequence` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`mid`, `cid`, `modulename`, `modcolor`, `is_quiz_mod`, `stage`, `status`, `sequence`) VALUES
(1, 2, 'Module 1', '#ce5595', 1, 1, 1, 1),
(2, 2, 'Module2', '#9eb017', 0, NULL, 1, 2),
(3, 4, 'Module1', '#d4404f', 0, NULL, 1, 1),
(4, 4, 'Module 2', '#40d4d1', 0, NULL, 1, 2),
(5, 5, 'Module1', '#3c5813', 0, NULL, 1, 1),
(6, 5, 'Module2', '#d4cf40', 0, NULL, 1, 2),
(7, 6, 'Module1', '#711909', 0, NULL, 1, 1),
(8, 6, 'Module2', '#797b81', 0, NULL, 1, 2),
(9, 2, 'Module3', '#80d775', 0, NULL, 1, 3),
(10, 2, 'Module4', '#6bc7bc', 1, 2, 1, 4),
(11, 6, 'Module3', '#107109', 0, NULL, 1, 3),
(12, 6, 'Module4', '#193486', 0, NULL, 1, 4),
(13, 5, 'Module3', '#d4cf46', 0, NULL, 1, 3),
(14, 4, 'Module3', '#d4404f', 0, NULL, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `qt_id` int(11) NOT NULL,
  `que_typ_name` varchar(20) DEFAULT NULL COMMENT 'Category of question',
  `total_q` int(11) NOT NULL COMMENT 'total question to dispay of this cat '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`qt_id`, `que_typ_name`, `total_q`) VALUES
(1, 'Aesthetic', 0),
(2, 'art', 8),
(3, 'calligraphy', 4),
(4, 'color', 7),
(5, 'history', 0),
(6, 'meta', 0),
(7, 'photography', 4),
(8, 'SA', 0),
(9, 'typo', 6),
(10, 'web', 6);

-- --------------------------------------------------------

--
-- Table structure for table `quizz_data`
--

CREATE TABLE `quizz_data` (
  `id` int(11) NOT NULL,
  `qt_id` int(11) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `explanation` varchar(255) NOT NULL,
  `choice1` varchar(255) NOT NULL,
  `choice2` varchar(255) NOT NULL,
  `choice3` varchar(255) NOT NULL,
  `choice4` varchar(255) NOT NULL,
  `answer` int(2) NOT NULL COMMENT 'correct answer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizz_data`
--

INSERT INTO `quizz_data` (`id`, `qt_id`, `question_type`, `question`, `explanation`, `choice1`, `choice2`, `choice3`, `choice4`, `answer`) VALUES
(1, 1, 'Aesthetic', 'Aesthetic\' term was first used in the branch of', 'The first use of the term aesthetics in something like its modern sense is commonly attributed to Alexander Baumgarten in 1735 familiar sense as a distinct branch of philosophy.', '*Philosophy ', 'Science', 'Maths', 'all of the above', 1),
(2, 2, 'art', 'What is the right solution to create unity', 'Unity can be created using all 3 options mentioned', 'Line up photographs and text with the same grid lines.', 'Repeat a color, shape, or texture in different areas throughout.', 'Use the same color palette throughout.', '*Any of these', 4),
(3, 2, 'art', 'Out of the following, which establishes typographic hierarchy?', 'All three can establish', 'Weight', 'Contrast', 'Placement', '*All of these', 4),
(4, 2, 'art', 'In Corporate Identity a Sign that represents the qualities, or the philosophy of a company is called?', 'In a logo unit, a symbol is the visual device that represents the philosophy or the qualities of a company.', '*Symbol', 'Logotype', 'Mascot', 'Muppet', 1),
(5, 2, 'art', 'In UX What is a Persona', 'A Persona is created that represents a user group which is a collection of characteristics that helps the designer empathise with those users.', 'An important personality', 'Anything that is personal', 'The Stakeholder (client)', '*A representation of the target user.', 4),
(6, 2, 'art', 'In Corporate Identity What is a Letter Mark or a Logotype', 'The font or the lettering in which the company name is written', '*The font or the lettering in which the company name is written', 'Letterhead the company uses all the time', 'A stamp that is used for official purpose', 'A logbook that contains all important company information', 1),
(7, 2, 'art', 'What does the printer use to know where to trim the paper after printing?', 'Crop Marks. Crop marks, also known as trim marks, are lines printed in the corners of your publication\'s sheet or sheets of paper to show the printer where to trim the paper. ', 'Registration Marks', '*Crop Marks', 'Color Bars', 'A Ruler', 2),
(8, 2, 'art', 'Gesture Drawing is?', 'Movement of action Gesture drawing is a method of capturing figures in exaggerated poses', '*movement of action', 'landscapes', 'geometric drawing', 'none of the above', 1),
(9, 2, 'art', 'Forms repeated in a design is called', 'Patterns are simply a repetition of more than one design element working in concert with each other.', 'illustration', '*pattern', 'variety', 'unity', 2),
(10, 2, 'art', 'What is a Text matter for a design callled ', 'written matter is known as content', '*content', 'panel', 'layer', 'layout', 1),
(11, 2, 'art', 'The arrangement of the visual elements is called as?', 'Composition is the way in which different elements of an artwork are combined or arranged.', '*composition', 'unity', 'harmony', 'contrast', 1),
(12, 2, 'art', 'Surface Quality of a design is ', 'texture. In the visual arts, texture is the perceived surface quality of a work of art.', 'harmony', '*texture', 'balance', 'unity', 2),
(13, 2, 'art', 'Three-dimensional means ', ' height, width, and depth.', '*height, width, and depth.', 'height, and width', 'height, and depth', 'none of the above', 1),
(14, 2, 'art', 'The extent of a shape is called as', 'Size', '*size', 'depth', 'volume', 'mass', 1),
(15, 2, 'art', 'What is Volume in a design?', 'solidity or mass', 'the extent of a shape', 'the specific spatial character', '*solidity or mass', 'extension in any direction', 3),
(16, 2, 'art', 'Which among the following is a design element?', 'all of the above', 'value', 'colour', 'space', '*all of the above', 4),
(17, 2, 'art', 'What refers to the space of a shape representing the subject matter.', 'positive space', '*positive space', 'negative space', 'form', 'value', 1),
(18, 2, 'art', 'An element of art that refers to the lightness or darkness of a color is a', 'Value', '*value', 'form', 'space', 'intensity', 1),
(19, 2, 'art', 'What is the visual illusion called where an impression of depth is created by using two dimensional colour images (usually blue and red)?', 'Visual perception is a constant factor that affects usability and design. Therefore, it is a good idea for the UX designer to be familiar with the limitations of the visual perception system.', 'Tessellation', 'RYB Primaries', '*Chromosteriopsis', 'Hyperchomatoscopy', 3),
(20, 2, 'art', 'What are the sequential rough sketches of screens, that give an idea of how the app is going to work, called?', 'Paper prototype is a low fidelity prototype (also referred to as wireframes) that is a series of screen drawings that provide the user with an idea of how the app is going to function. Paper prototypes are used to test app concepts as well as interaction ', 'Working Prototype', 'Rapid Prototype', '*Paper Prototype', 'User Acceptance Test', 3),
(21, 2, 'art', 'What is Fine Art?', 'Fine Art, as opposed to Applied Art, is an end in itself. The objective of Fine Art is creation of beauty, not creating artefacts merely to support external activities such as marketing communication.', 'Application of Artistic Fineness', 'Art that is better than Applied Art in its worth.', '*Art that is focused solely on imaginative, artistic or intellectual content.', 'Fine tuned art that is appreciated for its investment value.', 3),
(22, 3, 'calligraphy', 'In which angle is the broad edged pen supposed to be placed for writing the Chancery Hand Calligraphy?', 'In cursive chancery hand the pen was held slanted at a 45? angle for speed, but it could also produce beautiful calligraphic writing. Eventually it became a practice to hold the pen 45? angle as it also gave a perfect thick and thin contrast making the le', '25 Degrees', '35 Degrees', '*45 Degrees', '55 Degrees', 3),
(23, 3, 'calligraphy', 'In small letters, what is the central body part of the letters called as?', 'X-height refers to the height of the lowercase letters in a line of text. For Eg: The height of letters a,e,o,v,s,r, etc.', 'x length', '*x height', 'y length', 'y height', 2),
(24, 3, 'calligraphy', 'For Capital letters, how many contiguous nib widths are ideally required to draw the guidelines?', 'The Capital Letters are 2/3 nib width longer than the x height. The height of Capital Letters is lower than the ascender.  ', '*7-8 contiguous nib widths', '6-7 contiguous nib widths', '9-10 contiguous nib widths', '5-6 contiguous nib widths', 1),
(25, 3, 'calligraphy', 'Which letter travels through all the guidelines, x-height, ascenders and descenders?', 'The letter f is one of the toughest letter to draw as it is the most elongated letterform travelling through all the guidelines.', 'Letter y', '*Letter f', 'Letter g', 'Letter k', 2),
(26, 4, 'color', 'In the traditional RYB color model, which color is complimentary to blue?', 'Complementary colors are the opposite hues on the color wheel. Complementary colors may also be called \"opposite colors\".', 'Yellow', 'green', '*orange', 'purple', 3),
(27, 4, 'color', 'Which color best reflects these descriptions? Warmth, love, anger, danger, boldness, excitement, speed, strength, energy, determination, desire, passion, and courage', 'Colors in the red area of the color spectrum are known as warm colors and depith all mentioned emotions', 'Orange', 'Purple', 'Black', '*Red', 4),
(28, 4, 'color', 'If black is added to a pure color, the graphic design term for the result is:', 'Shade. In color theory, a tint is a mixture of a color with white, which increases lightness, while a shade is a mixture with black, which increases darkness.', 'Night Color', 'Tone', '*Shade', 'Fuzzy', 3),
(29, 4, 'color', 'Color harmony means?', 'pleasing arrangements of color In color theory, color harmony refers to the property that certain aesthetically pleasing color combinations have.', '*pleasing arrangements of color', 'contrast of colors', 'complexity', 'none of the above', 1),
(30, 4, 'color', 'The saturation or strength of a color is?', 'intensity', '*intensity', 'depth', 'brightness', 'hue', 1),
(31, 4, 'color', 'The character of a color or value of a surface is known as?', 'tone', 'saturation', '*tone', 'tint', 'contrast', 2),
(32, 4, 'color', 'Which Scheme have tints and shades of one color.', 'monochromatic Scheme', 'bichromatic Scheme', 'dichromatic Scheme', 'monolithic Scheme', '*monochromatic Scheme', 4),
(33, 5, 'history', 'Non realistic art is known as', 'abstract', 'surrealism', '*abstract', 'cubism', 'realism', 2),
(34, 5, 'history', 'When an artist uses geometric shapes to show what he is trying to paint is called as ', 'cubism- geometric shapes', 'pop art', 'impressionism', 'abstract', '*cubism', 4),
(35, 5, 'history', 'Petroglyphs are ', 'Images incised in rock', '*Images incised in rock', 'Paintings on rocks', 'Blocks', 'Carvings in Temples', 1),
(36, 5, 'history', 'The great intellectual movement of Renaissance Italy was ', 'humanism', 'cubism', 'groupism', 'fascism', '*humanism', 4),
(37, 5, 'history', 'A scriptorium is ', 'a room devoted to the hand-lettered copying of manuscripts', 'letter forms', '*a room devoted to the hand-lettered copying of manuscripts', 'the artist who scripted the books', 'A stylized script', 2),
(38, 5, 'history', 'The word paper comes from', 'The word \"paper\" comes from papyrus, which is \"the paper plant, or paper made from it.\"', '*the ancient Egyptian writing material called papyrus', 'Pepper', 'Petals', 'None of these', 1),
(39, 5, 'history', 'What did Johann Gutenberg invent?', 'Movable type printing Press thus known as the father of printing press', 'Telescope', '*Movable type Printing Press', 'Movable machines', 'Beats', 2),
(40, 6, 'meta', 'What is metacognition?', 'The term metacognition literally means \'above cognition\', and is used to indicate cognition about cognition, or more informally, thinking about thinking', 'creating mental images in your mind', '*thinking about your thinking', 'wondering as you read', 'thinking what the text might be about', 2),
(41, 6, 'meta', 'Self-awareness as a learner?', 'All of the above', 'Understands strengths and weakness ', 'Identifies one\'s emotions, and how they affect others', 'Understands the relationship between one\'s emotions, thoughts, values, and behaviors', '*All of the above', 4),
(42, 7, 'photography', 'Nearer view of an Image is called as', 'foreground. The area of the picture space nearest to the viewer, immediately behind the picture plane, is known as the foreground.', '*foreground', 'background', 'contact', 'depth of field', 1),
(43, 7, 'photography', 'The equilibrium of elements is called as', 'Balance ', 'background', '*balance', 'rhythm', 'contrast', 2),
(44, 7, 'photography', 'Which of the following is a component of Exposure Triangle?', 'Exposure Triangle consists of 3 major components that adjust how a camera capture light and in order to maintain the right exposure range ISO is one of the components along with Shutter Speed & Aperture. One can access the use of Exposure Triangle only if', 'Perspective', '*ISO', 'Focusing', 'Color', 2),
(45, 7, 'photography', 'In bright sunlight what Shutter Speed would you use to control exposure?', 'Faster Shutter speed helps to maintain the exposure range under bright sunlight where one needs to control the existing light to receive right range of brightness and details. ', '*1/125', '1/225', '1/325', '1/111', 1),
(46, 7, 'photography', ' Which of the following Aperture value reflects Shallow depth of field?', 'The wide-open Aperture is responsible to provide shallow depth of field in a photograph that is f/2.8 or below. ', '*f/1.8', 'f/6.3', 'f/11', 'f/16', 1),
(47, 7, 'photography', 'Which of the following Composition Rule do not allow to center compose a subject? ', 'The idea is that an off-centre composition is more pleasing to the eye and looks more natural than one where the subject is placed right in the middle of the frame. Rule of Thirds is considered as golden ratio where one must place the subject within any o', ' Leading Lines', 'Patterns & Repetition', '*Rule of Thirds', 'None of these', 3),
(48, 7, 'photography', 'In order to maintain details in an image what is more important to protect / control in Exposure?', 'In photography, by keeping your subjects in the highlights and then exposing your shot for the highlights, you can draw the viewers\' attention immediately to the main subject and use the underexposed area as a frame or a negative space to draw viewers to ', '* Highlights', ' Midtones', ' Darks', 'all of the above', 1),
(50, 9, 'typo', 'In typography, tracking is...', 'In typography, letter spacing, character spacing or tracking is?an optically consistent adjustment to the space between letters to change the visual density of a line or block of text.', '*uniformly increasing or decreasing the space between all letters in a block of text', 'the distance between the baselines of successive lines of type', 'uniformly adjusting the height of all characters', 'the process of selecting a document\'s typeface', 1),
(51, 9, 'typo', 'In typography what does a serif mean?', 'A decorative stroke that finishes off the end of a letters stem', '*A decorative stroke that finishes off the end of a letters stem', 'A writing book', 'A cut nib pen', 'A layout style', 1),
(52, 9, 'typo', 'Which of the following describes the Arial and Times New Roman fonts?  ', 'Arial is a sans serif font, Times New Roman is a serif font', '*Arial is a sans serif font, Times New Roman is a serif font', 'Arial is a serif font, Times New Roman is a sans serif font', 'Both are serif fonts', 'Both are sans serif fonts', 1),
(53, 9, 'typo', 'The top point of a capital A is called', 'Apex', 'Arm', '*Apex', 'Bowl', 'Tail', 2),
(54, 9, 'typo', 'What is the space between two baselines called', 'leading', 'tracking', 'kerning', 'span', '*leading', 4),
(55, 9, 'typo', 'According to typography guidelines what is a bowl?', 'The round, inside part of letters like b, d, o, etc.', 'The inside of the letter C.', '*The round, inside part of letters like b, d, o, etc.', 'None of these ', 'The inside of the letter G.', 2),
(56, 9, 'typo', 'What does Italic stand for in Typography?', 'Normally, those typefaces which slant to the right', 'Normally, those typefaces which have been designed to be used in Italy', '*Normally, those typefaces which slant to the right', 'Normally, those typefaces which are designed by Italian Typographers ', 'None of these.', 2),
(57, 9, 'typo', 'What are Expanded, Condensed and Normal in Typography?', 'The design of a letter - typeface that suggests its appearance.', '*The design of a letter - typeface that suggests its appearance.', 'That indicates the space available to adjust the text.', ' Normally, those typefaces which are not fit for any use.', 'The typefaces which to be used as the meaning of the text matter suggests.', 1),
(58, 9, 'typo', 'What is unit that is used to measure a font?', 'Point', 'Inch', 'Centimeter', '*Point', 'Millimeter', 3),
(59, 9, 'typo', 'In typography, Justify means?', 'A type of alignment', '*A type of alignment', 'explanation in an argument', 'balance of text and image', 'appropriate use of type', 1),
(60, 9, 'typo', 'In typography, Light, Normal, Bold suggest?', 'Type weight', 'Colour of selected type', '*Type weight', 'Importance of type in a layout', 'None of the above', 2),
(61, 9, 'typo', 'In a font, what is the meaning of Upper Case?', 'All the capital letters of a font', 'Letters placed above the line', 'Text that appears on the top', '*All the capital letters of a font', 'Letters which are bigger in size.', 3),
(62, 9, 'typo', 'What do you understand by the term x-height?', 'The mean height of lower-case letters, excluding ascenders and descenders.', 'Letters placed above the line', 'Text that appears on the top', '*The mean height of lower-case letters, excluding ascenders and descenders.', 'Letters which are bigger in size.', 3),
(63, 9, 'typo', 'In typography, the term black letters refers to?', 'Typeface evolved from the broad-nib pen style of Gothic Lettering, also known as Old English. ', 'Letters those are coloured in black', '*Typeface evolved from Gothic Lettering', 'Letters designed for magical purpose', 'None of the above', 2),
(64, 9, 'typo', 'What is meaning of set solid?', ' Lines of type set without any additional interline spacing', 'Letters those are painted in the darkest shades', 'Typeface that appears solid as a rock', ' Letters designed for architectural and engineering purpose', '*Lines of type set without any additional interline spacing', 4),
(65, 9, 'typo', 'What kind of fonts are referred as Roman?', 'Letters those are vertical  without slant', '*Letters those are vertical  without slant', 'Letters invented in Rome', 'Letters which are used for writing strictly by Romans', 'None of the above', 1),
(66, 9, 'typo', 'Drop cap letter is ', 'Large-sized initial letter, normally a cap that is used at the beginning of the text of a chapter. ', 'A missing letter from a word. ', '*Large-sized initial letter.', 'Letter that drops from its base-line.', 'A letter that is from different script.', 2),
(67, 9, 'typo', 'What is a Display Type?  ', 'A display typeface is a typeface that is intended for use at large sizes for headings, rather than for extended passages of body text. ', 'A type that can be displayed anywhere. ', 'Type that is meant for the use of exhibitions only.', '*A Large Typeface designed for headings etc.', 'Type that is meant for sign-board painters, to use.', 3),
(68, 9, 'typo', 'What is an ascender?  ', 'The parts of some lower-case letters such as b, d, h, which rise above the x-height or mean-line. ', 'Letters which are to be read while ascending a staircase', '*The parts of some lower-case letters which rise above x-height.', 'The letters arranged in an ascending order.', 'The letters appear in the heading or title of the book.', 2),
(69, 9, 'typo', 'What is a descender?  ', 'The parts of some lower-case letters such as p, q, y, which hangs below the x-height or mean-line. ', ' Letters which appear below the eye level. ', 'The letters arranged in a descending order.', 'The letters used specially for the footnotes of a technical book.', '*The parts of some lower-case letters which hang below x-height.', 4),
(70, 10, 'web', 'What does UI/UX design stand for?', 'User Interface/User Experience Design', 'User Interest/User Experience Design', '*User Interface/User Experience Design', 'United Interest/United Experience Design', 'User Inbound/User Example Design', 2),
(71, 10, 'web', 'In Web what does HTML stand for?', 'Hyper Text Markup Language', 'Hot Tools Machine Language', 'Hyper Transfer Machine Language', '*Hyper Text Markup Language', 'Heuristic Transfer Marked-up Linguistics', 3),
(72, 10, 'web', 'While designing for Mobile Interfaces which Colours are considered Primary?', 'For any digital display, the light colours  Red, Green, Blue are considered Primary Colours.', 'CMYK', 'RYB', 'HSBC', '*RGB', 4),
(73, 10, 'web', 'What program is used to make vector images?', ' Any art made with vector illustration software like Adobe Illustrator is considered vector art.', 'Photoshop', 'After Effects', 'Dreamweaver', '*Illustrator', 4),
(74, 10, 'web', 'What resolution is best suited for the web?', '72 points per inch. The standard resolution for web images is 72 PPI (often called screen resolution)', '300 points per inch', '12 points per inch.', '6 points per inch.', '*72 points per inch', 4),
(75, 10, 'web', 'Which image file format most commonly supports animation?', 'GIF, in full graphics interchange format, digital file format devised  by the Internet service provider CompuServe as a means of reducing the size of images and short animations.', '.jpg', '.tiff', '.psd', '*.gif', 4),
(76, 10, 'web', 'Which of the following is considered the industry standard for photo manipulation in graphic design?', 'Photoshop. Photoshop is the standard software used to edit and compose raster images/photos in multiple layers and several color models including RGB, CMYK,  spot color, and duotone.', 'GIMP', '*Photoshop', 'Acrobat', 'Dreamweaver', 2),
(77, 10, 'web', 'Which one of the following is not related to image format?', ' WAV is an audio file that is associated with Microsoft Windows. Rest formats are for images.', 'jpeg', 'tiff', '*wav', 'bmp', 3),
(78, 10, 'web', 'There are two types of graphics generated with the help of computers. One of them is Vectors. Which is the other one?', 'Rasters are the graphics that are made up of pixels (resulting out of parallel scanning lines on screen. Upon scaling, the number of pixels change and the values of the pixels are re-interpreted, therefore the sharpness and overall images quality may chan', 'Freighters', 'Gradients', '*Raster', 'GIFs', 3),
(80, 10, 'web', 'What is the third area of discovery apart from User Analysis and Task Analysis, that the UX Designer is supposed to undertake before beginning the design process?', 'Before starting the design process, the UX Designer is supposed to undertake User analysis that will clarify who the intended users of the system are, Task Analysis will clarify what tasks are the user likely to perform with the system, and Environment ', 'Conceptual Analysis', '*Environmental Analysis', 'Business Analysis', 'Cost Analysis', 2),
(81, 10, 'web', 'What is Information Architecture?', 'Information Architecture is essential to the logical organization of any online information system. Be it an online encyclopedia such as Wikipedia or a travel booking app, if organized by keeping the users information needs in mind', '*The hierarchy of information within a website or an app', 'A building where you get all required information', 'Informative Architecture', 'The hierarchy of officials responsible to provide information.', 1),
(82, 10, 'web', 'You call a website responsive when', 'Responsive website are adjustable to all type of devices', 'The website opens in a browser without an issue.', 'The website is built around the theme of social responsibility.', '*The website is suitable to access on all devices', 'The website can sustain all DDOS attacks and still works.', 3),
(83, 10, 'web', 'In web design, what does CSS stand for', 'Cascading Style Sheets (CSS) is a stylesheet language used to describes how HTML elements should be rendered on screen. Web pages are designed using CSS that decides the presentation and styling.', '*Cascading Style Sheets', 'Colour Standards & Systems.', 'Consortium of System Structures.', 'Code of Security Standards.', 1),
(84, 10, 'web', 'What is Sequential Navigation?', 'Sequential Navigation is what users use in a variety of websites such as booking a plane ticket or a movie ticket. It is an organization of web pages that are linked in a sequential manner. ', '*A navigation that is step by step, such as a wizard', 'The order in which people are supposed to enter a website.', 'Where the sequence of the navigation is well organised', 'A navigation system that undergoes many changes.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizz_data_test`
--

CREATE TABLE `quizz_data_test` (
  `id` int(11) NOT NULL,
  `qt_id` int(11) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `explaination` varchar(255) NOT NULL,
  `choice1` varchar(255) NOT NULL,
  `choice2` varchar(255) NOT NULL,
  `choice3` varchar(255) NOT NULL,
  `choice4` varchar(255) NOT NULL,
  `answer` int(2) NOT NULL COMMENT 'correct answer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `run_this`
--

CREATE TABLE `run_this` (
  `id` int(11) NOT NULL,
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `run_this`
--

INSERT INTO `run_this` (`id`, `query`) VALUES
(1, 'UPDATE `quizz_data` SET `qt_id`=4 WHERE `question_type`=\'color\';');

-- --------------------------------------------------------

--
-- Table structure for table `student_marks`
--

CREATE TABLE `student_marks` (
  `markid` int(11) NOT NULL,
  `tid` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `marks_json` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_submit` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_marks`
--

INSERT INTO `student_marks` (`markid`, `tid`, `first_name`, `last_name`, `middle_name`, `course`, `marks_json`, `date`, `date_modified`, `status`, `is_submit`) VALUES
(1, 23, 'Mamta', 'Malvi', 'Ashok', 6, '{\"marks\":{\"7\":{\"7\":\"11\",\"21\":\"11\",\"22\":\"11\",\"23\":\"11\",\"24\":\"11\"},\"8\":{\"8\":\"11\",\"25\":\"11\",\"26\":\"11\",\"27\":\"11\"},\"11\":{\"28\":\"11\",\"29\":\"11\"},\"12\":{\"30\":\"11\",\"31\":\"11\",\"32\":\"11\",\"33\":\"11\"}},\"total\":165}', '2023-02-26 15:31:58', '2023-02-26 15:32:49', 0, 0),
(2, 23, 'Mamta', 'Malvi', 'Ashok', 5, '{\"marks\":{\"5\":{\"5\":\"22\",\"35\":\"22\",\"36\":\"22\"},\"6\":{\"6\":\"22\",\"37\":\"22\",\"38\":\"22\"},\"13\":{\"39\":\"22\",\"40\":\"22\",\"41\":\"22\"}},\"total\":198}', '2023-02-26 15:36:26', '2023-02-26 15:37:37', 0, 1),
(3, 23, 'Mamta M', 'Malvi A', 'M A', 4, '{\"marks\":{\"3\":{\"3\":\"22\",\"42\":\"22\",\"43\":\"22\",\"44\":\"22\"},\"4\":{\"4\":\"22\",\"45\":\"22\",\"46\":\"22\",\"47\":\"22\"},\"14\":{\"48\":\"55\",\"49\":\"55\",\"50\":\"33\",\"51\":\"88\"}},\"total\":407}', '2023-03-02 16:00:19', '2023-03-02 16:00:19', 1, 1),
(4, 23, 'aa', 'a', 'a', 4, '{\"marks\":{\"3\":{\"3\":\"35\",\"42\":\"4\",\"43\":\"4\",\"44\":\"45\"},\"4\":{\"4\":\"45\",\"45\":\"45\",\"46\":\"54\",\"47\":\"4\"},\"14\":{\"48\":\"4\",\"49\":\"4\",\"50\":\"4\",\"51\":\"4\"}},\"total\":252}', '2023-03-10 10:55:37', '2023-03-10 10:55:37', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblaccount`
--

CREATE TABLE `tblaccount` (
  `accnt_Id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblaccount`
--

INSERT INTO `tblaccount` (`accnt_Id`, `username`, `password`, `user_Id`) VALUES
(1, 'mamta', '565fdb43462efef831c018f2e91cecbb', 1),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', 2),
(3, 'surabhi', 'aeb6b3ff2608256c8a0abc26acfdb70d', 3),
(4, 'new', '22af645d1859cb5ca6da0c484f1f37ea', 4),
(5, 'aa1', '1ebd82a5a4abd5962c3556bc679a388c', 5),
(6, 'dipti', '95e62d2c1c1cdab7efda7d2cdb64cf85', 6),
(7, 'aditeevaidya', '202cb962ac59075b964b07152d234b70', 7),
(8, 'm', 'b3cd915d758008bd19d0f2428fbb354a', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(11) NOT NULL,
  `utype` varchar(2) NOT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `utype`, `uname`, `pwd`) VALUES
(1, 'ad', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblpost`
--

CREATE TABLE `tblpost` (
  `post_Id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `cat_id` int(12) DEFAULT NULL,
  `user_Id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpost`
--

INSERT INTO `tblpost` (`post_Id`, `title`, `content`, `datetime`, `cat_id`, `user_Id`) VALUES
(11, 'sample', 'sample admin\r\n                        ', '2015-03-24 02:46:55', 1, 0),
(13, 'sample', 'user                        ', '2015-03-24 02:49:20', 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_Id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `user_id` int(11) NOT NULL,
  `uniq_id` varchar(15) DEFAULT NULL,
  `quizz_stage` int(2) DEFAULT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `fathername` varchar(20) DEFAULT NULL,
  `mothername` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`user_id`, `uniq_id`, `quizz_stage`, `fname`, `fathername`, `mothername`, `lname`, `country`, `date`, `last_login`) VALUES
(11, 'qz63d9479d4e2fa', 1, 'mamtat', 'ashokt', 'anusyat', 'malvit', '', '2023-01-31 04:53:49', '2023-01-31 04:54:53'),
(13, 'qz63d9479d4e2fa', 2, 'mamtat', 'ashokt', 'anusyat', 'malvit', 'india', '2023-01-31 05:00:24', NULL),
(14, 'qz63de2d7a20dad', 2, 'mamtam1', 'ashokm1', 'anusyam1', 'malvim1', 'india', '2023-02-03 22:03:38', NULL),
(15, 'qz63de2d7a20dad', 1, 'mamtam1', 'ashokm1', 'anusyam1', 'malvim1', '', '2023-02-03 22:20:52', NULL),
(16, 'qz63de3744e8d9b', 2, 'test1', 'test1', 'test1', 'test1', 'india', '2023-02-03 22:45:24', '2023-02-03 22:47:18'),
(17, 'qz63de3744e8d9b', 1, 'test1', 'test1', 'test1', 'test1', '', '2023-02-03 22:47:33', '2023-02-20 04:49:13'),
(18, 'qz63de38e62bb87', 1, 'test2', 'test2', 'test2', 'test2', '', '2023-02-03 22:52:22', NULL),
(19, 'qz63de38e62bb87', 2, 'test2', 'test2', 'test2', 'test2', 'india', '2023-02-03 22:52:54', NULL),
(20, 'qz63eb91fa0767b', 1, 'aa', 'a', 'a', 'a', '', '2023-02-14 01:51:54', NULL),
(21, 'qz63f3a42b510c5', 1, 'test', 'test', 'test', 'test', '', '2023-02-20 04:47:39', NULL),
(22, 'qz63f3af9c321c7', 1, 'xyz', 'xyz', 'xyz', 'xyz', '', '2023-02-20 05:36:28', '2023-02-20 05:37:01'),
(23, 'qz63f3af9c321c7', 2, 'xyz', 'xyz', 'xyz', 'xyz', 'india', '2023-02-20 05:37:26', NULL),
(24, 'qz640ef1e76f0c8', 1, 'sushil', 'fa', 'mo', 'rapatwar', '', '2023-03-12 21:50:31', NULL),
(25, 'qz64231e019db6b', 1, 'tiger', 'lion', 'lioness', 'jinda', '', '2023-03-28 05:04:01', NULL),
(26, 'qz642376398cc65', 2, 'beta', 'papa', 'mama', 'a', 'india', '2023-03-28 23:20:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `utype` varchar(11) DEFAULT NULL,
  `uinfo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`uinfo`)),
  `uname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `upass` varchar(20) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `lastlogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `utype`, `uinfo`, `uname`, `email`, `upass`, `date`, `lastlogin`) VALUES
(15, 'teacher', '{\"fname\":\"Aditee\",\"lname\":\"Vaidya\",\"email\":\"aditeevaidya@yahoo.com\",\"number\":\"9869081586\"}', '9869081586', 'aditeevaidya@yahoo.com', 'MTIzNDU2', '2022-12-11 05:48:09', '2022-12-11 05:48:09'),
(16, 'teacher', '{\"fname\":\"Amruta\",\"lname\":\"Langs\",\"email\":\"amruthag.langs@gmail.com\",\"number\":\"9833277812\"}', '9833277812', 'amruthag.langs@gmail.com', 'MTIzNDU2', '2022-12-11 05:50:55', '2022-12-11 05:50:55'),
(17, 'teacher', '{\"fname\":\"Sushil\",\"lname\":\"Rapatwar\",\"email\":\"sushil.rapatwar@astml.co.uk\",\"number\":\"7961082639\"}', '7961082639', 'sushil.rapatwar@astml.co.uk', 'MTIzNDU2', '2022-12-11 05:52:20', '2022-12-11 05:52:20'),
(18, 'teacher', '{\"fname\":\"Dilip\",\"lname\":\"Amdekar\",\"email\":\"dilip.amdekar@astml.co.uk\",\"number\":\"7766075244\"}', '7766075244', 'dilip.amdekar@astml.co.uk', 'MTIzNDU2', '2022-12-11 05:54:10', '2022-12-11 05:54:10'),
(20, 'admin', '{\"fname\":\"Mamta\",\"lname\":\"Malvi\",\"email\":\"malvimamta5598@gmail.com\",\"number\":\"9969936206\"}', '9969936206', 'malvimamta5598@gmail.com', 'OTk2OTkzNjIwNg==', '2023-01-31 09:41:19', '2023-01-31 09:41:19'),
(21, 'admin', '{\"fname\":\"test1\",\"lname\":\"test1\",\"email\":\"test@gmail.com\",\"number\":\"1234567890\"}', '1234567890', 'test@gmail.com', 'MTIzNDU2', '2023-01-31 11:48:54', '2023-01-31 11:48:54'),
(22, 'admin', '{\"fname\":\"Aashish\",\"lname\":\"Gala\",\"email\":\"aashishgala@gmail.com\",\"number\":\"9833698338\"}', '9833698338', 'aashishgala@gmail.com', 'QWFzaGlzaEAxMjM=', '2023-01-31 11:50:05', '2023-01-31 11:50:05'),
(23, 'teacher', '{\"fname\":\"abc1\",\"lname\":\"abc1\",\"email\":\"abc@gmail.com\",\"number\":\"1234123456\"}', '1234123456', 'abc@gmail.com', 'MTIzNDU2', '2023-01-31 11:53:42', '2023-01-31 11:53:42'),
(24, 'admin', '{\"fname\":\"test1\",\"lname\":\"test1\",\"email\":\"test1@gmail.com\",\"number\":\"9876543223\"}', '9876543223', 'test1@gmail.com', 'MTIzNDU2', '2023-02-04 01:29:08', '2023-02-04 01:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `userscore`
--

CREATE TABLE `userscore` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uniq_id` varchar(15) DEFAULT NULL,
  `round_1_mark` varchar(50) DEFAULT NULL,
  `round_2_mark` varchar(50) DEFAULT NULL,
  `json_round1` text DEFAULT NULL,
  `json_round2` text DEFAULT NULL,
  `quizz_stage` int(2) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userscore`
--

INSERT INTO `userscore` (`id`, `user_id`, `uniq_id`, `round_1_mark`, `round_2_mark`, `json_round1`, `json_round2`, `quizz_stage`, `date`) VALUES
(1, 1, 'qz62d429a8692e8', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"34\",\"que_numb\":\"1\",\"correcAns\":\"cubism\",\"userAns\":\"impressionism\"},{\"databaseId\":\"35\",\"que_numb\":\"2\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Blocks\"},{\"databaseId\":\"40\",\"que_numb\":\"3\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingwhatthetextmightbeabout\"},{\"databaseId\":\"38\",\"que_numb\":\"4\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"},{\"databaseId\":\"37\",\"que_numb\":\"5\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"theartistwhoscriptedthebooks\"},{\"databaseId\":\"36\",\"que_numb\":\"6\",\"correcAns\":\"humanism\",\"userAns\":\"humanism\"},{\"databaseId\":\"39\",\"que_numb\":\"7\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Beats\"},{\"databaseId\":\"33\",\"que_numb\":\"8\",\"correcAns\":\"abstract\",\"userAns\":\"realism\"},{\"databaseId\":\"41\",\"que_numb\":\"9\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Alloftheabove\"},{\"databaseId\":\"1\",\"que_numb\":\"10\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"}]', NULL, 1, '2022-07-17 03:24:41'),
(2, 2, 'qz634cf73a30ac0', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"37\",\"que_numb\":\"2\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"letterforms\"},{\"databaseId\":\"39\",\"que_numb\":\"3\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"MovabletypePrintingPress\"},{\"databaseId\":\"36\",\"que_numb\":\"4\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"41\",\"que_numb\":\"5\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"},{\"databaseId\":\"34\",\"que_numb\":\"6\",\"correcAns\":\"cubism\",\"userAns\":\"abstract\"},{\"databaseId\":\"33\",\"que_numb\":\"7\",\"correcAns\":\"abstract\",\"userAns\":\"realism\"},{\"databaseId\":\"1\",\"que_numb\":\"8\",\"correcAns\":\"Philosophy\",\"userAns\":\"Maths\"},{\"databaseId\":\"40\",\"que_numb\":\"9\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingaboutyourthinking\"},{\"databaseId\":\"38\",\"que_numb\":\"10\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Pepper\"}]', NULL, 1, '2022-10-17 06:34:29'),
(3, 3, 'qz634cf73a30ac0', NULL, '{\"total_score\" : \"10\", \"mark\" : \"20\"}', NULL, '[{\"databaseId\":\"3\",\"que_numb\":\"1\",\"correcAns\":\"Allofthese\",\"userAns\":\"Contrast\"},{\"databaseId\":\"5\",\"que_numb\":\"2\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"TheStakeholderclient\"},{\"databaseId\":\"10\",\"que_numb\":\"3\",\"correcAns\":\"content\",\"userAns\":\"content\"},{\"databaseId\":\"11\",\"que_numb\":\"4\",\"correcAns\":\"composition\",\"userAns\":\"unity\"},{\"databaseId\":\"14\",\"que_numb\":\"5\",\"correcAns\":\"size\",\"userAns\":\"volume\"},{\"databaseId\":\"15\",\"que_numb\":\"6\",\"correcAns\":\"solidityormass\",\"userAns\":\"thespecificspatialcharacter\"},{\"databaseId\":\"19\",\"que_numb\":\"7\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"Chromosteriopsis\"},{\"databaseId\":\"20\",\"que_numb\":\"8\",\"correcAns\":\"PaperPrototype\",\"userAns\":\"UserAcceptanceTest\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"25Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"ylength\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"910contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterf\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Purple\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Tone\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"complexity\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"depth\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"saturation\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"dichromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"background\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"rhythm\"},{\"databaseId\":\"47\",\"que_numb\":\"22\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"RuleofThirds\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"50\",\"que_numb\":\"24\",\"correcAns\":\"uniformlyincreasingordecreasingthespacebetweenalllettersinablockoftext\",\"userAns\":\"uniformlyadjustingtheheightofallcharacters\"},{\"databaseId\":\"51\",\"que_numb\":\"25\",\"correcAns\":\"Adecorativestrokethatfinishesofftheendofalettersstem\",\"userAns\":\"Awritingbook\"},{\"databaseId\":\"54\",\"que_numb\":\"26\",\"correcAns\":\"leading\",\"userAns\":\"tracking\"},{\"databaseId\":\"59\",\"que_numb\":\"27\",\"correcAns\":\"Atypeofalignment\",\"userAns\":\"balanceoftextandimage\"},{\"databaseId\":\"66\",\"que_numb\":\"28\",\"correcAns\":\"Largesizedinitialletter\",\"userAns\":\"Letterthatdropsfromitsbaseline\"},{\"databaseId\":\"68\",\"que_numb\":\"29\",\"correcAns\":\"Thepartsofsomelowercaseletterswhichriseabovexheight\",\"userAns\":\"Thepartsofsomelowercaseletterswhichriseabovexheight\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UserInterfaceUserExperienceDesign\"},{\"databaseId\":\"72\",\"que_numb\":\"31\",\"correcAns\":\"RGB\",\"userAns\":\"RYB\"},{\"databaseId\":\"73\",\"que_numb\":\"32\",\"correcAns\":\"Illustrator\",\"userAns\":\"Illustrator\"},{\"databaseId\":\"74\",\"que_numb\":\"33\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"72pointsperinch\"},{\"databaseId\":\"76\",\"que_numb\":\"34\",\"correcAns\":\"Photoshop\",\"userAns\":\"Dreamweaver\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CascadingStyleSheets\"}]', 2, '2022-10-17 06:35:47'),
(4, 4, 'qz634cfdb0d7967', '{\"total_score\" : \"6\", \"mark\" : \"12\"}', NULL, '[{\"databaseId\":\"1\",\"que_numb\":\"1\",\"correcAns\":\"Philosophy\",\"userAns\":\"Philosophy\"},{\"databaseId\":\"40\",\"que_numb\":\"2\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"creatingmentalimagesinyourmind\"},{\"databaseId\":\"39\",\"que_numb\":\"3\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Beats\"},{\"databaseId\":\"36\",\"que_numb\":\"4\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"38\",\"que_numb\":\"5\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\"},{\"databaseId\":\"41\",\"que_numb\":\"6\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Alloftheabove\"},{\"databaseId\":\"35\",\"que_numb\":\"7\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Paintingsonrocks\"},{\"databaseId\":\"33\",\"que_numb\":\"8\",\"correcAns\":\"abstract\",\"userAns\":\"abstract\"},{\"databaseId\":\"34\",\"que_numb\":\"9\",\"correcAns\":\"cubism\",\"userAns\":\"cubism\"},{\"databaseId\":\"37\",\"que_numb\":\"10\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\"}]', NULL, 1, '2022-10-17 07:02:41'),
(5, 5, 'qz634f8ec849bca', NULL, NULL, NULL, NULL, -1, NULL),
(6, 6, 'qz637dd04aa42dc', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"39\",\"que_numb\":\"1\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Telescope\"},{\"databaseId\":\"36\",\"que_numb\":\"2\",\"correcAns\":\"humanism\",\"userAns\":\"cubism\"},{\"databaseId\":\"38\",\"que_numb\":\"3\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"},{\"databaseId\":\"33\",\"que_numb\":\"4\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"40\",\"que_numb\":\"5\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingwhatthetextmightbeabout\"},{\"databaseId\":\"35\",\"que_numb\":\"6\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"CarvingsinTemples\"},{\"databaseId\":\"34\",\"que_numb\":\"7\",\"correcAns\":\"cubism\",\"userAns\":\"cubism\"},{\"databaseId\":\"41\",\"que_numb\":\"8\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Alloftheabove\"},{\"databaseId\":\"1\",\"que_numb\":\"9\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"37\",\"que_numb\":\"10\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"Astylizedscript\"}]', NULL, 1, '2022-11-22 19:49:35'),
(7, 7, 'qz6395ae3d349b3', NULL, NULL, NULL, NULL, -1, NULL),
(8, 8, 'qz63d5f558b8bb6', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"36\",\"que_numb\":\"1\",\"correcAns\":\"humanism\",\"userAns\":\"cubism\"},{\"databaseId\":\"33\",\"que_numb\":\"2\",\"correcAns\":\"abstract\",\"userAns\":\"abstract\"},{\"databaseId\":\"35\",\"que_numb\":\"3\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Blocks\"},{\"databaseId\":\"34\",\"que_numb\":\"4\",\"correcAns\":\"cubism\",\"userAns\":\"abstract\"},{\"databaseId\":\"39\",\"que_numb\":\"5\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Beats\"},{\"databaseId\":\"1\",\"que_numb\":\"6\",\"correcAns\":\"Philosophy\",\"userAns\":\"Science\"},{\"databaseId\":\"38\",\"que_numb\":\"7\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Pepper\"},{\"databaseId\":\"41\",\"que_numb\":\"8\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"},{\"databaseId\":\"37\",\"que_numb\":\"9\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"theartistwhoscriptedthebooks\"},{\"databaseId\":\"40\",\"que_numb\":\"10\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingaboutyourthinking\"}]', NULL, 1, '2023-01-29 04:26:22'),
(9, 9, 'qz63d8f1612b6ae', '{\"total_score\" : \"1\", \"mark\" : \"2\"}', NULL, '[{\"databaseId\":\"39\",\"que_numb\":\"1\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"MovabletypePrintingPress\"},{\"databaseId\":\"36\",\"que_numb\":\"2\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"41\",\"que_numb\":\"3\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"},{\"databaseId\":\"33\",\"que_numb\":\"4\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"1\",\"que_numb\":\"5\",\"correcAns\":\"Philosophy\",\"userAns\":\"Science\"},{\"databaseId\":\"38\",\"que_numb\":\"6\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"},{\"databaseId\":\"40\",\"que_numb\":\"7\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"wonderingasyouread\"},{\"databaseId\":\"35\",\"que_numb\":\"8\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Blocks\"},{\"databaseId\":\"37\",\"que_numb\":\"9\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"theartistwhoscriptedthebooks\"},{\"databaseId\":\"34\",\"que_numb\":\"10\",\"correcAns\":\"cubism\",\"userAns\":\"abstract\"}]', NULL, 1, '2023-01-30 22:46:13'),
(10, 10, 'qz63d8f184508a7', NULL, '{\"total_score\" : \"7\", \"mark\" : \"14\"}', NULL, '[{\"databaseId\":\"3\",\"que_numb\":\"1\",\"correcAns\":\"Allofthese\",\"userAns\":\"Placement\"},{\"databaseId\":\"4\",\"que_numb\":\"2\",\"correcAns\":\"Symbol\",\"userAns\":\"Mascot\"},{\"databaseId\":\"5\",\"que_numb\":\"3\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"Arepresentationofthetargetuser\"},{\"databaseId\":\"11\",\"que_numb\":\"4\",\"correcAns\":\"composition\",\"userAns\":\"harmony\"},{\"databaseId\":\"13\",\"que_numb\":\"5\",\"correcAns\":\"heightwidthanddepth\",\"userAns\":\"heightanddepth\"},{\"databaseId\":\"15\",\"que_numb\":\"6\",\"correcAns\":\"solidityormass\",\"userAns\":\"solidityormass\"},{\"databaseId\":\"18\",\"que_numb\":\"7\",\"correcAns\":\"value\",\"userAns\":\"space\"},{\"databaseId\":\"21\",\"que_numb\":\"8\",\"correcAns\":\"Artthatisfocusedsolelyonimaginativeartisticorintellectualcontent\",\"userAns\":\"Artthatisfocusedsolelyonimaginativeartisticorintellectualcontent\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"35Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"xlength\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"910contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterf\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"purple\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Tone\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"depth\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"contrast\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"dichromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"contact\"},{\"databaseId\":\"45\",\"que_numb\":\"21\",\"correcAns\":\"1125\",\"userAns\":\"1325\"},{\"databaseId\":\"47\",\"que_numb\":\"22\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Midtones\"},{\"databaseId\":\"51\",\"que_numb\":\"24\",\"correcAns\":\"Adecorativestrokethatfinishesofftheendofalettersstem\",\"userAns\":\"Acutnibpen\"},{\"databaseId\":\"54\",\"que_numb\":\"25\",\"correcAns\":\"leading\",\"userAns\":\"kerning\"},{\"databaseId\":\"57\",\"que_numb\":\"26\",\"correcAns\":\"Thedesignofalettertypefacethatsuggestsitsappearance\",\"userAns\":\"Thetypefaceswhichtobeusedasthemeaningofthetextmattersuggests\"},{\"databaseId\":\"61\",\"que_numb\":\"27\",\"correcAns\":\"Allthecapitallettersofafont\",\"userAns\":\"Allthecapitallettersofafont\"},{\"databaseId\":\"63\",\"que_numb\":\"28\",\"correcAns\":\"TypefaceevolvedfromGothicLettering\",\"userAns\":\"Lettersdesignedformagicalpurpose\"},{\"databaseId\":\"64\",\"que_numb\":\"29\",\"correcAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\",\"userAns\":\"Lettersdesignedforarchitecturalandengineeringpurpose\"},{\"databaseId\":\"71\",\"que_numb\":\"30\",\"correcAns\":\"HyperTextMarkupLanguage\",\"userAns\":\"HeuristicTransferMarkedupLinguistics\"},{\"databaseId\":\"73\",\"que_numb\":\"31\",\"correcAns\":\"Illustrator\",\"userAns\":\"Dreamweaver\"},{\"databaseId\":\"77\",\"que_numb\":\"32\",\"correcAns\":\"wav\",\"userAns\":\"wav\"},{\"databaseId\":\"80\",\"que_numb\":\"33\",\"correcAns\":\"EnvironmentalAnalysis\",\"userAns\":\"BusinessAnalysis\"},{\"databaseId\":\"82\",\"que_numb\":\"34\",\"correcAns\":\"Thewebsiteissuitabletoaccessonalldevices\",\"userAns\":\"Thewebsiteissuitabletoaccessonalldevices\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CodeofSecurityStandards\"}]', 2, '2023-01-30 22:47:29'),
(11, 11, 'qz63d9479d4e2fa', '{\"total_score\" : \"4\", \"mark\" : \"8\"}', NULL, '[{\"databaseId\":\"33\",\"que_numb\":\"1\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"41\",\"que_numb\":\"2\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Identifiesonesemotionsandhowtheyaffectothers\"},{\"databaseId\":\"1\",\"que_numb\":\"3\",\"correcAns\":\"Philosophy\",\"userAns\":\"Maths\"},{\"databaseId\":\"34\",\"que_numb\":\"4\",\"correcAns\":\"cubism\",\"userAns\":\"cubism\"},{\"databaseId\":\"37\",\"que_numb\":\"5\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\"},{\"databaseId\":\"36\",\"que_numb\":\"6\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"39\",\"que_numb\":\"7\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"MovabletypePrintingPress\"},{\"databaseId\":\"40\",\"que_numb\":\"8\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingaboutyourthinking\"},{\"databaseId\":\"35\",\"que_numb\":\"9\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Paintingsonrocks\"},{\"databaseId\":\"38\",\"que_numb\":\"10\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"}]', NULL, 1, '2023-01-31 04:54:07'),
(13, 13, 'qz63d9479d4e2fa', NULL, '{\"total_score\" : \"6\", \"mark\" : \"12\"}', NULL, '[[{\"databaseId\":\"2\",\"que_numb\":\"1\",\"correcAns\":\"Anyofthese\",\"userAns\":\"Repeatacolorshapeortextureindifferentareasthroughout\"},{\"databaseId\":\"3\",\"que_numb\":\"2\",\"correcAns\":\"Allofthese\",\"userAns\":\"Allofthese\"},{\"databaseId\":\"5\",\"que_numb\":\"3\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"Arepresentationofthetargetuser\"},{\"databaseId\":\"8\",\"que_numb\":\"4\",\"correcAns\":\"movementofaction\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"15\",\"que_numb\":\"5\",\"correcAns\":\"solidityormass\",\"userAns\":\"thespecificspatialcharacter\"},{\"databaseId\":\"18\",\"que_numb\":\"6\",\"correcAns\":\"value\",\"userAns\":\"form\"},{\"databaseId\":\"19\",\"que_numb\":\"7\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"RYBPrimaries\"},{\"databaseId\":\"20\",\"que_numb\":\"8\",\"correcAns\":\"PaperPrototype\",\"userAns\":\"PaperPrototype\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"45Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"ylength\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"56contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterg\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"contrastofcolors\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"brightness\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"tint\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"monochromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"depthoffield\"},{\"databaseId\":\"46\",\"que_numb\":\"21\",\"correcAns\":\"f18\",\"userAns\":\"f63\"},{\"databaseId\":\"47\",\"que_numb\":\"22\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"RuleofThirds\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Midtones\"},{\"databaseId\":\"50\",\"que_numb\":\"24\",\"correcAns\":\"uniformlyincreasingordecreasingthespacebetweenalllettersinablockoftext\",\"userAns\":\"uniformlyadjustingtheheightofallcharacters\"},{\"databaseId\":\"52\",\"que_numb\":\"25\",\"correcAns\":\"ArialisasansseriffontTimesNewRomanisaseriffont\",\"userAns\":\"Bothareseriffonts\"},{\"databaseId\":\"57\",\"que_numb\":\"26\",\"correcAns\":\"Thedesignofalettertypefacethatsuggestsitsappearance\",\"userAns\":\"Thetypefaceswhichtobeusedasthemeaningofthetextmattersuggests\"},{\"databaseId\":\"58\",\"que_numb\":\"27\",\"correcAns\":\"Point\",\"userAns\":\"Centimeter\"},{\"databaseId\":\"61\",\"que_numb\":\"28\",\"correcAns\":\"Allthecapitallettersofafont\",\"userAns\":\"Letterswhicharebiggerinsize\"},{\"databaseId\":\"64\",\"que_numb\":\"29\",\"correcAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\",\"userAns\":\"Lettersdesignedforarchitecturalandengineeringpurpose\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UserInboundUserExampleDesign\"},{\"databaseId\":\"73\",\"que_numb\":\"31\",\"correcAns\":\"Illustrator\",\"userAns\":\"AfterEffects\"},{\"databaseId\":\"76\",\"que_numb\":\"32\",\"correcAns\":\"Photoshop\",\"userAns\":\"Acrobat\"},{\"databaseId\":\"77\",\"que_numb\":\"33\",\"correcAns\":\"wav\",\"userAns\":\"wav\"},{\"databaseId\":\"78\",\"que_numb\":\"34\",\"correcAns\":\"Raster\",\"userAns\":\"GIFs\"},{\"databaseId\":\"82\",\"que_numb\":\"35\",\"correcAns\":\"Thewebsiteissuitabletoaccessonalldevices\",\"userAns\":\"Thewebsiteisbuiltaroundthethemeofsocialresponsibility\"}]{\"databaseId\":\"5\",\"que_numb\":\"1\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"Anythingthatispersonal\"},{\"databaseId\":\"6\",\"que_numb\":\"2\",\"correcAns\":\"Thefontortheletteringinwhichthecompanynameiswritten\",\"userAns\":\"Alogbookthatcontainsallimportantcompanyinformation\"},{\"databaseId\":\"11\",\"que_numb\":\"3\",\"correcAns\":\"composition\",\"userAns\":\"contrast\"},{\"databaseId\":\"12\",\"que_numb\":\"4\",\"correcAns\":\"texture\",\"userAns\":\"balance\"},{\"databaseId\":\"13\",\"que_numb\":\"5\",\"correcAns\":\"heightwidthanddepth\",\"userAns\":\"heightanddepth\"},{\"databaseId\":\"15\",\"que_numb\":\"6\",\"correcAns\":\"solidityormass\",\"userAns\":\"solidityormass\"},{\"databaseId\":\"17\",\"que_numb\":\"7\",\"correcAns\":\"positivespace\",\"userAns\":\"form\"},{\"databaseId\":\"19\",\"que_numb\":\"8\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"Chromosteriopsis\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"45Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"ylength\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"67contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterk\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"purple\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"hue\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"contrast\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"monochromaticScheme\"},{\"databaseId\":\"43\",\"que_numb\":\"20\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"46\",\"que_numb\":\"21\",\"correcAns\":\"f18\",\"userAns\":\"f16\"},{\"databaseId\":\"47\",\"que_numb\":\"22\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Darks\"},{\"databaseId\":\"50\",\"que_numb\":\"24\",\"correcAns\":\"uniformlyincreasingordecreasingthespacebetweenalllettersinablockoftext\",\"userAns\":\"theprocessofselectingadocumentstypeface\"},{\"databaseId\":\"52\",\"que_numb\":\"25\",\"correcAns\":\"ArialisasansseriffontTimesNewRomanisaseriffont\",\"userAns\":\"Bothareseriffonts\"},{\"databaseId\":\"59\",\"que_numb\":\"26\",\"correcAns\":\"Atypeofalignment\",\"userAns\":\"appropriateuseoftype\"},{\"databaseId\":\"63\",\"que_numb\":\"27\",\"correcAns\":\"TypefaceevolvedfromGothicLettering\",\"userAns\":\"Lettersdesignedformagicalpurpose\"},{\"databaseId\":\"65\",\"que_numb\":\"28\",\"correcAns\":\"Lettersthoseareverticalwithoutslant\",\"userAns\":\"Noneoftheabove\"},{\"databaseId\":\"69\",\"que_numb\":\"29\",\"correcAns\":\"Thepartsofsomelowercaseletterswhichhangbelowxheight\",\"userAns\":\"Thelettersusedspeciallyforthefootnotesofatechnicalbook\"},{\"databaseId\":\"72\",\"que_numb\":\"30\",\"correcAns\":\"RGB\",\"userAns\":\"HSBC\"},{\"databaseId\":\"74\",\"que_numb\":\"31\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"72pointsperinch\"},{\"databaseId\":\"77\",\"que_numb\":\"32\",\"correcAns\":\"wav\",\"userAns\":\"bmp\"},{\"databaseId\":\"78\",\"que_numb\":\"33\",\"correcAns\":\"Raster\",\"userAns\":\"Gradients\"},{\"databaseId\":\"80\",\"que_numb\":\"34\",\"correcAns\":\"EnvironmentalAnalysis\",\"userAns\":\"EnvironmentalAnalysis\"},{\"databaseId\":\"84\",\"que_numb\":\"35\",\"correcAns\":\"Anavigationthatisstepbystepsuchasawizard\",\"userAns\":\"Wherethesequenceofthenavigationiswellorganised\"}]', 2, '2023-01-31 05:01:51'),
(14, 14, 'qz63de2d7a20dad', NULL, '{\"total_score\" : \"10\", \"mark\" : \"20\"}', NULL, '[{\"databaseId\":\"6\",\"que_numb\":\"1\",\"correcAns\":\"Thefontortheletteringinwhichthecompanynameiswritten\",\"userAns\":\"Letterheadthecompanyusesallthetime\"},{\"databaseId\":\"7\",\"que_numb\":\"2\",\"correcAns\":\"CropMarks\",\"userAns\":\"CropMarks\"},{\"databaseId\":\"9\",\"que_numb\":\"3\",\"correcAns\":\"pattern\",\"userAns\":\"variety\"},{\"databaseId\":\"10\",\"que_numb\":\"4\",\"correcAns\":\"content\",\"userAns\":\"layer\"},{\"databaseId\":\"11\",\"que_numb\":\"5\",\"correcAns\":\"composition\",\"userAns\":\"harmony\"},{\"databaseId\":\"16\",\"que_numb\":\"6\",\"correcAns\":\"alloftheabove\",\"userAns\":\"space\"},{\"databaseId\":\"19\",\"que_numb\":\"7\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"Chromosteriopsis\"},{\"databaseId\":\"20\",\"que_numb\":\"8\",\"correcAns\":\"PaperPrototype\",\"userAns\":\"RapidPrototype\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"55Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"xheight\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"56contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterf\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Tone\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"complexity\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"brightness\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"tone\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"dichromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"contact\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"44\",\"que_numb\":\"22\",\"correcAns\":\"ISO\",\"userAns\":\"ISO\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Midtones\"},{\"databaseId\":\"58\",\"que_numb\":\"24\",\"correcAns\":\"Point\",\"userAns\":\"Point\"},{\"databaseId\":\"60\",\"que_numb\":\"25\",\"correcAns\":\"Typeweight\",\"userAns\":\"Importanceoftypeinalayout\"},{\"databaseId\":\"62\",\"que_numb\":\"26\",\"correcAns\":\"Themeanheightoflowercaselettersexcludingascendersanddescenders\",\"userAns\":\"Themeanheightoflowercaselettersexcludingascendersanddescenders\"},{\"databaseId\":\"65\",\"que_numb\":\"27\",\"correcAns\":\"Lettersthoseareverticalwithoutslant\",\"userAns\":\"LetterswhichareusedforwritingstrictlybyRomans\"},{\"databaseId\":\"66\",\"que_numb\":\"28\",\"correcAns\":\"Largesizedinitialletter\",\"userAns\":\"Letterthatdropsfromitsbaseline\"},{\"databaseId\":\"67\",\"que_numb\":\"29\",\"correcAns\":\"ALargeTypefacedesignedforheadingsetc\",\"userAns\":\"ALargeTypefacedesignedforheadingsetc\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UnitedInterestUnitedExperienceDesign\"},{\"databaseId\":\"71\",\"que_numb\":\"31\",\"correcAns\":\"HyperTextMarkupLanguage\",\"userAns\":\"HeuristicTransferMarkedupLinguistics\"},{\"databaseId\":\"73\",\"que_numb\":\"32\",\"correcAns\":\"Illustrator\",\"userAns\":\"Photoshop\"},{\"databaseId\":\"75\",\"que_numb\":\"33\",\"correcAns\":\"gif\",\"userAns\":\"tiff\"},{\"databaseId\":\"83\",\"que_numb\":\"34\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"ConsortiumofSystemStructures\"},{\"databaseId\":\"84\",\"que_numb\":\"35\",\"correcAns\":\"Anavigationthatisstepbystepsuchasawizard\",\"userAns\":\"Wherethesequenceofthenavigationiswellorganised\"}]', 2, '2023-02-03 22:04:53'),
(15, 15, 'qz63de2d7a20dad', '{\"total_score\" : \"0\", \"mark\" : \"0\"}', NULL, '[{\"databaseId\":\"37\",\"que_numb\":\"1\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"letterforms\"},{\"databaseId\":\"41\",\"que_numb\":\"2\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"},{\"databaseId\":\"38\",\"que_numb\":\"3\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"},{\"databaseId\":\"39\",\"que_numb\":\"4\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Movablemachines\"},{\"databaseId\":\"1\",\"que_numb\":\"5\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"34\",\"que_numb\":\"6\",\"correcAns\":\"cubism\",\"userAns\":\"abstract\"},{\"databaseId\":\"35\",\"que_numb\":\"7\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Blocks\"},{\"databaseId\":\"40\",\"que_numb\":\"8\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingwhatthetextmightbeabout\"},{\"databaseId\":\"33\",\"que_numb\":\"9\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"36\",\"que_numb\":\"10\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"}]', NULL, 1, '2023-02-03 22:21:09'),
(16, 16, 'qz63de3744e8d9b', NULL, '{\"total_score\" : \"6\", \"mark\" : \"12\"}', NULL, '[{\"databaseId\":\"2\",\"que_numb\":\"1\",\"correcAns\":\"Anyofthese\",\"userAns\":\"Repeatacolorshapeortextureindifferentareasthroughout\"},{\"databaseId\":\"5\",\"que_numb\":\"2\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"TheStakeholderclient\"},{\"databaseId\":\"9\",\"que_numb\":\"3\",\"correcAns\":\"pattern\",\"userAns\":\"unity\"},{\"databaseId\":\"10\",\"que_numb\":\"4\",\"correcAns\":\"content\",\"userAns\":\"layout\"},{\"databaseId\":\"11\",\"que_numb\":\"5\",\"correcAns\":\"composition\",\"userAns\":\"unity\"},{\"databaseId\":\"16\",\"que_numb\":\"6\",\"correcAns\":\"alloftheabove\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"17\",\"que_numb\":\"7\",\"correcAns\":\"positivespace\",\"userAns\":\"value\"},{\"databaseId\":\"18\",\"que_numb\":\"8\",\"correcAns\":\"value\",\"userAns\":\"space\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"55Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"yheight\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterk\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"56contiguousnibwidths\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"hue\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"tint\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"monochromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"contact\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"45\",\"que_numb\":\"22\",\"correcAns\":\"1125\",\"userAns\":\"1111\"},{\"databaseId\":\"46\",\"que_numb\":\"23\",\"correcAns\":\"f18\",\"userAns\":\"f11\"},{\"databaseId\":\"50\",\"que_numb\":\"24\",\"correcAns\":\"uniformlyincreasingordecreasingthespacebetweenalllettersinablockoftext\",\"userAns\":\"theprocessofselectingadocumentstypeface\"},{\"databaseId\":\"54\",\"que_numb\":\"25\",\"correcAns\":\"leading\",\"userAns\":\"span\"},{\"databaseId\":\"55\",\"que_numb\":\"26\",\"correcAns\":\"Theroundinsidepartofletterslikebdoetc\",\"userAns\":\"TheinsideoftheletterG\"},{\"databaseId\":\"56\",\"que_numb\":\"27\",\"correcAns\":\"Normallythosetypefaceswhichslanttotheright\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"57\",\"que_numb\":\"28\",\"correcAns\":\"Thedesignofalettertypefacethatsuggestsitsappearance\",\"userAns\":\"Normallythosetypefaceswhicharenotfitforanyuse\"},{\"databaseId\":\"62\",\"que_numb\":\"29\",\"correcAns\":\"Themeanheightoflowercaselettersexcludingascendersanddescenders\",\"userAns\":\"Letterswhicharebiggerinsize\"},{\"databaseId\":\"72\",\"que_numb\":\"30\",\"correcAns\":\"RGB\",\"userAns\":\"RGB\"},{\"databaseId\":\"74\",\"que_numb\":\"31\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"72pointsperinch\"},{\"databaseId\":\"76\",\"que_numb\":\"32\",\"correcAns\":\"Photoshop\",\"userAns\":\"Dreamweaver\"},{\"databaseId\":\"77\",\"que_numb\":\"33\",\"correcAns\":\"wav\",\"userAns\":\"wav\"},{\"databaseId\":\"80\",\"que_numb\":\"34\",\"correcAns\":\"EnvironmentalAnalysis\",\"userAns\":\"BusinessAnalysis\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CodeofSecurityStandards\"}]', 2, '2023-02-03 22:46:38'),
(17, 17, 'qz63de3744e8d9b', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"39\",\"que_numb\":\"1\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"MovabletypePrintingPress\"},{\"databaseId\":\"36\",\"que_numb\":\"2\",\"correcAns\":\"humanism\",\"userAns\":\"groupism\"},{\"databaseId\":\"35\",\"que_numb\":\"3\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Blocks\"},{\"databaseId\":\"41\",\"que_numb\":\"4\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Alloftheabove\"},{\"databaseId\":\"34\",\"que_numb\":\"5\",\"correcAns\":\"cubism\",\"userAns\":\"abstract\"},{\"databaseId\":\"37\",\"que_numb\":\"6\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"Astylizedscript\"},{\"databaseId\":\"33\",\"que_numb\":\"7\",\"correcAns\":\"abstract\",\"userAns\":\"realism\"},{\"databaseId\":\"40\",\"que_numb\":\"8\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"wonderingasyouread\"},{\"databaseId\":\"1\",\"que_numb\":\"9\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"38\",\"que_numb\":\"10\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Noneofthese\"}]', NULL, 1, '2023-02-03 22:47:51'),
(18, 18, 'qz63de38e62bb87', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"40\",\"que_numb\":\"1\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"creatingmentalimagesinyourmind\"},{\"databaseId\":\"37\",\"que_numb\":\"2\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\"},{\"databaseId\":\"35\",\"que_numb\":\"3\",\"correcAns\":\"Imagesincisedinrock\",\"userAns\":\"Paintingsonrocks\"},{\"databaseId\":\"38\",\"que_numb\":\"4\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Petals\"},{\"databaseId\":\"1\",\"que_numb\":\"5\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"33\",\"que_numb\":\"6\",\"correcAns\":\"abstract\",\"userAns\":\"realism\"},{\"databaseId\":\"39\",\"que_numb\":\"7\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Movablemachines\"},{\"databaseId\":\"36\",\"que_numb\":\"8\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"34\",\"que_numb\":\"9\",\"correcAns\":\"cubism\",\"userAns\":\"cubism\"},{\"databaseId\":\"41\",\"que_numb\":\"10\",\"correcAns\":\"Alloftheabove\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"}]', NULL, 1, '2023-02-03 22:52:38'),
(19, 19, 'qz63de38e62bb87', NULL, '{\"total_score\" : \"3\", \"mark\" : \"6\"}', NULL, '[{\"databaseId\":\"2\",\"que_numb\":\"1\",\"correcAns\":\"Anyofthese\",\"userAns\":\"Repeatacolorshapeortextureindifferentareasthroughout\"},{\"databaseId\":\"3\",\"que_numb\":\"2\",\"correcAns\":\"Allofthese\",\"userAns\":\"Placement\"},{\"databaseId\":\"6\",\"que_numb\":\"3\",\"correcAns\":\"Thefontortheletteringinwhichthecompanynameiswritten\",\"userAns\":\"Alogbookthatcontainsallimportantcompanyinformation\"},{\"databaseId\":\"8\",\"que_numb\":\"4\",\"correcAns\":\"movementofaction\",\"userAns\":\"geometricdrawing\"},{\"databaseId\":\"14\",\"que_numb\":\"5\",\"correcAns\":\"size\",\"userAns\":\"volume\"},{\"databaseId\":\"16\",\"que_numb\":\"6\",\"correcAns\":\"alloftheabove\",\"userAns\":\"space\"},{\"databaseId\":\"18\",\"que_numb\":\"7\",\"correcAns\":\"value\",\"userAns\":\"intensity\"},{\"databaseId\":\"19\",\"que_numb\":\"8\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"RYBPrimaries\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"55Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"xlength\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"67contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterg\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"complexity\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"hue\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"tint\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"monolithicScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"background\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"rhythm\"},{\"databaseId\":\"46\",\"que_numb\":\"22\",\"correcAns\":\"f18\",\"userAns\":\"f11\"},{\"databaseId\":\"47\",\"que_numb\":\"23\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"52\",\"que_numb\":\"24\",\"correcAns\":\"ArialisasansseriffontTimesNewRomanisaseriffont\",\"userAns\":\"Bothareseriffonts\"},{\"databaseId\":\"56\",\"que_numb\":\"25\",\"correcAns\":\"Normallythosetypefaceswhichslanttotheright\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"64\",\"que_numb\":\"26\",\"correcAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\",\"userAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\"},{\"databaseId\":\"66\",\"que_numb\":\"27\",\"correcAns\":\"Largesizedinitialletter\",\"userAns\":\"Aletterthatisfromdifferentscript\"},{\"databaseId\":\"67\",\"que_numb\":\"28\",\"correcAns\":\"ALargeTypefacedesignedforheadingsetc\",\"userAns\":\"Typethatismeantforsignboardpainterstouse\"},{\"databaseId\":\"69\",\"que_numb\":\"29\",\"correcAns\":\"Thepartsofsomelowercaseletterswhichhangbelowxheight\",\"userAns\":\"Thelettersusedspeciallyforthefootnotesofatechnicalbook\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UserInboundUserExampleDesign\"},{\"databaseId\":\"71\",\"que_numb\":\"31\",\"correcAns\":\"HyperTextMarkupLanguage\",\"userAns\":\"HeuristicTransferMarkedupLinguistics\"},{\"databaseId\":\"74\",\"que_numb\":\"32\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"6pointsperinch\"},{\"databaseId\":\"78\",\"que_numb\":\"33\",\"correcAns\":\"Raster\",\"userAns\":\"Raster\"},{\"databaseId\":\"80\",\"que_numb\":\"34\",\"correcAns\":\"EnvironmentalAnalysis\",\"userAns\":\"BusinessAnalysis\"},{\"databaseId\":\"82\",\"que_numb\":\"35\",\"correcAns\":\"Thewebsiteissuitabletoaccessonalldevices\",\"userAns\":\"ThewebsitecansustainallDDOSattacksandstillworks\"}]', 2, '2023-02-03 22:53:50'),
(20, 20, 'qz63eb91fa0767b', '{\"total_score\" : \"1\", \"mark\" : \"2\"}', NULL, '[{\"databaseId\":\"1\",\"que_numb\":\"1\",\"correcAns\":\"Philosophy\",\"userAns\":\"Philosophy\"},{\"databaseId\":\"33\",\"que_numb\":\"2\",\"correcAns\":\"abstract\",\"userAns\":\"realism\"}]', NULL, 1, '2023-02-14 01:52:13'),
(21, 21, 'qz63f3a42b510c5', '{\"total_score\" : \"2\", \"mark\" : \"4\"}', NULL, '[{\"databaseId\":\"33\",\"que_numb\":\"1\",\"correcAns\":\"abstract\",\"userAns\":\"abstract\"},{\"databaseId\":\"1\",\"que_numb\":\"2\",\"correcAns\":\"Philosophy\",\"userAns\":\"Philosophy\"}]', NULL, 1, '2023-02-20 04:47:48'),
(22, 17, 'qz63de3744e8d9b', NULL, '{\"total_score\" : \"5\", \"mark\" : \"10\"}', NULL, '[[{\"databaseId\":\"2\",\"que_numb\":\"1\",\"correcAns\":\"Anyofthese\",\"userAns\":\"Repeatacolorshapeortextureindifferentareasthroughout\"},{\"databaseId\":\"5\",\"que_numb\":\"2\",\"correcAns\":\"Arepresentationofthetargetuser\",\"userAns\":\"TheStakeholderclient\"},{\"databaseId\":\"9\",\"que_numb\":\"3\",\"correcAns\":\"pattern\",\"userAns\":\"unity\"},{\"databaseId\":\"10\",\"que_numb\":\"4\",\"correcAns\":\"content\",\"userAns\":\"layout\"},{\"databaseId\":\"11\",\"que_numb\":\"5\",\"correcAns\":\"composition\",\"userAns\":\"unity\"},{\"databaseId\":\"16\",\"que_numb\":\"6\",\"correcAns\":\"alloftheabove\",\"userAns\":\"alloftheabove\"},{\"databaseId\":\"17\",\"que_numb\":\"7\",\"correcAns\":\"positivespace\",\"userAns\":\"value\"},{\"databaseId\":\"18\",\"que_numb\":\"8\",\"correcAns\":\"value\",\"userAns\":\"space\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"55Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xheight\",\"userAns\":\"yheight\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterk\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"orange\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"56contiguousnibwidths\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Black\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"hue\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"tint\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"monochromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"contact\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"45\",\"que_numb\":\"22\",\"correcAns\":\"1125\",\"userAns\":\"1111\"},{\"databaseId\":\"46\",\"que_numb\":\"23\",\"correcAns\":\"f18\",\"userAns\":\"f11\"},{\"databaseId\":\"50\",\"que_numb\":\"24\",\"correcAns\":\"uniformlyincreasingordecreasingthespacebetweenalllettersinablockoftext\",\"userAns\":\"theprocessofselectingadocumentstypeface\"},{\"databaseId\":\"54\",\"que_numb\":\"25\",\"correcAns\":\"leading\",\"userAns\":\"span\"},{\"databaseId\":\"55\",\"que_numb\":\"26\",\"correcAns\":\"Theroundinsidepartofletterslikebdoetc\",\"userAns\":\"TheinsideoftheletterG\"},{\"databaseId\":\"56\",\"que_numb\":\"27\",\"correcAns\":\"Normallythosetypefaceswhichslanttotheright\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"57\",\"que_numb\":\"28\",\"correcAns\":\"Thedesignofalettertypefacethatsuggestsitsappearance\",\"userAns\":\"Normallythosetypefaceswhicharenotfitforanyuse\"},{\"databaseId\":\"62\",\"que_numb\":\"29\",\"correcAns\":\"Themeanheightoflowercaselettersexcludingascendersanddescenders\",\"userAns\":\"Letterswhicharebiggerinsize\"},{\"databaseId\":\"72\",\"que_numb\":\"30\",\"correcAns\":\"RGB\",\"userAns\":\"RGB\"},{\"databaseId\":\"74\",\"que_numb\":\"31\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"72pointsperinch\"},{\"databaseId\":\"76\",\"que_numb\":\"32\",\"correcAns\":\"Photoshop\",\"userAns\":\"Dreamweaver\"},{\"databaseId\":\"77\",\"que_numb\":\"33\",\"correcAns\":\"wav\",\"userAns\":\"wav\"},{\"databaseId\":\"80\",\"que_numb\":\"34\",\"correcAns\":\"EnvironmentalAnalysis\",\"userAns\":\"BusinessAnalysis\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CodeofSecurityStandards\"}]{\"databaseId\":\"3\",\"que_numb\":\"1\",\"correcAns\":\"Allofthese\",\"userAns\":\"Allofthese\"},{\"databaseId\":\"8\",\"que_numb\":\"2\",\"correcAns\":\"movementofaction\",\"userAns\":\"geometricdrawing\"},{\"databaseId\":\"11\",\"que_numb\":\"3\",\"correcAns\":\"composition\",\"userAns\":\"harmony\"},{\"databaseId\":\"12\",\"que_numb\":\"4\",\"correcAns\":\"texture\",\"userAns\":\"harmony\"},{\"databaseId\":\"14\",\"que_numb\":\"5\",\"correcAns\":\"size\",\"userAns\":\"size\"},{\"databaseId\":\"18\",\"que_numb\":\"6\",\"correcAns\":\"value\",\"userAns\":\"intensity\"},{\"databaseId\":\"19\",\"que_numb\":\"7\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"RYBPrimaries\"},{\"databaseId\":\"20\",\"que_numb\":\"8\",\"correcAns\":\"PaperPrototype\",\"userAns\":\"UserAcceptanceTest\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"35Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xlength\",\"userAns\":\"xheight\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"67contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Lettery\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"Yellow\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Orange\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Fuzzy\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"contrastofcolors\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"brightness\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"saturation\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"dichromaticScheme\"},{\"databaseId\":\"43\",\"que_numb\":\"20\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"44\",\"que_numb\":\"21\",\"correcAns\":\"ISO\",\"userAns\":\"Perspective\"},{\"databaseId\":\"47\",\"que_numb\":\"22\",\"correcAns\":\"RuleofThirds\",\"userAns\":\"PatternsRepetition\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Midtones\"},{\"databaseId\":\"54\",\"que_numb\":\"24\",\"correcAns\":\"leading\",\"userAns\":\"kerning\"},{\"databaseId\":\"55\",\"que_numb\":\"25\",\"correcAns\":\"Theroundinsidepartofletterslikebdoetc\",\"userAns\":\"TheinsideoftheletterG\"},{\"databaseId\":\"60\",\"que_numb\":\"26\",\"correcAns\":\"Typeweight\",\"userAns\":\"Noneoftheabove\"},{\"databaseId\":\"61\",\"que_numb\":\"27\",\"correcAns\":\"Allthecapitallettersofafont\",\"userAns\":\"Letterswhicharebiggerinsize\"},{\"databaseId\":\"64\",\"que_numb\":\"28\",\"correcAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\",\"userAns\":\"Lettersdesignedforarchitecturalandengineeringpurpose\"},{\"databaseId\":\"66\",\"que_numb\":\"29\",\"correcAns\":\"Largesizedinitialletter\",\"userAns\":\"Largesizedinitialletter\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UserInterfaceUserExperienceDesign\"},{\"databaseId\":\"72\",\"que_numb\":\"31\",\"correcAns\":\"RGB\",\"userAns\":\"CMYK\"},{\"databaseId\":\"74\",\"que_numb\":\"32\",\"correcAns\":\"72pointsperinch\",\"userAns\":\"12pointsperinch\"},{\"databaseId\":\"70\",\"que_numb\":\"30\",\"correcAns\":\"UserInterfaceUserExperienceDesign\",\"userAns\":\"UserInterfaceUserExperienceDesign\"},{\"databaseId\":\"77\",\"que_numb\":\"33\",\"correcAns\":\"wav\",\"userAns\":\"tiff\"},{\"databaseId\":\"78\",\"que_numb\":\"34\",\"correcAns\":\"Raster\",\"userAns\":\"Raster\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CodeofSecurityStandards\"}]', 2, '2023-02-20 04:50:44');
INSERT INTO `userscore` (`id`, `user_id`, `uniq_id`, `round_1_mark`, `round_2_mark`, `json_round1`, `json_round2`, `quizz_stage`, `date`) VALUES
(23, 22, 'qz63f3af9c321c7', '{\"total_score\" : \"0\", \"mark\" : \"0\"}', NULL, '[{\"databaseId\":\"33\",\"que_numb\":\"1\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"1\",\"que_numb\":\"2\",\"correcAns\":\"Philosophy\",\"userAns\":\"Maths\"}]', NULL, 1, '2023-02-20 05:36:37'),
(24, 23, 'qz63f3af9c321c7', NULL, '{\"total_score\" : \"3\", \"mark\" : \"6\"}', NULL, '[{\"databaseId\":\"3\",\"que_numb\":\"1\",\"correcAns\":\"Allofthese\",\"userAns\":\"Allofthese\"},{\"databaseId\":\"4\",\"que_numb\":\"2\",\"correcAns\":\"Symbol\",\"userAns\":\"Muppet\"},{\"databaseId\":\"7\",\"que_numb\":\"3\",\"correcAns\":\"CropMarks\",\"userAns\":\"ColorBars\"},{\"databaseId\":\"8\",\"que_numb\":\"4\",\"correcAns\":\"movementofaction\",\"userAns\":\"geometricdrawing\"},{\"databaseId\":\"11\",\"que_numb\":\"5\",\"correcAns\":\"composition\",\"userAns\":\"unity\"},{\"databaseId\":\"12\",\"que_numb\":\"6\",\"correcAns\":\"texture\",\"userAns\":\"unity\"},{\"databaseId\":\"14\",\"que_numb\":\"7\",\"correcAns\":\"size\",\"userAns\":\"mass\"},{\"databaseId\":\"19\",\"que_numb\":\"8\",\"correcAns\":\"Chromosteriopsis\",\"userAns\":\"RYBPrimaries\"},{\"databaseId\":\"22\",\"que_numb\":\"9\",\"correcAns\":\"45Degrees\",\"userAns\":\"35Degrees\"},{\"databaseId\":\"23\",\"que_numb\":\"10\",\"correcAns\":\"xlength\",\"userAns\":\"yheight\"},{\"databaseId\":\"24\",\"que_numb\":\"11\",\"correcAns\":\"78contiguousnibwidths\",\"userAns\":\"67contiguousnibwidths\"},{\"databaseId\":\"25\",\"que_numb\":\"12\",\"correcAns\":\"Letterf\",\"userAns\":\"Letterg\"},{\"databaseId\":\"26\",\"que_numb\":\"13\",\"correcAns\":\"orange\",\"userAns\":\"purple\"},{\"databaseId\":\"27\",\"que_numb\":\"14\",\"correcAns\":\"Red\",\"userAns\":\"Red\"},{\"databaseId\":\"28\",\"que_numb\":\"15\",\"correcAns\":\"Shade\",\"userAns\":\"Tone\"},{\"databaseId\":\"29\",\"que_numb\":\"16\",\"correcAns\":\"pleasingarrangementsofcolor\",\"userAns\":\"noneoftheabove\"},{\"databaseId\":\"30\",\"que_numb\":\"17\",\"correcAns\":\"intensity\",\"userAns\":\"brightness\"},{\"databaseId\":\"31\",\"que_numb\":\"18\",\"correcAns\":\"tone\",\"userAns\":\"saturation\"},{\"databaseId\":\"32\",\"que_numb\":\"19\",\"correcAns\":\"monochromaticScheme\",\"userAns\":\"bichromaticScheme\"},{\"databaseId\":\"42\",\"que_numb\":\"20\",\"correcAns\":\"foreground\",\"userAns\":\"background\"},{\"databaseId\":\"43\",\"que_numb\":\"21\",\"correcAns\":\"balance\",\"userAns\":\"contrast\"},{\"databaseId\":\"46\",\"que_numb\":\"22\",\"correcAns\":\"f18\",\"userAns\":\"f16\"},{\"databaseId\":\"48\",\"que_numb\":\"23\",\"correcAns\":\"Highlights\",\"userAns\":\"Darks\"},{\"databaseId\":\"51\",\"que_numb\":\"24\",\"correcAns\":\"Adecorativestrokethatfinishesofftheendofalettersstem\",\"userAns\":\"Awritingbook\"},{\"databaseId\":\"53\",\"que_numb\":\"25\",\"correcAns\":\"Apex\",\"userAns\":\"Tail\"},{\"databaseId\":\"60\",\"que_numb\":\"26\",\"correcAns\":\"Typeweight\",\"userAns\":\"Noneoftheabove\"},{\"databaseId\":\"64\",\"que_numb\":\"27\",\"correcAns\":\"Linesoftypesetwithoutanyadditionalinterlinespacing\",\"userAns\":\"Lettersdesignedforarchitecturalandengineeringpurpose\"},{\"databaseId\":\"65\",\"que_numb\":\"28\",\"correcAns\":\"Lettersthoseareverticalwithoutslant\",\"userAns\":\"Noneoftheabove\"},{\"databaseId\":\"67\",\"que_numb\":\"29\",\"correcAns\":\"ALargeTypefacedesignedforheadingsetc\",\"userAns\":\"Typethatismeantfortheuseofexhibitionsonly\"},{\"databaseId\":\"71\",\"que_numb\":\"30\",\"correcAns\":\"HyperTextMarkupLanguage\",\"userAns\":\"HyperTextMarkupLanguage\"},{\"databaseId\":\"75\",\"que_numb\":\"31\",\"correcAns\":\"gif\",\"userAns\":\"psd\"},{\"databaseId\":\"76\",\"que_numb\":\"32\",\"correcAns\":\"Photoshop\",\"userAns\":\"Acrobat\"},{\"databaseId\":\"81\",\"que_numb\":\"33\",\"correcAns\":\"Thehierarchyofinformationwithinawebsiteoranapp\",\"userAns\":\"Thehierarchyofofficialsresponsibletoprovideinformation\"},{\"databaseId\":\"82\",\"que_numb\":\"34\",\"correcAns\":\"Thewebsiteissuitabletoaccessonalldevices\",\"userAns\":\"ThewebsitecansustainallDDOSattacksandstillworks\"},{\"databaseId\":\"83\",\"que_numb\":\"35\",\"correcAns\":\"CascadingStyleSheets\",\"userAns\":\"CodeofSecurityStandards\"}]', 2, '2023-02-20 05:38:47'),
(25, 24, 'qz640ef1e76f0c8', '{\"total_score\" : \"0\", \"mark\" : \"0\"}', NULL, '[{\"databaseId\":\"33\",\"que_numb\":\"1\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"1\",\"que_numb\":\"2\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"}]', NULL, 1, '2023-03-12 21:50:41'),
(26, 25, 'qz64231e019db6b', '{\"total_score\" : \"1\", \"mark\" : \"2\"}', NULL, '[{\"databaseId\":\"33\",\"que_numb\":\"1\",\"correcAns\":\"abstract\",\"userAns\":\"abstract\"},{\"databaseId\":\"1\",\"que_numb\":\"2\",\"correcAns\":\"Philosophy\",\"userAns\":\"alloftheabove\"}]', NULL, 1, '2023-03-28 05:04:38'),
(27, 26, 'qz642376398cc65', NULL, NULL, NULL, NULL, -2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `assign_course`
--
ALTER TABLE `assign_course`
  ADD PRIMARY KEY (`caid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`qt_id`);

--
-- Indexes for table `quizz_data`
--
ALTER TABLE `quizz_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizz_data_test`
--
ALTER TABLE `quizz_data_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `run_this`
--
ALTER TABLE `run_this`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_marks`
--
ALTER TABLE `student_marks`
  ADD PRIMARY KEY (`markid`);

--
-- Indexes for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD PRIMARY KEY (`accnt_Id`),
  ADD KEY `user_Id` (`user_Id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblpost`
--
ALTER TABLE `tblpost`
  ADD PRIMARY KEY (`post_Id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_Id` (`user_Id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_Id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `userscore`
--
ALTER TABLE `userscore`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `assign_course`
--
ALTER TABLE `assign_course`
  MODIFY `caid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `question_type`
--
ALTER TABLE `question_type`
  MODIFY `qt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quizz_data`
--
ALTER TABLE `quizz_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `quizz_data_test`
--
ALTER TABLE `quizz_data_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `run_this`
--
ALTER TABLE `run_this`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_marks`
--
ALTER TABLE `student_marks`
  MODIFY `markid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accnt_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpost`
--
ALTER TABLE `tblpost`
  MODIFY `post_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `userscore`
--
ALTER TABLE `userscore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblpost`
--
ALTER TABLE `tblpost`
  ADD CONSTRAINT `tblpost_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `question_type` (`qt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
