# 📅 Event Managemnt App (Laravel Frontend)

This is a Laravel-based client application that consumes a RESTful **Event Management API**. It allows users to sign up, log in, view events, attend/unattend events, and reset their passwords. The app also integrates with a backend notification system for event reminders.

---

## 🚀 Features

- 🔐 User Authentication (Login, Register, Logout)
- 📋 List All Events (Public and User-specific)
- 📝 View Event Details
- ✅ Attend / Unattend Events
- 📩 Password Reset via Email
- 🔔 Receive Event Reminder Notifications (via Mailtrap)
- 🎯 Role-based Access (Event owner sees attendee list)
- 🌐 REST API Integration using Laravel HTTP client

---

## 📦 Tech Stack

- **Laravel 12**
- **Blade Templates**
- **Tailwind CSS / Bootstrap**
- **Laravel Sanctum** (for API authentication)
- **Mailtrap** (for email testing)

---

## ⚙️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/mechetenco/Event-Management-App.git
cd event-client-app
2. Install Dependencies
bash
Copy
Edit
composer install
npm install && npm run dev
3. Configure .env
Copy .env.example to .env:

bash
Copy
Edit
cp .env.example .env
Edit the following values:

dotenv
Copy
Edit
APP_NAME="Event Client"
APP_URL=http://localhost:8001

# API Base URL
API_BASE_URL=http://localhost:8000/api

# Mail Settings (Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=client@app.com
MAIL_FROM_NAME="Event Client App"
4. Generate Application Key
bash
Copy
Edit
php artisan key:generate
5. Serve the App
bash
Copy
Edit
php artisan serve --port=8000
Your client app will be available at http://localhost:8001.

🔑 Authentication & API Connection
Users authenticate using credentials via the API.

Upon successful login, the app stores the API token in the session.

The token is used for authenticated API requests (e.g., attending/unattending events).

✉️ Password Reset Flow
User submits email to forgot-password.

Receives a reset link (via Mailtrap).

Clicks the link, is taken to reset form.

Submits new password; if valid, is redirected to login page.

🔔 Event Reminder Notifications
Scheduled in the API backend (app/Console/Kernel.php)

Sends email reminders before events.

Mailtrap is used to catch and preview emails.

📂 Project Structure
bash
Copy
Edit
resources/views/
    ├── auth/                # Login, register, reset-password forms
    ├── events/              # Event list, detail, and action buttons
    └── layouts/             # Base layout

routes/web.php              # Client routes
app/Http/Controllers/       # Handles user actions and consumes the API
✅ Useful Commands
bash
Copy
Edit
php artisan serve --port=9000        # Start dev server
php artisan config:clear             # Clear config cache
php artisan route:list               # View client app routes
📬 Contact
If you encounter issues or want to contribute, feel free to open an issue or reach out!

