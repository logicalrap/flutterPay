# Laravel Framework 8.83.27 Documentation

## System Requirements

Before installing Laravel Framework 8.83.27, ensure that you have the following prerequisites installed on your system:

- PHP version 8.1.17 or higher
- XAMPP or a similar local development environment
- MySQL database
- Composer (PHP Dependency Manager)

## Installation

Follow these steps to install and configure Laravel Framework 8.83.27 on your system:

1. **Start XAMPP**: Ensure that XAMPP is up and running on your local machine. XAMPP provides the necessary web server environment for Laravel.

2. **Configure `.env` File**: In your Laravel project directory, locate the `.env` file. Configure the following settings in the `.env` file:

   - Set `DB_DATABASE` to your desired database name.
   - Set `DB_USERNAME` and `DB_PASSWORD` with your MySQL credentials.

3. **Install Composer Dependencies**: Open your terminal or command prompt, navigate to the Laravel project directory, and run the following command to install Composer dependencies:

   ```bash
   composer install
   ```

4. **Generate Application Key**: Run the following command to generate a unique application key for your Laravel project:

   ```bash
   php artisan key:generate
   ```

## Features

Laravel Framework 8.83.27 offers the following features:

### Local Currency Display

- As you make payments in USD, the application displays the local currency equivalent in real-time.

### Flutterwave Payment Integration

- Laravel Framework 8.83.27 integrates with the Flutterwave API to facilitate payments.

### KingFlamez Package

- The application utilizes the KingFlamez package for Flutterwave integration. You can find more information about this package at [https://github.com/kingflamez/laravelrave](https://github.com/kingflamez/laravelrave).

### Payment Information Storage

- Once a user makes a successful payment, the payment information is securely stored in the database.

### Location Selection

- Users can select their location before making a payment. The application performs real-time currency conversion to display the local currency equivalent.

## Sample `.env` Configuration

Here is a sample configuration for your `.env` file:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

# Other Configuration Settings...
```

Please replace the placeholders with your specific configuration values.

## Additional Configuration

You may need to configure other settings in your Laravel project, such as mail, cache, and queue drivers, based on your specific requirements. Refer to the Laravel documentation for detailed information on configuring these settings.

## Contact and Support

For any issues, questions, or support related to Laravel Framework 8.83.27, please reach out to the Laravel community or the package maintainers if you encounter any issues with the KingFlamez package.

Enjoy using Laravel Framework 8.83.27 for your web development needs!