# Bogue

![](./public/favicon.ico)

## Environnement d'exécution

Ce projet est conçu pour fonctionner de deux manières :

- Via Docker (recommandé) — l'environnement est entièrement conteneurisé grâce à Docker et Docker Compose. C'est notamment l'environnement utilisé pour la production.
- Via WAMP — le projet peut également être exécuté directement dans un environnement WAMP local.

Les versions des logiciels utilisées dans l'image Docker (PHP, MySQL, ...) correspondent volontairement à celles de l'environnement WAMP du product owner, afin de garantir une cohérence et d'éviter tout problème de compatibilité entre les deux environnements.

## Installation

### Via Docker

1. Lancer l'environnement

   ```sh
   docker compose build --pull --no-cache
   ```

   ```sh
   docker compose up --wait
   ```

2. Stopper l'environnement

   ```sh
   docker compose down --remove-orphans
   ```

### Via WAMP

1. Importer la base de données

Ouvrir phpMyAdmin et exécuter le script sql contenu dans le dossier [`sql`](./sql/).

2. Installer les dépendances PHP

   ```sh
   composer install
   ```

3. Lancer le serveur de développement

   ```sh
   symfony server:start
   ```
