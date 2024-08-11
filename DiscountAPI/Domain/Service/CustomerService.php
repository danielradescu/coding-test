<?php

namespace DiscountAPI\Domain\Service;

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
        try {
            $customer = $this->customerRepository->findById($id);
            if ($customer === null) {
                throw new Exception("Customer with ID $id not found");
            }
            return $customer;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve customer: " . $e->getMessage());
        }
    }

}