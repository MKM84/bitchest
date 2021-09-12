
# Bitchest


## Description :
BitChest est une application web qui a pour vocation de permettre à des particuliers d’acheter et de vendre des cryptomonnaies (Cryptocurrencies), tel que le Bitcoin ou l’Ethereum.

Après installation du projet sur votre environnement de développement, vous pourriez vous y connecter en tant que client où vous pouvez acheter ou vendre des cryptomonnaies, consulter les cours actuels de ces dernières, consulter l'historique de vos transactions... Si vous vous connectez en tant que admin, vous pourriez consulter également les cryptomonnnaies supportées par l'application et gérer les clients, modifier, supprimer...

## Avant propos :

Ce projet est une SPA, vous aurez besoin de la lancer sur deux serveurs locals.
L'authentification se fera à l'aide des cookies lorsque la demande entrante provient de votre propre interface SPA, cela vous impliquera de lancer le back et le front sur le même domaine.
Ex : 

Front : http://localhost:8080/

Back : http://localhost:8000/

Technologies :

Back :
- composer 2.1.3
- Laravel 8.58.0
- Laravel Sanctum

Front
- Node v16.3.0
- npm 7.15.1
- Vue.js 3 / Vue CLI 

## Initialisation du projet :

Téléchargez le repo. 

Créez une base de donnée sur phpMyAdmin.

Créez un fichier .env à la racine du projet, copier-coller le contenu du fichier .env.example et modifiez les lignes suivantes comme suit :

- APP_NAME = BitChest
à la racine du projet

       composer install
- APP_KEY = Générez une clé avec la commande :

        php artisan key:generate

- DB_DATABASE =  "Nom de votre base de données"
- DB_PORT = "Port de votre base de données"
- DB_USERNAME = "L'identifiant de votre base de données"
- DB_PASSWORD = "Mot de passe de connexion à votre base de données"
- SESSION_DRIVER = cookie
- Ajouter les ligne suivantes :

    - “SESSION_DOMAIN=localhost:8080"  ou l'adresse de votre localhost dans lequel est lancé la partie front du projet.
    - “SANCTUM_STATEFUL_DOMAINS=localhost:8000” ou l'adresse du localhost où est lancé le projet.

Modifiez le fichier database.php en fonction votre DB.

### Dans votre ligne de commande à la racine du projet :
    
        php artisan migrate:fresh --seed`
        php artisan serve

### Dans votre ligne de commande à la racine du projet :
        cd bitchest-front
        npm install
        npm run serve ou yarn serve

### Connexion à l'application :

Pour vous connecter en tant que client :

`email : majed@majed.fr`

`mot de passe : password1`

Pour vous connecter en tant que admin :

`email : ludovic@ludovic.fr`

`mot de passe : password2`

Vous pouvez récuperez les adresses mail des utilisateurs sur phpMyAdmin et vous connecter avec le mot de passe `password`
