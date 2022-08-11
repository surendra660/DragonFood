DROP TABLE admin_login CASCADE CONSTRAINT;
CREATE TABLE admin_login (
    admin_id NUMBER(10) NOT NULL,
    admin_username VARCHAR(255) NOT NULL,
    admin_password VARCHAR(255) NOT NULL
);

ALTER TABLE admin_login ADD CONSTRAINT pk_admin_id PRIMARY KEY (admin_id);