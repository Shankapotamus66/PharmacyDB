# PharmacyDB
CMPS 3420 - Pharmacy Database Source

This database uses the PostgreSQL relational database management system (RDBMS) to create, load and query the data. This database keeps track of entities such as customers, employees, suppliers, and insurances. The idea is to allow of the tracking of purchases/sells made from an online pharmacy where customers can purchase medicine.

**Requirments**
- PostgreSQL

**How to Setup:**
Log into the postgres user.   
***Note: all commands listed are for Ubuntu/Debian machines***  
If signed in as super user you can use this command,
```
sudo -u postgres psql
```
Now you are logged into the PostgreSQL server you need to create the database and postgres user.
You will be doing this by executing the 'CreateDB.sql' file, to do this use the following command:
```
\i CreateDB.sql
```
This will create:

    Database: pharmacydb
    Postgres User: pharmacy
    
Now the database and postgres user should have been created, you can see this by using ```\l``` command in the PostgreSQL server terminal.    
Once, you verified this as true, quit out of PostgreSQL server (```\q```) and sign as the **pharmacy** user, if you have a user named this on your machine you can switch to this user or use:
```
sudo -u pharmacy psql
```
And this will sign you in on the PostgreSQL server as the pharmacy postgres user.

Now we will be adding the tables to the database, to do this you need to execute 'CreateTables.sql' file, to do so run the following command:
```
\i CreateTables.sql
```
Then you can insert the data into these tables by executing the 'insert_Data.sql' file, to do so run the following command:
```
\i insert_Data.sql
```
