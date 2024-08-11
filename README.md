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
