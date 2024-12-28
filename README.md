# CertVeri - QR Code-Based Attribute Management System

CertVeri is a versatile QR code-based attribute management system built with Laravel. It is designed to securely generate and verify data attributes that can be embedded in certificates, products, and other use cases. Originally developed for certificate verification, it now extends to a wide range of scenarios requiring attribute validation and data sharing through QR codes.

## Features

- **Attribute Management**
  - Create and manage digital records with customizable attributes
  - Unique numbering system for each record
  - QR code generation for each record
  - Attribute validity period tracking

- **Flexible Use Cases**
  - Certificates for education, training, and compliance
  - Product authenticity and warranty tracking
  - Event tickets and passes
  - Asset and inventory tracking
  - Membership and ID cards
  - Document verification and traceability
  - Marketing campaigns and promotions
  - Supply chain management with traceable data

- **User Roles**
  - Admin dashboard for system management
  - Editor access for record creation
  - Role-based access control

- **Data Management**
  - Excel/CSV import/export functionality
  - Bulk operations for records
  - Advanced search and filtering

- **Security**
  - JWT authentication for API access
  - Role-based middleware protection
  - CSRF protection
  - Secure QR code-based verification

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

### Attribute Management

- **Creating Records**
  - Access the record creation form
  - Fill in required details (e.g., name, dates, qualifications, etc.)
  - System automatically generates a QR code

- **Verification**
  - Use QR code scanning
  - Manual attribute number verification
  - API-based verification for third-party systems

### API Integration

The system provides a RESTful API for data verification:

```bash
GET /api/verify/{record_number}
```

API authentication is required using JWT tokens.

## System Documentation

Detailed system flows and diagrams can be found in the [docs/system-flows.md](docs/system-flows.md) file. These include:

1. Authentication Flow
2. Record Creation Flow
3. QR Code Verification Flow
4. Role-Based Access Control
5. Record Management Flow
6. Data Export Flow

## Security Considerations

- All API endpoints are protected with JWT authentication
- Role-based access control for different user types
- Input validation for record creation
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

