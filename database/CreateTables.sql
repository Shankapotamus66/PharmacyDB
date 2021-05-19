----------Customer----------
CREATE TABLE IF NOT EXISTS Customer
(
    c_id SERIAL NOT NULL,
    c_fname character varying(256) COLLATE pg_catalog."default" NOT NULL,
    c_lname character varying(256) COLLATE pg_catalog."default" NOT NULL,
    c_phoneNum character varying(256) NOT NULL,
    c_email character varying(256) COLLATE pg_catalog."default" NOT NULL,
    c_password character varying(256) COLLATE pg_catalog."default" NOT NULL,
    c_doctor character varying(256) COLLATE pg_catalog."default",
    c_dob character varying(256) COLLATE pg_catalog."default" NOT NULL,
    c_address character varying(256) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT Customer_pkey PRIMARY KEY (c_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Customer
    OWNER to pharmacy;

----------Employee----------
CREATE TABLE IF NOT EXISTS Employee
(
    e_id SERIAL NOT NULL,
    e_fname character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_lname character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_salary integer NOT NULL,
    e_position character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_snn character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_address character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_email character varying(256) COLLATE pg_catalog."default" NOT NULL,
    e_password character varying(256) COLLATE pg_catalog."default" NOT NULL,

    CONSTRAINT Employee_pkey PRIMARY KEY (e_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Employee
    OWNER to pharmacy;

----------Product----------
CREATE TABLE IF NOT EXISTS Product
(
    p_id SERIAL NOT NULL,
    p_price integer NOT NULL,
    p_name text NOT NULL,
    p_supplier character varying(256) COLLATE pg_catalog."default" NOT NULL,
    p_quantity integer NOT NULL,
    p_PrescriptionNeeded boolean NOT NULL,
    
    CONSTRAINT Product_pkey PRIMARY KEY (p_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Product
    OWNER to pharmacy;

----------Insurance----------
CREATE TABLE IF NOT EXISTS Insurance
(
    i_id SERIAL NOT NULL,
    i_name character varying(256) COLLATE pg_catalog."default" NOT NULL,
    i_discount integer,
    
    CONSTRAINT Insurance_pkey PRIMARY KEY (i_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Insurance
    OWNER to pharmacy;

----------Supplier----------
CREATE TABLE IF NOT EXISTS Supplier
(
    s_id SERIAL NOT NULL,
    s_name character varying(256) COLLATE pg_catalog."default" NOT NULL,
    
    CONSTRAINT Supplier_pkey PRIMARY KEY (s_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Supplier
    OWNER to pharmacy;

----------Orders----------
CREATE TABLE IF NOT EXISTS Orders
(
    c_id integer NOT NULL,
    o_id SERIAL NOT NULL,
    o_shipDate date NOT NULL,
    
    CONSTRAINT Order_pkey PRIMARY KEY (o_id),
    CONSTRAINT c_id FOREIGN KEY (c_id)
    REFERENCES Customer(c_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Orders
    OWNER to pharmacy;


----------Discounts----------
CREATE TABLE IF NOT EXISTS Discounts
(
    i_id integer NOT NULL,
    p_id integer NOT NULL,
    d_discount integer, 
    
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id),
    CONSTRAINT i_id FOREIGN KEY (i_id)
    REFERENCES Insurance(i_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Discounts
    OWNER to pharmacy;

----------Presciption----------
CREATE TABLE IF NOT EXISTS Prescription
(
    p_id integer NOT NULL,
    c_id integer NOT NULL,
    pre_doctorName character varying(256) COLLATE pg_catalog."default" NOT NULL,
    pre_lastFilled date NOT NULL,
    pre_refill integer NOT NULL,
    
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id),
    CONSTRAINT c_id FOREIGN KEY (c_id)
    REFERENCES Customer(c_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Prescription
    OWNER to pharmacy;

----------Contains----------
CREATE TABLE IF NOT EXISTS Contains
(
    o_id integer NOT NULL,
    p_id integer NOT NULL,
    p_quantity integer NOT NULL,
    
    CONSTRAINT o_id FOREIGN KEY (o_id)
    REFERENCES Orders(o_id),
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Contains
    OWNER to pharmacy;

----------Restocks----------
CREATE TABLE IF NOT EXISTS Restocks
(
    e_id integer NOT NULL,
    p_id integer NOT NULL,
    restock_date date NOT NULL,
    
    CONSTRAINT e_id FOREIGN KEY (e_id)
    REFERENCES Employee(e_id),
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Restocks
    OWNER to pharmacy;

----------OrdersFrom----------
CREATE TABLE IF NOT EXISTS OrdersFrom
(
    e_id integer NOT NULL,
    s_id integer NOT NULL,
    order_date date NOT NULL,
    
    CONSTRAINT e_id FOREIGN KEY (e_id)
    REFERENCES Employee(e_id),
    CONSTRAINT s_id FOREIGN KEY (s_id)
    REFERENCES Supplier(s_id)
)

    TABLESPACE pg_default;

    ALTER TABLE OrdersFrom
    OWNER to pharmacy;

----------Covers----------
CREATE TABLE IF NOT EXISTS Covers
(
    c_id integer NOT NULL,
    i_id integer NOT NULL,
    
    CONSTRAINT c_id FOREIGN KEY (c_id)
    REFERENCES Customer(c_id),
    CONSTRAINT i_id FOREIGN KEY (i_id)
    REFERENCES Insurance(i_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Covers
    OWNER to pharmacy;

----------Ships----------
CREATE TABLE IF NOT EXISTS Ships
(
    e_id integer NOT NULL,
    p_id integer NOT NULL,
    ship_date date NOT NULL,
    
    CONSTRAINT e_id FOREIGN KEY (e_id)
    REFERENCES Employee(e_id),
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Ships
    OWNER to pharmacy;

----------Provides----------
CREATE TABLE IF NOT EXISTS Provides
(
    s_id integer NOT NULL,
    p_id integer NOT NULL,
    provide_date date NOT NULL,
    
    CONSTRAINT s_id FOREIGN KEY (s_id)
    REFERENCES Supplier(s_id),
    CONSTRAINT p_id FOREIGN KEY (p_id)
    REFERENCES Product(p_id)
)

    TABLESPACE pg_default;

    ALTER TABLE Provides
    OWNER to pharmacy;
