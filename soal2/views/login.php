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
        .captcha-img {
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .captcha-img:hover {
            opacity: 0.8;
        }
        .captcha-hint {
            font-size: 11px;
            color: #888;
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
                <div>
                    <img src="index.php?action=captcha&t=<?= time() ?>" alt="Security Image" class="captcha-img" id="captchaImg"
                         onclick="this.src='index.php?action=captcha&t='+Date.now()" title="Klik untuk refresh captcha">
                    <div class="captcha-hint">Klik gambar untuk refresh</div>
                </div>
            </div>

            <div class="form-group">
                <label for="captcha">Input karakter yang muncul pada tampilan diatas</label>
                <input type="text" id="captcha" name="captcha" required maxlength="5" autocomplete="off"
                       style="text-transform: uppercase;">
            </div>

            <div class="btn-center">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
