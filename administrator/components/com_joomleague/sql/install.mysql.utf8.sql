-- -----------------------------------------------------
-- Table `#__joomleague_club`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_club` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `name` VARCHAR(100) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(100) NOT NULL DEFAULT '' ,
  `admin` INT(11) NULL DEFAULT NULL ,
  `address` VARCHAR(100) NOT NULL DEFAULT '' ,
  `zipcode` VARCHAR(10) NOT NULL DEFAULT '' ,
  `location` VARCHAR(50) NOT NULL DEFAULT '' ,
  `state` VARCHAR(50) NOT NULL DEFAULT '' ,
  `country` VARCHAR(3) NULL DEFAULT NULL,
  `founded` VARCHAR(50) NULL DEFAULT NULL ,
  `dissolved` VARCHAR(50) NULL DEFAULT NULL,
  `phone` VARCHAR(20) NOT NULL DEFAULT '' ,
  `fax` VARCHAR(20) NOT NULL DEFAULT '' ,
  `email` VARCHAR(255) NOT NULL DEFAULT '' ,
  `website` VARCHAR(250) NOT NULL DEFAULT '' ,
  `president` VARCHAR(50) NOT NULL DEFAULT '' ,
  `manager` VARCHAR(50) NOT NULL DEFAULT '' ,
  `logo_big` VARCHAR(255) NOT NULL DEFAULT '' ,
  `logo_middle` VARCHAR(255) NOT NULL DEFAULT '' ,
  `logo_small` VARCHAR(255) NOT NULL DEFAULT '' ,
  `standard_playground` INT(11) NULL DEFAULT NULL ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_division`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_division` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) NOT NULL DEFAULT '0' ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `shortname` VARCHAR(10) NULL ,
  `notes` TEXT NOT NULL ,
  `parent_id` INT(11) NULL DEFAULT NULL ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `published` TINYINT(1) NOT NULL DEFAULT '1' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
 KEY `project_id` (`project_id`),
 KEY `parent_id` (`parent_id`)
 )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_eventtype`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_eventtype` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `icon` VARCHAR(128) NOT NULL DEFAULT '' ,
  `parent` INT(11) NOT NULL DEFAULT '0' ,
  `splitt` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `direction` CHAR(4) NOT NULL DEFAULT 'DESC' ,
  `double` TINYINT(3) NOT NULL DEFAULT '0' ,
  `sports_type_id` TINYINT(1) NOT NULL DEFAULT '1' ,
  `published` TINYINT(1) NOT NULL DEFAULT '1' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `sports_type_id` (`sports_type_id`),
  UNIQUE KEY `name` (`name`,`parent`,`sports_type_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_league`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_league` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `short_name` VARCHAR(15) NOT NULL DEFAULT '' ,
  `middle_name` VARCHAR(25) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `country` VARCHAR(3) NULL DEFAULT NULL,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_match`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_match` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `round_id` INT(11) NOT NULL DEFAULT '0' ,
  `match_number` VARCHAR(10) NULL DEFAULT NULL ,
  `projectteam1_id` INT(11) NOT NULL DEFAULT '0' ,
  `projectteam2_id` INT(11) NOT NULL DEFAULT '0' ,
  `playground_id` INT(11) NULL DEFAULT NULL ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `match_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `time_present` TIME NULL DEFAULT NULL ,
  `team1_result` FLOAT NULL DEFAULT NULL ,
  `team2_result` FLOAT NULL DEFAULT NULL ,
  `team1_bonus` INT(11) NULL DEFAULT NULL ,
  `team2_bonus` INT(11) NULL DEFAULT NULL ,
  `team1_legs` FLOAT NULL DEFAULT NULL ,
  `team2_legs` FLOAT NULL DEFAULT NULL ,
  `team1_result_split` VARCHAR(64) NULL DEFAULT NULL ,
  `team2_result_split` VARCHAR(64) NULL DEFAULT NULL ,
  `match_result_type` TINYINT(4) NOT NULL DEFAULT '0' ,
  `team_won` TINYINT(4) NOT NULL DEFAULT '0' ,
  `team1_result_ot` FLOAT NULL DEFAULT NULL ,
  `team2_result_ot` FLOAT NULL DEFAULT NULL ,
  `team1_result_so` FLOAT NULL DEFAULT NULL ,
  `team2_result_so` FLOAT NULL DEFAULT NULL ,
  `alt_decision` TINYINT(4) NOT NULL DEFAULT '0' ,
  `team1_result_decision` FLOAT NULL DEFAULT NULL ,
  `team2_result_decision` FLOAT NULL DEFAULT NULL ,
  `decision_info` VARCHAR(128) NOT NULL DEFAULT '' ,
  `cancel` TINYINT(4) NOT NULL DEFAULT '0' ,
  `cancel_reason` VARCHAR(32) NOT NULL DEFAULT '' ,
  `count_result` TINYINT(4) NOT NULL DEFAULT '1' ,
  `crowd` INT(11) NOT NULL DEFAULT '0' ,
  `summary` TEXT NOT NULL ,
  `show_report` TINYINT(4) NOT NULL DEFAULT '0' ,
  `preview` TEXT NOT NULL ,
  `match_result_detail` VARCHAR(64) NOT NULL DEFAULT '' ,
  `new_match_id` INT(11) NOT NULL DEFAULT '0' ,
  `old_match_id` INT(11) NOT NULL DEFAULT '0' ,
  `extended` TEXT NULL ,
  `published` TINYINT(4) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `round_id` (`round_id`),
  KEY `projectteam1_id` (`projectteam1_id`),
  KEY `projectteam2_id` (`projectteam2_id`),
  KEY `playground_id` (`playground_id`),
  KEY `new_match_id` (`new_match_id`),
  KEY `old_match_id` (`old_match_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_match_event`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_match_event` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `match_id` INT(11) NOT NULL DEFAULT '0' ,
  `projectteam_id` INT(11) NOT NULL DEFAULT '0' ,
  `teamplayer_id` INT(11) NOT NULL DEFAULT '0' ,
  `teamplayer_id2` INT(11) NOT NULL DEFAULT '0' ,
  `event_time` VARCHAR(20) NOT NULL DEFAULT '' ,
  `event_type_id` INT(11) NOT NULL DEFAULT '0' ,
  `event_sum` DOUBLE NULL DEFAULT NULL ,
  `notice` VARCHAR(64) NOT NULL DEFAULT '' ,
  `notes` TEXT NOT NULL ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `projectteam_id` (`projectteam_id`),
  KEY `teamplayer_id` (`teamplayer_id`),
  KEY `teamplayer_id2` (`teamplayer_id2`),
  KEY `event_type_id` (`event_type_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_match_player`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_match_player` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `match_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' ,
  `teamplayer_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' ,
  `project_position_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' ,
  `came_in` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `in_for` INT(11) UNSIGNED NULL DEFAULT NULL ,
  `out` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `in_out_time` VARCHAR(15) NULL DEFAULT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `teamplayer_id` (`teamplayer_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_match_statistic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_match_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL DEFAULT '0',
  `projectteam_id` int(11) NOT NULL,
  `teamplayer_id` int(11) NOT NULL DEFAULT '0',
  `statistic_id` int(11) NOT NULL DEFAULT '0',
  `value` DOUBLE NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `projectteam_id` (`projectteam_id`),
  KEY `teamplayer_id` (`teamplayer_id`),
  KEY `statistic_id` (`statistic_id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8
AUTO_INCREMENT=1 ;

-- -----------------------------------------------------
-- Table `#__joomleague_match_staff_statistic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_match_staff_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL DEFAULT '0',
  `projectteam_id` int(11) NOT NULL,
  `team_staff_id` int(11) NOT NULL DEFAULT '0',
  `statistic_id` int(11) NOT NULL DEFAULT '0',
  `value` double NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `projectteam_id` (`projectteam_id`),
  KEY `team_staff_id` (`team_staff_id`),
  KEY `statistic_id` (`statistic_id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8
AUTO_INCREMENT=1 ;

-- -----------------------------------------------------
-- Table `#__joomleague_match_referee`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_match_referee` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `match_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_referee_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_position_id` INT(11) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `project_referee_id` (`project_referee_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_match_staff`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_match_staff` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `match_id` INT(11) NOT NULL DEFAULT '0' ,
  `team_staff_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_position_id` INT(11) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  KEY `team_staff_id` (`team_staff_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_person`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_person` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `contact_id` INT(11) NULL DEFAULT NULL ,
  `firstname` VARCHAR(45) NOT NULL DEFAULT '' ,
  `lastname` VARCHAR(45) NOT NULL DEFAULT '' ,
  `nickname` VARCHAR(45) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(90) NOT NULL DEFAULT '' ,
  `country` VARCHAR(3) NULL DEFAULT NULL,
  `knvbnr` VARCHAR(10) NOT NULL DEFAULT '' ,
  `birthday` DATE NOT NULL DEFAULT '0000-00-00' ,
  `deathday` DATE NOT NULL DEFAULT '0000-00-00' ,
  `height` INT(3) NULL DEFAULT NULL ,
  `weight` INT(3) NULL DEFAULT NULL ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `show_pic` TINYINT(1) NOT NULL DEFAULT '1' ,
  `show_persdata` TINYINT(1) NOT NULL DEFAULT '1' ,
  `show_teamdata` TINYINT(1) NOT NULL DEFAULT '1' ,
  `show_on_frontend` TINYINT(1) NOT NULL DEFAULT '1' ,
  `info` VARCHAR(255) NOT NULL DEFAULT '' ,
  `notes` TEXT NOT NULL ,
  `phone` VARCHAR(20) NOT NULL DEFAULT '' ,
  `mobile` VARCHAR(20) NOT NULL DEFAULT '' ,
  `email` VARCHAR(50) NOT NULL ,
  `website` VARCHAR(250) NOT NULL ,
  `address` VARCHAR(100) NOT NULL DEFAULT '' ,
  `zipcode` VARCHAR(10) NOT NULL DEFAULT '' ,
  `location` VARCHAR(50) NOT NULL DEFAULT '' ,
  `state` VARCHAR(50) NOT NULL DEFAULT '' ,
  `address_country` VARCHAR(3) NULL DEFAULT NULL,
  `extended` TEXT NULL ,
  `position_id` INT(11) NULL,
  `published` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `position_id` (`position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_playground`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_playground` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `short_name` VARCHAR(15) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `address` VARCHAR(100) NOT NULL DEFAULT '' ,
  `zipcode` VARCHAR(10) NOT NULL DEFAULT '' ,
  `city` VARCHAR(64) NOT NULL DEFAULT '' ,
  `country` VARCHAR(3) NULL DEFAULT NULL,
  `max_visitors` INT(11) NULL DEFAULT NULL ,
  `website` VARCHAR(250) NOT NULL DEFAULT '' ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `notes` TEXT NOT NULL ,
  `club_id` INT(11) NOT NULL DEFAULT '0' ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `club_id` (`club_id`),
  UNIQUE INDEX `name` (`name` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_position`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_position` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `parent_id` INT(11) NOT NULL DEFAULT '0' ,
  `persontype` TINYINT(4) NOT NULL DEFAULT '1' ,
  `sports_type_id` TINYINT(1) NOT NULL DEFAULT '1' ,
  `published` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ordering` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `parent_id` (`parent_id`),
  KEY `sports_type_id` (`sports_type_id`),
  UNIQUE KEY `name` (`name`,`parent_id`,`persontype`,`sports_type_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_position_eventtype`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_position_eventtype` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `position_id` INT(11) NOT NULL DEFAULT '0' ,
  `eventtype_id` INT(11) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `position_id` (`position_id`),
  KEY `eventtype_id` (`eventtype_id`),
  UNIQUE INDEX `pos_et` (`position_id` ASC, `eventtype_id` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_position_statistic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_position_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL DEFAULT '0',
  `statistic_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `checked_out` int(11) DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `statistic_id` (`statistic_id`),
  UNIQUE KEY `pos_et` (`position_id`,`statistic_id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8
AUTO_INCREMENT=1 ;

-- -----------------------------------------------------
-- Table `#__joomleague_project`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_project` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(100) NOT NULL DEFAULT '' ,
  `league_id` INT(11) NOT NULL DEFAULT '0' ,
  `season_id` INT(11) NOT NULL DEFAULT '0' ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `master_template` INT(11) NOT NULL DEFAULT '0' ,
  `sub_template_id` INT(11) NOT NULL DEFAULT '0' ,
  `extension` VARCHAR(80) NULL DEFAULT NULL ,
  `timezone` VARCHAR(50) NOT NULL DEFAULT 'Europe/Amsterdam' ,
  `project_type` ENUM('SIMPLE_LEAGUE', 'DIVISIONS_LEAGUE', 'TOURNAMENT_MODE', 'FRIENDLY_MATCHES') NOT NULL DEFAULT 'SIMPLE_LEAGUE' ,
  `teams_as_referees` TINYINT(1) NOT NULL DEFAULT '0' ,
  `sports_type_id` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` DATE NOT NULL DEFAULT '0000-00-00' ,
  `start_time` VARCHAR(5) NOT NULL DEFAULT '15:30' ,
  `current_round_auto` TINYINT(4) NOT NULL DEFAULT '0' ,
  `current_round` VARCHAR(32) NOT NULL DEFAULT '0' ,
  `auto_time` INT(11) NULL DEFAULT NULL ,
  `game_regular_time` SMALLINT(6) NOT NULL DEFAULT '90' ,
  `game_parts` SMALLINT(6) NOT NULL DEFAULT '2' ,
  `halftime` SMALLINT(6) NOT NULL DEFAULT '15' ,
  `points_after_regular_time` VARCHAR(10) NOT NULL DEFAULT '3,1,0' ,
  `use_legs` TINYINT(1)  NULL DEFAULT NULL ,
  `allow_add_time` TINYINT(1) NOT NULL DEFAULT '0' ,
  `add_time` SMALLINT(6) NOT NULL DEFAULT '30' ,
  `points_after_add_time` VARCHAR(10) NOT NULL DEFAULT '3,1,0' ,
  `points_after_penalty` VARCHAR(10) NOT NULL DEFAULT '3,1,0' ,
  `fav_team` VARCHAR(64) NOT NULL DEFAULT '' ,
  `fav_team_highlight_type` VARCHAR(7) NOT NULL DEFAULT '' ,
  `fav_team_color` VARCHAR(7) NOT NULL DEFAULT '' ,
  `fav_team_text_color` VARCHAR(7) NOT NULL DEFAULT '' ,
  `fav_team_text_bold` VARCHAR(7) NOT NULL DEFAULT '' ,
  `template` VARCHAR(32) NOT NULL DEFAULT 'default' ,
  `enable_sb` TINYINT(4) NOT NULL DEFAULT '0' ,
  `sb_catid` INT(11) NOT NULL DEFAULT '0' ,
  `extended` TEXT NULL ,
  `picture` VARCHAR(128) NULL DEFAULT NULL ,
  `published` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `league_id` (`league_id`),
  KEY `season_id` (`season_id`),
  KEY `sub_template_id` (`sub_template_id`),
  KEY `sports_type_id` (`sports_type_id`),
  UNIQUE INDEX `name, league, season` (`name` ASC, `league_id` ASC, `season_id` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_project_position`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_project_position` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) NOT NULL ,
  `position_id` INT(11) NOT NULL ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `project_id` (`project_id`),
  KEY `position_id` (`position_id`),
  UNIQUE INDEX `pos_proj` (`position_id` ASC, `project_id` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_project_referee`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_project_referee` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_id` INT(11) NOT NULL DEFAULT '0' ,
  `person_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_position_id` INT(11) NULL DEFAULT NULL ,
  `notes` TEXT NOT NULL ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `published` INT(1) UNSIGNED NOT NULL DEFAULT '1' ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `person_id` (`person_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_project_team`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_project_team` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) NOT NULL DEFAULT '0' ,
  `team_id` INT(11) NOT NULL DEFAULT '0' ,
  `division_id` INT(11) NULL DEFAULT NULL ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `start_points` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `points_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `neg_points_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `matches_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `won_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `draws_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `lost_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `homegoals_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `guestgoals_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `diffgoals_finally` SMALLINT(6) NOT NULL DEFAULT '0' ,
  `is_in_score` TINYINT(1) NOT NULL DEFAULT '1' ,
  `use_finally` TINYINT(1) NOT NULL DEFAULT '0' ,
  `info` VARCHAR(255) NOT NULL DEFAULT '' ,
  `picture` VARCHAR(128) NULL DEFAULT NULL ,
  `notes` TEXT NOT NULL ,
  `standard_playground` INT(11) NULL DEFAULT NULL ,
  `reason` VARCHAR(150) NOT NULL ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `project_id` (`project_id`),
  KEY `team_id` (`team_id`),
  KEY `division_id` (`division_id`),
  UNIQUE INDEX `combi` (`project_id` ASC, `team_id` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_round`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_round` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) NOT NULL DEFAULT '0' ,
  `roundcode` INT(11) NOT NULL DEFAULT '0' ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `round_date_first` DATE NOT NULL DEFAULT '0000-00-00' ,
  `round_date_last` DATE NOT NULL DEFAULT '0000-00-00' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `project_id` (`project_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_season`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_season` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_sports_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_sports_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL DEFAULT '' ,
  `icon` varchar(128) NOT NULL DEFAULT '',
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_statistic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL DEFAULT '',
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `short` varchar(10) NOT NULL DEFAULT '',
  `icon` varchar(128) NOT NULL DEFAULT '',
  `class` varchar(50) NOT NULL COMMENT 'must be the name of the class handling it',
  `calculated` tinyint(4) NOT NULL,
  `params` text NOT NULL,
  `baseparams` text NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `sports_type_id` TINYINT(1) NOT NULL DEFAULT '1' ,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `sports_type_id` (`sports_type_id`)
)
ENGINE=MyISAM
DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_team`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_team` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `club_id` INT(11) NULL DEFAULT NULL ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `name` VARCHAR(75) NOT NULL DEFAULT '' ,
  `short_name` VARCHAR(15) NOT NULL DEFAULT '' ,
  `middle_name` VARCHAR(25) NOT NULL DEFAULT '' ,
  `alias` VARCHAR(75) NOT NULL DEFAULT '' ,
  `website` VARCHAR(250) NOT NULL DEFAULT '' ,
  `info` VARCHAR(255) NOT NULL DEFAULT '' ,
  `notes` TEXT NOT NULL ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `extended` TEXT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  KEY `club_id` (`club_id`),
  INDEX `fk_club` (`club_id` ASC)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_team_player`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_team_player` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `projectteam_id` INT(11) NULL DEFAULT '0' ,
  `person_id` INT(11) NULL DEFAULT '0' ,
  `project_position_id` INT(11) NULL DEFAULT NULL ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `active` TINYINT(1) NULL DEFAULT '1' ,
  `jerseynumber` INT(11) NULL DEFAULT NULL ,
  `notes` TEXT NOT NULL ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `extended` TEXT NULL ,
  `injury` TINYINT(4) NOT NULL DEFAULT '0' ,
  `injury_date` INT(11) NOT NULL ,
  `injury_end` INT(11) NOT NULL ,
  `injury_detail` VARCHAR(255) NOT NULL ,
  `injury_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `injury_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `suspension` TINYINT(4) NOT NULL DEFAULT '0' ,
  `suspension_date` INT(11) NOT NULL ,
  `suspension_end` INT(11) NOT NULL ,
  `suspension_detail` VARCHAR(255) NOT NULL ,
  `susp_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `susp_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `away` TINYINT(4) NOT NULL DEFAULT '0' ,
  `away_date` INT(11) NOT NULL ,
  `away_end` INT(11) NOT NULL ,
  `away_detail` VARCHAR(255) NOT NULL ,
  `away_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `away_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `published` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `projectteam_id` (`projectteam_id`),
  KEY `person_id` (`person_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_team_staff`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_team_staff` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `projectteam_id` INT(11) NULL DEFAULT '0' ,
  `person_id` INT(11) NULL DEFAULT '0' ,
  `project_position_id` INT(11) NULL DEFAULT NULL ,
  `asset_id` INT(11) NOT NULL DEFAULT '0' ,
  `active` TINYINT(1) NULL DEFAULT '1' ,
  `notes` TEXT NOT NULL ,
  `injury` TINYINT(4) NOT NULL DEFAULT '0' ,
  `injury_date` INT(11) NOT NULL ,
  `injury_end` INT(11) NOT NULL ,
  `injury_detail` VARCHAR(255) NOT NULL ,
  `injury_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `injury_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `suspension` TINYINT(4) NOT NULL DEFAULT '0' ,
  `suspension_date` INT(11) NOT NULL ,
  `suspension_end` INT(11) NOT NULL ,
  `suspension_detail` VARCHAR(255) NOT NULL ,
  `susp_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `susp_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `away` TINYINT(4) NOT NULL DEFAULT '0' ,
  `away_date` INT(11) NOT NULL ,
  `away_end` INT(11) NOT NULL ,
  `away_detail` VARCHAR(255) NOT NULL ,
  `away_date_start` DATE NOT NULL DEFAULT '0000-00-00' ,
  `away_date_end` DATE NOT NULL DEFAULT '0000-00-00' ,
  `picture` VARCHAR(128) NOT NULL DEFAULT '' ,
  `extended` TEXT NULL ,
  `published` TINYINT(1) NOT NULL DEFAULT '0' ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `projectteam_id` (`projectteam_id`),
  KEY `person_id` (`person_id`),
  KEY `project_position_id` (`project_position_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_team_trainingdata`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_team_trainingdata` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) NOT NULL DEFAULT '0' ,
  `team_id` INT(11) NOT NULL DEFAULT '0' ,
  `project_team_id` INT(11) NOT NULL DEFAULT '0' ,
  `dayofweek` TINYINT(1) NOT NULL DEFAULT '0' ,
  `time_start` INT(11) NOT NULL DEFAULT '0' ,
  `time_end` INT(11) NOT NULL DEFAULT '0' ,
  `place` VARCHAR(255) NOT NULL DEFAULT '' ,
  `notes` TEXT NOT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out` INT(11) NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `team_id` (`team_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


-- -----------------------------------------------------
-- Table `#__joomleague_template_config`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_template_config` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `project_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' ,
  `template` VARCHAR(64) NOT NULL DEFAULT '' ,
  `func` VARCHAR(64) NOT NULL DEFAULT '' ,
  `title` VARCHAR(255) NOT NULL DEFAULT '' ,
  `params` TEXT NOT NULL ,
  `published` INT(1) UNSIGNED NOT NULL DEFAULT '1' ,
  `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0' ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_treeto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_treeto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL default '0',
  `division_id` int(11) NOT NULL default '0',
  `tree_i` int(11) NOT NULL default '0',
  `name` varchar(128) default NULL,
  `global_bestof` tinyint(1) NOT NULL default '0',
  `global_matchday` tinyint(1) NOT NULL default '0',
  `global_known` tinyint(1) NOT NULL default '0',
  `global_fake` tinyint(1) NOT NULL default '0',
  `leafed` tinyint(1) NOT NULL default '0',
  `mirror` tinyint(1) NOT NULL default '0',
  `hide` tinyint(1) NOT NULL default '0',
  `trophypic` varchar(128) default NULL,
  `extended` text,
  `published` tinyint(1) NOT NULL default '1',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,  PRIMARY KEY  (`id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_treeto_match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_treeto_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) NOT NULL default '0',
  `match_id` int(11) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `combi` (`node_id`,`match_id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_treeto_node`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__joomleague_treeto_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `treeto_id` int(11) NOT NULL default '0',
  `node` int(11) NOT NULL default '0',
  `row` int(11) NOT NULL default '0',
  `bestof` tinyint(1) NOT NULL default '1',
  `title` varchar(50) NOT NULL default '',
  `content` varchar(50) NOT NULL default '',
  `team_id` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `is_leaf` tinyint(1) NOT NULL default '0',
  `is_lock` tinyint(1) NOT NULL default '0',
  `is_ready` tinyint(1) NOT NULL default '0',
  `got_lc` tinyint(1) NOT NULL default '0',
  `got_rc` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY  (`id`)
  )
ENGINE=MyISAM
DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
-- Table `#__joomleague_version`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `#__joomleague_version` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `major` INT NOT NULL ,
  `minor` INT NOT NULL ,
  `build` INT NOT NULL ,
  `count` INT NOT NULL ,
  `revision` VARCHAR(128) NOT NULL ,
  `file` VARCHAR(255) NOT NULL DEFAULT '' ,
  `date` TIMESTAMP NOT NULL ,
  `version` VARCHAR(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
  )
ENGINE = MyISAM
DEFAULT CHARSET = utf8;
