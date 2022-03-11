<?php
function getConnection() {

    $host = 'localhost';
    $db   = 'testwork';
    $user = 'TikhonovG';
    $pass = '123456';
    $charset = 'utf8';

    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_set_charset($conn, $charset);

    return $conn;
}

if (isset($_POST['phrase'])) {
    $conn = getConnection();
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $phrase_search = $_POST['phrase'];
    $sql = "SELECT posts.id, title, comments.id, comments.body 
            FROM comments JOIN posts 
            ON posts.id = comments.postId 
            WHERE comments.body LIKE '%$phrase_search%'";
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_row()) {
            echo '<div><p>Заголовок записи: ' . "$row[1]" . '</p>' . '<p>Комментарий: ' . "$row[3]" .'</p></div><hr>';
        }

    }

    $conn->close();
}

?>
<form method="post">
    <label>Поиск по фразе <input type="text" name="phrase"/></label><br/>
    <input type="submit" name="submit" value="Найти"/>
</form>
