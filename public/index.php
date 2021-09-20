<?php

use LinkedDataImporter\CustomerProvider\SimpleArrayCustomerProvider;
use LinkedDataImporter\CustomerTree\CustomerTreeBuilder;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$customerProvider = new SimpleArrayCustomerProvider();
$customerTreeBuilder = new CustomerTreeBuilder();

$customerList = $customerProvider->getCustomers();
$customerList = $customerTreeBuilder->build($customerList);
$customerProvider->saveCustomers($customerList);