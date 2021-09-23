<?php

use LinkedDataImporter\CustomerChain\CustomerChainBuilder;
use LinkedDataImporter\CustomerProvider\CsvCustomerProvider;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$customerProvider = new CsvCustomerProvider(dirname(__DIR__) . '/data/customers.csv');
$customerTreeBuilder = new CustomerChainBuilder();

$customerList = $customerProvider->getCustomers();
$customerList = $customerTreeBuilder->build($customerList);
$customerProvider->saveCustomers($customerList);