## **XSLT and CSV Exercise**

One of the contracts finder sources of contract notices did not have full preview of the Contract notices_2020.xml which were given to the users as notices_2020.csv.

For that reason the Classification Procurement Vocabulary Code had to be analysed to form the CSV file format.

## **How to Transform the Existing XML File**

```bash

cd xslt/processor
php xslt_processor.php 

```

## **How to convert the XML file to CSV file**

```bash

cd csv/processor
php csv_processor.php

```

## **How to conduct a test using XPath**

```bash

cd csv/xpath
php xpath.php

```

