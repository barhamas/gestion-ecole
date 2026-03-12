# 🎓 API REST Laravel — Gestion Étudiants & Cours

API REST complète pour gérer les étudiants, les cours et les inscriptions.

---

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/barhamas/gestion-ecole.git
cd gestion-ecole
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données
Ouvrir `.env` et modifier :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_ecole
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Créer la base de données
```bash
mysql -u root -p -e "CREATE DATABASE gestion_ecole;"
```

### 6. Lancer les migrations
```bash
php artisan migrate
```

### 7. Démarrer le serveur
```bash
php artisan serve
```

---

## 🔑 Authentification (Sanctum)

| Méthode | URL | Description |
|---------|-----|-------------|
| POST | /api/v1/auth/register | Inscription |
| POST | /api/v1/auth/login | Connexion → retourne token |
| POST | /api/v1/auth/logout | Déconnexion |
| GET  | /api/v1/auth/me | Utilisateur connecté |

---

## 👨‍🎓 Étudiants

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | /api/v1/etudiants | Lister (paginé) |
| POST | /api/v1/etudiants | Créer |
| GET | /api/v1/etudiants/{id} | Détails |
| PUT | /api/v1/etudiants/{id} | Modifier |
| DELETE | /api/v1/etudiants/{id} | Supprimer (204) |

---

## 📚 Cours

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | /api/v1/cours | Lister (paginé) |
| POST | /api/v1/cours | Créer |
| GET | /api/v1/cours/{id} | Détails |
| PUT | /api/v1/cours/{id} | Modifier |
| DELETE | /api/v1/cours/{id} | Supprimer (204) |

---

## 🔗 Inscriptions (Many-to-Many)

| Méthode | URL | Description |
|---------|-----|-------------|
| POST | /api/v1/etudiants/{id}/cours/attach | Inscrire à des cours |
| POST | /api/v1/etudiants/{id}/cours/detach | Désinscrire |
| POST | /api/v1/etudiants/{id}/cours/sync | Remplacer tous les cours |

---

## 🔍 Query Parameters
```
?include=cours          → inclure les cours d'un étudiant
?include=etudiants      → inclure les étudiants d'un cours
?per_page=10            → pagination
?q=mamadou              → recherche étudiant
?professeur=Ndiaye      → filtrer cours par professeur
```

---

## 🧪 Tests
```bash
php artisan test
```

✅ 8 tests passés

---

## 🔒 Sécurité

- Authentification par token **Laravel Sanctum**
- Toutes les routes CRUD protégées → **401** sans token
- Rate limiting : **60 requêtes/minute**

---

## 📖 Références

- https://laravel.com/docs/12.x/eloquent-resources
- https://laravel.com/docs/12.x/testing
- https://laravel.com/docs/12.x/authentication
- https://laravel.com/docs/11.x/sanctum
- https://laravel.com/docs/12.x/routing
