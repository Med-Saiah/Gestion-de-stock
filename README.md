# Logiciel de Gestion de Stock - Web App

## Description

Ce projet est une application web de gestion de stock et de facturation, développée en **PHP (OOP)** avec **MySQL** pour la base de données et **HTML/CSS** pour l’interface utilisateur.  
Il permet aux administrateurs et utilisateurs de :

- Gérer les produits
- Gérer les utilisateurs
- Gérer les clients
- Gérer les factures
- Visualiser les détails des factures

---

## Fonctionnalités

- Authentification avec gestion de rôles (admin et utilisateur)
- Ajout, modification et suppression de produits
- Ajout, modification et suppression de clients
- Génération et consultation de factures
- Mise à jour automatique du stock
- Suivi des achats par client

---

## Installation

### Prérequis

- Serveur local PHP avec MySQL (XAMPP recommandé)
- Navigateur web

### Étapes

1. Clonez ou téléchargez le projet.
2. Placez le dossier du projet dans le dossier `htdocs` de XAMPP.
3. Importez le fichier `store.sql` dans **phpMyAdmin** pour créer la base de données et les tables.
4. Démarrez **Apache** et **MySQL** depuis le panneau XAMPP.
5. Accédez au projet via : `http://localhost/nom_du_projet`

---

## Informations de Connexion

### Compte Administrateur

- **Username** : `admin`
- **Password** : `admin`

### Compte Utilisateur

- **Username** : `user`
- **Password** : `user`

---

## Remarques Importantes

- ✅ Le programme par défaut s'exécute uniquement sur le **serveur XAMPP**.
- ⚠️ Si vous souhaitez l'exécuter sur le **serveur WAMP**, remplacez le fichier `Database.php` dans le dossier `classes` par le fichier `Database.php` dans le dossier principal.
- 📭 Le tableau de factures est **vide au début**, vous devez d'abord **ajouter des factures** pour qu'elles s'affichent.

---

## Structure du Projet

/project-root
│
├── main.php
├── login.php
├── user_manage.php
├── product_manage.php
├── client_manage.php
├── facture_manage.php
├── invoice_view.php
├── classes/
│ └── Database.php
├── style.css
├── login.css
└── README.md


---

## Auteurs

Développé par [Mohamed SAIAH AISSA] – [(https://github.com/Med-Saiah)]

---

## Licence

Ce projet est libre d'utilisation à des fins académiques ou personnelles.
