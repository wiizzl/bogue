# Bogue

## Prérequis

- [Docker](https://docs.docker.com/get-docker)
- [Docker Compose](https://docs.docker.com/compose/install)

## Installation

1. Cloner le dépôt

    ```sh
    git clone https://github.com/wiizzl/bogue
    cd bogue
    ```

2. Lancer l'environnement

    ```sh
    docker compose up -d
    ```

## Utilisation

| Service     | URL                                     | Description                                   |
| ----------- | --------------------------------------- | --------------------------------------------- |
| Application | [localhost:8080](http://localhost:8080) | Interface principale de l'application Symfony |
| phpMyAdmin  | [localhost:8081](http://localhost:8081) | Gestion de la base de données                 |
