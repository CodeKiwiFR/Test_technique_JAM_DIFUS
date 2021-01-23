-- CREATING Database if it does not exist
CREATE DATABASE IF NOT EXISTS `db_mhotting`;
USE `db_mhotting`;

-- DROPING all the tables if they exist
DROP TABLE IF EXISTS
    `db_mhotting.t_dev`,
    `db_mhotting.t_lang`,
    `db_mhotting.t_devlang`;

-- CREATING the tables
CREATE TABLE IF NOT EXISTS `db_mhotting.t_dev` (
    `dev_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dev_name` VARCHAR(255) NOT NULL,
    `dev_imageUrl` VARCHAR(2000) NOT NULL,
    `dev_price` INT DEFAULT 0,
    `dev_description` VARCHAR(2000) NOT NULL,
    PRIMARY KEY (`dev_id`),
    UNIQUE INDEX `dev_id_UNIQUE` (`dev_id` ASC),
    UNIQUE INDEX `dev_name_UNIQUE` (`dev_name` ASC)
);
CREATE TABLE IF NOT EXISTS `db_mhotting.t_lang` (
    `lang_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lang_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`lang_id`),
    UNIQUE INDEX `lang_id_UNIQUE` (`lang_id` ASC),
    UNIQUE INDEX `lang_uname_UNIQUE` (`lang_name` ASC)
);
CREATE TABLE IF NOT EXISTS `db_mhotting.t_devlang` (
    `devlang_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `devlang_idDev` INT UNSIGNED NOT NULL,
    `devlang_idLanguage` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`devlang_id`),
    UNIQUE INDEX `devlang_id_UNIQUE` (`devlang_id` ASC)
);

-- ADDING foreign key constraints
ALTER TABLE `db_mhotting.t_devlang` 
ADD CONSTRAINT FK_Devlang_User
FOREIGN KEY (`devlang_idDev`) REFERENCES `db_mhotting.t_dev`(dev_id);
ALTER TABLE `db_mhotting.t_devlang` 
ADD CONSTRAINT FK_DevLang_Lang
FOREIGN KEY (`devlang_idLanguage`) REFERENCES `db_mhotting.t_lang`(lang_id);

-- INSERTING DATA into tables
INSERT INTO `db_mhotting.t_lang`(`lang_name`)
VALUES
    ('javascript'),
    ('php'),
    ('java'),
    ('c'),
    ('c++'),
    ('go'),
    ('python');
INSERT INTO `db_mhotting.t_dev`(`dev_name`, `dev_imageUrl`, `dev_price`, `dev_description`)
VALUES
    (
        'DroidMarcel',
        'https://images.unsplash.com/photo-1589254065878-42c9da997008?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80',
        500,
        'Marcel est notre premier droid. Un peu ancien, il fait tout de même très bien son travail.'
    ),
    (
        'DroidAnna',
        'https://images.unsplash.com/photo-1563396983906-b3795482a59a?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1052&q=80',
        700,
        'Anna a rapidement rejoint Marcel afin de compléter notre gamme de robots. Profitez d''Anna pour ajouter de la féminité au sein de votre équipe.'
    ),
    (
        'DroidGilles',
        'https://images.unsplash.com/photo-1599272771314-f3ec16bda3f2?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80',
        200,
        'Gilles n''est pas un robot très performant. Il n''a pas beaucoup de connaissances. Malgré tout, il est très économique et connaît un très grand nombre de plaisanteries.'
    ),
    (
        'DroidLila',
        'https://images.unsplash.com/photo-1581879410444-c8b6af591710?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1248&q=80',
        1500,
        'Lila est un modèle très performant. Elle ne compte pas ses heures et peut torturer vos autres employés afin de les obliger à travailler plus.'
    ),
    (
        'DroidMiaou',
        'https://images.unsplash.com/photo-1533743983669-94fa5c4338ec?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1283&q=80',
        5000,
        'Le robot ultime. Ne vous fiez pas à son apparence, il est capable de gérer n''importe quel projet en un temps record. Grâce à lui, vous pourrez vous passer de tous vos autres employés et partir en vacances plus régulièrement.'
    ),
    (
        'DroidAngie',
        'https://images.unsplash.com/photo-1575755049931-8338ad979f7c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1267&q=80',
        2500,
        'Angie fait les choses correctement. Elle est parfois vulgaire et violente mais travaille vraiment bien.'
    ),
    (
        'DroidMartin',
        'https://i.pinimg.com/originals/57/2b/1e/572b1ee3eb85a5c608b39019f243f744.jpg',
        3200,
        'Tout droit venu de chez Disney, personne ne sait ce qu''il fait ici.'
    );

INSERT INTO `db_mhotting.t_devlang`(`devlang_idDev`, `devlang_idLanguage`)
VALUES
    (1, 1), (1, 2), (1, 3), (2, 4), (2, 5), (3, 1),
    (4, 2), (4, 5), (5, 1), (5, 2), (5, 3), (5, 4),
    (5, 5), (5, 6), (5, 7), (6, 3), (6, 6), (7, 1);