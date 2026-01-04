# GUM - Gym Management System

GUM is a comprehensive web application designed to manage the operational workflow of fitness centers. It features a multi-tenant architecture with distinct portals for Gym Owners, Trainers, and Members, facilitating efficient management of subscriptions, workout regimens, and performance tracking.

## System Architecture

The application is built on a modular architecture separating concern by user role.

### Authentication & Authorization
The system implements a multi-guard authentication strategy using Laravel's native authentication services. Access control is enforced via dedicated middleware and guards for each user role:

*   **Gym Owner (Admin)**: Authenticated via the `gym` guard. Managed through specific Gym-scoped controllers.
*   **Trainer**: Authenticated via the `trainer` guard. Access is restricted to assigned members and workout plans.
*   **Member**: Authenticated via the `member` guard. Read-only access to assigned plans, with write access limited to progress logs.

### Entity Relationships
The database schema relies on strict foreign key constraints to maintain data integrity:
1.  **Gym**: The primary tenant entity.
2.  **Trainer**: Belongs to a Gym (`gym_id`).
3.  **Member**: Belongs to a Gym (`gym_id`) and is assigned to a Trainer (`trainer_id`).
4.  **Subscription**: Linked to a Member (`member_id`), defining the access validity period.

## Core Features

### Gym Manager (Admin)
*   **Dashboard**: aggregated view of active members, trainer status, and financial metrics.
*   **Resource Management**: Full CRUD capabilities for Trainer and Member entities.
*   **Subscription Lifecycle**: Management of subscription validity, renewals, and cancellations.
*   **Reporting**: Generation of performance and resource utilization reports.

### Trainer Portal
*   **Member Oversight**: Access to assigned member profiles and progress history.
*   **Workout Management**: creation and assignment of detailed exercise routines.
*   **Dietary Planning**: Construction of nutritional plans based on member metrics.
*   **Communication**: Dispatching system notifications to assigned members.

### Member Portal
*   **Status Overview**: Real-time view of subscription status and assigned trainer.
*   **Plan Access**: Interface for viewing assigned workout routines and diet plans.
*   **Progress Tracking**: Tools for logging biometric data (weight, BMI) over time.
*   **Notifications**: Reception of updates regarding plans or subscription status.

## Security

*   **Authentication**: Secure session-based authentication using Laravel's built-in guards or Laravel Sanctum.
*   **Role-Based Access Control (RBAC)**: Strict separation of duties enforced by middleware (`auth:gym`, `auth:trainer`, `auth:member`).
*   **Input Validation**: Server-side request validation using Laravel Form Requests to prevent malformed data injection.
*   **CSRF Protection**: Native Cross-Site Request Forgery protection on all state-changing routes.

## Tech Stack

**Backend**
*   **Framework**: Laravel 10
*   **Language**: PHP 8.1+
*   **Database**: MySQL
*   **Authentication**: Custom Guards (Multi-Auth)

**Frontend**
*   **Templating Engine**: Blade
*   **CSS Framework**: Bootstrap 5, SASS
*   **Asset Bundling**: Vite

## Folder Structure

The project adheres to a strict MVC implementation with role-based directory separation:

```text
gum/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Gym/          # Controllers for Gym Owner logic
│   │   │   ├── Trainer/      # Controllers for Trainer logic
│   │   │   └── Member/       # Controllers for Member logic
│   │   ├── Requests/         # Form validation classes
│   │   └── Middleware/       # Role-specific access control
│   └── Models/               # Eloquent ORM definitions
├── database/
│   ├── migrations/           # Schema definitions
│   └── seeders/              # Initial data population
├── resources/
│   ├── views/
│   │   ├── gym/              # Admin interface templates
│   │   ├── trainer/          # Trainer interface templates
│   │   └── member/           # Member interface templates
│   └── css/                  # SASS source files
└── routes/
    └── web.php               # Route definitions with grouped middleware
```

## Installation

Follow these steps to deploy the application in a local environment:

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yourusername/gum.git
    cd gum
    ```

2.  **Install Dependencies**
    Backend:
    ```bash
    composer install
    ```
    Frontend:
    ```bash
    npm install
    ```

3.  **Environment Configuration**
    Copy the example environment file:
    ```bash
    cp .env.example .env
    ```
    Configure the database connection in `.env`:
    ```ini
    DB_DATABASE=gum_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Database Setup**
    Run migrations and seed the database with initial test data:
    ```bash
    php artisan migrate --seed
    ```

6.  **Build Assets**
    ```bash
    npm run build
    ```

## Running the Application

Initialize the local development server:

```bash
php artisan serve
```

The application will be accessible at `http://127.0.0.1:8000`.
## Screenshots
## Screenshots

### Home Page
![Home Page](https://github.com/user-attachments/assets/9a59d92d-9a8e-4713-bc61-9f44b44287a2)
A clean and responsive landing page introducing GUM Gym Management System.

### Gym Members Login Page
![Gym Members Login Page](https://github.com/user-attachments/assets/e697a9bc-b9c2-429a-9226-cb5e2bce7cee)
The login interface specifically for Gym Members, allowing them to access their assigned workout routines, diet plans, and progress tracking.

### Admin Dashboard
![Admin Dashboard](https://github.com/user-attachments/assets/90fa81e9-0839-43a7-8a1f-40afe44fbfa5)
Dashboard view for Gym Members showing active members, subscriptions, and performance reports.

### Default Credentials

The `DatabaseSeeder` populates the database with the following accounts for testing:

**Gym Owner (Admin)**
*   Email: `gym@example.com`
*   Password: `123456`



**Trainer**
*   Email: `trainer@example.com`
*   Password: `123456`

**Member**
*   Email: `member@example.com` (Member Code: `MEM001`)
*   Password: `123456`
