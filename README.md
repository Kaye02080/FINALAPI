# Money Remittance System - Laravel Project

## Prerequisites

Before setting up the project, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/download.html) – Includes PHP, MySQL, and Apache
- [Visual Studio Code](https://code.visualstudio.com/download) – Recommended code editor
- [Composer](https://getcomposer.org/download/) – PHP dependency manager
- [Node.js](https://nodejs.org/en/download/) (v14 or higher) – Required for Laravel Mix & frontend dependencies
- [Git](https://git-scm.com/downloads) – For cloning the repository and version control

## About the Project

**Money Remittance System** is a Laravel-based application for securely and efficiently transferring money between users. It includes features for managing users, tracking transactions, and generating reports.

## Features

- User registration and login
- Role-based access control (Admin/User)
- Dashboard with statistics
- Send and receive money
- Transaction history with filters
- Secure authentication using Laravel Sanctum or Passport
- Admin panel to manage users and transactions
- Error handling and form validation
- PDF receipt generation

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/money-remittance.git
    ```

2. Install dependencies:

    ```bash
    cd money-remittance
    composer install
    ```

3. Set up environment:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure `.env` with your database credentials.

5. Run migrations:

    ```bash
    php artisan migrate
    ```

6. Start the development server:

    ```bash
    php artisan serve
    ```

## License

This project is open-source and available under the [MIT license](https://opensource.org/licenses/MIT).
