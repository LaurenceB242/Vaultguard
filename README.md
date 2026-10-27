# VaultGuard

VaultGuard est un projet Symfony en cours de développement autour de la gestion de mots de passe. Il vise à permettre à chaque utilisateur de conserver ses identifiants de services dans un coffre personnel, avec des fonctionnalités de compte et de récupération d’accès.

Ce projet est réalisé dans le cadre de mon apprentissage, avec un accompagnement en partie de Gemini et de Claude.

## Fonctionnalités présentes

- Pages d’accueil, d’inscription et de connexion.
- Modèle de compte utilisateur avec adresse e-mail, rôles et mot de passe haché.
- Envoi d’un e-mail de confirmation et procédure de réinitialisation du mot de passe.
- Modèle de données pour les identifiants enregistrés : service, login, mot de passe et score de robustesse.
- Première interface du coffre, réservée aux utilisateurs connectés.
- Services prévus pour chiffrer un mot de passe et évaluer sa robustesse.

Le projet est encore au stade de prototype : le chiffrement et l’analyse de robustesse ne sont pas encore reliés au flux d’enregistrement des identifiants. Le coffre et certaines étapes d’authentification restent donc à finaliser. La clé de chiffrement actuelle est codée en dur ; ce mécanisme ne doit pas être considéré comme prêt pour protéger de vraies données.

## Organisation du code

```text
.
├── bin/                         Commandes Symfony
├── config/                      Configuration des services, routes et bundles
│   └── packages/                Configuration de Symfony, Doctrine, sécurité et e-mails
├── public/                      Point d’entrée HTTP de l’application
├── src/
│   ├── Controller/              Pages et traitements HTTP
│   ├── Entity/                  Utilisateur, identifiant et demande de réinitialisation
│   ├── Form/                    Formulaires Symfony
│   ├── Migrations/              Évolutions du schéma de base de données
│   ├── Repository/              Accès aux entités Doctrine
│   ├── Security/                Authentification et vérification d’adresse e-mail
│   └── Service/                 Chiffrement et analyse de robustesse (en cours)
├── templates/                   Vues Twig des pages et des e-mails
├── composer.json                Dépendances et configuration PHP
└── docker-compose.yml           Services de développement MySQL et Mailpit
```

### Rôle des principales parties

- **Controllers** : gèrent les pages d’accueil, d’inscription, de connexion, de réinitialisation et le coffre.
- **Entities et repositories** : représentent les données et leur accès via Doctrine ORM.
- **Forms** : définissent les champs et validations des formulaires.
- **Security** : contient l’authentificateur et le service de confirmation d’e-mail.
- **Services** : `EncryptionService` utilise l’extension Sodium pour le chiffrement symétrique ; `PasswordAnalyzerService` attribue un score et un niveau de robustesse.
- **Templates** : affichent les pages avec Twig, ainsi que les e-mails de confirmation et de réinitialisation.
- **Migrations** : créent les tables des utilisateurs, des demandes de réinitialisation et des identifiants.

## Technologies utilisées

- **PHP 8.3**
- **SymfonyLTS 7.4.21** : framework web, formulaires, sécurité, validation, sessions et envoi d’e-mails.
- **Twig** : moteur de templates.
- **Doctrine ORM et Doctrine Migrations** : persistance et évolution du schéma de données.
- **MySQL 8** : base de données prévue par la configuration Docker Compose.
- **SymfonyCasts VerifyEmail et ResetPassword** : briques de vérification d’adresse e-mail et de réinitialisation.
- **Sodium** : bibliothèque PHP utilisée par le service de chiffrement.
- **Docker Compose et Mailpit** : services prévus pour le développement et la réception locale des e-mails.
- **Bootstrap Icons** : icônes référencées dans les templates.
