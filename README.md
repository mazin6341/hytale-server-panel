# Hytale Server Panel

A web-based control panel for managing your Docker Hytale Server, built with Laravel.

## Prerequisites

Ensure you have the following installed on your local machine:

-   [Docker](https://www.docker.com/)
-   [Docker Compose](https://docs.docker.com/compose/)
-   [Make](https://www.gnu.org/software/make/) (Optional)

## Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/mazin6341/hytale-server-panel.git
    cd hytale-server-panel
    ```

    Or if you already have a hytale docker container setup

    ```bash
    cd <your-hytale-docker-directory>
    git clone https://github.com/mazin6341/hytale-server-panel.git .
    ```

2.  **Copy the docker-compose.yml File**

    ```bash
    cp docker-compose.example.yml docker-compose.yml
    ```

    Or if you already have a hytale docker container setup, add the following service to your docker-compose.yml file.

    ```yaml
        hytale-web-panel:
            container_name: hytale-web-panel
            restart: unless-stopped
            build:
                context: .
                dockerfile: .docker/Dockerfile
            volumes:
                - ./src:/var/www/html
                - ./.docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini:ro
                - ./.docker/php/entrypoint.sh:/docker-entrypoint.sh:z
                - ./.docker/database:/var/www/database
                - ./.docker:/var/www/.docker
                - /var/run/docker.sock:/var/run/docker.sock
                # Game Server Folder
                - ./data:/var/www/html/data
            ports:
                - "8000:8000"
            entrypoint: /bin/sh /docker-entrypoint.sh
    ```

### With Makefile
3. **Automatic Docker & Application Setup**

    ```bash
    make first-boot
    ```

NOTE: This step requires user input for user creation!

4. **Start Application**

    ```bash
    make start
    ```

### Without Makefile

3. **Manual Docker & Application Setup**

    ```bash
    touch .docker/.env
    docker-compose build
    docker-compose run --rm --entrypoint "/bin/sh /firstboot.sh" -v $(pwd)/.docker/php/firstboot.sh:/firstboot.sh hytale-web-panel
    ```

NOTE: This step requires user input for user creation!

4. **Start Application**

    ```bash
    docker-compose up -d
    ```

## Creating your first user

**NOTE: The first user in the system will be automatically assigned Super Admin role!**

    ```bash
    docker-compose exec hytale-web-panel php artisan user:create
    ```

## Usage

Once the containers are running, you can access the application at `http://localhost:8000` (or the port defined in your Docker configuration).

## Makefile Commands

This project includes a `Makefile` to simplify common tasks:

-   `make start`: Start all containers.
-   `make stop`: Stop all containers.
-   `make restart`: Restart all containers.
-   `make build`: Build all containers.
-   `make logs`: Follow application logs.
-   `make exec`: Open a bash shell inside the application container.