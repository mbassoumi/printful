<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 31/10/2018
 * Time: 15:44
 */

include_once("../src/db/DB.php");
$db = new DB();
$get_user_query = "select * from users where id = {$_GET['user_id']}";
$get_quiz_query = "select * from quizzes where id= {$_GET['quiz_id']}";

$user = $db->getData($get_user_query);

/**
 * get quiz questions
 * and get all options for each question in one query.
 */
$questions_query = "SELECT 
                    questions.id as question_id,
                    questions.`name` as question_name, 
                    `options`.id AS option_id,
                    `options`.`name` as option_name,
                    `options`.mark as option_mark
                    FROM questions
                    JOIN `options` on `options`.question_id = questions.id
                    WHERE questions.quiz_id = {$_GET['quiz_id']}";


$quiz_id = $_GET['quiz_id'];
$user_id = $_GET['user_id'];
$questions = $db->getData($questions_query);

$questions_array = [];
/**
 * simplify the result set,
 */
foreach ($questions as $question) {
    $questions_array[$question['question_id']]['name'] = $question['question_name'];
    $questions_array[$question['question_id']]['options'][$question['option_id']]['name'] = $question['option_name'];
    $questions_array[$question['question_id']]['options'][$question['option_id']]['mark'] = $question['option_mark'];

}
$questions_count = count($questions_array);


?>

<html>
<head>
    <title>Quiz</title>

    <!--
    cdn for materialize css and jquery,
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</head>

<body>
<div class="container center-align">
    <form>
        <?php
        $j = 0;
        $questions_length = count($questions_array);
        foreach ($questions_array as $question_id => $question) {
            echo "<div  id='div_$j' hidden>";
            echo "<h1 class='question_{$question_id}'>{$question['name']}</h1>";
            echo "<br>";
            $i = 0;
            $close_div = false;
            foreach ($question['options'] as $option_id => $option) {
                if ($i % 2 == 0) {
                    if ($close_div) {
                        echo "</div>";
                    }
                    $close_div = true;
                    echo "<div class='row'>";
                }
                $i++;
                echo "<div class='col s6'><button class='option_value btn waves-effect waves-light' style='color: #000; background: white; width: 80%; ' data-option_value='$option_id' name='$option_id'>{$option['name']}</button></div>";
            }
            echo "</div>";
            echo "<br>";
            echo "<div id='progress-bar'>";
            echo "<div id='progress-bar-status' style='width:".((($j)/$questions_count)*100)."%'></div>";
            echo "</div>";
            echo "<br>";
            echo "<div class='col s6'>";
            if ($j + 1 == $questions_length) {
                echo "<button class='next btn waves-effect waves-light deep-purple grey darken-2' data-question_id='$question_id' data-is_last='true' style='width: 50%'>SUBMIT</button>";
            } else {
                echo "<button class='next btn waves-effect waves-light deep-purple grey darken-2' data-question_id='$question_id' data-is_last='false' style='width: 40%'>NEXT</button>";
            }
            echo "</div>";
            echo "</div>";
            $j++;
        }
        ?>
    </form>
</div>
</body>
</html>

<style>
    #progress-bar {
        width: 200px;
        border: 2px solid #000;
        margin: 0 auto 20px auto;
    }

    #progress-bar div {
        height: 20px;
        background: gray;
    }
</style>

<script>


    $(document).ready(function () {

        let user_id = '<?php echo $user_id;?>';
        let quiz_id = '<?php echo $quiz_id;?>';
        let value_button = null;
        let option_value = null;
        let i = 0;
        let current_div = $("#div_" + i);
        current_div.show();


        $("body").on('click', '.option_value', function (e) {
            e.preventDefault();
            /**
             * add blue color the selected option using jquery,
             */
            $('.option_value').css('background', 'white');
            value_button = $(this);
            value_button.css('background', '#29b6f6');
            option_value = value_button.data('option_value');
            console.log(option_value);
        });


        $("body").on('click', '.next', function (e) {
            e.preventDefault();
            if (option_value === null) {
                alert('you have to answer this question');
                return;
            }
            let next_button = $(this);
            let question_id = next_button.data('question_id');
            let is_last = next_button.data('is_last');
            let url = '';
            if (is_last === true) {
                url = '/submit-quiz'
            } else {
                url = '/save-answer';
            }

            let formData = new FormData();
            formData.append('quiz_id', quiz_id);
            formData.append('user_id', user_id);
            formData.append('question_id', question_id);
            formData.append('option_id', option_value);

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                complete: function (response) {
                    console.log('completed');
                },
                success: function (response) {
                    /**
                     * after ajax request success, hide the current question and show the next one without refresh the page,
                     */
                    console.log('Submission was successful.');
                    console.log(response)
                    value_button = null;
                    option_value = null;
                    current_div.hide();
                    i++;
                    current_div = $("#div_" + i);
                    console.log(current_div);
                    current_div.show();
                    if (is_last) {
                        /**
                         * redirect to result page,
                         */
                        window.location.href = response;
                    }
                    // $('#options_div').html(response);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('error');
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

        });
    });
</script>