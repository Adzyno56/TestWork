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
$conn = getConnection();
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}

// Comments
$jsonData_comments = file_get_contents(
    "https://jsonplaceholder.typicode.com/comments");
$data = json_decode($jsonData_comments, TRUE);
$count_comments = 0;
$stmt = $conn->prepare("INSERT INTO comments(postId, id, name, email, body) VALUES (?,?,?,?,?)");
foreach($data as $stats ) {

    $stmt->bind_param('iisss', $stats['postId'], $stats['id'], $stats['name'], $stats['email'], $stats['body']);
    $stmt->execute();
    $count_comments++;
}
$stmt->close();

// Posts
$jsonData_comments = file_get_contents(
    "https://jsonplaceholder.typicode.com/posts");
$data = json_decode($jsonData_comments, TRUE);
$count_posts = 0;
$stmt = $conn->prepare("INSERT INTO posts(userId, id, title, body) VALUES (?,?,?,?)");
foreach($data as $stats ) {

    $stmt->bind_param('iiss', $stats['userId'], $stats['id'], $stats['title'], $stats['body']);
    $stmt->execute();
    $count_posts++;
}
$stmt->close();

echo "Загруженно  $count_posts записей и $count_comments комментариев";


?>
