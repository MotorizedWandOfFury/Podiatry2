

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (

  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medicalrecordnumber` int(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `doctor` int(11) NOT NULL,  
  `role` int(11) NOT NULL,
  `dob` int(10) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(59) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  

  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sex` (`sex`),
  KEY `doctor` (`doctor`),
  KEY `role` (`role`)

);



DROP TABLE IF EXISTS `physicians`;
 CREATE TABLE IF NOT EXISTS `physicians` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `username` varchar(20) NOT NULL,
   `firstname` varchar(20) NOT NULL,
   `lastname` varchar(20) NOT NULL,
   `password` varchar(40) NOT NULL,
   `role` int(11) NOT NULL,
   `dob` int(10) DEFAULT NULL,
   `sex` int(11) NOT NULL,
   `experience` varchar(80) DEFAULT NULL,
   `phone` varchar(12) DEFAULT NULL,
   `email` varchar(59) DEFAULT NULL,
   `street` varchar(50) DEFAULT NULL,
   `city` varchar(50) DEFAULT NULL,
   `age` int(11) DEFAULT NULL,
   `state` varchar(50) DEFAULT NULL,
   `zip` int(11) DEFAULT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `id` (`id`),
   KEY `sex` (`sex`),
   KEY `role` (`role`)

);



DROP TABLE IF EXISTS `login`;
 CREATE TABLE IF NOT EXISTS `login` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `username` varchar(20) NOT NULL,
   `role` int(11) NOT NULL,
   `firstname` varchar(20) NOT NULL,
   `lastname` varchar(20) NOT NULL,
   `password` varchar(40) NOT NULL,
   `sex` int(11) NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `id` (`id`),
   KEY `sex` (`sex`),
   KEY `role` (`role`)

);


DROP TABLE IF EXISTS `extremity`;
CREATE TABLE IF NOT EXISTS `extremity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ex` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `extremity` (`id`, `ex`) VALUES
(1, 'L'),
(2, 'R');


DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sex` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `gender` (`id`, `sex`) VALUES
(1, 'M'),
(2, 'F');



DROP TABLE IF EXISTS `sf36_answers`;
CREATE TABLE IF NOT EXISTS `sf36_answers` (

id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
patientid int(11) NOT NULL,
`type` int(1) NOT NULL,
extremity int(1) NOT NULL,

Q4 int(2) DEFAULT NULL,
Q5 int(2) DEFAULT NULL, 
Q7 int(2) DEFAULT NULL,
Q8 int(2) DEFAULT NULL,
Q9 int(2) DEFAULT NULL,
Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL,
Q12 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,
Q15 int(2) DEFAULT NULL,
Q16 int(2) DEFAULT NULL,
Q18 int(2) DEFAULT NULL,
Q19 int(2) DEFAULT NULL,
Q20 int(2) DEFAULT NULL,
Q21 int(2) DEFAULT NULL,
Q23 int(2) DEFAULT NULL,
Q24 int(2) DEFAULT NULL,
Q25 int(2) DEFAULT NULL,
Q26 int(2) DEFAULT NULL,
Q27 int(2) DEFAULT NULL,
Q28 int(2) DEFAULT NULL,
Q31 int(2) DEFAULT NULL,
Q32 int(2) DEFAULT NULL,
Q33 int(2) DEFAULT NULL,
Q34 int(2) DEFAULT NULL,
Q35 int(2) DEFAULT NULL,
Q36 int(2) DEFAULT NULL,
Q37 int(2) DEFAULT NULL,
Q38 int(2) DEFAULT NULL,
Q39 int(2) DEFAULT NULL,
Q40 int(2) DEFAULT NULL,
Q42 int(2) DEFAULT NULL,
Q43 int(2) DEFAULT NULL,
Q44 int(2) DEFAULT NULL,
Q45 int(2) DEFAULT NULL,

PRIMARY KEY (`id`),

KEY `patientid` (`patientid`)
 );


DROP TABLE IF EXISTS `demo_answers`;
CREATE TABLE IF NOT EXISTS `demo_answers` (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,

Q1 int(2) DEFAULT NULL,
Q2 int(2) DEFAULT NULL, 
Q3 int(2) DEFAULT NULL,
Q4 int(2) DEFAULT NULL,
Q5 int(2) DEFAULT NULL,
Q6 int(2) DEFAULT NULL,

PRIMARY KEY (`id`),

KEY `pat_id` (`pat_id`)
);


DROP TABLE IF EXISTS `eval_answers`;
CREATE TABLE IF NOT EXISTS `eval_answers` (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
dateofexam int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
sur_id int(11) NOT NULL,
`height` int(11) DEFAULT NULL,
`weight` int(11) DEFAULT NULL,
`extremity` int(11) DEFAULT NULL,

Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL, 
Q12 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,
Q15 int(4) DEFAULT NULL,
Q16 int(2) DEFAULT NULL,
Q17 varchar(27) DEFAULT NULL,
Q18 varchar(15) DEFAULT NULL,
Q19 int(4) DEFAULT NULL,
Q20 int(4) DEFAULT NULL,
Q21 int(2) DEFAULT NULL,
Q22 int(2) DEFAULT NULL,
Q23 int(2) DEFAULT NULL,
Q24 varchar(15) DEFAULT NULL,
Q25 int(2) DEFAULT NULL,
Q26 int(2) DEFAULT NULL,
Q27 varchar(15) DEFAULT NULL,

PRIMARY KEY (`id`),
KEY `extremity` (`extremity`),
KEY `pat_id` (`pat_id`)
);

DROP TABLE IF EXISTS `foot_answers`;
CREATE TABLE IF NOT EXISTS `foot_answers` (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
`type` int(1) NOT NULL,
extremity int(1) NOT NULL,

Q4 int(2) DEFAULT NULL,
Q6 int(2) DEFAULT NULL, 
Q7 int(2) DEFAULT NULL,
Q8 int(2) DEFAULT NULL,
Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,
Q15 int(2) DEFAULT NULL,
Q17 int(2) DEFAULT NULL,
Q18 int(2) DEFAULT NULL,
Q19 int(2) DEFAULT NULL,
Q20 int(2) DEFAULT NULL,

PRIMARY KEY (`id`),

KEY `pat_id` (`pat_id`)
);


DROP TABLE IF EXISTS mcgillpain_answers;
CREATE TABLE IF NOT EXISTS mcgillpain_answers (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
sur_id int(11) NOT NULL,
`type` int(1) NOT NULL,
extremity int(1) NOT NULL,

Q5 int(2) DEFAULT NULL,
Q6 int(2) DEFAULT NULL,
Q7 int(2) DEFAULT NULL,
Q8 int(2) DEFAULT NULL,
Q9 int(2) DEFAULT NULL,
Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL,
Q12 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,
Q15 int(2) DEFAULT NULL,
Q16 int(2) DEFAULT NULL,
Q17 int(2) DEFAULT NULL,
Q18 int(2) DEFAULT NULL,
Q19 int(2) DEFAULT NULL,
Q20 int(2) DEFAULT NULL,
Q21 int(2) DEFAULT NULL,
Q22 int(2) DEFAULT NULL,
Q23 int(2) DEFAULT NULL,
Q24 int(2) DEFAULT NULL,
Q25 int(2) DEFAULT NULL,
Q26 int(2) DEFAULT NULL,
Q27 int(2) DEFAULT NULL,
Q28 int(2) DEFAULT NULL,
Q29 int(2) DEFAULT NULL,

PRIMARY KEY (id) 
);


DROP TABLE IF EXISTS post_answers;
CREATE TABLE IF NOT EXISTS post_answers (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
sur_id int(11) NOT NULL,
dateofexam int(10) DEFAULT NULL,
painmedused int(11) NOT NULL,
dosepainmedused int(11) NOT NULL,
`type` int(1) NOT NULL,
extremity int(1) NOT NULL,

Q7 int(2) DEFAULT NULL,
Q8 int(2) DEFAULT NULL,
Q9 int(2) DEFAULT NULL,
Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL,
Q12 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,

PRIMARY KEY (id) 
);

DROP TABLE IF EXISTS surgical_answers;
CREATE TABLE IF NOT EXISTS surgical_answers (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
dateofsurgery int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
sur_id int(11) NOT NULL,
extremity int(1) NOT NULL,

Q5 varchar(39) DEFAULT NULL,
Q6 int(2) DEFAULT NULL,
Q7 int(2) DEFAULT NULL,
Q8 int(2) DEFAULT NULL,
Q9 int(2) DEFAULT NULL,
Q10 int(2) DEFAULT NULL,
Q11 int(2) DEFAULT NULL,
Q12 int(2) DEFAULT NULL,
Q13 int(2) DEFAULT NULL,
Q14 int(2) DEFAULT NULL,
Q15 int(2) DEFAULT NULL,
Q16 int(2) DEFAULT NULL,
Q17 int(2) DEFAULT NULL,
Q18 int(2) DEFAULT NULL,
Q19 int(2) DEFAULT NULL,
Q20 int(2) DEFAULT NULL,
Q21 int(2) DEFAULT NULL,
Q22 int(2) DEFAULT NULL,
Q23 int(2) DEFAULT NULL,
Q24 int(2) DEFAULT NULL,
Q25 int(2) DEFAULT NULL,
Q26 int(2) DEFAULT NULL,

PRIMARY KEY (id) 
);


DROP TABLE IF EXISTS xrays_answers;
CREATE TABLE IF NOT EXISTS xrays_answers (
id int(15) NOT NULL AUTO_INCREMENT,
dateof int(10) DEFAULT NULL,
dateofxrays int(10) DEFAULT NULL,
pat_id int(11) NOT NULL,
sur_id int(11) NOT NULL,
`type` int(1) NOT NULL,
extremity int(1) NOT NULL,

Q4 varchar(100) DEFAULT NULL,
Q5 varchar(100) DEFAULT NULL,
Q6 varchar(100) DEFAULT NULL,
Q7 varchar(100) DEFAULT NULL,
Q8 varchar(100) DEFAULT NULL,
Q9 varchar(100) DEFAULT NULL,
Q10 varchar(100) DEFAULT NULL,
Q11 varchar(100) DEFAULT NULL,
Q12 varchar(100) DEFAULT NULL,
Q13 varchar(100) DEFAULT NULL,
Q14 varchar(100) DEFAULT NULL,
Q15 varchar(100) DEFAULT NULL,
Q16 varchar(100) DEFAULT NULL,
Q17 varchar(100) DEFAULT NULL,
Q18 varchar(100) DEFAULT NULL,
Q19 varchar(100) DEFAULT NULL,
Q20 varchar(100) DEFAULT NULL,
Q21 varchar(100) DEFAULT NULL,
Q22 varchar(100) DEFAULT NULL,
Q23 varchar(100) DEFAULT NULL,
Q24 varchar(100) DEFAULT NULL,
Q25 varchar(100) DEFAULT NULL,
Q26 varchar(100) DEFAULT NULL,
Q27 varchar(100) DEFAULT NULL,
Q28 varchar(100) DEFAULT NULL,
Q29 varchar(100) DEFAULT NULL,
Q30 varchar(100) DEFAULT NULL,
Q31 varchar(100) DEFAULT NULL,
Q32 varchar(100) DEFAULT NULL,
Q33 varchar(100) DEFAULT NULL,
Q34 varchar(100) DEFAULT NULL,
Q35 varchar(100) DEFAULT NULL,
Q36 varchar(100) DEFAULT NULL,
Q37 varchar(100) DEFAULT NULL,
Q38 varchar(100) DEFAULT NULL,


PRIMARY KEY (id) 
);


GRANT ALL PRIVILEGES ON Podiatry TO 'root'@localhost IDENTIFIED BY '' WITH GRANT OPTION;

