<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Application\Exception\UnprocessableEntityException;
use DiscountAPI\Domain\Entity\Customer;
use DiscountAPI\Domain\Repository\CustomerRepositoryInterface;
use Exception;

class CustomerService
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws Exception
     */
    public function getCustomerById(string $id): ?Customer
    {
        $customer = $this->customerRepository->findById($id);
        if ($customer === null) {
            throw new UnprocessableEntityException("Customer with ID $id not found");
        }
        return $customer;
    }

}