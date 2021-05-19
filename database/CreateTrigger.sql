CREATE FUNCTION deleteOrders() RETURNS TRIGGER AS $_$
BEGIN
    DELETE FROM Orders
    WHERE NOT EXISTS (
        SELECT *
        FROM Customer
        WHERE Orders.c_id = Customer.c_id
    );
    RETURN NULL;
END;
$_$ LANGUAGE plpgsql;
CREATE TRIGGER customer_delete
AFTER DELETE ON customer
FOR EACH ROW
EXECUTE PROCEDURE deleteOrders();