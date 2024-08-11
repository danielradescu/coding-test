<?php

namespace DiscountAPI\Infrastructure\Repository;

use DiscountAPI\Domain\Entity\Customer;
use DiscountAPI\Domain\Repository\CustomerRepositoryInterface;
use RuntimeException;

readonly class JsonCustomerRepository implements CustomerRepositoryInterface
{

    public function __construct(private string $filePath)
    {
    }

    public function findById(string $id): ?Customer
    {
        $customers = $this->loadData();

        foreach ($customers as $customerData) {
            if ($customerData['id'] === $id) {
                return $this->mapToCustomer($customerData);
            }
        }

        return null;
    }

    private function loadData(): array
    {
        if (!file_exists($this->filePath)) {
            throw new RuntimeException("JSON file not found: " . $this->filePath);
        }

        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON format: " . json_last_error_msg());
        }

        return $data;
    }

    private function mapToCustomer(array $data): Customer
    {
        return new Customer(
            $data['id'],
            $data['name'],
            $data['since'],
            (float)$data['revenue']
        );
    }
}