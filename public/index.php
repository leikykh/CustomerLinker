<?php

use LinkedDataImporter\CustomerProvider\CsvCustomerProvider;
use LinkedDataImporter\CustomerTree\CustomerTreeBuilder;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$customerProvider = new CsvCustomerProvider(dirname(__DIR__) . '/data/customers.csv');
$customerTreeBuilder = new CustomerTreeBuilder();

$customerList = $customerProvider->getCustomers();
$customerList = $customerTreeBuilder->build($customerList);
$customerProvider->saveCustomers($customerList);