CREATE TABLE sso_users (
sso_user_id int(11) NOT NULL auto_increment,
sso_username varchar(20) NOT NULL,
sso_password char(40) NOT NULL,
PRIMARY KEY (sso_user_id),
UNIQUE KEY sso_username (sso_username)
);