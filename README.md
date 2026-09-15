# Hospital Laravel Microservices

Laravel 12 backend services for the hospital system. Each service is an independent Laravel application with its own dependencies, environment configuration, and database.

## Services

| Service | Directory | Port | Database |
| --- | --- | ---: | --- |
| Authentication | `hospital.auth-service/` | 8001 | `hospital_auth_db` |
| Patient | `hospital.patient-service/` | 8002 | `hospital_patient_db` |
| OPD | `hospital.opd-service/` | 8003 | `hospital_opd_db` |
| Doctor consultation | `hospital.consultation-service/` | 8004 | `hospital_doctor_consultation_db` |

The authentication service currently exposes its API under `http://127.0.0.1:8001/api`. Each service also exposes Laravel's health endpoint at `/up`.

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js 18 or newer and npm
- Docker with Docker Compose, or a local MySQL 8 installation

## Local setup

1. Install the root development dependency:

   ```bash
   npm install
   ```

2. Install PHP dependencies and create local environment files:

   ```bash
   for service in hospital.auth-service hospital.patient-service hospital.opd-service hospital.consultation-service; do
     composer install --working-dir="$service"
     cp "$service/.env.example" "$service/.env"
     php "$service/artisan" key:generate
   done
   ```

3. Start MySQL:

   ```bash
   docker compose up -d mysql
   ```

   Docker exposes MySQL on host port `8889`. Create the four databases:

   ```bash
   docker compose exec mysql mysql -uroot -proot -e \
     "CREATE DATABASE IF NOT EXISTS hospital_auth_db; \
      CREATE DATABASE IF NOT EXISTS hospital_patient_db; \
      CREATE DATABASE IF NOT EXISTS hospital_opd_db; \
      CREATE DATABASE IF NOT EXISTS hospital_doctor_consultation_db;"
   ```

4. Configure each service's local `.env` for MySQL. Use these common values and the database name from the services table:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=8889
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

5. Run migrations for each service:

   ```bash
   for service in hospital.auth-service hospital.patient-service hospital.opd-service hospital.consultation-service; do
     php "$service/artisan" migrate
   done
   ```

6. Start all four Laravel development servers:

   ```bash
   npm run dev
   ```

## Repository layout

```text
hospital-laravel-microservice/
├── hospital.auth-service/
├── hospital.patient-service/
├── hospital.opd-service/
├── hospital.consultation-service/
├── docker/
├── MySQL/                  # local dumps are ignored
├── docker-compose.yml
├── package.json
├── package-lock.json
├── .dockerignore
├── .gitignore
└── README.md
```

## Repository hygiene

Local `.env` files, installed dependencies, application logs, compiled Laravel files, SQLite runtime databases, and files under `MySQL/` are intentionally excluded from Git. Commit each service's `.env.example` so other developers can create their own local configuration.
