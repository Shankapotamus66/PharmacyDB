import csv
import os

# Author: Andrew Mccuan
# Date: 4/18/20
#
# This pythong script converts .csv (Comma-Separated Values) files filled with mock data
# into from sources like https://mockaroo.com/ to .sql inserts.
#
# File format:
# First Row of CSV should contain the attributes with the exact names as they appear in the table.
# Following Rows will contain data for each attribute.

#Set the directory of .csv location
#Set the directory of .sql location
#Grab filenames from a directory and store into a list
csvDirectory = "csvFiles/"
sqlDirectory = "database/mockdata/"
entries = os.listdir(csvDirectory)

# Only read in .csv, prevent the breaking of writing to sql files.
notAllowed = []
for i in range(len(entries)):
    if ".csv" not in entries[i]:
        notAllowed.append(entries[i])
#print("Before .csv check: {0}".format(entries))
#print("NotAllowed: {0}".format(notAllowed))
for i in range(len(notAllowed)):
    entries.remove(notAllowed[i])
#print("After .csv check: {0}".format(entries))

# Read file by file listed in entries
# This will open and create a sql for each .csv files
# Note: it uses the name of the .csv file.

for files in range(len(entries)):
    tableName = entries[files]
    print(tableName[:-4])
    # Opening .csv with encoding='utf-8-sig' to remove the "ï»¿" bug
    # https://stackoverflow.com/questions/34399172/why-does-my-python-code-print-the-extra-characters-%C3%AF-when-reading-from-a-tex/34399309
    with open(csvDirectory + tableName, encoding='utf-8-sig') as csvinput:
        reader = csv.reader(csvinput)
        with open(sqlDirectory + "create_{0}.sql".format(tableName[:-4]), 'w') as sqloutput:
            firstLine = True
            for row in reader:
                if firstLine:
                    #Grab the first row that contains the attribute names and join them with a ", " seperation.
                    firstLine = False
                    #print(row)
                    #print(", ".join(row))
                    attributes = ", ".join(row)
                    print("attributes: {0}".format(attributes))
                else:
                    #print(row)
                    #Grab current row that contains the attributes and join them with a ", " seperation.
                    for i in range(len(row)):
                        if row[i].isnumeric() == False:
                            row[i] = "\'"+ row[i] + "\'"
                    values = ", ".join(row)
                    print("INSERT INTO {0} ({1}) VALUES ({2});".format(tableName[:-4], attributes, values))
                    sqloutput.write("INSERT INTO {0} ({1}) VALUES ({2});\n".format(tableName[:-4], attributes, values))
