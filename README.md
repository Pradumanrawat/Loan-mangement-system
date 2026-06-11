# Loan Management System

A complete Loan Management System built with Laravel 12, following MVC architecture, clean code principles, repository pattern, and security best practices.

## Features

### User Roles
- **Customer**: Apply for loans, view loan applications, make repayments
- **Admin**: View dashboard, manage loan applications (approve/reject), view repayment history

### Authentication
- User Registration with validation
- Secure Login with session-based authentication
- Password hashing using bcrypt
- Role-based authorization middleware

### Customer Features
1. **Register Account**
   - Full Name, Email, Mobile Number, Password
   - Email and Mobile uniqueness validation
   - Password minimum 8 characters

2. **Login**
   - Secure authentication with email and password

3. **Apply for Loan**
   - Loan Amount (positive number)
   - Loan Tenure (1-60 months)
   - Loan Purpose
   - Status tracking: Pending, Approved, Rejected

4. **View My Loan Applications**
   - Application ID, Amount, Tenure, Purpose, Status, Created Date
   - Pagination support

5. **Make Loan Repayment**
   - Loan ID, Repayment Amount, Payment Date
   - Repayment history tracking

### Admin Features
1. **Admin Dashboard**
   - Total Customers
   - Total Applications
   - Approved Loans
   - Rejected Loans
   - Pending Loans
   - Total Repayments

2. **View All Loan Applications**
   - Filter by status (Pending, Approved, Rejected)
   - Search by Customer Name
   - Search by Email
   - Pagination support

3. **Approve/Reject Loans**
   - Update loan status with one click

4. **View Repayment History**
   - Customer Name, Loan ID, Amount Paid, Payment Date
   - Pagination support

### REST API
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout (authenticated)
- `POST /api/loan/apply` - Apply for loan (authenticated)
- `GET /api/loan/status` - View loan status (authenticated)
- `POST /api/repayment` - Make repayment (authenticated)

## Technical Stack

- **Framework**: Laravel 12
- **Database**: MySQL
- **Authentication**: Laravel Sanctum (API), Session (Web)
- **ORM**: Eloquent ORM
- **Validation**: Form Request Validation
- **Views**: Blade Templates
- **Security**: CSRF Protection, XSS Protection, bcrypt hashing

## Installation Steps

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (for asset compilation if needed)

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd loan-mangement-system
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Environment Setup
Copy the example environment file:
```bash
cp .env.example .env
```

### Step 4: Database Configuration
Update the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loan_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Generate Application Key
```bash
php artisan key:generate
```

### Step 6: Create Database
Create the MySQL database (if it does not exist):
```sql
CREATE DATABASE loan_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Option A — Migrations & Seeder (recommended)**
```bash
php artisan migrate
php artisan db:seed
```

**Option B — Import SQL Dump**
```bash
mysql -u root -p < database/dump.sql
```

### Step 7: Verify Database
After seeding or importing, confirm the `users`, `loans`, and `repayments` tables exist.

### Step 8: Start the Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Admin Credentials

After running the database seeder, you can login with the following admin credentials:

- **Email**: admin@loan.com
- **Password**: admin123

## API Documentation

### Base URL
```
http://localhost:8000/api
```

### Endpoints

#### 1. User Registration
**POST** `/api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "mobile": "1234567890",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "message": "Registration successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "mobile": "1234567890",
      "role": "customer"
    },
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
  }
}
```

#### 2. User Login
**POST** `/api/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "mobile": "1234567890",
      "role": "customer"
    },
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
  }
}
```

#### 3. User Logout
**POST** `/api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Logged out successfully"
}
```

#### 4. Apply for Loan
**POST** `/api/loan/apply`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "amount": 10000.00,
  "tenure": 12,
  "purpose": "Home renovation"
}
```

**Response:**
```json
{
  "message": "Loan application submitted successfully",
  "data": {
    "loan": {
      "id": 1,
      "user_id": 1,
      "amount": "10000.00",
      "tenure": 12,
      "purpose": "Home renovation",
      "status": "pending"
    }
  }
}
```

#### 5. View Loan Status
**GET** `/api/loan/status`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Loan status retrieved successfully",
  "data": {
    "loans": {
      "data": [
        {
          "id": 1,
          "amount": "10000.00",
          "tenure": 12,
          "purpose": "Home renovation",
          "status": "pending",
          "created_at": "2024-01-01T00:00:00.000000Z"
        }
      ]
    }
  }
}
```

#### 6. Make Repayment
**POST** `/api/repayment`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "loan_id": 1,
  "amount_paid": 500.00,
  "payment_date": "2024-01-15"
}
```

