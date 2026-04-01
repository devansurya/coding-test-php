<?php
// View: Daftar User
$e = [View::class, 'escape'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        h2 {
            margin-top: 0;
        }
        .container {
            background: #fff;
            border: 1px solid #ccc;
            padding: 25px;
            max-width: 750px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .actions a {
            margin-right: 5px;
        }
        .actions .delete-link {
            color: #cc0000;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .btn {
            padding: 6px 16px;
            font-size: 13px;
            cursor: pointer;
            background: #fff;
            border: 1px solid #999;
            text-decoration: none;
            color: #333;
        }
        .btn:hover {
            background: #eee;
            text-decoration: none;
        }
        .btn-danger {
            color: #cc0000;
            border-color: #cc0000;
        }
        .flash-success {
            color: #008800;
            background: #eeffee;
            border: 1px solid #ccffcc;
            padding: 8px 12px;
            margin-bottom: 15px;
        }
        .flash-error {
            color: #cc0000;
            background: #ffeeee;
            border: 1px solid #ffcccc;
            padding: 8px 12px;
            margin-bottom: 15px;
        }
        .user-info {
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <span class="user-info">Login sebagai: <strong><?= $e($username) ?></strong></span>
        <a href="index.php?action=logout" class="btn btn-danger">Logout</a>
    </div>

    <?php if ($flash): ?>
        <div class="flash-<?= $e($flash['type']) ?>"><?= $e($flash['message']) ?></div>
    <?php endif; ?>

    <div class="container">
        <h2>DAFTAR USER</h2>

        <a href="index.php?action=user_add" class="btn">+ Tambah User</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Password</th>
                    <th>Ctime</th>
                    <th>Fungsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">Belum ada data user.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $i => $user): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $e($user['Username']) ?></td>
                            <td>Xxxx</td>
                            <td><?= $e(date('j/n/Y', strtotime($user['CreateTime']))) ?></td>
                            <td class="actions">
                                <a href="index.php?action=user_edit&id=<?= (int) $user['Id'] ?>">Edit</a> |
                                <a href="index.php?action=user_delete&id=<?= (int) $user['Id'] ?>&token=<?= $e($csrfToken) ?>"
                                   class="delete-link"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
