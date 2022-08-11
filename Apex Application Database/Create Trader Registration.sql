DROP TABLE trader_reg CASCADE CONSTRAINT;
CREATE TABLE trader_reg (
    trader_reg_id NUMBER(10),
    trader_username VARCHAR2(255) NOT NULL,
    trader_password VARCHAR2(255) NOT NULL,
    contact_name VARCHAR2(255) NOT NULL,    
    contact_email VARCHAR2(255) NOT NULL,
    contact_number NUMBER(10) NOT NULL,   
    trader_street VARCHAR2(255) NOT NULL,
    trader_district VARCHAR2(255) NOT NULL,
    trader_city VARCHAR2(255) NOT NULL,
    trader_province NUMBER(10) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

ALTER TABLE trader_reg ADD CONSTRAINT pk_trader_reg_id PRIMARY KEY (trader_reg_id);

DROP SEQUENCE seq_trader_reg_id;
CREATE SEQUENCE seq_trader_reg_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_trader_reg
BEFORE INSERT
ON trader_reg
FOR EACH ROW
BEGIN
:new.trader_reg_id:=seq_trader_reg_id.nextval;
END;

