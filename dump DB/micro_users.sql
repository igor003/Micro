CREATE TABLE micro.users
(
    id int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    remember_token varchar(100),
    created_at timestamp,
    updated_at timestamp
);
CREATE UNIQUE INDEX users_email_unique ON micro.users (email);
INSERT INTO micro.users (id, name, email, password, remember_token, created_at, updated_at) VALUES (1, 'igor003', 'igorio6ka1995@gmail.com', '$2y$10$h.VaZX2Qp3Nae4910jk78Oxk7QiWgLqkNibLi1aYgDE/PON0SWuw.', 'cIvOG2Usu4EXmca7pt08OSLsLC8IS5jxr0Xq0f0f4vlswQHPmMSJSAsi73Rn', '2018-06-09 18:45:04', '2018-06-09 18:45:04');