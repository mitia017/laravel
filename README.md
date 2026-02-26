# Mini CRM SaaS for PME

A fully functional Mini CRM SaaS application built with Laravel 12 and Vue 3. This application is designed for small and medium-sized enterprises to manage their clients, invoices, and real estate properties.

## Features

- **Authentication**: Secure login, registration, and logout using Laravel Sanctum.
- **Role-Based Access Control (RBAC)**: Distinct 'admin' and 'staff' roles. Admins have full access, including deletion rights.
- **Client Management**: Full CRUD operations for managing client information.
- **Invoice Management**:
    - Create and track invoices.
    - Generate and download PDF invoices.
- **Dashboard**: Overview of key metrics, including total clients, revenue, and recent activities.
- **Real Estate Properties**:
    - Manage property listings.
    - Multiple image uploads per property.
    - Responsive image carousel for property display.

## Tech Stack

- **Backend**: Laravel 12, Laravel Sanctum, DomPDF.
- **Frontend**: Vue 3, Pinia (State Management), Vue Router.
- **Styling**: Tailwind CSS 4.
- **Database**: SQLite (local development).
- **Build Tool**: Vite.

## Installation & Setup

1. **Clone the repository**
2. **Install PHP dependencies**:
   ```bash
   composer install
   ```
3. **Install NPM dependencies**:
   ```bash
   npm install
   ```
4. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. **Database Initialization**:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```
6. **Storage Link**:
   ```bash
   php artisan storage:link
   ```
7. **Build Frontend Assets**:
   ```bash
   npm run build
   ```
8. **Run the Application**:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.

## Testing

Run the test suite to ensure everything is working correctly:
```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
