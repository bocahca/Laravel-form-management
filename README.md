# 📄 Laravel Form Management

## 📌 Introduction
**Laravel Form Management** is a role-based web application built with Laravel for managing online forms and submissions.

The system supports two roles:
- **Admin**: Create forms, view and review user submissions (approve/reject).
- **User**: Fill out forms and view submission history.

It also integrates with **Telegram** to send notifications when a new submission is received.

---

## 📚 Table of Contents
1. [Features](#-features)
2. [Tech Stack](#-tech-stack)
3. [Installation](#-installation)
4. [Configuration](#-configuration)
5. [Usage](#-usage)
6. [Telegram Integration](#-telegram-integration)
7. [Troubleshooting](#-troubleshooting)
---

## Features
- Role-based authentication (**Admin & User**)
- Admin dashboard with form builder
- Submission review system (approve/reject)
- User submission history tracking
- **Livewire** for interactive components
- **PostgreSQL** database support
- **Telegram** notifications for new submissions

---

## Tech Stack
- **Framework:** Laravel + Breeze authentication
- **Frontend:** Blade templates, Alpine.js, Livewire
- **Database:** PostgreSQL
- **Notifications:** Telegram Bot API
- **Styling:** Tailwind CSS

---

## Installation

### 1️⃣ Clone the repository
```bash
git clone https://github.com/bocahca/Laravel-form-management.git
cd Laravel-form-management
```

### 2️⃣ Install dependencies
```bash
composer install
npm install
```

### 3️⃣ Configure environment

Copy the example environment file:
```bash
cp .env.example .env
```
Edit .env with your database and Telegram credentials.

### 4️⃣ Generate application key
```bash
php artisan key:generate
```

### 5️⃣ Run migrations & seeders
```bash
php artisan migrate --seed
```

### 6️⃣ Start the application
```bash
php artisan serve
npm run dev
```

## Configuration
Example .env: 
```bash
APP_NAME="Laravel Form Management"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=your_username
DB_PASSWORD=your_password

TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_chat_id_here
```

## Usage
- Admin logs in, creates forms, views all submissions, and approves/rejects them.
- User logs in, fills out available forms, and views their submission history.
- On every new user submission, the system sends a Telegram notification.

## Telegram Integration
Step 1: Create a Telegram Bot
1. Open Telegram and search for BotFather.

2. Send /start and then /newbot.

3. Follow the prompts to set a name and username for your bot.

4. BotFather will provide a Bot Token — copy it to .env as TELEGRAM_BOT_TOKEN.

Step 2: Get Your Chat ID
1. Start a conversation with your bot and send any message.

2. Open this URL in your browser:
```bash
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates
```
3. Find "chat":{"id":123456789,...} in the JSON response — copy that number into .env as TELEGRAM_CHAT_ID.

## Troubleshooting
- Telegram messages not sent?

    - Make sure you have started a chat with the bot manually.

    - Double-check TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID in .env.

- Database connection failed?

    - Verify PostgreSQL is running and .env credentials match your database setup.

- Livewire components not updating?

    - Run npm run dev and ensure no caching issues in the browser.


