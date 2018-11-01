<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 31/10/2018
 * Time: 15:45
 */

include_once("../src/db/DB.php");

$db = new DB();

$save_user_query = 'insert into users (name) values ("' . $_POST['name'] . '")';
$user_id = $db->insertAndGetInsertedId($save_user_query);
$save_user_quiz_query = "insert into user_quiz (user_id, quiz_id) values ($user_id, {$_POST['quiz_id']})";
$db->execute($save_user_quiz_query);

?>

<html>
<head>
    <title>Welcome</title>
</head>

<body>
<?php echo "<a href=\"quiz.php?user_id={$user_id}&quiz_id={$_POST['quiz_id']}\">Start your quiz</a>" ?>
</body>
</html>