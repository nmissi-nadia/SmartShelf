
# Système de Gestion des Rayons dans un Supermarché


## Table des matières
1. [Introduction](#introduction)
2. [Fonctionnalités principales](#fonctionnalités-principales)
3. [Diagramme de conception](#diagramme-de-conception)
4. [Installation](#installation)
5. [Utilisation](#utilisation)
6. [API Documentation](#api-documentation)
7. [Technologies utilisées](#technologies-utilisées)
8. [Contributions](#contributions)

---

## Introduction

Ce projet est un **système de gestion des rayons dans un supermarché**, conçu pour aider les administrateurs à gérer efficacement les produits, les catégories, les rayons et les commandes. Il permet également aux clients de consulter les produits populaires, les promotions et d'effectuer des recherches.

L'objectif principal est d'automatiser et de simplifier les opérations quotidiennes dans un supermarché, tout en offrant une interface intuitive pour les utilisateurs.

---

## Fonctionnalités principales

### Pour l'administrateur :
- **Gestion des produits** : Ajouter, modifier ou supprimer des produits dans un rayon.
- **Gestion des rayons** : Créer, modifier ou supprimer des rayons.
- **Statistiques** : Voir les statistiques sur les ventes, les produits populaires et les promotions.
- **Notifications** : Recevoir des alertes lorsque le stock d'un produit passe sous un seuil critique.

### Pour le client :
- **Rechercher un produit** : Rechercher un produit par nom ou catégorie.
- **Consulter les promotions** : Voir les produits en promotion ou populaires.
- **Consulter la liste des produits** : Accéder à une liste complète des produits disponibles.

---

## Diagramme de conception

Le diagramme de conception du système est disponible dans le fichier suivant :

- [Conception du système (PDF)](UML/conceptionSmartShelf.drawio.pdf)

Ce diagramme illustre les relations entre les entités principales du système (`Produit`, `Rayon`, `Catégorie`, `Commande`) ainsi que les cas d'utilisation pour les différents acteurs (Administrateur et Client).

---

## Installation

### Prérequis
Assurez-vous d'avoir les éléments suivants installés sur votre machine :
- PHP >= 8.0
- Composer
- PostreSQL
- Node.js et npm (pour le frontend, si applicable)

### Étapes d'installation
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/nmissi-nadia/SmartShelf.git
   cd supermarket-shelf-management
   ```

2. Installez les dépendances PHP :
   ```bash
   composer install
   ```

3. Configurez les variables d'environnement :
   - Dupliquez le fichier `.env.example` en `.env` :
     ```bash
     cp .env.example .env
     ```
   - Modifiez les variables d'environnement dans `.env` pour configurer la base de données et autres paramètres.

4. Générez une clé d'application :
   ```bash
   php artisan key:generate
   ```

5. Exécutez les migrations et les seeders :
   ```bash
   php artisan migrate --seed
   ```

6. Démarrez le serveur local :
   ```bash
   php artisan serve
   ```

7. Accédez à l'application via `http://localhost:8000`.

---

## Utilisation

### Pour l'administrateur :
- Connectez-vous avec un compte administrateur pour accéder aux fonctionnalités de gestion.
- Utilisez l'interface pour ajouter, modifier ou supprimer des produits, rayons et catégories.

### Pour le client :
- Consultez les produits disponibles, recherchez un produit spécifique ou explorez les promotions.

---

## API Documentation

La documentation de l'API est générée automatiquement à l'aide de Swagger. Pour accéder à la documentation :

1. Générez la documentation :
   ```bash
   php artisan l5-swagger:generate
   ```

2. Accédez à l'URL suivante dans votre navigateur :
   ```
   http://localhost:8000/api/documentation
   ```

---

## Technologies utilisées

- **Backend** : Laravel (PHP Framework)
- **Base de données** : PostegreSQL
- **Authentification** : Laravel Sanctum
- **Documentation API** : Swagger (via `darkaonline/l5-swagger`)
- **Outils de développement** : Git

---

## Contributions

Nous apprécions toutes les contributions ! Si vous souhaitez contribuer à ce projet :

1. Fork le dépôt.
2. Créez une branche pour vos modifications :
   ```bash
   git checkout -b feature/ma-nouvelle-fonctionnalite
   ```
3. Soumettez une Pull Request avec une description détaillée de vos changements.

---


## Contact

Pour toute question ou suggestion, veuillez contacter :

- **Nom** : [Nmissi Nadia]
- **Email** : [votre.email@example.com]
- **GitHub** : [https://github.com/nmissi-nadia](https://github.com/nmissi-nadia)