**Response:**
```json
{
  "message": "Repayment recorded successfully",
  "data": {
    "repayment": {
      "id": 1,
      "loan_id": 1,
      "amount_paid": "500.00",
      "payment_date": "2024-01-15"
    }
  }
}
```

## Database Schema

### users
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| name | string | User's full name |
| email | string | User's email (unique) |
| mobile | string | User's mobile number (unique) |
| password | string | Hashed password |
| role | enum | User role (admin/customer) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### loans
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| user_id | bigint | Foreign key to users |
| amount | decimal | Loan amount |
| tenure | integer | Loan tenure in months |
| purpose | string | Loan purpose |
| status | enum | Loan status (pending/approved/rejected) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### repayments
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| loan_id | bigint | Foreign key to loans |
| amount_paid | decimal | Amount paid |
| payment_date | date | Payment date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

## Security Features

1. **CSRF Protection**: All forms include CSRF tokens
2. **XSS Protection**: Blade templates automatically escape output
3. **Password Hashing**: Using bcrypt with 12 rounds
4. **Login Rate Limiting**: Max 5 failed attempts per email + IP
5. **API Rate Limiting**: Throttled auth and API routes
6. **Token Rotation**: Old Sanctum tokens revoked on API login
7. **Role-based Authorization**: Middleware ensures users can only access their authorized routes
8. **Input Validation**: Form Request validation for all user inputs
9. **SQL Injection Prevention**: Using Eloquent ORM parameterized queries
10. **API Authentication**: Laravel Sanctum for secure API access
11. **HTTPS**: Forced in production environment

## Code Quality

- **PSR Standards**: Following PSR-4 autoloading and PSR-12 coding standards
- **Repository Pattern**: Separation of data access from controllers
- **Service Layer**: `LoanService` holds business rules (approve/reject/repay logic)
- **Form Request Validation**: Centralized validation logic
- **Middleware**: Clean separation of concerns for authorization
- **Clean MVC Structure**: Proper separation of models, views, and controllers
- **Enums**: `UserRole` and `LoanStatus` for type-safe constants

## Applied Best Practices

| Category | Practice | Where |
|----------|----------|-------|
| **Architecture** | Layered MVC + Service + Repository | `Controllers` → `Services` → `Repositories` → `Models` |
| **SOLID** | Dependency injection via interfaces | `AppServiceProvider` bindings |
| **Type safety** | Return types on repositories & controllers | `LoanRepositoryInterface`, controllers |
| **Constants** | PHP enums instead of magic strings | `UserRole`, `LoanStatus` |
| **Validation** | Dedicated Form Request classes | `RegisterRequest`, `LoginRequest`, `LoanApplicationRequest` |
| **Auth security** | Login rate limiting (5 attempts) | `LoginRequest::authenticate()` |
| **API security** | Sanctum tokens + rotation on login | `Api\AuthController` |
| **API security** | Rate limiting (10/min auth, 60/min API) | `routes/api.php`, `throttleApi()` |
| **Data integrity** | DB transactions for repayments | `LoanService::recordRepayment()` |
| **Session security** | Regenerate session on login/logout | `AuthController` |
| **Production** | Force HTTPS in production | `AppServiceProvider::boot()` |
| **Secrets** | `.env` ignored, `.env.example` committed | `.gitignore` |
| **Git hygiene** | Logs, sessions, SQLite DB ignored | `.gitignore` |
| **Consistency** | `.editorconfig` for formatting | Project root |
| **API design** | Uniform JSON via `ApiResponse` trait | `app/Traits/ApiResponse.php` |
| **Error handling** | Global JSON exception handlers | `bootstrap/app.php` |
| **Filtering** | Validated admin search/filter inputs | `AdminLoanFilterRequest` |

## Technical Evaluation Alignment

This project is structured to meet common backend assessment criteria:

### 1. Code Structure & Readability
- **Layered architecture**: Routes → Controllers → Services → Repositories → Models
- **Single responsibility**: Controllers handle HTTP only; `LoanService` owns business rules
- **Interfaces**: Repository contracts allow swapping data sources in tests
- **Named enums** instead of magic strings for roles and loan status
- **Consistent naming** and PHPDoc on service methods

