<?php

namespace LinkedDataImporter\CustomerProvider;

use LinkedDataImporter\Contract\CustomerProviderInterface;
use LinkedDataImporter\DataStructure\CustomerList;
use LinkedDataImporter\Model\Customer;

/**
 * Simple data provider for debugging and testing
 */
class SimpleArrayCustomerProvider implements CustomerProviderInterface
{
    public function getCustomers(): CustomerList
    {
        return new CustomerList(
            new Customer(1,'email1','card1','phone1'),
            new Customer(2,'email1','card2','phone2'),
            new Customer(3,'email3','card3','phone3'),
            new Customer(4,'email4','card4','phone2')
        );
    }

    public function saveCustomers(CustomerList $customerList): void
    {
    }
}