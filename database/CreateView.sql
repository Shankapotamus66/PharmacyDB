CREATE OR REPLACE VIEW CustomerInfo
AS SELECT c_id AS ID, c_fname AS "First", c_lname AS "Last",
c_phonenum AS "Phone", c_email AS "Email", c_doctor AS "Doctor",
c_dob AS "DOB", c_address AS "Address"
FROM Customer;

--SELECT * FROM CustomerInfo;

CREATE OR REPLACE VIEW OrderInfo
AS SELECT Orders.c_id AS C_ID, Orders.o_id AS O_ID, Orders.o_shipdate AS O_SHIP, 
Customer.c_fname AS C_FNAME, Customer.c_lname As C_LNAME
FROM Orders, Customer
WHERE Orders.c_id = Customer.c_id;

--SELECT * FROM OrderInfo WHERE Orders.c_id = 5;

CREATE OR REPLACE VIEW OrderInfoAll
AS SELECT Orders.c_id AS C_ID, Orders.o_id AS O_ID, Orders.o_shipdate AS O_SHIP, 
Customer.c_fname AS C_FNAME, Customer.c_lname As C_LNAME, Product.p_name
FROM Orders, Customer, Product, Contains
WHERE Orders.c_id = Customer.c_id
    AND Contains.o_id = Orders.o_id
    AND Contains.p_id = Product.p_id;

--SELECT * FROM OrderInfoAll;
--SELECT * FROM OrderInfoAll ORDER BY o_id;