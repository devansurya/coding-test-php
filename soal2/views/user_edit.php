<?php
// View: Form Ubah User
$e = [View::class, 'escape'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        .container {
            background: #fff;
            border: 1px solid #ccc;
            padding: 25px;
            max-width: 450px;
        }
        .container h2 {
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
            width: 120px;
            font-size: 14px;
        }
        .form-group input {
            flex: 1;
            padding: 6px 10px;
            border: 1px solid #999;
            font-size: 14px;
        }
        .btn-center {
            text-align: center;
            margin-top: 15px;
        }
        button {
            padding: 8px 24px;
            font-size: 14px;
            cursor: pointer;
            background: #fff;
            border: 1px solid #999;
        }
        button:hover {
            background: #eee;
        }
        .error-list {
            color: #cc0000;
            background: #ffeeee;
            border: 1px solid #ffcccc;
            padding: 8px 12px;
            margin-bottom: 15px;
            list-style: disc;
            padding-left: 30px;
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
        .hint {
            font-size: 11px;
            color: #888;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <a href="index.php?action=users" class="back-link">&laquo; Kembali ke Daftar User</a>

    <?php if (!empty($errors)): ?>
        <ul class="error-list">
            <?php foreach ($errors as $err): ?>
                <li><?= $e($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="container">
        <h2>FORM UBAH USER</h2>
        <form method="post" action="index.php?action=user_edit">
            <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-group">
                <label for="username">Nama</label>
                <input type="text" id="username" name="username" value="<?= $e($username) ?>"
                       required maxlength="128">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div style="flex: 1;">
                    <input type="password" id="password" name="password"
                           minlength="5" maxlength="8" autocomplete="new-password">
                    <div class="hint">Kosongkan jika tidak ingin mengubah password. Min 5, Max 8 karakter.</div>
                </div>
            </div>

            <div class="btn-center">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
