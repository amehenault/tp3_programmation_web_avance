

## 5. GitHub (dépôt public) : https://github.com/amehenault/tp3_programmation_web_avance.git
- [ ] Dans le terminal, à partir du dossier `amelie-henault_tp3` :
  ```
  git init
  git add .
  git commit -m "Remise du TP3"
  git branch -M main
  git remote add origin https://github.com/amehenault/tp3_programmation_web_avance.git
  git push -u origin main
  ```
- [ ] Vérifier sur GitHub que le dossier `images/` est bien là et que le `.env` n'y est **pas**

## 6. Mise en ligne sur WebDev

- [ ] Créer la base de données sur WebDev et importer `tp3_blog.sql`
- [ ] Envoyer tous les fichiers du projet (avec le dossier `vendor/`, ou faire `composer install` sur le serveur)
- [ ] Créer le fichier `.env` sur le serveur avec les informations de la base WebDev (voir `.env.example`)
- [ ] Vérifier que le dossier `images/` est accessible en écriture (permissions 755 ou 775)
- [ ] Vérifier que le `.htaccess` est bien envoyé
- [ ] Refaire les tests de la section 2 directement sur le site en ligne

## 7. Document Word ou PDF

- [ ] Lien vers le dépôt GitHub
- [ ] Lien vers le projet sur WebDev
- [ ] Brève description du projet
- [ ] Diagramme ER
- [ ] Comptes pour accéder à la section sécurisée :
  - Administrateur : `admin` / `Admin123!`
  - Client : `alex` / `Client123!`
- [ ] Section « Nouvelle fonctionnalité : téléversement d'images » :
  - Objectif : permettre à l'administrateur d'ajouter une image à un article à partir du site
  - Étapes : champ `Image` ajouté dans la table `posts`, champ fichier dans les formulaires, validation et enregistrement de l'image dans le dossier `images/`, nom du fichier enregistré dans la base de données, affichage sur le site
  - Classes utilisées : `Upload` (providers), `PostController`, `PostModel`, vues `post-create`, `post-edit`, `post-index`, `post-show`
  - Bibliothèques : aucune bibliothèque externe (fonctions PHP : `move_uploaded_file`, `finfo`). Twig était déjà utilisé depuis le TP2.

## 8. Fichier ZIP final

- [ ] À la racine du ZIP :
  1. le dossier du projet `amelie-henault_tp3`
  2. le document Word ou PDF
  3. le script `tp3_blog.sql`
- [ ] Vérifier que le code du ZIP, celui de GitHub et celui de WebDev sont **la même version**
- [ ] Remettre avant la date limite (−1 pt jusqu'à 24 h de retard, −2 pts jusqu'à 48 h, 0 après)

---

⚠️ **Supprimer ce fichier `toDoList.md` avant de pousser sur GitHub et de faire le ZIP de remise !**
