DROP TABLE payments CASCADE CONSTRAINT;
CREATE TABLE payments (
	payment_id NUMBER(10) PRIMARY KEY,   
    order_id NUMBER(10) NOT NULL,
    transaction_id VARCHAR(225) NOT NULL,
    amount NUMBER(10) NOT NULL, 
    payment_fee NUMBER(10) NOT NULL, 
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY ( order_id) REFERENCES orders( order_id) ON DELETE CASCADE         
);

DROP SEQUENCE seq_payment_id;
CREATE SEQUENCE seq_payment_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_payments
BEFORE INSERT
ON payments
FOR EACH ROW
BEGIN
:new.payment_id:=seq_payment_id.nextval;
END;