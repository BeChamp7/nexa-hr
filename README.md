# Nexa HR — Employee Management System

A polished, production-style **HR management web application** built with **Laravel 13** and **Tailwind CSS**.
It demonstrates clean CRUD architecture, a real approval workflow, authentication, and full **multilingual
(English / Urdu) support with right-to-left (RTL) layout**.

> Portfolio demo highlighting business-application skills: forms, validation, relationships, and i18n.

---

## ✨ Features

| Module | What it does |
| --- | --- |
| **Dashboard** | At-a-glance KPIs — total/active employees, pending requests, approved leaves, headcount by department, and a recent-requests feed. |
| **Employees** | Full CRUD with search & filters (by department / status), employee profiles, tenure, and leave history. Auto-generated employee codes. |
| **Departments** | Manage teams with live employee counts. |
| **Leave Requests** | Submit requests, then **approve / reject** with reviewer notes. Status filters with live counts. |
| **Authentication** | Secure login (Laravel Breeze). Feels like a real internal admin panel. |
| **i18n + RTL** | One-click switch between **English** and **اردو**. Urdu flips the entire UI to RTL and uses a Nastaliq font. Every label is translatable. |

## 🛠 Tech Stack

- **Laravel 13** (PHP 8.5)
- **Tailwind CSS 3** + **Alpine.js** (via Vite)
- **SQLite** (zero-config; swap to MySQL/Postgres via `.env`)
- **Laravel Breeze** for auth scaffolding

## 🚀 Getting Started

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment (key is already generated; .env ships with the repo)
php artisan key:generate   # only if needed

# 3. Create & seed the database
php artisan migrate:fresh --seed

# 4. Build assets
npm run build        # or: npm run dev  (hot reload)

# 5. Serve
php artisan serve
```

Visit **http://127.0.0.1:8000**.

### 🔑 Demo Login

| Email | Password |
| --- | --- |
| `admin@nexahr.test` | `password` |

The seeder creates **6 departments**, **14 employees**, and **11 leave requests** in mixed states.

## 🌐 Language Switching

Use the **globe menu** in the top bar (or the EN / اردو toggle on the login screen).
The selected locale is stored in the session and applied by `App\Http\Middleware\SetLocale`.
Translations live in `lang/en/messages.php` and `lang/ur/messages.php`.

## 🗂 Project Structure (highlights)

```
app/
├── Http/Controllers/      Dashboard, Employee, Department, LeaveRequest, Locale
├── Http/Requests/         Form-request validation
├── Http/Middleware/       SetLocale (locale resolution)
└── Models/                Department, Employee, LeaveRequest
lang/                      en/ + ur/ translation files
resources/views/
├── components/            Reusable Blade UI (icon, badges, field, page-header…)
├── layouts/app.blade.php  Sidebar shell (RTL-aware)
├── dashboard / employees / departments / leaves / auth
```

## 📐 Notable Implementation Details

- **Reusable Blade components** keep views DRY (`<x-icon>`, `<x-field>`, `<x-emp-status>`, `<x-leave-status>`, `<x-empty-state>`).
- **Logical CSS properties** (`ps-*`, `pe-*`, `ms-*`, `start/end`) make every screen mirror cleanly in RTL.
- **Pluralization** via `trans_choice` for "X days" / "X employees" in both languages.
- **Eloquent relationships** with eager loading to avoid N+1 queries.
- **Form Request** classes centralize validation with unique-rule handling on update.
