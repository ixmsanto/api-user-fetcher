# Laravel 11 - User API Integration with AJAX, jQuery, and Scheduler

This Laravel 11 application fetches user data from the public API [JSONPlaceholder](https://jsonplaceholder.typicode.com/users), displays it in a searchable table, and stores it in a MySQL database. It also supports AJAX fetching and periodic updates using Laravel Scheduler.

---

## 🔧 Features

- Fetch user data from a third-party API
- Store and update data in MySQL
- Display users in a Blade view
- Search users by name using a search bar
- Fetch users using AJAX & jQuery (no page reload)
- Handle API errors gracefully
- Schedule periodic data fetching with Laravel Scheduler

---

## 📦 Tech Stack

- Laravel 11
- MySQL
- jQuery + AJAX
- Blade
- Laravel Scheduler
- JSONPlaceholder API

---

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ixmsanto/api-user-fetcher.git
   cd api-user-fetcher
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure `.env`**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Update database info in `.env`:
   ```env
   DB_DATABASE=your_db_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Serve the application**
   ```bash
   php artisan serve
   ```

6. **Visit the app**
   ```
   http://localhost:8000
   ```

---

## 💡 Usage

- Click **“Fetch Users from API”** to load and store user data.
- Use the search input to filter users by name.
- Data is saved to your local database.

---

## ⏱️ Scheduling (Optional but Recommended)

### 1. **Register Command**
```bash
php artisan make:command FetchUsersCommand
```

- Already included in this repo as `app/Console/Commands/FetchUsersCommand.php`

### 2. **Schedule It**
In `App\Console\Kernel.php`:
```php
$schedule->command('users:fetch')->hourly();
```

### 3. **Add Cron Job**
Run the scheduler every minute:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Or run manually:
```bash
php artisan schedule:run
```

---

## 📁 Folder Structure Highlights

- `routes/web.php`: Web routes for index and fetch logic
- `app/Http/Controllers/UserController.php`: Main controller
- `app/Models/User.php`: User model
- `resources/views/users/index.blade.php`: Blade UI
- `app/Console/Commands/FetchUsersCommand.php`: Scheduler command

---

## 🧪 Testing (Basic)

You can visit `/` to:
- View stored users
- Search for names
- Fetch API data via the AJAX button

---

## 🛠️ Troubleshooting

- **Error: 419 page expired** — Make sure your AJAX includes CSRF token.
- **Fetch fails silently** — Check if your internet allows access to `https://jsonplaceholder.typicode.com`.
- **Database issues** — Ensure DB is running and `.env` is configured correctly.

---

## 👤 Author

**Your Name**  
GitHub: [ixmsanto](https://github.com/ixmsanto)
