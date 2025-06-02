# 🎬 OMDb Movie & Series Explorer

A Laravel-based web application to browse movies and series using the [OMDb API](http://www.omdbapi.com/).

---

## 📚 Features

- 🔍 Search movies/series with filters (year, type)
- ⭐ Add/remove favorites (authenticated users)
- 📜 Infinite scroll with lazy-loaded posters
- 🌐 Multi-language support (EN/ID)
- 🔐 Auth system (login/logout)
- 🧾 Movie detail page with full metadata
- 💾 Data pulled from OMDb API in real-time

---

## 🏗 Architecture

- **MVC (Model-View-Controller)** pattern
- **RESTful routing**
- **Blade templating** with Bootstrap 5
- **Session-based** localization
- **Custom Favorite model** with relational mapping

---

## ⚙️ Tech Stack

| Layer         | Technology                   |
| ------------- | ---------------------------- |
| Backend       | Laravel 8                    |
| Frontend      | Blade + Bootstrap 5          |
| Auth          | Manual (Laravel sessions)    |
| HTTP Client   | Laravel HTTP Client (Guzzle) |
| Database      | MySQL (local)                |

---

## 📸 Screenshots
### Login Page
![Login](https://github.com/user-attachments/assets/0e0a7d3e-4b7e-4a16-988d-f94820fe5c30)

### Dashboard / Search Page
![Dashboard](https://github.com/user-attachments/assets/f8ced4a1-01a1-45fa-a9cd-52295be5930e)

### Movie Detail
![Detail](https://github.com/user-attachments/assets/87ccbfb0-65ed-4f8f-a73e-37ef4ff4f38d)

### Favorites Page
![Favorites](https://github.com/user-attachments/assets/2888c057-e78b-403a-a01a-420062a410c3)

---

## 🚀 Setup Instructions

```
git clone https://github.com/username/omdbapi.git
cd omdbapi

cp .env.example .env
composer install
php artisan key:generate

# ✏️ Add your OMDB API key to the .env file
# Example:
# OMDB_API_KEY=your_api_key_here

php artisan migrate --seed
php artisan serve
```
