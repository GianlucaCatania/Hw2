Create DATABASE hw2;
USE hw2;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    name varchar(255) not null,
    surname varchar(255) not null
);

CREATE TABLE products (
    id integer primary key auto_increment,
    category varchar(255) not null,
    name varchar(255) not null,
    image varchar(255) not null,
    macro varchar(255) not null,
    price double not null
);

INSERT INTO products (category, name, image, macro, price) VALUES
('menu', 'Box Meal', 'img/box_meal.png', 'hamburger', 8.99),
('menu', 'Bucket', 'img/bucket.png', 'chicken', 16.99),
('menu', 'Double Kentucky BBQ', 'img/double_kentucky_bbq.png', 'hamburger', 7.59),
('menu', 'Snack Box', 'img/snack_box.png', 'chips', 4.59),
('menu', 'Twister', 'img/twister.png', 'kebab', 6.59),
('snack', 'Chips', 'img/chips.png', 'chips', 2.59),
('snack', 'Sundae', 'img/sundae.png', 'ice-cream', 2.59),
('drink', 'Acqua', 'img/water.png', 'water', 1.59),
('drink', 'Redbull', 'img/redbull.png', 'cola', 3.09),
('drink', 'Coffee', 'img/coffee.png', 'coffee', 1.29),
('extra', 'Maionese', 'img/maionese.png', 'sauce', 0.59),
('extra', 'Winx Drink', 'img/winx.png', 'yogurt', 2.09),
('extra', 'Nesquick', 'img/nesquick.png', 'chocolate', 2.09);

CREATE TABLE cart (
    id integer primary key auto_increment,
    user_id integer not null,
    product_id integer not null,
    quantita integer,
    ordinato boolean,

    foreign key (user_id) references users(id),
    foreign key (product_id) references products(id)
);