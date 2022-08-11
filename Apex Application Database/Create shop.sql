DROP TABLE shop CASCADE CONSTRAINT;
CREATE TABLE shop (
    shop_id NUMBER(10),
    trader_reg_id NUMBER(10) NOT NULL,  
    shop_name VARCHAR(255) NOT NULL,    
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (trader_reg_id) REFERENCES trader_reg(trader_reg_id) 
    ON DELETE CASCADE
);

ALTER TABLE shop ADD CONSTRAINT pk_shop_id PRIMARY KEY (shop_id);

DROP SEQUENCE seq_shop_id;
CREATE SEQUENCE seq_shop_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_shop
BEFORE INSERT
ON shop
FOR EACH ROW
BEGIN
:new.shop_id:=seq_shop_id.nextval;
END;
