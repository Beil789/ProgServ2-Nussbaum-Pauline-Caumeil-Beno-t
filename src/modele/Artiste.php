<?php

class Artiste {
    private ?int $id_artiste = null;
    private string $nom;
    private string $email_contact;
    private ?string $description = null;
    private ?string $photo = null;
    private ?string $npa = null;
    private ?string $localite = null;
    private ?string $lien = null;
    private ?string $url_insta = null;
    private ?string $url_facebook = null;
    private ?string $url_youtube = null;
    private ?string $url_tiktok = null;
    private ?int $id_user = null;
    private int $id_metier;
    private int $id_canton;
    private int $id_statut = 2; 

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id'])) $this->setIdArtiste((int) $data['id']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
        if (isset($data['email_contact'])) $this->setEmailContact($data['email_contact']);
        if (isset($data['description'])) $this->setDescription($data['description']);
        if (isset($data['photo'])) $this->setPhoto($data['photo']);
        if (isset($data['npa'])) $this->setNpa($data['npa'] !== '' ? (string) $data['npa'] : null);
        if (isset($data['localite'])) $this->setLocalite($data['localite']);
        if (isset($data['lien'])) $this->setLien($data['lien']);
        if (isset($data['url_insta'])) $this->setUrlInsta($data['url_insta']);
        if (isset($data['url_facebook'])) $this->setUrlFacebook($data['url_facebook']);
        if (isset($data['url_youtube'])) $this->setUrlYoutube($data['url_youtube']);
        if (isset($data['url_tiktok'])) $this->setUrlTiktok($data['url_tiktok']);
        if (isset($data['id_utilisateur'])) $this->setIdUser((int) $data['id_utilisateur']);
        if (isset($data['id_metier'])) $this->setIdMetier((int) $data['id_metier']);
        if (isset($data['id_canton'])) $this->setIdCanton((int) $data['id_canton']);
        if (isset($data['id_statut'])) $this->setIdStatut((int) $data['id_statut']);
    }

    public function getIdArtiste(): ?int { return $this->id_artiste; }
    public function setIdArtiste(?int $id_artiste): void { $this->id_artiste = $id_artiste; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getEmailContact(): string { return $this->email_contact; }
    public function setEmailContact(string $email_contact): void { $this->email_contact = $email_contact; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }

    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(?string $photo): void { $this->photo = $photo; }

    public function getNpa(): ?string { return $this->npa; }
    public function setNpa(?string $npa): void { $this->npa = $npa; }

    public function getLocalite(): ?string { return $this->localite; }
    public function setLocalite(?string $localite): void { $this->localite = $localite; }

    public function getLien(): ?string { return $this->lien; }
    public function setLien(?string $lien): void { $this->lien = $lien; }

    public function getUrlInsta(): ?string { return $this->url_insta; }
    public function setUrlInsta(?string $url_insta): void { $this->url_insta = $url_insta; }

    public function getUrlFacebook(): ?string { return $this->url_facebook; }
    public function setUrlFacebook(?string $url_facebook): void { $this->url_facebook = $url_facebook; }

    public function getUrlYoutube(): ?string { return $this->url_youtube; }
    public function setUrlYoutube(?string $url_youtube): void { $this->url_youtube = $url_youtube; }

    public function getUrlTiktok(): ?string { return $this->url_tiktok; }
    public function setUrlTiktok(?string $url_tiktok): void { $this->url_tiktok = $url_tiktok; }

    public function getIdUser(): ?int { return $this->id_user; }
    public function setIdUser(?int $id_user): void { $this->id_user = $id_user; }

    public function getIdMetier(): int { return $this->id_metier; }
    public function setIdMetier(int $id_metier): void { $this->id_metier = $id_metier; }

    public function getIdCanton(): int { return $this->id_canton; }
    public function setIdCanton(int $id_canton): void { $this->id_canton = $id_canton; }

    public function getIdStatut(): int { return $this->id_statut; }
    public function setIdStatut(int $id_statut): void { $this->id_statut = $id_statut; }
}