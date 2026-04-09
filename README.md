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
- DB_HOST=db 
- DB_PORT=3306
- DB_DATABASE=toDoBoard_DB
- DB_USERNAME=your_username <-- input your database username
- DB_PASSWORD=your_password  <-- input your database password


# SERVICE URL
- API Endpoint http://localhost:8080/api/v1/
- Postman Collection and Environment https://www.dropbox.com/scl/fo/1irpy2qarc24extkzo0nm/AOvdioShPi1XtSU6yPopj_I?rlkey=ohazpy39mtufpfm4udtqr3y88&st=r4tkbqh1&dl=0
