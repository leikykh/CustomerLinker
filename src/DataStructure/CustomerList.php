<?php

namespace LinkedDataImporter\DataStructure;

use LinkedDataImporter\Model\Customer;

/**
 * Simple List implementation
 * Designed to facilitate contract compliance and simplify data handling
 */
class CustomerList
{
    private array $list;

    public function __construct(Customer ...$customers)
    {
        $this->list = $customers;
    }

    public function add(Customer $customer): self
    {
        $this->list[] = $customer;

        return $this;
    }

    public function all(): array
    {
        return $this->list;
    }

    public function sort(): self
    {
        $list = $this->list;

        usort($list, static function(Customer $first, Customer $second){
            return $first->getId() > $second->getId();
        });

        $this->list = $list;

        return $this;
    }
}