### 2. Database Design
- **Normalized schema**: `users` → `loans` → `repayments` with foreign keys and `ON DELETE CASCADE`
- **Appropriate types**: `decimal(15,2)` for money, `enum` for status/role, `date` for payment dates
- **Indexes** on `loans.status`, `loans.user_id`, `repayments.loan_id`, `users.role` for filters
- **Eloquent relationships**: `hasMany` / `belongsTo` defined on all models

### 3. Security Best Practices
- **bcrypt** password hashing via Laravel `hashed` cast
- **CSRF** tokens on all web forms
- **XSS** protection via Blade `{{ }}` escaping
- **Role middleware** (`auth` + `admin` / `customer`) on protected routes
- **Sanctum** bearer tokens for API authentication
- **Mass assignment** guarded via `$fillable` on models
- **Ownership checks** before repayments (user can only repay own approved loans)

### 4. Error Handling
- **Form Request** validation with user-friendly messages (web + API)
- **Try/catch** in controllers for business rule violations (`InvalidArgumentException`)
- **Global API exception rendering** in `bootstrap/app.php` (404, 422, validation errors as JSON)
- **Flash messages** for success/error feedback on web routes

### 5. Application Logic
- Loan applications start as **pending**; only admin can approve/reject
- Only **pending** loans can be approved or rejected (prevents invalid state changes)
- Repayments allowed **only on approved loans** owned by the customer
- Admin dashboard aggregates customers, applications, and repayment totals
- Admin can **filter by status** and **search by name/email**

### 6. API Integration Approach
- **RESTful endpoints** under `/api` with JSON request/response
- **Laravel Sanctum** token auth on protected routes
- **`ApiResponse` trait** for consistent `{ message, data }` structure
- **Same business logic** as web via shared `LoanService` (no duplicated rules)
- Public: `POST /register`, `POST /login` | Protected: loan apply, status, repayment, logout

## Project Structure

```
loan-mangement-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── CustomerController.php
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── LoanController.php
│   │   │       └── RepaymentController.php
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php
│   │   │   └── IsCustomer.php
│   │   └── Requests/
│   │       ├── AdminLoanFilterRequest.php
│   │       ├── LoginRequest.php
│   │       ├── LoanApplicationRequest.php
│   │       ├── RegisterRequest.php
│   │       └── RepaymentRequest.php
│   ├── Enums/
│   │   ├── LoanStatus.php
│   │   └── UserRole.php
│   ├── Models/
│   │   ├── Loan.php
│   │   ├── Repayment.php
│   │   └── User.php
│   ├── Services/
│   │   └── LoanService.php
│   ├── Traits/
│   │   └── ApiResponse.php
│   └── Repositories/
│       ├── Interfaces/
│       │   ├── LoanRepositoryInterface.php
│       │   ├── RepaymentRepositoryInterface.php
│       │   └── UserRepositoryInterface.php
│       ├── LoanRepository.php
│       ├── RepaymentRepository.php
│       └── UserRepository.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── auth.php
│   ├── cors.php
│   ├── database.php
│   └── sanctum.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_01_000001_create_loans_table.php
│   │   ├── 2024_01_01_000002_create_repayments_table.php
│   │   ├── 2024_01_01_000003_create_sessions_table.php
│   │   └── 2024_01_01_000004_create_personal_access_tokens_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── loans.blade.php
│       │   └── repayments.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── customer/
│           ├── apply-loan.blade.php
│           ├── dashboard.blade.php
│           └── make-repayment.blade.php
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
├── .env
├── .env.example
├── composer.json
└── README.md
```

---

## Architecture Guide

This section explains **why each folder exists** and **why security features are used** — in simple language, useful for understanding the project and explaining it in an interview.

### Request flow (big picture)

Think of the app like a **bank office**. When a user visits the site, the request passes through several departments:

```
User (Browser or API client)
        ↓
   routes/              → "Which URL maps to which action?"
        ↓
   Middleware           → "Is this user allowed in?"
        ↓
   Controllers          → "Receive request, return response"
        ↓
   Services             → "Apply business rules"
        ↓
   Repositories         → "Read/write database"
        ↓
   Models               → "Represent database tables"
        ↓
   Views (Blade)        → "Show HTML to the user" (web only)
```

---

### Folder-by-folder — why it exists

#### `routes/` — The reception desk
**Files:** `web.php`, `api.php`

Answers the question: *"When someone visits this URL, which code should run?"*

