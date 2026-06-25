# Parfum Bloom - Application Web PHP

## Description

**Parfum Bloom** est une application web développée en **PHP** pour la présentation et la gestion d’une boutique de parfums.
Le projet permet d’afficher des produits, de présenter les collections de parfums et de proposer une interface simple pour les utilisateurs.

Ce projet a été réalisé dans un objectif d’apprentissage et de pratique du développement web avec PHP, HTML, CSS, JavaScript et MySQL.

## Fonctionnalités principales

* Page d’accueil de la boutique
* Présentation des parfums disponibles
* Affichage des détails des produits
* Interface utilisateur simple et responsive
* Gestion des pages avec PHP
* Connexion à une base de données MySQL
* Organisation des fichiers du projet
* Design adapté à une boutique de parfums

## Technologies utilisées

| Partie             | Technologie           |
| ------------------ | --------------------- |
| Frontend           | HTML, CSS, JavaScript |
| Backend            | PHP                   |
| Base de données    | MySQL                 |
| Serveur local      | XAMPP                 |
| Éditeur recommandé | Visual Studio Code    |

## Structure du projet

```text
parfum-bloom-php/
│
├── README.md
├── index.php
├── config.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── pages/
│   ├── produits.php
│   ├── details.php
│   └── contact.php
│
└── database/
    └── parfum_bloom.sql
```

> La structure peut varier selon l’organisation réelle du projet.

## Installation locale

### 1. Prérequis

Avant de lancer le projet, installer :

* XAMPP
* PHP
* MySQL
* phpMyAdmin
* Visual Studio Code

### 2. Cloner le projet

```bash
git clone https://github.com/haninhamdi-gif/parfum-bloom-php.git
```

### 3. Placer le projet dans XAMPP

Copier le dossier du projet dans :

```text
C:\xampp\htdocs\
```

Le chemin final doit être similaire à :

```text
C:\xampp\htdocs\parfum-bloom-php
```

### 4. Lancer XAMPP

Ouvrir XAMPP puis démarrer :

* Apache
* MySQL

### 5. Créer la base de données

Ouvrir phpMyAdmin :

```text
http://localhost/phpmyadmin
```

Créer une base de données, par exemple :

```sql
parfum_bloom
```

Puis importer le fichier SQL du projet, s’il existe :

```text
database/parfum_bloom.sql
```

### 6. Configurer la connexion à la base de données

Dans le fichier `config.php`, vérifier les paramètres de connexion :

```php
<?php

$host = "localhost";
$dbname = "parfum_bloom";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.");
}
```

### 7. Lancer l’application

Ouvrir le navigateur et accéder à :

```text
http://localhost/parfum-bloom-php/
```

## Objectifs du projet

* Pratiquer le développement web avec PHP
* Créer une interface claire pour une boutique de parfums
* Organiser un projet web de manière professionnelle
* Utiliser une base de données MySQL
* Améliorer la structure du code et la présentation sur GitHub

## Améliorations futures

* Ajouter un espace administrateur
* Ajouter la gestion complète des produits
* Ajouter un panier d’achat
* Ajouter une page de connexion utilisateur
* Ajouter un système de recherche et de filtrage
* Améliorer le design responsive
* Ajouter une validation des formulaires
* Sécuriser davantage la connexion à la base de données

## Bonnes pratiques de sécurité

Avant de publier le projet en public :

* Ne pas publier les vrais mots de passe
* Ne pas publier de données personnelles
* Utiliser un fichier `config.example.php`
* Ajouter `config.php` dans `.gitignore`
* Utiliser des données fictives pour la démonstration

Exemple de `.gitignore` :

```gitignore
config.php
.env
*.log
.DS_Store
Thumbs.db
/vendor/
```

## Auteur

Projet réalisé par **Hanin Hamdi**.

## Licence

Ce projet est réalisé dans un cadre académique et d’apprentissage.
Toute réutilisation doit mentionner l’auteur du projet.
