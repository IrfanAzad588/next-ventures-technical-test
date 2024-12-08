### User, Role, and Permission Management API 

This is a RESTful API built using Laravel for managing users, roles, and permissions. It supports secure token-based authentication using Laravel Passport and follows clean architecture principles for scalability and maintainability.

Features:
1. User management with multiple roles and permissions.
2. Role management with associated permissions.
3. Permission inheritance through roles.
4. Laravel Passport for secure token-based authentication.
5. Clean code structure using the Repository Pattern.

Prerequisites:
1. PHP >= 8.0
2. Laravel 10
3. Composer
4. MySQL or any compatible database
5. Laravel Passport installed

Installation:
    1. Clone the repository:
        git clone <repository-url>  
        cd <project-directory>
    2. Install dependencies:
        composer install
    3. Set up the environment:
        Copy .env.example to .env.
        Configure your database and other environment settings in the .env file.
    4. Run migrations and seeders: 
	    php artisan migrate --seed  
    5. Install and configure Laravel Passport:
	    php artisan passport:install  
    6. Start the development server:
	    php artisan serve

Authentication
    This API uses Laravel Passport for token-based authentication.
     1. Use the /api/login endpoint to log in and retrieve an access token.
     2. Pass the token as a Bearer token in the Authorization header for protected         routes.

Examples of API usage:
For logging in, use the following endpoint:
Endpoint: http://localhost:8000/api/login
Credentials:
Email: superadmin@gmail.com
Password: 123456


After logging in, you can manage users, roles, and permissions. This allows you to create, retrieve, update, and delete users, roles, and permissions seamlessly.

User Management Endpoints
Authorization: Bearer Token
1. POST localhost:8000/api/user/store: Create a user
2. GET localhost:8000/api/user/show?id={id}: Show a user
3. GET localhost:8000/api/user/list: Show all users
4. POST localhost:8000/api/user/update: Update a user
5. POST localhost:8000/api/user/delete: Delete a user

Role Management Endpoints
Authorization: Bearer Token
1. POST localhost:8000/api/role/store: Create a role
2. GET localhost:8000/api/role/show?id={id}: Show a role
3. GET localhost:8000/api/role/list: Show all roles
4. POST localhost:8000/api/role/update: Update a role
5. POST localhost:8000/api/role/delete: Delete a role

Permission Management Endpoints
Authorization: Bearer Token
1. POST localhost:8000/api/permission/store: Create a permission
2. GET localhost:8000/api/permission/show?id={id}: Show a permission
3. GET localhost:8000/api/permission/list: Show all permissions
4. POST localhost:8000/api/permission/update: Update a permission
6. POST localhost:8000/api/permission/delete: Delete a permission
