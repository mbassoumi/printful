<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 02/11/2018
 * Time: 1:03
 */

include_once("../src/db/DB.php");

$db = new DB();

$user_id = $_GET['user_id'];
$user_query = "select * from users where users.id = {$user_id}";
$user_set = $db->getData($user_query);
$user = $user_set[0];
$result_query = "select result from results where user_id = {$user_id}";
$result_set = $db->getData($result_query);

$questions_count_query = "SELECT COUNT(*) as result
                            FROM questions
                            JOIN quizzes on questions.quiz_id = quizzes.id
                            JOIN user_quiz on quizzes.id = user_quiz.quiz_id 
                            AND user_quiz.user_id = 46";

$questions_count_set = $db->getData($questions_count_query);
$questions_count = $questions_count_set[0]['result'];
$result = $result_set[0]['result'];
?>


<html>

<body style="margin: 20%">

</body>
</html>


<html>
<head>
    <title>Home</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</head>

<body>
<div class="container center-align">
    <form style="margin: 20%;">
        <div class="row">
            <div class="col s12">
                <?php

                echo "<h1>Thanks, {$user['name']}!</h1>";
                echo "<h6>You responded correctly to $result out of $questions_count questions.</h6>"

                ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>

