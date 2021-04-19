CREATE USER pharmacy SUPERUSER PASSWORD 'CMPS3420';  -- create a role.

CREATE DATABASE pharmacydb
     WITH OWNER = pharmacy
     ENCODING = 'UTF8'
     --LC_COLLATE = 'en_US.UTF-8'
     --LC_CTYPE = 'en_US.UTF-8'
     CONNECTION LIMIT = -1;