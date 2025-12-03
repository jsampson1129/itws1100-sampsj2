-- create the tables for our movies
CREATE TABLE `movies` (
   `movieid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(100) NOT NULL,
   `year` char(4) DEFAULT NULL,
   PRIMARY KEY (`movieid`)
);
-- insert data into the tables
INSERT INTO movies
VALUES (1, "Elizabeth", "1998"),
   (2, "Black Widow", "2021"),
   (3, "Oh Brother Where Art Thou?", "2000"),
   (
      4,
      "The Lord of the Rings: The Fellowship of the Ring",
      "2001"
   ),
   (5, "Up in the Air", "2009");
CREATE TABLE actors (
    'actor_id' INT AUTO_INCREMENT PRIMARY KEY,
    'first_name' VARCHAR(50) NOT NULL,
    'last_name' VARCHAR(50) NOT NULL,
    'dob' DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add 5+ actors (at least 3 born before 1960)
INSERT INTO actors (first_name, last_name, dob) VALUES
('Tom', 'Hanks', '1956-07-09'),
('Meryl', 'Streep', '1949-06-22'),
('Leonardo', 'DiCaprio', '1974-11-11'),
('Denzel', 'Washington', '1954-12-28'),
('Natalie', 'Portman', '1981-06-09'),
('Jack', 'Nicholson', '1937-04-22');

CREATE TABLE movie_actors (
    'movie_id' INT,
    'actor_id' INT,
    PRIMARY KEY (movie_id, actor_id),
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES actors(actor_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Example links
INSERT INTO movie_actors (movie_id, actor_id) VALUES
(1, 1),  -- Tom Hanks in Forrest Gump
(2, 2),  -- Meryl Streep in The Devil Wears Prada
(3, 5);  -- Natalie Portman in Black Swan