DROP TABLE timeslots CASCADE CONSTRAINT;
CREATE TABLE timeslots (
    slot_id NUMBER(10) PRIMARY KEY,
    slot_name VARCHAR2(255) NOT NULL   
);
