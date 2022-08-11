DROP TABLE products CASCADE CONSTRAINT;
CREATE TABLE products (
	product_id NUMBER(10) PRIMARY KEY,
    trader_reg_id NUMBER(10) NOT NULL,
    shop_id NUMBER(10) NOT NULL,
    category_id NUMBER(10) NOT NULL,    
    product_title VARCHAR2(255) NOT NULL,
    product_desc VARCHAR2(255) NOT NULL,    
	product_price NUMBER(10, 2) NOT NULL,
    product_qty NUMBER(10) NOT NULL,
    product_img1 VARCHAR2(255) NOT NULL,
    product_img2 VARCHAR2(255) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (trader_reg_id) REFERENCES trader_reg(trader_reg_id) ON DELETE CASCADE,
    FOREIGN KEY (shop_id) REFERENCES shop(shop_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE CASCADE    
);


DROP SEQUENCE seq_product_id;
CREATE SEQUENCE seq_product_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;


CREATE OR REPLACE TRIGGER trg_products
BEFORE INSERT
ON products
FOR EACH ROW
BEGIN
:new.product_id:=seq_product_id.nextval;
END;