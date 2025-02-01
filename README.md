
# UserApp

This app allows you to create, edit, and delete users using Laravel.

## Installation  

To make it work, you need to clone the repository with the following command:  

```bash
git clone git@github.com:Danielfo684/userApp.git
```

You will need to have **Composer** and **Laravel** installed beforehand.  

## Configuration  

Edit the `.env` file with the following changes:  

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_user
DB_PASSWORD=your_password

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Use an email of your preference.  

## Final Steps  

Generate the application key and migrate the tables with the following commands:  

```bash
php artisan key:generate
php artisan migrate
```

## Project Features  
- User creation, editing, and deletion  
- Email verification  
- Admin panel to manage users


# More info available on the following portfolio:
https://danielfo684.github.io/Portfolio/


# Code and UI:

## Screenshots

### User List
![User List](/documentation/usuarios.png)

### User Creation
![User Creation](/documentation/login.png)

### User Editing
![User Editing](/documentation/perfil.png)

### Middleware
![Admin Panel](/documentation/middleware.png)

### Migration
![Admin Panel](/documentation/base%20migration.png.png)
