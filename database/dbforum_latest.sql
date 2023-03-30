-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2022 at 09:27 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `qt_id` int(12) NOT NULL,
  `que_typ_name` varchar(20) DEFAULT NULL COMMENT 'Category of question'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`qt_id`, `que_typ_name`) VALUES
(1, 'Aesthetic'),
(2, 'art'),
(3, 'calligraphy'),
(4, 'color'),
(5, 'history'),
(6, 'meta'),
(7, 'photography'),
(8, 'SA'),
(9, 'typo'),
(10, 'web');

-- --------------------------------------------------------

--
-- Table structure for table `quizz_data`
--

CREATE TABLE `quizz_data` (
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

--
-- Dumping data for table `quizz_data`
--

INSERT INTO `quizz_data` (`id`, `qt_id`, `question_type`, `question`, `explaination`, `choice1`, `choice2`, `choice3`, `choice4`, `answer`) VALUES
(1, 1, 'Aesthetic', 'Aesthetic\' term was first used in the branch of', 'The first use of the term aesthetics in something like its modern sense is commonly attributed to Alexander Baumgarten in 1735 familiar sense as a distinct branch of philosophy.', 'Philosophy ', 'Science', 'Maths', 'all of the above', 4),
(2, 2, 'art', 'What is the right solution to create unity', '', 'Line up photographs and text with the same grid lines.', 'Repeat a color, shape, or texture in different areas throughout.', 'Use the same color palette throughout.', '*Any of these', 4),
(3, 2, 'art', 'Out of the following, which establishes typographic hierarchy?', '', 'Weight', 'Contrast', 'Placement', 'All of these', 4),
(4, 2, 'art', 'In Corporate Identity a Sign that represents the qualities, or the philosophy of a company is called?', 'In a logo unit, a symbol is the visual device that represents the philosophy or the qualities of a company.', '*Symbol', 'Logotype', 'Mascot', 'Muppet', 1),
(5, 2, 'art', 'In UX What is a Persona', 'A Persona is created that represents a user group which is a collection of characteristics that helps the designer empathise with those users.', 'An important personality', 'Anything that is personal', 'The Stakeholder (client)', '*A representation of the target user.', 4),
(6, 2, 'art', 'In Corporate Identity What is a Letter Mark or a Logotype', 'The font or the lettering in which the company name is written', '*The font or the lettering in which the company name is written', 'Letterhead the company uses all the time', 'A stamp that is used for official purpose', 'A logbook that contains all important company information', 1),
(7, 2, 'art', 'What does the printer use to know where to trim the paper after printing?', 'Crop Marks. Crop marks, also known as trim marks, are lines printed in the corners of your publication\'s sheet or sheets of paper to show the printer where to trim the paper. ', 'Registration Marks', '*Crop Marks', 'Color Bars', 'A Ruler', 2),
(8, 2, 'art', 'Gesture Drawing is?', 'Movement of action Gesture drawing is a method of capturing figures in exaggerated poses', '*movement of action', 'landscapes', 'geometric drawing', 'none of the above', 2),
(9, 2, 'art', 'Forms repeated in a design is called', 'Patterns are simply a repetition of more than one design element working in concert with each other.', 'illustration', '*pattern', 'variety', 'unity', 3),
(10, 2, 'art', '????.is a Text matter for a design.', 'written matter is known as content', '*content', 'panel', 'layer', 'layout', 2),
(11, 2, 'art', 'The arrangement of the visual elements is called as?', 'Composition is the way in which different elements of an artwork are combined or arranged.', '*composition', 'unity', 'harmony', 'contrast', 1),
(12, 2, 'art', 'Surface Quality of a design is????.', 'texture. In the visual arts, texture is the perceived surface quality of a work of art.', 'harmony', '*texture', 'balance', 'unity', 2),
(13, 2, 'art', 'Three-dimensional means????..', ' height, width, and depth.', '*height, width, and depth.', 'height, and width', 'height, and depth', 'none of the above', 2),
(14, 2, 'art', 'The extent of a shape is called????..', 'Size', '*size', 'depth', 'volume', 'mass', 2),
(15, 2, 'art', 'What is Volume in a design?', 'solidity or mass', 'the extent of a shape', 'the specific spatial character', '*solidity or mass', 'extension in any direction', 3),
(16, 2, 'art', 'Which among the following is a design element?', 'all of the above', 'value', 'colour', 'space', '*all of the above', 4),
(17, 2, 'art', '. ???. refers to the space of a shape representing the subject matter.', 'positive space', '*positive space', 'negative space', 'form', 'value', 1),
(18, 2, 'art', 'An element of art that refers to the lightness or darkness of a color is a ???..', 'Value', '*value', 'form', 'space', 'intensity', 1),
(19, 2, 'art', 'What is the visual illusion called where an impression of depth is created by using two dimensional colour images (usually blue and red)?', 'Visual perception is a constant factor that affects usability and design. Therefore, it is a good idea for the UX designer to be familiar with the limitations of the visual perception system.', 'Tessellation', 'RYB Primaries', '*Chromosteriopsis', 'Hyperchomatoscopy', 3),
(20, 2, 'art', 'What are the sequential rough sketches of screens, that give an idea of how the app is going to work, called?', 'Paper prototype is a low fidelity prototype (also referred to as wireframes) that is a series of screen drawings that provide the user with an idea of how the app is going to function. Paper prototypes are used to test app concepts as well as interaction ', 'Working Prototype', 'Rapid Prototype', '*Paper Prototype', 'User Acceptance Test', 3),
(21, 2, 'art', 'What is Fine Art?', 'Fine Art, as opposed to Applied Art, is an end in itself. The objective of Fine Art is creation of beauty, not creating artefacts merely to support external activities such as marketing communication.', 'Application of Artistic Fineness', 'Art that is better than Applied Art in its worth.', '*Art that is focused solely on imaginative, artistic or intellectual content.', 'Fine tuned art that is appreciated for its investment value.', 3),
(22, 3, 'calligraphy', 'In which angle is the broad edged pen supposed to be placed for writing the Chancery Hand Calligraphy?', 'In cursive chancery hand the pen was held slanted at a 45? angle for speed, but it could also produce beautiful calligraphic writing. Eventually it became a practice to hold the pen 45? angle as it also gave a perfect thick and thin contrast making the le', '25 Degrees', '35 Degrees', '*45 Degrees', '55 Degrees', 3),
(23, 3, 'calligraphy', 'In small letters, what is the central body part of the letters called as?', 'X-height refers to the height of the lowercase letters in a line of text. For Eg: The height of letters a,e,o,v,s,r, etc.', '*x length', 'x height', 'y length', 'y height', 1),
(24, 3, 'calligraphy', 'For Capital letters, how many contiguous nib widths are ideally required to draw the guidelines?', 'The Capital Letters are 2/3 nib width longer than the x height. The height of Capital Letters is lower than the ascender.  ', '*7-8 contiguous nib widths', '6-7 contiguous nib widths', '9-10 contiguous nib widths', '5-6 contiguous nib widths', 1),
(25, 3, 'calligraphy', 'Which letter travels through all the guidelines, x-height, ascenders and descenders?', 'The letter f is one of the toughest letter to draw as it is the most elongated letterform travelling through all the guidelines.', 'Letter y', '*Letter f', 'Letter g', 'Letter k', 2),
(26, 4, 'color', 'In the traditional RYB color model, which color is complimentary to blue?', 'Complementary colors are the opposite hues on the color wheel. Complementary colors may also be called \"opposite colors\".', 'Yellow', 'green', '*orange', 'purple', 3),
(27, 4, 'color', 'Which color best reflects these descriptions? Warmth, love, anger, danger, boldness, excitement, speed, strength, energy, determination, desire, passion, and courage', 'Colors in the red area of the color spectrum are known as warm colors and depith all mentioned emotions', 'Orange', 'Purple', 'Black', '*Red', 4),
(28, 4, 'color', 'If black is added to a pure color, the graphic design term for the result is:', 'Shade. In color theory, a tint is a mixture of a color with white, which increases lightness, while a shade is a mixture with black, which increases darkness.', 'Night Color', 'Tone', '*Shade', 'Fuzzy', 3),
(29, 4, 'color', 'Color harmony means???', 'pleasing arrangements of color In color theory, color harmony refers to the property that certain aesthetically pleasing color combinations have.', '*pleasing arrangements of color', 'contrast of colors', 'complexity', 'none of the above', 1),
(30, 4, 'color', 'The saturation or strength of a color is????.', 'intensity', '*intensity', 'depth', 'brightness', 'hue', 1),
(31, 4, 'color', 'The character of a color or value of a surface is known as????..', 'tone', 'saturation', '*tone', 'tint', 'contrast', 2),
(32, 4, 'color', '. ???????colors are tints and shades of one color.', 'monochromatic colors', 'bichromatic colours', 'dichromatic colours', 'monolithic colours', '*monochromatic colors', 4),
(33, 5, 'history', 'Non realistic art is known as????..', 'abstract', 'surrealism', '*abstract', 'cubism', 'realism', 2),
(34, 5, 'history', '???..style is the artist uses geometric shapes to show what he is trying to paint.', 'realism', 'pop art', 'impressionism', 'abstract', '*realism', 4),
(35, 5, 'history', 'Petroglyphs are ', 'Images incised in rock', '*Images incised in rock', 'Paintings on rocks', 'Blocks', 'Carvings in Temples', 0),
(36, 5, 'history', 'The great intellectual movement of Renaissance Italy was ', 'humanism', 'cubism', 'groupism', 'fascism', '*humanism', 4),
(37, 5, 'history', 'A scriptorium is ??.', 'a room devoted to the hand-lettered copying of manuscripts', 'letter forms', '*a room devoted to the hand-lettered copying of manuscripts', 'the artist who scripted the books', 'A stylized script', 2),
(38, 5, 'history', 'The word paper comes from', 'The word \"paper\" comes from papyrus, which is \"the paper plant, or paper made from it.\"', '*the ancient Egyptian writing material called papyrus', 'Pepper', 'Petals', 'None of these', 1),
(39, 5, 'history', 'What did Johann Gutenberg invent?', 'Movable type printing Press thus known as the father of printing press', 'Telescope', '*Movable type Printing Press', 'Movable machines', 'Beats', 2),
(40, 6, 'meta', 'What is metacognition?', 'thinking about your thinking', 'creating mental images in your mind', '*thinking about your thinking', 'wondering as you read', 'thinking what the text might be about', 2),
(41, 6, 'meta', 'Self-awareness as a leaner?', 'All of the above', 'Understands strengths and weakness ', 'Identifies one?s emotions, and how they affect others', 'Understands the relationship between one?s emotions, thoughts, values, and behaviors', '*All of the above', 3),
(42, 7, 'photography', 'Nearer view of an Image is called as?', 'foreground. The area of the picture space nearest to the viewer, immediately behind the picture plane, is known as the foreground.', '*foreground', 'background', 'contact', 'depth of field', 0),
(43, 7, 'photography', 'The equilibrium of elements is called?????.', 'Balance ', 'background', '*balance', 'rhythm', 'contrast', 1),
(44, 7, 'photography', 'Which of the following is a component of Exposure Triangle?', 'Exposure Triangle consists of 3 major components that adjust how a camera capture light and in order to maintain the right exposure range ISO is one of the components along with Shutter Speed & Aperture. One can access the use of Exposure Triangle only if', 'Perspective', '*ISO', 'Focusing', 'Color', 2),
(45, 7, 'photography', 'In bright sunlight what Shutter Speed would you use to control exposure?', 'Faster Shutter speed helps to maintain the exposure range under bright sunlight where one needs to control the existing light to receive right range of brightness and details. ', '*1/125', '1/225', '1/325', '1/111', 1),
(46, 7, 'photography', ' Which of the following Aperture value reflects Shallow depth of field?', 'The wide-open Aperture is responsible to provide shallow depth of field in a photograph that is f/2.8 or below. ', '*f/1.8', 'f/6.3', 'f/11', 'f/16', 1),
(47, 7, 'photography', 'Which of the following Composition Rule do not allow to center compose a subject? ', 'The idea is that an off-centre composition is more pleasing to the eye and looks more natural than one where the subject is placed right in the middle of the frame. Rule of Thirds is considered as golden ratio where one must place the subject within any o', ' Leading Lines', 'Patterns & Repetition', '*Rule of Thirds', 'None of these', 3),
(48, 7, 'photography', 'In order to maintain details in an image what is more important to protect / control in Exposure?', 'In photography, by keeping your subjects in the highlights and then exposing your shot for the highlights, you can draw the viewers\' attention immediately to the main subject and use the underexposed area as a frame or a negative space to draw viewers to ', '* Highlights', ' Midtones', ' Darks', 'all of the above', 1),
(49, 8, 'SA', 'This is the sample question.', 'This is the sample explanation.', 'This is the first choice.', 'This is the second choice.', '*This is the third (and correct) choice.', '', 3),
(50, 9, 'typo', 'In typography, tracking is...', 'In typography, letter spacing, character spacing or tracking is?an optically consistent adjustment to the space between letters to change the visual density of a line or block of text.', '*uniformly increasing or decreasing the space between all letters in a block of text', 'the distance between the baselines of successive lines of type', 'uniformly adjusting the height of all characters', 'the process of selecting a document\'s typeface', 1),
(51, 9, 'typo', 'In typography what does a serif mean?', 'A decorative stroke that finishes off the end of a letters stem', '*A decorative stroke that finishes off the end of a letters stem', 'A writing book', 'A cut nib pen', 'A layout style', 1),
(52, 9, 'typo', 'Which of the following describes the Arial and Times New Roman fonts?  ', 'Arial is a sans serif font, Times New Roman is a serif font', '*Arial is a sans serif font, Times New Roman is a serif font', 'Arial is a serif font, Times New Roman is a sans serif font', 'Both are serif fonts', 'Both are sans serif fonts', 1),
(53, 9, 'typo', 'The top point of a capital A is called:', 'Apex', 'Arm', '*Apex', 'Bowl', 'Tail', 2),
(54, 9, 'typo', 'What is the space between two baselines called?', 'leading', 'tracking', 'kerning', 'span', '*leading', 4),
(55, 9, 'typo', 'According to typography guidelines what is a bowl?', 'The round, inside part of letters like b, d, o, etc.', 'The inside of the letter C.', '*The round, inside part of letters like b, d, o, etc.', 'None of these ', 'The inside of the letter G.', 2),
(56, 9, 'typo', 'What does ?Italic? stand for in Typography?', 'Normally, those typefaces which slant to the right', 'Normally, those typefaces which have been designed to be used in Italy', '*Normally, those typefaces which slant to the right', 'Normally, those typefaces which are designed by Italian Typographers ', 'None of these.', 2),
(57, 9, 'typo', 'What are Expanded, Condensed and Normal in Typography?', 'The design of a letter - typeface that suggests its appearance.', '*The design of a letter - typeface that suggests its appearance.', 'That indicates the space available to adjust the text.', ' Normally, those typefaces which are not fit for any use.', 'The typefaces which to be used as the meaning of the text matter suggests.', 2),
(58, 9, 'typo', 'What is unit that is used to measure a font?', 'Point', 'Inch', 'Centimeter', '*Point', 'Millimeter', 3),
(59, 9, 'typo', 'In typography, Justify means?', 'A type of alignment', '*A type of alignment', 'explanation in an argument', 'balance of text and image', 'appropriate use of type', 1),
(60, 9, 'typo', 'In typography, Light, Normal, Bold suggest?', 'Type weight', 'Colour of selected type', '*Type weight', 'Importance of type in a layout', 'None of the above', 2),
(61, 9, 'typo', 'In a font, what is the meaning of Upper Case?', 'All the capital letters of a font', 'Letters placed above the line', 'Text that appears on the top', '*All the capital letters of a font', 'Letters which are bigger in size.', 3),
(62, 9, 'typo', 'What do you understand by the term x-height?', 'The mean height of lower-case letters, excluding ascenders and descenders.', 'Letters placed above the line', 'Text that appears on the top', '*The mean height of lower-case letters, excluding ascenders and descenders.', 'Letters which are bigger in size.', 3),
(63, 9, 'typo', 'In typography, the term ?black letters? refers to?', 'Typeface evolved from the broad-nib pen style of Gothic Lettering, also known as Old English. ', 'Letters those are coloured in black', '*Typeface evolved from Gothic Lettering', 'Letters designed for magical purpose', 'None of the above', 2),
(64, 9, 'typo', 'What is meaning of ?set solid??', ' Lines of type set without any additional interline spacing', 'Letters those are painted in the darkest shades', 'Typeface that appears solid as a rock', ' Letters designed for architectural and engineering purpose', ' Lines of type set without any additional interline spacing', 4),
(65, 9, 'typo', 'What kind of fonts are referred as ?Roman??', 'Letters those are vertical ? without slant', '*Letters those are vertical ? without slant', 'Letters invented in Rome', 'Letters which are used for writing strictly by Romans', 'None of the above', 1),
(66, 9, 'typo', 'Drop cap/letter is that?', 'Large-sized initial letter, normally a cap that is used at the beginning of the text of a chapter. ', 'A missing letter from a word. ', '*Large-sized initial letter.', 'Letter that drops from its base-line.', 'A letter that is from different script.', 2),
(67, 9, 'typo', 'What is a Display Type?  ', 'A display typeface is a typeface that is intended for use at large sizes for headings, rather than for extended passages of body text. ', 'A type that can be displayed anywhere. ', 'Type that is meant for the use of exhibitions only.', '*A Large Typeface designed for headings etc.', 'Type that is meant for sign-board painters, to use.', 3),
(68, 9, 'typo', 'What is an ascender?  ', 'The parts of some lower-case letters such as b, d, h, which rise above the x-height or mean-line. ', 'Letters which are to be read while ascending a staircase', '*The parts of some lower-case letters which rise above x-height.', 'The letters arranged in an ascending order.', 'The letters appear in the heading or title of the book.', 2),
(69, 9, 'typo', 'What is a descender?  ', 'The parts of some lower-case letters such as p, q, y, which hangs below the x-height or mean-line. ', ' Letters which appear below the eye level. ', 'The letters arranged in a descending order.', 'The letters used specially for the footnotes of a technical book.', '*The parts of some lower-case letters which hang below x-height.', 4),
(70, 10, 'web', 'What does UI/UX design stand for?', 'User Interface/User Experience Design', 'User Interest/User Experience Design', '*User Interface/User Experience Design', 'United Interest/United Experience Design', 'User Inbound/User Example Design', 2),
(71, 10, 'web', 'In Web what does HTML stand for?', 'Hyper Text Markup Language', 'Hot Tools Machine Language', 'Hyper Transfer Machine Language', '*Hyper Text Markup Language', 'Heuristic Transfer Marked-up Linguistics', 3),
(72, 10, 'web', 'While designing for Mobile Interfaces which Colours are considered Primary?', 'For any digital display, the light colours ? Red, Green, Blue are considered Primary Colours.', 'CMYK', 'RYB', 'HSBC', '*RGB', 4),
(73, 10, 'web', 'What program is used to make vector images?', ' Any art made with vector illustration software like Adobe Illustrator is considered vector art.', 'Photoshop', 'After Effects', 'Dreamweaver', '*Illustrator', 4),
(74, 10, 'web', 'What resolution is best suited for the web?', '72 points per inch. The standard resolution for web images is 72 PPI (often called ?screen resolution?)', '300 points per inch', '12 points per inch.', '6 points per inch.', '*72 points per inch', 4),
(75, 10, 'web', 'Which image file format most commonly supports animation??', 'GIF, in full graphics interchange format, digital file format devised  by the Internet service provider CompuServe as a means of reducing the size of images and short animations.', '.jpg', '.tiff', '.psd', '*.gif', 4),
(76, 10, 'web', 'Which of the following is considered the industry standard for photo manipulation in graphic design?', 'Photoshop. Photoshop is the standard software used to edit and compose raster images/photos in multiple layers and several color models including RGB, CMYK,  spot color, and duotone.', 'GIMP', '*Photoshop', 'Acrobat', 'Dreamweaver', 2),
(77, 10, 'web', 'Which one of the following is not related to image format?', ' WAV is an audio file that is associated with Microsoft Windows. Rest formats are for images.', 'jpeg', 'tiff', '*wav', 'bmp', 3),
(78, 10, 'web', 'There are two types of graphics generated with the help of computers. One of them is Vectors. Which is the other one?', 'Rasters are the graphics that are made up of pixels (resulting out of parallel scanning lines on screen. Upon scaling, the number of pixels change and the values of the pixels are re-interpreted, therefore the sharpness and overall images quality may chan', 'Freighters', 'Gradients', '*Raster', 'GIFs', 3),
(79, 10, 'web', 'What is Affordance (in UX Design)?', 'The design of the button should inform the user that they have to press it. The design of a slider should make it easy for the user to understand that it needs to be moved. Such design quality is called ?affordance cue?. In real life, a door handle should', 'Users? ability to afford a device', 'Expense that the marketer incurs to get users', '*the quality of an interaction element such as a button that tells the users how to use it.', 'Based on the price of the device and relative price of the app subscription that makes the app viable for users.', 3),
(80, 10, 'web', 'What is the third area of discovery apart from User Analysis and Task Analysis, that the UX Designer is supposed to undertake before beginning the design process?', 'Before starting the design process, the UX Designer is supposed to undertake User analysis that will clarify who the intended users of the system are, Task Analysis will clarify what tasks are the user likely to perform with the system, and Environment An', 'Conceptual Analysis', '*Environmental Analysis', 'Business Analysis', 'Cost Analysis', 2),
(81, 10, 'web', 'What is Information Architecture?', 'Information Architecture is essential to the logical organization of any online information system. Be it an online encyclopedia such as Wikipedia or a travel booking app, if organized by keeping the users? information needs in mind, becomes easy for thos', '*The hierarchy of information within a website or an app', 'A building where you get all required information', 'Informative Architecture', 'The hierarchy of officials responsible to provide information.', 1),
(82, 10, 'web', 'You call a website ?responsive? when?', 'Information Architecture is essential to the logical organization of any online information system. Be it an online encyclopedia such as Wikipedia or a travel booking app, if organized by keeping the users? information needs in mind, becomes easy for thos', 'The website opens in a browser without an issue.', 'The website is built around the theme of social responsibility.', '*The website is suitable to access on all devices', 'The website can sustain all DDOS attacks and still works.', 3),
(83, 10, 'web', 'In web design, what does CSS stand for', 'Cascading Style Sheets (CSS) is a stylesheet language used to describes how HTML elements should be rendered on screen. Web pages are designed using CSS that decides the presentation and styling.', '*Cascading Style Sheets', 'Colour Standards & Systems.', 'Consortium of System Structures.', 'Code of Security Standards.', 1),
(84, 10, 'web', 'What is Sequential Navigation?', 'Sequential Navigation is what users use in a variety of websites such as booking a plane ticket or a movie ticket. It is an organization of web pages that are linked in a sequential manner. Wizards, such as the one used when setting up your wi-fi router o', '*A navigation that is step by step, such as a wizard', 'The order in which people are supposed to enter a website.', 'Where the sequence of the navigation is well organised', 'A navigation system that undergoes many changes.', 1);

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
(1, 'mamta', '565fdb43462efef831c018f2e91cecbb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(11) NOT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `uname`, `pwd`) VALUES
(1, 'admin', 'admin'),
(2, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomment`
--

CREATE TABLE `tblcomment` (
  `comment_Id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `post_Id` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `user_Id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcomment`
--

INSERT INTO `tblcomment` (`comment_Id`, `comment`, `post_Id`, `datetime`, `user_Id`) VALUES
(4, 'my', 11, '2015-03-24 02:52:00', 13),
(5, 'mar', 11, '2015-03-24 02:52:27', 14),
(6, 'tesy', 11, '2022-05-08 07:43:15', 15),
(7, 'sadsad', 11, '2022-05-08 07:43:31', 15);

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

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_Id`, `fname`, `lname`, `gender`) VALUES
(1, 'mamta', 'malvi', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `userscore`
--

CREATE TABLE `userscore` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `round_1_mark` varchar(50) NOT NULL,
  `round_2_mark` varchar(50) NOT NULL,
  `json_round1` text NOT NULL,
  `json_round2` text NOT NULL,
  `quizz_stage` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userscore`
--

INSERT INTO `userscore` (`id`, `user_id`, `round_1_mark`, `round_2_mark`, `json_round1`, `json_round2`, `quizz_stage`) VALUES
(1, 1, '{\"total_score\" : \"2\", \"mark\" : \"4\"}', '', '[{\"databaseId\":\"1\",\"que_numb\":\"1\",\"correcAns\":\"alloftheabove\",\"userAns\":\"Science\"},{\"databaseId\":\"33\",\"que_numb\":\"2\",\"correcAns\":\"abstract\",\"userAns\":\"cubism\"},{\"databaseId\":\"34\",\"que_numb\":\"3\",\"correcAns\":\"realism\",\"userAns\":\"impressionism\"},{\"databaseId\":\"35\",\"que_numb\":\"4\",\"correcAns\":\"realism\",\"userAns\":\"Blocks\"},{\"databaseId\":\"36\",\"que_numb\":\"5\",\"correcAns\":\"humanism\",\"userAns\":\"fascism\"},{\"databaseId\":\"37\",\"que_numb\":\"6\",\"correcAns\":\"aroomdevotedtothehandletteredcopyingofmanuscripts\",\"userAns\":\"theartistwhoscriptedthebooks\"},{\"databaseId\":\"38\",\"que_numb\":\"7\",\"correcAns\":\"theancientEgyptianwritingmaterialcalledpapyrus\",\"userAns\":\"Noneofthese\"},{\"databaseId\":\"39\",\"que_numb\":\"8\",\"correcAns\":\"MovabletypePrintingPress\",\"userAns\":\"Movablemachines\"},{\"databaseId\":\"40\",\"que_numb\":\"9\",\"correcAns\":\"thinkingaboutyourthinking\",\"userAns\":\"thinkingaboutyourthinking\"},{\"databaseId\":\"41\",\"que_numb\":\"10\",\"correcAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\",\"userAns\":\"Understandstherelationshipbetweenonesemotionsthoughtsvaluesandbehaviors\"}]', '', 1),
(2, 1, '', '', '', '', -2);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `run_this`
--
ALTER TABLE `run_this`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tblcomment`
--
ALTER TABLE `tblcomment`
  ADD PRIMARY KEY (`comment_Id`),
  ADD KEY `user_Id` (`user_Id`),
  ADD KEY `post_Id` (`post_Id`),
  ADD KEY `user_Id_2` (`user_Id`);

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
-- Indexes for table `userscore`
--
ALTER TABLE `userscore`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question_type`
--
ALTER TABLE `question_type`
  MODIFY `qt_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quizz_data`
--
ALTER TABLE `quizz_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `run_this`
--
ALTER TABLE `run_this`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblaccount`
--
ALTER TABLE `tblaccount`
  MODIFY `accnt_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcomment`
--
ALTER TABLE `tblcomment`
  MODIFY `comment_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpost`
--
ALTER TABLE `tblpost`
  MODIFY `post_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userscore`
--
ALTER TABLE `userscore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblaccount`
--
ALTER TABLE `tblaccount`
  ADD CONSTRAINT `tblaccount_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `tbluser` (`user_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblcomment`
--
ALTER TABLE `tblcomment`
  ADD CONSTRAINT `tblcomment_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `tbluser` (`user_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcomment_ibfk_2` FOREIGN KEY (`post_Id`) REFERENCES `tblpost` (`post_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblpost`
--
ALTER TABLE `tblpost`
  ADD CONSTRAINT `tblpost_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `question_type` (`qt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
