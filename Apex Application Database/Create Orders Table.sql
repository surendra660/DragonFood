DROP TABLE orders CASCADE CONSTRAINT;
CREATE TABLE orders (
	order_id NUMBER(10) PRIMARY KEY,   
    customer_reg_id NUMBER(10) NOT NULL,
    slot_id NUMBER(10) NOT NULL,    
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (customer_reg_id) REFERENCES customer_reg(customer_reg_id) ON DELETE CASCADE,
    FOREIGN KEY (slot_id) REFERENCES timeslots(slot_id) ON DELETE CASCADE
       
);

DROP SEQUENCE seq_order_id;
CREATE SEQUENCE seq_order_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_orders
BEFORE INSERT
ON orders
FOR EACH ROW
BEGIN
:new.order_id:=seq_order_id.nextval;
END;