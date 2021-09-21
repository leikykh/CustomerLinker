<?php

namespace LinkedDataImporter\CustomerProvider;

use LinkedDataImporter\Contract\CustomerProviderInterface;
use LinkedDataImporter\DataStructure\CustomerList;
use LinkedDataImporter\Model\Customer;

/**
 * A very basic csv reader implementation
 * It doesn't have any data validation or errors handling
 * And it is also doesn't monitor any memory leaks
 * BE AWARE!
 */
class CsvCustomerProvider implements CustomerProviderInterface
{
    private const ID_FIELD_POSITION = 0;
    private const EMAIL_FIELD_POSITION = 2;
    private const CARD_FIELD_POSITION = 3;
    private const PHONE_FIELD_POSITION = 4;

    private const HEADER = "ID,PARENT_ID,EMAIL,CARD,PHONE";

    private string $filepath;
    private string $testFilepath;
    private string $duplicateChainsFilepath;

    public function __construct(string $filepath = '')
    {
        $this->filepath = $filepath;
        $this->testFilepath = dirname(__DIR__) . '/../data/test_customers.csv';
        $this->duplicateChainsFilepath = dirname(__DIR__) . '/../data/duplicates_chain.csv';
    }

    public function getCustomers(): CustomerList
    {
        $csvCustomers = @file_get_contents($this->filepath);
        if (!$csvCustomers || empty($csvCustomers)) {
            $csvCustomers = file_get_contents($this->testFilepath);
        }

        $csvCustomers = explode("\n", $csvCustomers);

        // unset header
        unset($csvCustomers[0]);

        $customerList = new CustomerList();
        foreach ($csvCustomers as $csvCustomer) {
            if (empty($csvCustomer)) {
                continue;
            }

            $csvCustomer = explode(',', $csvCustomer);

            $customer = new Customer(
                $csvCustomer[self::ID_FIELD_POSITION],
                $csvCustomer[self::EMAIL_FIELD_POSITION],
                $csvCustomer[self::CARD_FIELD_POSITION],
                $csvCustomer[self::PHONE_FIELD_POSITION]
            );

            $customerList->add($customer);
        }

        return $customerList;
    }

    public function saveCustomers(CustomerList $customerList): void
    {
        $customers = [];
        foreach ($customerList->all() as $customer) {
            $customers[] = implode(',', array_values($customer->toArray()));
        }

        $customers = implode("\n", $customers);
        $csv = self::HEADER . "\n" . $customers;

        file_put_contents($this->duplicateChainsFilepath, $csv);
    }
}