DROP TABLE order_product CASCADE CONSTRAINT;
CREATE TABLE order_product (
	order_id NUMBER(10) NOT NULL, 
    product_id NUMBER(10) NOT NULL,
    quantity NUMBER(10) NOT NULL,    
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE 
);

