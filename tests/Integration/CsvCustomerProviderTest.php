<?php

namespace LinkedDataImporter\Tests\Integration;

use LinkedDataImporter\CustomerProvider\CsvCustomerProvider;
use LinkedDataImporter\CustomerProvider\SimpleArrayCustomerProvider;
use PHPUnit\Framework\TestCase;

class CsvCustomerProviderTest extends TestCase
{
    private CsvCustomerProvider $csvCustomerProvider;
    private SimpleArrayCustomerProvider $simpleArrayCustomerProvider;
    private string $resultFilepath;

    public function setUp(): void
    {
        $this->csvCustomerProvider = new CsvCustomerProvider();
        $this->simpleArrayCustomerProvider = new SimpleArrayCustomerProvider();
        $this->resultFilepath = dirname(__DIR__) . '/../data/duplicates_chain.csv';

        $this->unlinkResultFile();
    }

    public function testGetTestCustomers(): void
    {
        $expected = $this->simpleArrayCustomerProvider->getCustomers();
        $actual = $this->csvCustomerProvider->getCustomers();

        self::assertEquals($expected, $actual);
    }

    public function testSaveCustomers(): void
    {
        $customers = $this->simpleArrayCustomerProvider->getCustomers();
        $this->csvCustomerProvider->saveCustomers($customers);

        self::assertFileExists($this->resultFilepath);

        $expected = "ID,PARENT_ID,EMAIL,CARD,PHONE\n1,,email1,card1,phone1\n2,,email1,card2,phone2\n3,,email3,card3,phone3\n4,,email4,card4,phone2";
        $actual = file_get_contents($this->resultFilepath);

        self::assertEquals($expected, $actual);
    }

    public function tearDown(): void
    {
        $this->unlinkResultFile();
    }

    private function unlinkResultFile(): void
    {
        if (file_exists($this->resultFilepath)) {
            unlink($this->resultFilepath);
        }
    }
}