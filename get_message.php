<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ゲットするやつ</title>
    </head>
    <body>
    <?php
        $message = $_POST["post_message"];
        echo $message;
        echo '<br>';

        $dsn = 'mysql:dbname=training_matsuura;host=localhost';
        $user = 'training';
        $password = 'trainingtest';

    try {
        $dbh = new PDO($dsn, $user, $password);
        $sql = 'select * from Foundation';

        $result = "INSERT INTO foundation (message) VALUES ('', ''$message')";

        foreach ($dbh->query($sql) as $row) {
            echo $row['message'];
            echo '<br>';
        }
    } catch (PDOException $e) {
            echo $e -> getMessage();
    }
    ?>
    </body>
</html>