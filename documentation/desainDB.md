# Desain Database

## Database Coffine

This database contains comprehensive information about coffee, including details such as name, type, price, and other relevant attributes.

## ERD

```mermaid
erDiagram
    users {
        int id PK
        string name
        string email
        string address
        string phone
        datetime email_verified_at
        string password
        string token
        string role
        string remember_token
        datetime created_at
        datetime updated_at
    }

    categories {
        int id PK
        string name
        datetime created_at
        datetime updated_at
    }

    products {
        int id PK
        string name
        int stock
        string description
        datetime created_at
        datetime updated_at
    }

    product_details {
        int id PK
        int product_id FK
        int category_id FK
        decimal price
        string image
        datetime created_at
        datetime updated_at
    }

    cart {
        int id PK
        int user_id FK
        int product_id FK
        int qty
        decimal total_amount
        datetime created_at
        datetime updated_at
    }

    orders {
        int id PK
        int user_id FK
        datetime order_date
        string status
        decimal total_amount
        int qty
        datetime created_at
        datetime updated_at
    }

    order_items {
        int id PK
        int order_id FK
        int product_id FK
        int quantity
        decimal price
        datetime created_at
        datetime updated_at
    }

    payments {
        int id PK
        int order_id FK
        string payment_method
        decimal amount
        datetime payment_date
        string status
        string transaction_code
        datetime created_at
        datetime updated_at
    }

    personal_access_tokens {
        int id PK
        string tokenable_type
        int tokenable_id
        string name
        string token
        string abilities
        datetime last_used_at
        datetime expires_at
        datetime created_at
        datetime updated_at
    }

    %% Relationships
    users ||--o{ orders : has
    users ||--o{ cart : has
    users ||--o{ personal_access_tokens : has

    orders ||--o{ order_items : contains
    orders ||--o{ payments : has

    categories ||--o{ product_details : contains
    products ||--o{ product_details : has

    cart ||--|| users : belongs_to
    cart ||--|| products : contains

    order_items ||--|| orders : belongs_to
    order_items ||--|| products : contains

    payments ||--|| orders : belongs_to

    product_details ||--|| categories : belongs_to
    product_details ||--|| products : belongs_to

```
