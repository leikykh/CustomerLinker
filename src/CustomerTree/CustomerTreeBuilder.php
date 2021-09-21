<?php

namespace LinkedDataImporter\CustomerTree;

use LinkedDataImporter\DataStructure\CustomerList;
use LinkedDataImporter\Model\Customer;

/**
 * Directly solves the task - builds chains of duplicates
 */
class CustomerTreeBuilder
{
    private array $parentsState;

    public function __construct()
    {
        $this->defaultParentsState();
    }

    public function build(CustomerList $customerList): CustomerList
    {
        $customerList->sort();

        foreach ($customerList->all() as $customer) {
            $this->setParent($customer);
            $this->updateParentsState($customer);
        }

        $this->defaultParentsState();

        return $customerList;
    }

    private function setParent(Customer $customer): void
    {
        $parent = $this->parentsState['email'][$customer->getEmail()] ??
            $this->parentsState['card'][$customer->getCard()] ??
            $this->parentsState['phone'][$customer->getPhone()] ??
            null;

        if (!is_null($parent)) {
            $customer->setParentId($parent->getParentId());
            return;
        }

        $customer->setParentId($customer->getId());
    }

    private function updateParentsState(Customer $customer): void
    {
        if (!isset($this->parentsState['email'][$customer->getEmail()])) {
            $this->parentsState['email'][$customer->getEmail()] = $customer;
        }
        if (!isset($this->parentsState['card'][$customer->getCard()])) {
            $this->parentsState['card'][$customer->getCard()] = $customer;
        }
        if (!isset($this->parentsState['phone'][$customer->getPhone()])) {
            $this->parentsState['phone'][$customer->getPhone()] = $customer;
        }
    }

    private function defaultParentsState(): void
    {
        $this->parentsState = [
            'email' => [],
            'card' => [],
            'phone' => []
        ];
    }
}