CREATE TABLE change_password (id  BIGSERIAL NOT NULL, userid int8 NOT NULL, "key" text DEFAULT trunc((random() * (10000000000::bigint)::double precision)) NOT NULL, active bool DEFAULT 'true' NOT NULL, created_at date DEFAULT NOW() NOT NULL, PRIMARY KEY (id));
CREATE TABLE allow (id  BIGSERIAL NOT NULL, controller_actionid int8 NOT NULL, roleid int8, PRIMARY KEY (id));
CREATE TABLE user_role (id  BIGSERIAL NOT NULL, roleid int8, userid int8, PRIMARY KEY (id));
CREATE TABLE account (id  BIGSERIAL NOT NULL, fullname varchar(255) NOT NULL, email varchar(255) NOT NULL UNIQUE, password varchar(255) NOT NULL, photo varchar(255) DEFAULT '/images/users_photo/default.gif' NOT NULL, created_at date DEFAULT NOW () NOT NULL, active bool DEFAULT 'false' NOT NULL, PRIMARY KEY (id));
CREATE TABLE role (id  BIGSERIAL NOT NULL, tag varchar(255) NOT NULL UNIQUE, description varchar(255) NOT NULL, PRIMARY KEY (id));
CREATE TABLE controller_action (id  BIGSERIAL NOT NULL, controller varchar(255) NOT NULL, action varchar(255) NOT NULL, description varchar(255) NOT NULL, PRIMARY KEY (id));
ALTER TABLE allow ADD CONSTRAINT FKallow274 FOREIGN KEY (roleid) REFERENCES role (id);
ALTER TABLE allow ADD CONSTRAINT FKallow725469 FOREIGN KEY (controller_actionid) REFERENCES controller_action (id);
ALTER TABLE user_role ADD CONSTRAINT FKuser_role432826 FOREIGN KEY (roleid) REFERENCES role (id);
ALTER TABLE user_role ADD CONSTRAINT FKuser_role954230 FOREIGN KEY (userid) REFERENCES "user" (id);
ALTER TABLE change_password ADD CONSTRAINT FKchange_pas155625 FOREIGN KEY (userid) REFERENCES "user" (id);

