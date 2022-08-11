DROP TABLE customer_reg CASCADE CONSTRAINT;
CREATE TABLE customer_reg (
    customer_reg_id NUMBER(10),
    customer_fname VARCHAR2(255) NOT NULL,
    customer_lname VARCHAR2(255) NOT NULL,
    customer_username VARCHAR2(255) NOT NULL,
    customer_email VARCHAR2(255) NOT NULL,
    customer_password VARCHAR2(255) NOT NULL,
    customer_dob DATE NOT NULL,
    customer_gender VARCHAR(255) NOT NULL,
    status NUMBER(1) DEFAULT 0 NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

ALTER TABLE customer_reg ADD CONSTRAINT pk_customer_reg_id PRIMARY KEY (customer_reg_id);

DROP SEQUENCE seq_customer_reg_id;
CREATE SEQUENCE seq_customer_reg_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_customer_reg
BEFORE INSERT
ON customer_reg
FOR EACH ROW
BEGIN
:new.customer_reg_id:=seq_customer_reg_id.nextval;
END;