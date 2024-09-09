# API Documentation

This document provides an overview of the available API endpoints for the E-Commerce project. For detailed information on each endpoint, including request/response schemas and examples, please refer to the corresponding OpenAPI/Swagger JSON files in the `documentation/docs api/` directory.

## Authentication

- **Register**: [POST /api/register](docs%20api/auth.json)
- **Login**: [POST /api/login](docs%20api/auth.json)

## User Management

- **Get User Profile**: [GET /api/user/profile](docs%20api/user.json)
- **Update User Profile**: [PUT /api/user/profile](docs%20api/user.json)

## Product Management

- **Get All Products**: [GET /api/products](docs%20api/products.json)
- **Get Product by ID**: [GET /api/products/{id}](docs%20api/products.json)
- **Create Product**: [POST /api/products](docs%20api/products.json)
- **Update Product**: [PUT /api/products/{id}](docs%20api/products.json)
- **Delete Product**: [DELETE /api/products/{id}](docs%20api/products.json)

## Category Management

- **Get All Categories**: [GET /api/categories](docs%20api/categories.json)
- **Get Category by ID**: [GET /api/categories/{id}](docs%20api/categories.json)
- **Create Category**: [POST /api/categories](docs%20api/categories.json)
- **Update Category**: [PUT /api/categories/{id}](docs%20api/categories.json)
- **Delete Category**: [DELETE /api/categories/{id}](docs%20api/categories.json)

## Cart Management

- **Get User Cart**: [GET /api/user/cart](docs%20api/cart.json)
- **Add to Cart**: [POST /api/user/cart](docs%20api/cart.json)
- **Update Cart Item**: [PUT /api/user/cart/{id}](docs%20api/cart.json)
- **Remove from Cart**: [DELETE /api/user/cart/{id}](docs%20api/cart.json)

## Order Management

- **Get User Orders**: [GET /api/user/orders](docs%20api/orders.json)
- **Create Order**: [POST /api/user/order](docs%20api/orders.json)
- **Get Order Details**: [GET /api/user/orders/{id}](docs%20api/orders.json)

## Payment Management

- **Get Payment History**: [GET /api/user/history-payments](docs%20api/payments.json)
- **Process Payment**: [POST /api/payments](docs%20api/payments.json)

For more detailed information on request/response schemas, authentication requirements, and example usage, please refer to the individual OpenAPI/Swagger JSON files linked above.
