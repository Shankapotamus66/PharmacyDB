CREATE OR REPLACE FUNCTION RegisterCustomer(
    fname character varying(20),
    lname character varying(20),
    phoneNum character varying(15),
    email character varying(50),
    cpassword character varying(32),
    doctor character varying(50),
    dob character varying(10),
    caddress character varying(50)
)
RETURNS VOID AS
    $BODY$
        DECLARE 
            useremailCount integer;
        BEGIN
            SELECT COUNT(*) INTO useremailCount
            From Customer
            WHERE c_email = email;

            IF useremailCount = 0 THEN
                INSERT INTO Customer (c_id, c_fname, c_lname, c_phonenum, c_email, c_password, c_doctor, c_dob, c_address) VALUES (DEFAULT, fname, lname, phoneNum, email, cpassword, doctor, dob, caddress);
            END IF;
        END;
    $BODY$ LANGUAGE plpgsql;
--Test insert function here
--\df
--SELECT RegisterCustomer('TEST_ACCOUNT', 'TEST_ACC_LAST', '661-661-9867', 'test_account@testing.com', 'testpass', 'John Dorian', '04-29-99', '123 Sunnyville, Bakersfield, CA, 93311');
--SELECT RegisterCustomer('Drew', 'NewUser', '123-456-7890', 'drewtest@test.com', 'test', 'John Dorian', '04-29-99', '123 Sunnyville, Bakersfield, CA, 93311');

CREATE OR REPLACE FUNCTION deleteCustomer(
    id integer
)
RETURNS VOID AS
    $BODY$
        BEGIN
            DELETE FROM Customer
            WHERE c_id = id;
        END;
    $BODY$ LANGUAGE plpgsql; 


CREATE OR REPLACE FUNCTION deleteCustomerTest(
    email character varying(256)
)
RETURNS VOID AS
    $BODY$
        BEGIN
            DELETE FROM Customer
            WHERE c_email = email;
        END;
    $BODY$ LANGUAGE plpgsql; 

--SELECT deleteCustomer('id');

CREATE OR REPLACE FUNCTION getOrdersByDate(
    datefrom date,
    dateto date
)
RETURNS TABLE (
    c_id integer,
    c_fname character varying(256),
    c_lname character varying(256),
    o_id integer,
    o_shipdate date
)
AS  $BODY$
        SELECT Customer.c_id, Customer.c_fname, Customer.c_lname, Orders.o_id, Orders.o_shipdate
        FROM Orders INNER JOIN Customer
            ON Orders.c_id = Customer.c_id
        WHERE Orders.o_shipdate >= datefrom
            AND Orders.o_shipdate <= dateto;
    $BODY$ LANGUAGE sql;    

--SELECT getOrdersByDate('2020-01-01', '2021-05-19');