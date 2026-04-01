# Coding Test PHP

## Struktur Project

```
coding-test-php/
├── index.php                          # Halaman utama (navigasi)
├── soal1/
│   ├── Fibonacci.php                  # Class Fibonacci (OOP)
│   └── index.php                      # Entry point (menggunakan class Fibonacci)
├── soal2/
│   ├── config/
│   │   └── db.php                     # Class db (koneksi MySQL - PDO, Singleton)
│   ├── core/
│   │   ├── App.php                    # Front Controller & Bootstrap
│   │   ├── Session.php                # Class Session (auth, CSRF, flash message)
│   │   ├── Captcha.php                # Class Captcha (Security Image - GD)
│   │   ├── View.php                   # Class View (template renderer)
│   │   └── Controller.php            # Abstract base Controller
│   ├── models/
│   │   └── User.php                   # Class User (CRUD tbl_user)
│   ├── controllers/
│   │   ├── AuthController.php         # Login, Logout, Captcha
│   │   └── UserController.php         # CRUD User (list, add, edit, delete)
│   ├── views/
│   │   ├── login.php                  # Template form login
│   │   ├── users.php                  # Template daftar user
│   │   ├── user_add.php               # Template form tambah user
│   │   └── user_edit.php              # Template form ubah user
│   ├── index.php                      # Single entry point (front controller)
│   └── setup.sql                      # Script setup database
```

## Konsep OOP yang Diterapkan

- **Encapsulation** - Setiap class membungkus data dan logiknya sendiri
- **Inheritance** - `AuthController` & `UserController` meng-extend `Controller`
- **Singleton Pattern** - Class `db` dan `Session` menggunakan singleton
- **MVC Pattern** - Model (`User`), View (templates), Controller (logic)
- **Front Controller** - Single entry point melalui `App` class
- **Separation of Concerns** - Logic, tampilan, dan data terpisah

## Cara Setup

1. **Start Laragon** (pastikan Apache & MySQL berjalan)

2. **Import database** - buka terminal Laragon dan jalankan:
   ```
   mysql -u root < C:\laragon\www\coding-test-php\soal2\setup.sql
   ```
   Atau import file `soal2/setup.sql` melalui phpMyAdmin.

3. **Akses aplikasi** di browser:
   - Halaman utama: `http://localhost/coding-test-php/`
   - Soal 1: `http://localhost/coding-test-php/soal1/`
   - Soal 2: `http://localhost/coding-test-php/soal2/`

4. **Login default:**
   - Username: `hanandia`
   - Password: `admin123`

## Fitur Keamanan

- Password di-hash menggunakan `password_hash()` dengan algoritma **bcrypt**
- Prepared statements (PDO) untuk mencegah **SQL Injection**
- `htmlspecialchars()` untuk mencegah **XSS**
- CSRF Token pada semua form submission
- Security Image (Captcha) pada form login
- Session regeneration setelah login berhasil
