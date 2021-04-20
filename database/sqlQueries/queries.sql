--1. Select the cheapest drug (before discount)--
SELECT * FROM Product
ORDER BY p_price
LIMIT 1


--2. Select all customers who ordered Ibuprofen.--
SELECT DISTINCT Customer.*, Product.p_name
FROM Orders INNER JOIN Contains
ON Orders.o_id = Contains.o_id
INNER JOIN Product ON Product.p_id = Contains.p_id
INNER JOIN Customer ON Customer.c_id = Orders.c_id
WHERE Product.p_name = 'Ibuprofen'
ORDER BY c_id;

--3. Select all customers who live in Bakersfield.--
SELECT DISTINCT Customer.*
FROM Customer
WHERE 'Bakersfield' =
(
    SPLIT_PART(c_address,',', 2)
);


SELECT SPLIT_PART('40440 Annamark Way, Bakersfield, CA, 93311;',',', 1)  

--4. Select all employees making over $60,000.---
SELECT DISTINCT Employee.*
FROM Employee
WHERE Employee.e_salary > 60000
ORDER BY e_id;

--5. Select all drugs that are below 50 in quantity.--
SELECT DISTINCT Product.*
FROM Product
WHERE p_quantity < 50
ORDER BY p_id;

--6. Select drugs that cost over $90--
SELECT DISTINCT Product.*
FROM Product
WHERE p_price < 90
ORDER BY p_id;

--7. Select all customers whose doctor is John Dorian--
SELECT DISTINCT Customer.*
FROM Customer
WHERE Customer.c_doctor = 'John Dorian';
ORDER BY c_id;

--8. Select all customers who have a prescription--

--9. Select all customers with the first name Carl--
SELECT DISTINCT Customer.*
FROM Customer
WHERE Customer.c_fname = 'Carl';
ORDER BY c_id;

--10. Select all customers who made an order between 1-1-2019 and 1-1-2020--