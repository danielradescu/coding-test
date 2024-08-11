<?php

namespace Tests\Unit\Domain\Service;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use DiscountAPI\Domain\Service\CustomerService;
use DiscountAPI\Domain\Repository\CustomerRepositoryInterface;
use DiscountAPI\Domain\Entity\Customer;
use RuntimeException;

class CustomerServiceTest extends TestCase
{
    /**
     * @throws Exception|\Exception
     */
    public function testGetCustomerById()
    {
        $customer = new Customer("1", "John Doe", "2022-01-01", 1500);

        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository->method('findById')
            ->willReturn($customer);

        $service = new CustomerService($repository);
        $result = $service->getCustomerById("1");

        $this->assertInstanceOf(Customer::class, $result);
        $this->assertEquals("John Doe", $result->getName());
    }

    /**
     * @throws \Exception|Exception
     */
    public function testGetCustomerByIdNotFound()
    {
        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository->method('findById')
            ->willReturn(null);

        $service = new CustomerService($repository);

        $this->expectException(\Exception::class);
        $service->getCustomerById("1");
    }
}