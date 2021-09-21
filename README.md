# CustomerLinker

Just links customers from **"data/customer.csv"** into chains by their duplicate identifiers and saves result to **"data/duplicates_chain.csv"** :man_shrugging:

## Installation

Use docker-compose for deploying :call_me_hand:

```bash
docker-compose up -d
```

Put your CSV file to the "data" directory of the project.\
If you don't it will use test csv file.

## Usage

Run container's terminal like this:
```bash
docker exec -it inked-data-importer-php-app sh
```
And then run the application inside container like this:
```bash
php public/index.php
```
The result will be store at **"data/duplicates_chain.csv"**

## Requirements
Filename **customers.csv** is a MUST. :man_teacher:

Data format:\
ID,PARENT_ID,EMAIL,CARD,PHONE,TMP\
1,NULL,email1,card1,phone1,\
2,NULL,email1,card2,phone2,\
3,NULL,email3,card3,phone3,\
4,NULL,email4,card4,phone2,

Current data format is a MUST.