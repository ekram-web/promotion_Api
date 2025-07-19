# 🚀 BasirahTV API Backend (Laravel)

Welcome to the **BasirahTV API** – a robust, secure, and scalable backend built with Laravel. This API powers the BasirahTV platform, delivering dynamic content, user management, and admin features to the frontend.

---

## 🛠️ Tech Stack
- **Framework:** Laravel
- **Database:** MySQL (or compatible)
- **Auth:** Laravel Sanctum (or Passport)
- **Deployment:** GitHub Actions + cPanel (FTP/SFTP)
- **Styling:** Tailwind CSS and dark mode by default

---

## ✨ Features
- RESTful API for all frontend needs
- Admin panel for content management
- Secure authentication & authorization
- File upload support (with `php artisan storage:link`)
- Auto-deploy on push to `main` branch

---

## 🚦 Quick Start

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
- Configure your database in `.env`
- Access API at `http://localhost:8000/api`

---

## 🚀 Deployment
- Auto-deploys to [besirad.basirahtv.com](https://besirad.basirahtv.com) via GitHub Actions
- See root `DEPLOYMENT_STEPS.md` for full workflow

---

## 📚 API Docs
- See `API_DOCUMENTATION.md` for endpoints and usage

---



---

> "Modern API. Professional workflow. Ready for scale."
