/** POSTGRESQL **/
CREATE TABLE users(
    id serial primary key,
    name varchar(20) not null,
    surname varchar(30) not null,
    email varchar(100) unique CHECK (email LIKE '%@%'), 
    login varchar(50) unique not null,
    password varchar(150) not null,
    type varchar(10) not null
);

/**hasło: kwakwa5!**/
INSERT INTO users(name, surname, email, login, password, type) VALUES
('Franek', 'Dolas', 'franekdolas@gmail.com', 'franuś', '$2y$10$5eshcEfZpwE9SvByYaD9j.Iy0C21tSS5rijvTYpAvXt.VJXLncjk.', 'admin'),
('Franek1', 'Dolas1', 'franekdolas1@gmail.com', 'franek', '$2y$10$5eshcEfZpwE9SvByYaD9j.Iy0C21tSS5rijvTYpAvXt.VJXLncjk.', 'user'),
('Franek2', 'Dolas2', 'franekdolas2@gmail.com', 'franek2', '$2y$10$5eshcEfZpwE9SvByYaD9j.Iy0C21tSS5rijvTYpAvXt.VJXLncjk.', 'user');


CREATE TABLE groups(
    id serial primary key,
    name varchar(50) not null,
    owner_id int not null,
    image_path varchar(100),
    description text,
    visibility varchar(50) not null
);

INSERT INTO groups(name, owner_id, image_path, description, visibility) VALUES
('Hajsownicy', 1, 'hajsownicy.png', '', 'public'),
('Matoły', 2, 'matoły.png', 'taka o grupa', 'only_members');

CREATE TABLE groups_members(
    id serial primary key,
    group_id int not null,
    user_id int not null,
    foreign key (user_id) references users(id),
    foreign key (group_id) references groups(id)
);

INSERT INTO groups_members(group_id, user_id) VALUES
(1, 2),
(2, 1);

CREATE TABLE user_profiles(
    id serial primary key,
    image_path varchar(50),
    description text,
    visibility varchar(50) not null,
    foreign key (id) references users(id)
);

INSERT INTO user_profiles(id, image_path, description, visibility) VALUES
(1, 'franek0.png', null, 'public'),
(2, 'franek1.png', 'taki profil se zrobilem', 'public'),
(3, 'franek2.png', 'profil', 'public');

CREATE TABLE posts(
    id serial primary key,
    user_id int not null,
    title varchar(50),
    content text not null,
    group_id int,
    visibility varchar(50) not null,
    time timestamp not null,
    foreign key (user_id) references users(id),
    foreign key (group_id) references groups(id)
);

CREATE OR REPLACE FUNCTION update_post_time()
RETURNS TRIGGER AS $$
BEGIN
    NEW.time = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_post_time_trigger
BEFORE INSERT ON posts
FOR EACH ROW
EXECUTE FUNCTION update_post_time();

INSERT INTO posts(user_id, title, content, group_id, visibility) VALUES
(1, null, 'zawartosc tresc posta', null, 'public'),
(1, 'tytuł', 'zawartosc', 1, 'public');

CREATE TABLE posts_images(
    id serial primary key,
    post_id int not null,
    image_path varchar(50),
    foreign key (post_id) references posts(id)
);

INSERT INTO posts_images(post_id, image_path) VALUES
(1, 'zdjecie.png'),
(1, 'zdjecie2.png'),
(1, 'zdjecie3.png');

CREATE TABLE comments(
    id serial primary key,
    user_id int not null,
    post_id int not null,
    content text,
    foreign key (user_id) references users(id),
    foreign key (post_id) references posts(id)
);

INSERT INTO comments(user_id, post_id, content) VALUES
(2, 1, 'komentarz'),
(3, 1, 'komentarz2');