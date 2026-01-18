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

### With Makefile
2. **Automatic Docker & Application Setup**

    ```bash
    make first-boot
    ```

3. **Start Application**

    ```bash
    make start
    ```

### Without Makefile

2. **Manual Docker & Application Setup**

    ```bash
    touch .docker/.env
    docker-compose build
    docker-compose run --rm --entrypoint "/bin/sh /firstboot.sh" -v $(pwd)/.docker/php/firstboot.sh:/firstboot.sh hytale-web-panel
    ```

3. **Start Application**

    ```bash
    docker-compose up -d
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