| File | Purpose |
|------|---------|
| `web.php` | Browser pages — login, register, dashboards, forms |
| `api.php` | API endpoints — `/api/login`, `/api/loan/apply`, etc. |

**Why separate?** Web users use **sessions** and HTML forms. API clients use **JSON** and **tokens**. Same business logic, different entry points.

---

#### `app/Http/Controllers/` — Request handlers
**Examples:** `AuthController`, `CustomerController`, `AdminController`, `Api/LoanController`

Controllers are like **front-desk staff**:
- Receive the incoming request
- Call the correct Service or Repository
- Return a Blade view (HTML) or JSON response

They stay **thin** — they do not contain heavy business rules.

**Why `Api/` subfolder?** API controllers always return JSON, not HTML pages. Separating them keeps the structure clear.

---

#### `app/Services/LoanService.php` — The rule book
This is the **brain** of loan-related logic:
- New loan application → status is always `pending`
- Approve / reject → only allowed when loan is still `pending`
- Repayment → only on **approved** loans owned by that customer

**Why this folder?** The same rules are used by both the **web** (`CustomerController`) and the **API** (`Api/LoanController`). Without a Service, you would copy-paste rules in many places and bugs would appear.

---

#### `app/Repositories/` — Database helpers
**Examples:** `LoanRepository`, `UserRepository`, `RepaymentRepository`  
**Interfaces:** `LoanRepositoryInterface`, etc.

Repositories handle **how** data is fetched and saved:
- Get all loans for a user
- Filter loans by status
- Search by customer name or email

**Why not put this in controllers?** Controllers stay small. If storage changes later, you mostly update repositories — not every controller.

---

#### `app/Models/` — Database table representation
**Files:** `User.php`, `Loan.php`, `Repayment.php`

Each model maps to one database table. They define:
- Which fields can be mass-assigned (`$fillable`)
- Relationships (`User hasMany Loans`, `Loan belongsTo User`)
- Helper methods (`isAdmin()`, `isApproved()`)

**Why?** Instead of writing raw SQL everywhere, you write readable code like `$user->loans`.

---

#### `app/Enums/` — Fixed allowed values
**Files:** `UserRole.php`, `LoanStatus.php`

Enums store allowed values in one place:
- Roles: `admin`, `customer`
- Loan status: `pending`, `approved`, `rejected`

**Why?** Avoids typos like `'apprved'` or `'custmer'`. Makes the code safer and easier to read.

---

#### `app/Http/Requests/` — Input validators
**Examples:** `RegisterRequest`, `LoginRequest`, `LoanApplicationRequest`, `RepaymentRequest`

These run **before** the controller processes data and check rules such as:
- Email is valid and unique
- Password is at least 8 characters
- Loan amount is positive
- Tenure is between 1 and 60 months

**Why a separate folder?** Validation rules live in one place instead of being mixed inside controllers.

---

#### `app/Http/Middleware/` — Security guards
**Examples:** `IsAdmin.php`, `IsCustomer.php`

Middleware runs **before** the controller:
- Is the user logged in?
- Is the user an admin or a customer?

**Why?** You do not repeat "check if admin" in every admin method. One guard protects all admin routes.

---

#### `app/Traits/ApiResponse.php` — Consistent API format
All API responses follow the same shape:

```json
{
  "message": "Success message",
  "data": { ... }
}
```

**Why?** Mobile apps and API clients expect predictable responses. Easier to integrate and debug.

---

#### `resources/views/` — HTML pages (UI)
**Folders:** `auth/`, `customer/`, `admin/`, `layouts/`

Blade templates display forms, tables, and dashboards to the user.

**Why `layouts/app.blade.php`?** Header, navigation, and styles are written once and reused on every page.

---

#### `database/migrations/` — Database blueprint
Each migration file creates or updates tables (`users`, `loans`, `repayments`).

**Why migrations?** Database structure is version-controlled. Any developer can rebuild the DB with `php artisan migrate`.

---

#### `database/seeders/` — Default / sample data
**Example:** `AdminSeeder` creates the admin account (`admin@loan.com`).

**Why?** After setup, you can log in immediately without manually inserting rows into the database.

---

#### `config/` and `.env` — App settings
- `.env` — environment-specific values (DB connection, app key)
- `config/` — framework configuration (auth, session, sanctum)

**Why?** Secrets and settings are not hardcoded in PHP files.

---

