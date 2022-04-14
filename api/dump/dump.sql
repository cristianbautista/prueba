CREATE TABLE club (
id integer auto_increment NOT NULL,
name VARCHAR(100) NOT NULL UNIQUE,
presupposition integer NOT NULL,
INDEX name_idx (name),
PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;



CREATE TABLE player(
id integer auto_increment NOT NULL,
name VARCHAR (100) NOT NULL,
dorsal INTEGER,
salary INTEGER,
idClub INTEGER,
INDEX name_idx_player(name),
FOREIGN KEY (idClub) references club(id),
PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;




CREATE TABLE coach(
id integer auto_increment NOT NULL,
name VARCHAR (100) NOT NULL,
salary INTEGER,
idClub INTEGER,
INDEX name_idx_coach(name),
FOREIGN KEY (idClub) references club(id),
PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
