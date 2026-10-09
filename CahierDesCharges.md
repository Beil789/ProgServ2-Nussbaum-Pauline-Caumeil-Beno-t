# ProgServ2-Nussbaum-Pauline-Caumeil-Beno-t

# Le Scope
**Projet de Benoît Caumeil et Pauline Nussbaum**

## Concept
Le Scope est une application web interactive destinée à recenser et mettre en lumière les artistes de Suisse romande gravitant autour du domaine musical. L'application ne se limite pas aux musiciens, mais inclut également les métiers de l'ombre et de l'image (vidéastes, designers, ingénieurs du son). Le but est de créer un annuaire interactif, visuel et communautaire.

## Différents types d'utilisation

* **Visiteur (Non connecté) :** Peut naviguer sur les différents onglets, chercher des artistes, voir les pages artistes.
* **Membre (Connecté) :** Possède un compte. Peut ajouter des artistes à sa liste de favoris et attribuer des "Likes" pour influencer la mise en avant des artistes. *Pour créer une page artiste, il faut également se connecter pour pouvoir remplir un formulaire.*
* **Administrateur :** Possède des droits étendus. Reçoit les soumissions du formulaire des artistes, les analyse, et approuve ou rejette leur publication sur le site. Reçoit une notification lorsqu'une page artiste est mise à jour.

## Pages et fonctionnalités

* **Menu bandeau :** Donne accès aux différentes pages du site. Point d'accès pour s'inscrire ou se connecter à son compte.
* **Page d'accueil :** Met en avant le nom du site et son principe. Possède une grande barre de recherche pour rechercher un artiste. Mets en avant les différentes catégorie de recherche d'artiste.
*  **Page de Recherche :** Permet d'effectuer des recherches précises grâce à une barre de recherche et des filtres spécifique. En cas de recherche global, affichage dynamique des artistes les plus populaires (basé sur le nombre de Likes )
*   **Page Artiste :** Présente les informations précises d'un.e artiste.
* **Page de création d'une page artiste :** Pour figurer sur le site, un artiste doit remplir un formulaire qui passera par un flux d'approbation (Statuts : En attente, Approuvé, Refusé).
  * **Formulaire de soumission Artiste :**
    * *Informations de base (obligatoire):* Nom, Photo de profil, Description. 
    * *Catégorisation :* Domaine d’activité (obligatoire, choix à selectionner), Genre musical (choix multiple).
    * *Localisation :* Canton (obligatoire), Code postal, Localité.
    * *Contact & Liens :* Email de contact (obligatoire), Liens vers les plateformes de streaming (Spotify, Apple Music, etc.).
    * *Réseaux Sociaux :* Liens vers Instagram, Facebook, TikTok, YouTube.
    *  **Page formulaire modification/ suppression de page artiste :** Cette page propose aux utilisateurs de changer les éléments présent sur leur page d'artiste ou de la supprimer.
* **Page de connexion ou inscription :** Inscription et connexion via un formulaire standard (Nom d'utilisateur, Email, Mot de passe).
* **Pages Membre :** Une fois connecté, le membre a accès à sa page "Favoris" (les artistes qu'il a enregister) et il peut également liker la page des artistes.
* **Page favoris :** Fonctionne comme une page supplémentaire auquel les utilisateurs enregistrés ont accès, elle présente les artistes que l'utilisateur a liker/enregistrer dans ses favoris, les options de filtres y sont également disponible.
* **Page contact :** Cette page donne les contacts disponible des modérateurs du site, ainsi qu'une jolie photo.

## Moyens de recherche

* **Recherche Globale :** Une barre de recherche omniprésente sur le site permettant de chercher un artiste par son nom.
* **Recherche filtrée :** Permet d'affiner les résultats selon le métier, le genre musical et la région. Disponible sur chaque page, hormis depuis la page d'accueil.

## Fonctionnalités générales

**Indispensables :**
* Rechercher des artistes par nom ou filtre.
* Création du compte pour pouvoir accéder à chacune des fonctionnalités
* Créer des pages artistes.
* L'administrateur doit accepter la publication de la page
* Ajouter des pages artistes à ses favoris

**Secondaire :**
* Liker des pages Artiste
* Modifier et supprimer sa page artiste
* Supprimer son compte utilisateur


## Lien Maquette Figma :
https://www.figma.com/design/7HT2EGw87xnV7Yw5yauOT8/Maquette_LE-SCOPE?node-id=0-1&t=tTIJpuQIzi6ydbbc-1