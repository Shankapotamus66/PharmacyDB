--1. Select the cheapest drug (before discount)--
SELECT * FROM Product
ORDER BY p_price
LIMIT 1;


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
WHERE ' Bakersfield' =
(
    SPLIT_PART(c_address,',', 2)
);

--Example how the SPLIT_PART Works--
--SELECT SPLIT_PART('40440 Annamark Way, Bakersfield, CA, 93311;',',', 1)  

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
WHERE Customer.c_doctor = 'John Dorian'
ORDER BY c_id;

--8. Select all customers who have a prescription of Lidocaine Hydrochloride--
SELECT DISTINCT Customer.*
FROM Prescription INNER JOIN Product
    ON Prescription.p_id = Product.p_id
    INNER JOIN Customer ON Customer.c_id = Prescription.c_id
WHERE p_name = 'Lidocaine Hydrochloride';


--9. Select all customers with the first name Carl--
SELECT DISTINCT Customer.*
FROM Customer
WHERE Customer.c_fname = 'Carl'
ORDER BY c_id;

--10. Select all customers who made an order between 1-1-2019 and 1-1-2020--
SELECT DISTINCT Customer.*
FROM Orders INNER JOIN Customer
    ON Orders.c_id = Customer.c_id
WHERE Orders.o_shipdate >= '2019-01-01 00:00'
    AND Orders.o_shipdate < '2020-01-01 00:00'
ORDER BY c_id;
--this shows the shipping dates but won't be distinct customers
SELECT DISTINCT Customer.*, Orders.o_shipdate
FROM Orders INNER JOIN Customer
ON Orders.c_id = Customer.c_id
WHERE Orders.o_shipdate >= '2019-01-01 00:00'
AND Orders.o_shipdate < '2019-01-01 00:00'
ORDER BY c_id;

SELECT customer.* FROM orders INNER JOIN
customer ON orders.c_id=customer.c_id WHERE 
orders.o_shipdate >= '2019-01-01'
AND orders.o_shipdate < '2020-01-01';

--11. Select suppliers that every employee has ordered from.--
SELECT e.*
FROM Employee e
JOIN (
    SELECT e_id
    FROM OrdersFrom
    GROUP BY e_id
    HAVING COUNT(distinct s_id) = (SELECT COUNT(*) FROM Supplier)
) s ON e.e_id = s.e_id


select c.Customer_Name
from Customer c
join (  select Customer_No
        from DVD_Purchase
        group by Customer_No
        having count(distinct DVD_No) = (select count(*) from DVD)
) d on c.Customer_No = d.Customer_No


SELECT DISTINCT Supplier.s_id
FROM Supplier
JOIN ( SELECT E
    
)
Supplier s
    ON of.s_id = s.s_id;
WHERE s.

select pur.cid
from purchases pur
join products pro
 on pur.pid = pro.pid
where pro.original_price > 200
 and month(pur.ptime) =  10
group by pur.cid;