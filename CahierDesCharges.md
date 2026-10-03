# ProgServ2-Nussbaum-Pauline-Caumeil-Beno-t

# Le Scope
**Projet de Benoît Caumeil et Pauline Nussbaum**

## Concept
Le Scope est une application web interactive destinée à recenser et mettre en lumière les artistes de Suisse romande gravitant autour du domaine musical. L'application ne se limite pas aux musiciens, mais inclut également les métiers de l'ombre et de l'image (vidéastes, designers, ingénieurs du son). Le but est de créer un annuaire interactif, visuel et communautaire.

## Différents types d'utilisation

* **Visiteur (Non connecté) :** Peut naviguer sur les différents onglets, chercher des artistes, utiliser les filtres et consulter la carte.
* **Membre (Connecté) :** Possède un compte. Peut ajouter des artistes à sa liste personnelle (le "Scopedex") et attribuer des "Likes" pour influencer la mise en avant des artistes. *Pour créer une page artiste, il faut également se connecter pour pouvoir remplir un formulaire.*
* **Administrateur :** Possède des droits étendus. Reçoit les soumissions du formulaire des artistes, les analyse, et approuve ou rejette leur publication sur le site. Reçoit une notification lorsqu'une page artiste est mise à jour.

## Pages et fonctionnalités

* **Menu bandeau :** Donne accès aux différentes pages du site. Point d'accès pour s'inscrire ou se connecter à son compte.
* **Page d'accueil :** Met en avant le nom du site et les différentes pages disponibles. Possède une grande barre de recherche pour rechercher un artiste.
*  **Page de Recherche :** Permet d'effectuer des recherches précises grâce à une barre de recherche et des filtres spécifique.
*   **Page artiste :** Présente les informations précises d'un.e artiste.
* **Page Musique :** Page de découverte mettant en avant les genres musicaux présents en Suisse romande. Affichage dynamique des artistes les plus populaires (basé sur le nombre de Likes des utilisateurs). Donne accès aux différentes pages spécifiques à chaque style de musique.
* **Page Map :** Une carte interactive affichant la provenance des artistes enregistrés en fonction de leur code postal/région. Donne accès aux différentes pages spécifiques par région.
* **Page Métiers :** Un annuaire classé par catégories professionnelles (ex: Musiciens, Vidéastes, Graphistes, Beatmakers) pour faciliter la recherche de collaborateurs dans le milieu musical. Donne accès aux différentes pages spécifiques par métier.
* **Page de création d'une page artiste :** Pour figurer sur le site, un artiste doit soumettre une candidature qui passera par un flux d'approbation (Statuts : En attente, Approuvé, Refusé).
  * **Formulaire de soumission Artiste :**
    * *Informations de base (obligatoire):* Nom, Photo de profil, Description. 
    * *Catégorisation :* Domaine d’activité (obligatoire, choix multiple), Genre musical (choix multiple).
    * *Localisation :* Région, Code postal.
    * *Contact & Liens :* Email de contact, Liens vers les plateformes de streaming (Spotify, Apple Music, etc.).
    * *Réseaux Sociaux :* Liens vers Instagram, Facebook, TikTok, YouTube.
    *  **Page formulaire modification de page artiste :** Cette page propose aux utilisateurs de changer les éléments présent sur leur page d'artiste
* **Page de connexion ou inscription :** Inscription et connexion via un formulaire standard (Nom d'utilisateur, Email, Mot de passe).
* **Pages Membre :** Une fois connecté, le membre a accès à sa page "Likes" (les artistes qu'il a likés) et "Scopedex" (les artistes qu'il a enregistrés).
* **Page favoris :** Fonctionne comme une page supplémentaire auquel les utilisateurs enregistrés ont accès, elle présente les artistes que l'utilisateur a liker/enregistrer dans ses favoris.
* **Page contact :** Cette page donne les contacts disponible des modérateurs du site, ainsi qu'une jolie photo.

## Moyens de recherche

* **Recherche Globale :** Une barre de recherche omniprésente sur le site permettant de chercher un artiste par son nom.
* **Recherche filtrée :** Permet d'affiner les résultats selon le métier, le genre musical et la région. Disponible sur chaque page, hormis depuis la page d'accueil.

## Fonctionnalités générales

**Indispensables :**
* Création du compte pour pouvoir accéder à chacune des fonctionnalités
* Rechercher des artistes par nom ou filtre.
* Ajouter des pages artistes.
* Modifier sa page artiste.
* L'administrateur doit accepter la publication de la page.

**Fonctionnalités du compte :**
* Ajouter des pages artistes.
* Modifier sa page artiste
* Modifier une page artiste.
* Accès aux contacts
* Liste d'artistes favoris.
