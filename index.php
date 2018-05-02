<?php
$pdo = new PDO("mysql:host=localhost;dbname=global","kpronin", "neto1718");

$pdo->exec('SET NAMES utf8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $sql = "SELECT * FROM books WHERE ((name LIKE :name) AND (isbn LIKE :isbn) AND (author LIKE :author))";
    $statement = $pdo->prepare($sql);
    $statement->execute(["name"=>"%{$name}%","isbn"=>"%{$isbn}%","author"=>"%{$author}%"]);
}else{
    $sql = "SELECT * FROM books";
    $statement = $pdo->prepare($sql);
    $statement->execute();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="UTF-8">
    <style>
        .grid {
            margin: 0 auto;
        }
        form * {
            display: inline-block;
            margin: 5px 0;
        }
        table {
            border-collapse: collapse;
            border: 1px solid #C2C2C2;
        }
        table * {
            border: 1px solid #C2C2C2;
            padding: 5px;
        }
        table th {
            background: #EEEEEE;
            text-align: center;
        }
        table td {
            text-align: left;
        }
        table tr:hover td {
            text-decoration: underline;
        }

    </style>
</head>
<body>


<div class="grid">
    <h1>Библиотека успешного человека</h1>
    <form method="POST">
        <div class="into-form">
            <input type="text" name="isbn" placeholder="ISBN" value="<?php if (!empty($_POST)){echo $_POST['isbn'];} ?>">
        </div>
        <div class="into-form">
            <input type="text" name="name" placeholder="Название книги" value="<?php if (!empty($_POST)){echo $_POST['name'];} ?>">
        </div>
        <div class="into-form">
            <input type="text" name="author" placeholder="Автор книги" value="<?php if (!empty($_POST)){echo $_POST['author'];} ?>">
        </div>
        <div class="into-form">
            <button type="submit">Поиск</button>
        </div>
    </form>
    <table class="table_blur">
        <thead>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Год выпуска</th>
            <th>Жанр</th>
            <th>ISBN</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statement as $row) : ?>
            <tr>
                <td><?=$row['name']?></td>
                <td><?=$row['author']?></td>
                <td><?=$row['year']?></td>
                <td><?=$row['genre']?></td>
                <td><?=$row['isbn']?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

</body>
</html>