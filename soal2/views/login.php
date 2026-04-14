<?php
// View: Login
$e = [View::class, 'escape'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        .login-box {
            background: #fff;
            border: 1px solid #ccc;
            padding: 30px;
            max-width: 450px;
        }
        .login-box h2 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-group {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 180px;
            font-size: 14px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            flex: 1;
            padding: 6px 10px;
            border: 1px solid #999;
            font-size: 14px;
        }
        .g-recaptcha {
            margin-top: 4px;
        }
        button {
            padding: 8px 24px;
            font-size: 14px;
            cursor: pointer;
            background: #fff;
            border: 1px solid #999;
            margin-top: 10px;
        }
        button:hover {
            background: #eee;
        }
        .btn-center {
            text-align: center;
            margin-top: 15px;
        }
        .error {
            color: #cc0000;
            font-weight: bold;
            margin: 10px 0;
            padding: 8px;
            background: #ffeeee;
            border: 1px solid #ffcccc;
        }
        .result-gagal {
            color: #cc0000;
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0;
        }
        .result-sukses {
            color: #008800;
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0066cc;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="../" class="back-link">&laquo; Kembali</a>

    <?php if ($loginResult === 'LOGIN SUKSES'): ?>
        <p class="result-sukses">LOGIN SUKSES</p>
        <p>Mengalihkan ke halaman daftar user...</p>
    <?php elseif ($loginResult === 'LOGIN GAGAL'): ?>
        <p class="result-gagal">LOGIN GAGAL</p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $e($error) ?></p>
    <?php endif; ?>

    <div class="login-box">
        <h2>FORM LOGIN</h2>
        <form method="post" action="index.php?action=login">
            <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">

            <div class="form-group">
                <label for="username">Nama</label>
                <input type="text" id="username" name="username" value="<?= $e($username) ?>" required maxlength="128" autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required maxlength="8" autocomplete="current-password">
            </div>

            <div class="form-group">
                <label>Security Image</label>
                <div class="g-recaptcha" data-sitekey="6LeJtbUsAAAAAFimkmGH-Z65Zr_0SAC1OEXcKdJ1"></div>
            </div>

            <div class="btn-center">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
