# Desain Database

## Database Coffine

This database contains comprehensive information about coffee, including details such as name, type, price, and other relevant attributes.

## ERD

```mermaid
erDiagram
    USERS {
        INT id PK "Auto Increment"
        VARCHAR name "User's full name"
        VARCHAR email "Unique email address"
        VARCHAR password "User password (hashed)"
        VARCHAR address "User's address"
        VARCHAR phone_number "User's phone number"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    ORDERS {
        INT id PK "Auto Increment"
        INT user_id FK "References USERS.id"
        DATETIME order_date "Default: CURRENT_TIMESTAMP"
        ENUM status "Order status: 'pending', 'processing', 'completed', 'cancelled'"
        DECIMAL total_amount "Total amount of the order"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    ORDER_ITEMS {
        INT id PK "Auto Increment"
        INT order_id FK "References ORDERS.id"
        INT product_id FK "References PRODUCTS.id"
        INT quantity "Quantity of the product ordered"
        DECIMAL price "Price of a single product at the time of the order"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    PRODUCTS {
        INT id PK "Auto Increment"
        VARCHAR name "Name of the product"
        DECIMAL price "Price of the product"
        INT stock "Available stock for the product"
        TEXT description "Description of the product"
        INT category_id FK "References CATEGORIES.id"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    CATEGORIES {
        INT id PK "Auto Increment"
        VARCHAR name "Name of the category"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    PAYMENTS {
        INT id PK "Auto Increment"
        INT order_id FK "References ORDERS.id"
        ENUM payment_method "Payment method: 'BCA', 'Mandiri', 'QRIS', 'PayPal', 'Cash'"
        DECIMAL amount "Amount paid"
        DATETIME payment_date "Default: CURRENT_TIMESTAMP"
        ENUM status "Payment status: 'successful', 'pending', 'failed'"
        VARCHAR transaction_code "Unique transaction code"
        DATETIME created_at "Default: CURRENT_TIMESTAMP"
        DATETIME updated_at "Default: CURRENT_TIMESTAMP"
    }

    USERS ||--o{ ORDERS : "places"
    ORDERS ||--o{ ORDER_ITEMS : "contains"
    PRODUCTS ||--o{ ORDER_ITEMS : "includes"
    ORDERS ||--o{ PAYMENTS : "has"
    PRODUCTS ||--o{ CATEGORIES : "classified_as"
    CATEGORIES ||--o{ PRODUCTS : "contains"

```
