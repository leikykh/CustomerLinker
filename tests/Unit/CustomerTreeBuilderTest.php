<?php

namespace LinkedDataImporter\Tests\Unit;

use LinkedDataImporter\CustomerProvider\SimpleArrayCustomerProvider;
use LinkedDataImporter\CustomerChain\CustomerChainBuilder;
use PHPUnit\Framework\TestCase;

class CustomerTreeBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $simpleArrayCustomerProvider = new SimpleArrayCustomerProvider();

        $customerTreeBuilder = new CustomerChainBuilder();

        $customerList = $customerTreeBuilder->build($simpleArrayCustomerProvider->getCustomers());

        $expectedParentIds = [1 => 1, 2 => 1, 3 => 3, 4 => 1];

        foreach ($customerList->all() as $customer) {
            self::assertEquals($expectedParentIds[$customer->getId()], $customer->getParentId());
        }
    }
}