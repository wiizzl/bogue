# Bogue

![](./public/favicon.ico)

Bogue est un projet scolaire réalisé en équipe. Il s'agit d'une application web de suivi de stage destinée aux enseignants, leur permettant de gérer et suivre les stages de leurs élèves.

## Environnement d'exécution

Ce projet est conçu pour fonctionner de deux manières :

- Via Docker (recommandé) : l'environnement est entièrement conteneurisé grâce à Docker et Docker Compose. C'est l'environnement utilisé pour la production.
- Via WAMP : le projet peut également être exécuté directement dans un environnement WAMP local.

Les versions des logiciels utilisées dans l'image Docker (PHP, MySQL) correspondent volontairement à celles de l'environnement WAMP du product owner, afin de garantir une cohérence et d'éviter tout problème de compatibilité entre les deux environnements.

| Programme  | Version |
| ---------- | ------- |
| PHP        | 8.2.18  |
| MySQL      | 8.3     |
| phpMyAdmin | 5.2.1   |

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

3. Bonus : Container de développement

Il est possible d'utiliser les [Development Container](https://containers.dev) pour simplifier l'environnement de développement, ce qui permet d'intégrer votre IDE directement dans le container.

### Via WAMP

1. Installer les dépendances PHP

   ```sh
   composer install
   ```

2. Importer la base de données

   ```sh
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
   ```

3. Lancer le serveur de développement

   ```sh
   symfony serve
   ```