#### `bootstrap/app.php` — Application bootstrap
Registers routes, middleware aliases, and global API error handling when something goes wrong.

---

### Example: Customer applies for a loan (web)

| Step | What happens |
|------|----------------|
| 1 | User opens `/customer/apply-loan` → defined in `routes/web.php` |
| 2 | Middleware checks: user is logged in **and** is a customer |
| 3 | User submits form with a CSRF token |
| 4 | `LoanApplicationRequest` validates amount, tenure, purpose |
| 5 | `CustomerController` calls `LoanService::submitApplication()` |
| 6 | `LoanService` sets status to `pending` |
| 7 | `LoanRepository` saves the record via the `Loan` model |
| 8 | User is redirected to dashboard with a success message |

The **same business rules** apply when using the API — only the entry controller changes.

---

## Security Guide (Easy Explanation)

### 1. Password hashing (bcrypt)
**What:** Passwords are never stored as plain text.  
**Example:** `admin123` is stored as something like `$2y$12$msqPy9...`  
**Why:** If the database is leaked, attackers cannot easily read real passwords.

---

### 2. CSRF protection
**What:** Every web form includes a hidden token (`@csrf` in Blade).  
**Why:** Stops malicious websites from submitting forms **on behalf of a logged-in user**.

**Simple example:** You are logged into the loan site. A fake website tries to auto-submit "approve this loan" using your browser session. CSRF blocks it because the fake site does not have the valid token.

**Used on:** Login, register, apply loan, approve/reject, repayment, logout (web).

---

### 3. XSS protection (Blade escaping)
**What:** Blade `{{ $name }}` automatically escapes HTML.  
**Why:** If someone enters `<script>alert('hack')</script>` as their name, it displays as plain text — it does **not** run as JavaScript.

| Avoid | Prefer |
|-------|--------|
| `{!! $userInput !!}` | `{{ $userInput }}` |

---

### 4. Authentication vs authorization

| Term | Meaning | In this project |
|------|---------|-----------------|
| **Authentication** | Who are you? | Login with email + password |
| **Authorization** | What are you allowed to do? | Admin vs customer routes |

| Role | Can access |
|------|------------|
| Customer | Apply loan, view own loans, make repayments |
| Admin | Dashboard, approve/reject loans, view all repayments |

Middleware `IsAdmin` and `IsCustomer` enforce this on protected routes.

---

### 5. Sanctum (API token security)
**What:** After API login, the client sends `Authorization: Bearer <token>` on protected requests.  
**Why:** APIs do not use browser sessions the same way. Tokens identify the user securely.

**Protected API routes:** apply loan, loan status, repayment, logout.

---

### 6. Form Request validation
**What:** Server-side validation on every input.  
**Why:** Users can bypass the browser and send bad data directly (e.g. via Postman). **Never trust frontend validation alone.**

---

### 7. Mass assignment protection (`$fillable`)
**What:** Only specific fields can be saved from user input.  
**Why:** Prevents someone from sending `"role": "admin"` during registration and becoming an admin. Role is set to `customer` in code — not from user input.

---

### 8. SQL injection prevention (Eloquent ORM)
**What:** Laravel uses parameterized queries through Eloquent.  
**Why:** Attackers cannot inject malicious SQL through form fields.

| Avoid | Prefer |
|-------|--------|
| Raw SQL with string concatenation | `User::where('email', $email)->first()` |

---

### 9. Ownership checks (business security)
**What:** Before a repayment, the code verifies:
- The loan belongs to the logged-in user
- The loan is approved

**Why:** Even if someone guesses another user's loan ID, they cannot repay or access it. This logic lives in `LoanService`.

---

### 10. Logout via POST (not a GET link)
**What:** Logout uses a form with `POST` + CSRF, not a simple clickable link.  
**Why:** Prevents accidental or forced logout from link prefetching or third-party sites.

---

### Security quick reference (for interviews)

| Topic | One-line answer |
|-------|-----------------|
| Why folders? | Each folder has one job — easier to read, test, and maintain |
| Why Service layer? | Business rules in one place, shared by web and API |
| Why Repository? | Database access separated from controllers |
| Why CSRF? | Stop fake sites from acting as the logged-in user |
| Why password hashing? | Protect passwords if the database is stolen |
| Why middleware? | Block unauthorized access before the controller runs |
| Why validation? | Never trust user input |
| Why Sanctum? | Secure token-based API authentication |

---

## License

This project is open-source and available under the MIT License.
