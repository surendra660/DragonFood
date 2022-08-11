DROP TABLE category CASCADE CONSTRAINT;
CREATE TABLE category (
    category_id NUMBER(10) NOT NULL,
    category_name VARCHAR(255) NOT NULL    
);

ALTER TABLE category ADD CONSTRAINT pk_category_id PRIMARY KEY (category_id);
