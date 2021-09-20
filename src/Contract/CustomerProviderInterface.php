<?php

namespace LinkedDataImporter\Contract;

use LinkedDataImporter\DataStructure\CustomerList;

interface CustomerProviderInterface
{
    public function getCustomers(): CustomerList;
    public function saveCustomers(CustomerList $customerList): void;
}