# CertVeri - Certificate Verification System

CertVeri is a robust certificate verification system built with Laravel, designed to manage and verify educational certificates securely and efficiently.

## Features

- **Certificate Management**
  - Create and manage digital certificates
  - Unique certificate numbering system
  - QR code generation for each certificate
  - Certificate validity period tracking

- **User Roles**
  - Admin dashboard for system management
  - Editor access for certificate creation
  - Role-based access control

- **Data Management**
  - Excel/CSV import/export functionality
  - Bulk certificate operations
  - Advanced search and filtering

- **Security**
  - JWT authentication for API access
  - Role-based middleware protection
  - CSRF protection
  - Secure certificate verification

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL

## Installation

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd certveri
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database in `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Build assets:
   ```bash
   npm run dev
   ```

## Usage

### Certificate Management

- **Creating Certificates**
  - Access the certificate creation form
  - Fill in required details (certificate number, student name, dates, etc.)
  - System automatically generates QR code

- **Verification**
  - Use QR code scanning
  - Manual certificate number verification
  - API-based verification for third-party systems

### API Integration

The system provides a RESTful API for certificate verification:

```bash
GET /api/verify/{certificate_number}
```

API authentication is required using JWT tokens.

## Security Considerations

- All API endpoints are protected with JWT authentication
- Role-based access control for different user types
- Input validation for certificate creation
- Rate limiting on API endpoints

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is proprietary software - see the [LICENSE.md](LICENSE.md) file for the full license agreement.

## Support

For support and queries, please create an issue in the repository or contact the development team.
