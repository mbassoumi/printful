<?php

include_once("../src/db/DB.php");
include_once("../src/controllers/QuizController.php");


$requestUrl = strtolower($_SERVER['REQUEST_URI']);


if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    /**
     * handle ajax request functions,
     */
    switch ($requestUrl) {
        case '/save-home' :
            $controller = new QuizController();
            $controller->saveHome();
            break;
        case '/save-answer' :
            $controller = new QuizController();
            $controller->saveAnswer();
            break;
        case '/submit-quiz' :
            $controller = new QuizController();
            $controller->submitQuiz();
            break;

    }
} else if (strtolower($_SERVER['REQUEST_METHOD']) == 'get' and $requestUrl == '/') {
    $db = new DB();

    $quiz_query = "SELECT * FROM quizzes ORDER BY id DESC";
    $quizzes = $db->getData($quiz_query);

    ?>

    <html>
    <head>
        <title>Home</title>
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
        <form style="margin: 20%;">
            <div class="row">
                <div class="col s12">
                    <input placeholder="Enter your name" name="name" id="name" type="text" class="validate">
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <select id="quiz_id" name="quiz_id">
                        <option value="" disabled selected>Choose Test</option>
                        <?php
                        foreach ($quizzes as $quiz) {
                            echo '<option value="' . $quiz['id'] . '">' . $quiz['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <!--                <div class="input-field col s6">-->

                <button id="submitHome" class='btn waves-effect waves-light deep-purple grey darken-2'
                        style="width: 50%">Start
                </button>
                <!--                </div>-->
            </div>
        </form>
    </div>
    </body>
    </html>

    <script>
        $(document).ready(function () {
            $('select').formSelect();

            $("body").on('click', '#submitHome', function (e) {
                e.preventDefault();

                let url = '/save-home';
                let user_name = $('#name').val();
                let quiz_id = $('#quiz_id').val();
                if (user_name === '') {
                    alert('you have to enter your name');
                    return;
                }
                if (quiz_id === null) {
                    alert('you have to select a quiz');
                    return;
                }


                let formData = new FormData();
                formData.append('name', user_name);
                formData.append('quiz_id', quiz_id);

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
                        console.log('Submission was successful.');
                        console.log(response);
                        /**
                         * redirect to quiz page
                         */
                        window.location.href = response;
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


    <?php
}