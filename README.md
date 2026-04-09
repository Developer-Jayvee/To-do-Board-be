# To-do Board Backend Application

Laravel backend API for the To-do Board application.

## Prerequisites

Before you begin, ensure you have the following installed on your system:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [PHP](https://www.php.net/downloads) (>= 8.0)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/downloads/)

## Environment Configuration

### Database Setup

1. Copy the example environment file:
```bash
cp .env.example .env
```

2. Open the .env file and update the database credentials:

env
- DB_CONNECTION=mysql
- DB_HOST=db <-- change this if not using docker 
- DB_PORT=3306
- DB_DATABASE=toDoBoard_DB
- DB_USERNAME=your_username <-- input your database username
- DB_PASSWORD=your_password  <-- input your database password


## If you are not using docker and want to run manually run these commands

### 1. Run this to install required dependencies
```bash
composer install
```
### 2. Install passport
if error occured while migrating , ignore it continue to the next command
```bash
php artisan passport:install

# If not yet migrated run
php artisan migrate
```
### 3. Setup client then input `toDoBoard` then click enter 
```bash
php artisan passport:client --personal
```
### 4. Generate an env key
```bash
php artisan key:generate
```
### 5. Run this seed command
```bash
php artisan db:seed --class=CategorySeed
```

### 6. Last run this command for email sending and for running the application
``` bash
php artisan queue:work

php artisan serve
```



# SERVICE URL
- API Endpoint http://localhost:8080/api/v1/ - You may change the url to the result of php artisan serve command , if you are not using docker but if yes , keep it as is
- Postman Collection and Environment https://www.dropbox.com/scl/fo/1irpy2qarc24extkzo0nm/AOvdioShPi1XtSU6yPopj_I?rlkey=ohazpy39mtufpfm4udtqr3y88&st=r4tkbqh1&dl=0
