CREATE TABLE `projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','inprogress','done') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
)

CREATE TABLE contacts (
	ID int not null AUTO_INCREMENT,
	name varchar(255) not null,
	email varchar(255) not null,
	project_id int,
	primary key (ID)
);
