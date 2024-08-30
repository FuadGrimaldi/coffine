# Desain Database

## Database Coffine

This database contains comprehensive information about coffee, including details such as name, type, price, and other relevant attributes.

## ERD

```mermaid
erDiagram
    users {
        INT id PK "Auto Increment"
        VARCHAR name "Not Null"
        VARCHAR email "Unique, Not Null"
        VARCHAR password "Not Null"
        TEXT address
        VARCHAR phone
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    products {
        INT id PK "Auto Increment"
        VARCHAR name "Not Null"
        TEXT description
        DECIMAL price "Not Null"
        INT stock "Not Null"
        VARCHAR category
        VARCHAR image_url
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    orders {
        INT id PK "Auto Increment"
        INT user_id FK "Not Null"
        DECIMAL total "Not Null"
        ENUM status "Pending, Processing, Completed, Cancelled"
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    order_items {
        INT id PK "Auto Increment"
        INT order_id FK "Not Null"
        INT product_id FK "Not Null"
        INT quantity "Not Null"
        DECIMAL price "Not Null"
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    payments {
        INT id PK "Auto Increment"
        INT order_id FK "Not Null"
        DECIMAL amount "Not Null"
        ENUM payment_method "Credit Card, PayPal, Bank Transfer"
        ENUM payment_status "Pending, Completed, Failed"
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    categories {
        INT id PK "Auto Increment"
        VARCHAR name "Unique, Not Null"
        TIMESTAMP created_at "Default: CURRENT_TIMESTAMP"
        TIMESTAMP updated_at "Default: CURRENT_TIMESTAMP"
    }

    product_category {
        INT product_id PK, FK "Not Null"
        INT category_id PK, FK "Not Null"
    }

    users ||--o{ orders : places
    orders ||--o{ order_items : contains
    products ||--o{ order_items : is
    orders ||--o{ payments : has
    products ||--o{ product_category : "is classified as"
    categories ||--o{ product_category : "contains"
```
