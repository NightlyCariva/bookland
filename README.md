# 📚 Bookland - Application de Gestion de Bibliothèque

Une application web Symfony 5.4 pour la gestion d'une bibliothèque avec des livres, auteurs et genres.

## 🎯 Description

Bookland est une application de gestion de bibliothèque qui permet de :
- Gérer une collection de livres avec leurs métadonnées (ISBN, titre, nombre de pages, date de parution, note)
- Organiser les livres par auteurs et genres
- Effectuer des recherches avancées et des statistiques
- Analyser la parité des auteurs par genre

## 🏗️ Architecture

### Entités principales
- **Livre** : Contient les informations des livres (ISBN, titre, pages, date, note)
- **Auteur** : Gère les informations des auteurs (nom, nationalité, sexe)
- **Genre** : Catégorise les livres par genre littéraire

## 🚀 Installation

### Prérequis
- PHP >= 7.2.5
- Composer
- MySQL/MariaDB
- Symfony CLI (optionnel)

### Étapes d'installation

1. **Cloner le projet**
   ```bash
   git clone [URL_DU_REPO]
   cd bookland
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   - Créer une base de données MySQL
   - Modifier le fichier `.env` avec vos paramètres de connexion :
   ```env
   DATABASE_URL="mysql://username:password@127.0.0.1:3306/bookland"
   ```

4. **Créer les tables**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   # ou
   php -S localhost:8000 -t public/
   ```

## 📋 Fonctionnalités

### Gestion des livres
- ✅ Ajouter un nouveau livre
- ✅ Modifier un livre existant
- ✅ Supprimer un livre
- ✅ Consulter les détails d'un livre
- ✅ Lister tous les livres

### Gestion des auteurs
- ✅ Ajouter un nouvel auteur
- ✅ Modifier un auteur
- ✅ Consulter les détails d'un auteur
- ✅ Lister tous les auteurs

### Gestion des genres
- ✅ Ajouter un nouveau genre
- ✅ Lister tous les genres
- ✅ Consulter les livres par genre

### Recherches et statistiques
- ✅ Rechercher des livres par période de parution
- ✅ Rechercher des livres par note et période
- ✅ Lister les auteurs ayant écrit au moins 3 livres
- ✅ Analyser la parité des auteurs par genre
- ✅ Calculer le nombre total de pages par genre
- ✅ Lister les livres d'auteurs de nationalités différentes

## 🛠️ Technologies utilisées

- **Backend** : Symfony 5.4
- **Base de données** : MySQL avec Doctrine ORM
- **Template Engine** : Twig
- **Validation** : Symfony Validator
- **Tests** : PHPUnit
- **Frontend** : HTML, CSS, JavaScript

## 📁 Structure du projet

```
bookland/
├── src/
│   ├── Controller/          # Contrôleurs de l'application
│   ├── Entity/             # Entités Doctrine
│   ├── Form/               # Formulaires Symfony
│   ├── Repository/         # Repositories pour les requêtes personnalisées
│   └── Kernel.php
├── templates/              # Templates Twig
├── config/                 # Configuration Symfony
├── migrations/             # Migrations de base de données
├── public/                 # Fichiers publics (index.php)
└── var/                    # Cache et logs
```

## 🔧 Commandes utiles

### Base de données
```bash
# Créer une migration
php bin/console make:migration

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Vider la base de données
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### Cache
```bash
# Vider le cache
php bin/console cache:clear

# Vider le cache en production
php bin/console cache:clear --env=prod
```

### Tests
```bash
# Lancer les tests
php bin/phpunit
```

## 🌐 Routes principales

- `/` - Page d'accueil
- `/livre/` - Gestion des livres
- `/auteur/` - Gestion des auteurs
- `/genre/` - Gestion des genres
- `/action13` - Recherche par période
- `/action14` - Livres d'auteurs de nationalités différentes
- `/action15` - Recherche par note et période
- `/action16` - Auteurs avec au moins 3 livres
- `/action17` - Analyse de parité
- `/action18` - Genres par auteur
- `/action19` - Statistiques par genre


## 🤝 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence propriétaire.

## 👥 Auteurs

Développé dans le cadre d'un projet Universitaire.

---

**Note** : Assurez-vous de configurer correctement votre base de données avant de lancer l'application. 