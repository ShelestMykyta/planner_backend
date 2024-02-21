# Simple Planner (Backend)

The project implements the backend part of the Simple Planner application.
## Requirements

Before you begin, make sure you have the following components installed:
- Docker
- Docker Compose

## Інструкції з використання

1. Deployment instructions:
    - Clone the repository:
    ```bash
    git clone git@github.com:ShelestMykyta/planner_backend.git
    ```
    - Go to the project folder:
    ```bash
    cd planner_backend
    ```
    - Run the following command to start the application:
    ```bash
    docker-compose up -d --build
    ```
    - Run the following command:
    ```bash
    docker-compose exec php bash
    ```
    - Run composer script in bash:
    ```bash
    composer i
    ```
   - Run command to generate key:
    ```bash
    php artisan key:generate
    ```
    - The application will be available at the following address:
    ```bash
    http://localhost:8080
    ```
