# Larager

A Laravel logger package that listens to your logs and exceptions and displays them in a clean, user-friendly format — perfect for debugging without digging through raw log files.

---

## 🚀 Features

- Simplifies exception and log messages
- Translates technical exceptions like `Illuminate\Database\QueryException` into readable text
- Hooks directly into Laravel's logging system
- Works with default Laravel log drivers
- Lightweight and zero-configuration (auto-discovered)

---

## 📦 Installation

```bash
composer require alikhoursand/larager
```

If you're not using Laravel's package auto-discovery, manually register the service provider in `config/app.php`:

```php
'providers' => [
    Alikhoursand\Larager\LaragerServiceProvider::class,
],
```

---

## ⚙️ Configuration (Optional)

You can publish the configuration file:

```bash
php artisan vendor:publish --tag=larager-config
```

This will create `config/larager.php` where you can customize how logs are simplified and displayed.

---

## 🧠 How It Works

Larager listens to Laravel’s log events and exceptions. When an error occurs, it captures the original log and rewrites the message using a simplified format such as:

| Original Exception                     | Larager Output            |
|----------------------------------------|---------------------------|
| `Illuminate\Database\QueryException`   | `Database query error`    |
| `TypeError`                            | `Type error in code`      |
| `ErrorException`                       | `General PHP error`       |

---

## ✅ Example

Instead of this in your logs:

```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'test.non_existing_table' doesn't exist (Connection: mysql, SQL: select * from `non_existing_table`)
```


You'll see:

![Larager Example](https://path.png)



In a whole page.
Much cleaner, right?

---

## 🛠 Usage

No manual usage needed — just install and you're done. Larager starts listening automatically.

---

## 📄 License

Larager is open-sourced software licensed under the [MIT license](LICENSE).

---

## 💬 Feedback / Issues

Have suggestions or bugs? [Open an issue](https://github.com/alikhoursand/larager/issues) or feel free to contribute with a pull request!

 
