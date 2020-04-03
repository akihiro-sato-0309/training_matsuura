<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>掲示板</title>
</head>
<body>
<form method="post">
    <label>名前：</label>
    <?php
    $nowName = "";
    if (!empty($_POST["name"])) {
        $nowName = $_POST["name"];
    }
    ?>
    <input type="text" name="name" value="<?php echo $nowName?>">
    <br>
    <label>タイトル：</label>
    <?php
    $nowTitle = "";
    if (!empty($_POST["title"])) {
        $nowTitle = $_POST["title"];
    }
    ?>
    <input type="text" name="title" value="<?php echo $nowTitle?>">
    <input type="submit" name="send" value="送信">
    <br>
    <label>メッセージ</label>
    <?php
    $nowMessage = "";
    if (!empty($_POST["message"])) {
        $nowMessage = $_POST["message"];
    }
    ?>
    <br>
    <textarea name="message"><?php echo $nowMessage?></textarea>
</form>
<?php

echo '<br><br>';

$dsn = 'mysql:dbname=training_matsuura;host=localhost';
$user = 'training';
$password = 'trainingtest';
$error = array();

try {
    $dbh = new PDO($dsn, $user, $password);
    $sql = 'select * from main_training';

    if (!empty($_POST["send"])) {
        if (!empty($_POST["name"])) {
            if (mb_strlen($_POST["name"]) > 20) $error[] = "名前は20文字以内で入力してください";
        } else $error[] = "名前が入力されていません";
        if (!empty($_POST["title"])) {
            if (mb_strlen($_POST["title"]) > 40) $error[] = "タイトルは40文字以内で入力してください";
        } else $error[] = "タイトルが入力されていません";
        if (!empty($_POST["message"])) {
            if (mb_strlen($_POST["message"]) > 140) $error[] = "メッセージは140文字以内で入力してください";
        } else $error[] = "メッセージが入力されていません";
    }

    if (empty($error) && !empty($_POST["send"])) {
        $result = "INSERT INTO main_training (name, title, message, date) VALUES (:name, :title, :message, :date)";
        $stmt = $dbh->prepare($result);
        date_default_timezone_set("Asia/Tokyo");
        $date = new DateTime();
        $params = array(':name' => $_POST["name"], ':title' => $_POST["title"], ':message' => $_POST["message"], ':date' => $date -> format("Y-m-d H:i:s"));
        $stmt->execute($params);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    if (!empty($error)) {
        foreach ((array)$error as $value) {
            echo $value;
            echo '<br>';
        }
        echo '<br>';
    }

    foreach ($dbh->query($sql) as $row) {
        echo $row['name'];
        echo '<br>';
        echo $row['title'];
        echo '<br>';
        echo $row['message'];
        echo '<br>';
        echo $row['date'];
        echo '<br>';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

function ValidationCheck() {
    echo 'ばりでーしょん';
    return false;
}
?>
</body>
</html>