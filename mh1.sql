

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique
);

create table post(
    id INTEGER primary key AUTO_INCREMENT,
    author INTEGER,
    title VARCHAR(40),
    contenuto TEXT,
    FOREIGN KEY (author) REFERENCES users(id)
);