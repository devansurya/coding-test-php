<?php

require_once __DIR__ . '/Fibonacci.php';

$rows = isset($_POST['rows']) ? (int) $_POST['rows'] : 0;
$cols = isset($_POST['cols']) ? (int) $_POST['cols'] : 0;

$fibonacci = new Fibonacci($rows, $cols);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 1 - Fibonacci Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        .form-group input {
            padding: 5px 10px;
            border: 1px solid #999;
            width: 80px;
            font-size: 14px;
        }
        button {
            margin-top: 10px;
            padding: 8px 24px;
            font-size: 14px;
            cursor: pointer;
            background: #fff;
            border: 1px solid #999;
        }
        button:hover {
            background: #eee;
        }
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 1px solid #333;
            padding: 8px 14px;
            text-align: center;
            min-width: 40px;
            font-size: 14px;
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
    <form method="post" action="">
        <div class="form-group">
            <label for="rows">Rows</label>
            <input type="number" id="rows" name="rows" min="1" max="100" value="<?= $fibonacci->getRows() > 0 ? $fibonacci->getRows() : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="cols">Columns</label>
            <input type="number" id="cols" name="cols" min="1" max="100" value="<?= $fibonacci->getCols() > 0 ? $fibonacci->getCols() : '' ?>" required>
        </div>
        <button type="submit">Submit</button>
    </form>

    <?php if ($fibonacci->hasData()): ?>
        <?php $table = $fibonacci->generateTable(); ?>
        <table>
            <?php foreach ($table as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= $cell ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
