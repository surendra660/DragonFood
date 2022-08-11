DROP TABLE inquiry_reg CASCADE CONSTRAINT;
CREATE TABLE inquiry_reg (
    inquiry_reg_id NUMBER(10),
    inquiry_name VARCHAR2(255) NOT NULL,
    inquiry_mobile NUMBER(10) NOT NULL,
    inquiry_email VARCHAR2(255) NOT NULL,
    inquiry_reason VARCHAR2(255) NOT NULL,
    inquiry_message VARCHAR2(255) NOT NULL,
    inquiry_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE inquiry_reg ADD CONSTRAINT pk_inquiry_reg_id PRIMARY KEY (inquiry_reg_id);

DROP SEQUENCE seq_inquiry_reg_id;
CREATE SEQUENCE seq_inquiry_reg_id
START WITH 1 
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE OR REPLACE TRIGGER trg_inquiry_reg
BEFORE INSERT
ON inquiry_reg
FOR EACH ROW
BEGIN
:new.inquiry_reg_id:=seq_inquiry_reg_id.nextval;
END;