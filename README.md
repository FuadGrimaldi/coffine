# E-Commerce API

## Description

This project is an E-Commerce API built with Laravel, providing a robust backend for managing products, orders, carts, and payments in an online store environment.

## Tech Stack

- **Backend Framework**: Laravel
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **API Documentation**: OpenAPI/Swagger (JSON files provided)

## Features

- User Authentication (Register, Login)
- Product Management
- Category Management
- Cart Functionality
- Order Processing
- Payment Handling
- User Profile Management

## API Endpoints

The API includes the following main endpoints:

- `/api/register`: User registration
- `/api/login`: User login
- `/api/user/profile`: Get user profile
- `/api/user/orders`: Get user orders
- `/api/user/cart`: Manage user cart
- `/api/user/order`: Create new order
- `/api/user/history-payments`: Get user payment history
- `/api/categories`: Manage product categories
- `/api/products`: Manage products
- `/api/product-detail`: Manage product details
- `/api/orders`: Manage orders
- `/api/payments`: Manage payments

For detailed API documentation, refer to the OpenAPI/Swagger JSON files in the `documentation/docs api/` directory.

## Installation

1. Clone the repository:

   ```
   git clone [repository-url]
   ```

2. Navigate to the project directory:

   ```
   cd [project-directory]
   ```

3. Install PHP dependencies:

   ```
   composer install
   ```

4. Copy the `.env.example` file to `.env` and configure your database settings:

   ```
   cp .env.example .env
   ```

5. Generate an application key:

   ```
   php artisan key:generate
   ```

6. Run database migrations:

   ```
   php artisan migrate
   ```

7. (Optional) Seed the database with sample data:

   ```
   php artisan db:seed
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

## Usage

To use the API, send HTTP requests to the appropriate endpoints. Most endpoints require authentication, which can be achieved by including a bearer token in the request headers.

Example:

1. Register a new user:

   ```
   POST /api/register
   {
     "name": "John Doe",
     "email": "john@example.com",
     "password": "password123"
   }
   ```

2. Login to get a bearer token:

   ```
   POST /api/login
   {
     "email": "john@example.com",
     "password": "password123"
   }
   ```

3. Use the bearer token to access protected routes:

   ```
   GET /api/user/profile
   Authorization: Bearer <your_token_here>
   ```

4. Create a new order:
   ```
   POST /api/user/order
   Authorization: Bearer <your_token_here>
   {
     "items": [
       {
         "product_id": 1,
         "quantity": 2
       },
       {
         "product_id": 3,
         "quantity": 1
       }
     ]
   }
   ```

These examples demonstrate how to register, login, access a protected route, and create an order using the API.
