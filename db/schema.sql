
drop table if exists User;
drop table if exists Killed;

create table User(
  id integer primary key autoincrement,
  email text unique,
  password_digest text,
  salt text,
  dorm integer,
  alive boolean,
  image_filepath text,
  is_terminator boolean,
  target_id integer unique
);

create table Killed(
  assasin_id integer,
  target_id integer,
  termination boolean,
  time datetime,
  primary key (assasin_id, target_id)
);