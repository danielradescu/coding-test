## Installation and Running Tests

To set up the project and run the tests, follow these steps:

### 1. Build the Project

In the project root directory, run the following command to build the Docker containers:
```bash
docker-compose up --build
```
This command will build the Docker images and start the services defined in your docker-compose.yml file. If the project is already build run `docker-compose up`.
### 2. Run the Tests

After the project is built, you can run the tests using the following command:

```bash
docker-compose run --rm tests
```
This command runs the test suite in a temporary Docker container. The --rm flag ensures that the container is automatically removed after the tests have finished running.

## API Endpoint: Calculate Discounts

### Request

**POST** `/discount`

**Body**:

```json
{
  "id": "<order-id>",
  "customer-id": "<customer-id>",
  "items": [
    {
      "product-id": "<product-id>",
      "quantity": "<quantity>"
    }
  ]
}
```
### Response
A successful response returns details of the calculated discounts:
```json
{
  "total-discount": 114.64,
  "all-reasons": [
    "Buy five, get the sixth free for category Switches",
    "20% discount on the cheapest product when buying two or more Tools",
    "10% discount for orders over €1000"
  ],
  "total-percentage": 23.97,
  "total-order": 478.18,
  "detail-discounts": [
    {
      "amount": 64.87,
      "reasons": [
        "Buy five, get the sixth free for category Switches"
      ]
    },
    {
      "amount": 1.95,
      "reasons": [
        "20% discount on the cheapest product when buying two or more Tools"
      ]
    },
    {
      "amount": 47.82,
      "reasons": [
        "10% discount for orders over €1000"
      ]
    }
  ]
}

```



### Example Error Response
In case of an error, such as missing required fields or invalid input, the API will return an error response with the appropriate HTTP status code.

**Status:** `400 Bad Request`

**Body:**

```json
{
  "error": "Customer ID is required."
}
```

**Status:** `422 Unprocessable Entity`

**Body:**

```json
{
  "error": "Product with ID B1022 not found"
}
```
# Discount API

## Project Structure Overview

This project is organized according to Domain-Driven Design (DDD) principles. Below is an overview of the project structure, highlighting the key components in each layer.

### 1. Application Layer

- **`DiscountAPI/Application/Controller/DiscountController.php`**  
  Handles HTTP requests and coordinates the application logic related to discounts. It interacts with the domain layer to apply business rules and generate responses.

### 2. Domain Layer

- **Entities**
    - **`Customer.php`**: Represents the customer entity in the domain.
    - **`Discount.php`**: Encapsulates discount details within the domain.
    - **`DiscountableOrder.php`**: Represents an order eligible for discounts.
    - **`Order.php`**: Models the concept of an order in the domain.
    - **`OrderItem.php`**: Represents individual items within an order.
    - **`Product.php`**: Represents a product in the domain.

- **Repositories**
    - **`CustomerRepositoryInterface.php`**: Defines the contract for accessing customer data.
    - **`ProductRepositoryInterface.php`**: Defines the contract for accessing product data.

- **Services**
    - **`CustomerService.php`**: Handles business logic related to customers.
    - **`ProductService.php`**: Manages business logic related to products.
    - **`OrderDiscount.php`**: Applies discount logic to orders.
    - **`DiscountCalculator.php`**: Aggregates multiple discount strategies and calculates the total discount.
    - **`OrderFactory.php`**: Responsible for creating `Order` entities.

- **Discount Strategies**
    - **`CategorySwitchesDiscount.php`**: Implements discount logic for the "switches" category.
    - **`CategoryToolsDiscount.php`**: Applies discounts to products in the "tools" category.
    - **`TotalPurchaseDiscount.php`**: Provides discounts based on the total purchase amount.
    - **`DiscountDecorator.php`**: Used for combining or enhancing discount strategies.

- **DTOs**
    - **`DiscountDto.php`**: Handles data transfer related to discounts, ensuring that discount details are consistently represented across different layers.

- **Factory Interface**
    - **`DiscountStrategyFactoryInterface.php`**: Defines the contract for creating discount strategies, allowing for flexibility and dynamic configuration of strategies.

### 3. Infrastructure Layer

- **Repository Implementations**
    - **`JsonCustomerRepository.php`**: Implements the `CustomerRepositoryInterface`, providing access to customer data stored in JSON format.
    - **`JsonProductRepository.php`**: Implements the `ProductRepositoryInterface`, providing access to product data stored in JSON format.

- **Factory Implementation**
    - **`DiscountStrategyFactory.php`**: Implements the `DiscountStrategyFactoryInterface`, dynamically creating and returning an array of discount strategies based on the current configuration.

## Service Aggregation and Strategy Factory

### 1. Service Aggregation

- The **`DiscountCalculator.php`** class is responsible for aggregating multiple discount strategies. It does so through a strategy factory, ensuring that the `DiscountCalculator` remains decoupled from specific discount strategy implementations. This design allows for the dynamic creation and injection of different discount strategies, depending on the business requirements or configurations.

### 2. Strategy Factory

- The **`DiscountStrategyFactory.php`** in the infrastructure layer implements the `DiscountStrategyFactoryInterface.php`. This factory is designed to dynamically create and return an array of discount strategies. By doing so, it ensures that the `DiscountCalculator` can remain flexible and adaptable to different discount configurations, allowing the system to easily accommodate changes in business rules or the addition of new discount strategies.
