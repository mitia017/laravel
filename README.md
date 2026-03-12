# Laravel ERP MVP API

This is a complete MVP ERP backend built with Laravel 11. It is an API-only project following clean architecture with Service layer, Form Requests, and API Resources.

## Features

- **Authentication**: Laravel Sanctum (Login, Logout, Me).
- **Users**: CRUD users (admin/staff roles).
- **Customers**: CRUD customers.
- **Products**: CRUD products with stock management.
- **Orders**: Create orders, automatically update stock, and generate invoices.
- **Invoices**: Automatically generated from orders.

## Tech Stack

- Laravel 11
- Laravel Sanctum (Auth)
- SQLite (Default database)

## Setup Instructions

1. **Clone the repository**
2. **Install dependencies**
   ```bash
   composer install
   ```
3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate:fresh --seed
   ```
   *The seeder creates:*
   - Admin: `admin@example.com` / `password`
   - Staff: `staff@example.com` / `password`

5. **Run tests**
   ```bash
   php artisan test
   ```

## API Documentation

All endpoints (except `/api/login`) require `Authorization: Bearer <token>`.

### Authentication
- `POST /api/login`: Get access token.
- `POST /api/logout`: Revoke access token.
- `GET /api/me`: Get current user info.

### Users
- `GET /api/users`: List users (Paginated).
- `POST /api/users`: Create user.
- `GET /api/users/{id}`: View user.
- `PUT /api/users/{id}`: Update user.
- `DELETE /api/users/{id}`: Delete user.

### Customers
- `GET /api/customers`: List customers.
- `POST /api/customers`: Create customer.
- `GET /api/customers/{id}`: View customer.
- `PUT /api/customers/{id}`: Update customer.
- `DELETE /api/customers/{id}`: Delete customer.

### Products
- `GET /api/products`: List products.
- `POST /api/products`: Create product.
- `GET /api/products/{id}`: View product.
- `PUT /api/products/{id}`: Update product.
- `DELETE /api/products/{id}`: Delete product.

### Orders
- `GET /api/orders`: List orders.
- `POST /api/orders`: Create order (Reduces stock, generates invoice).
- `GET /api/orders/{id}`: View order with items and invoice.
- `PUT /api/orders/{id}`: Update order status.
- `DELETE /api/orders/{id}`: Delete order (Restores stock).

### Invoices
- `GET /api/invoices`: List invoices.
- `GET /api/invoices/{id}`: View invoice.
- `PUT /api/invoices/{id}`: Update invoice status.

## Clean Architecture

- **Models**: Standard Eloquent models with relationships.
- **Services**: Business logic isolated from controllers (`app/Services`).
- **Requests**: Validation logic (`app/Http/Requests`).
- **Resources**: API response formatting (`app/Http/Resources`).
- **Factories/Seeders**: Demo data generation.
