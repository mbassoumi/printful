<?php

include_once("../src/db/DB.php");
include_once("../src/controllers/QuizController.php");
include_once("../src/routes/Router.php");
include_once("../src/routes/Request.php");

$router = new Router(new Request());
//
$router->get('/', function() {
    include "home.php";
});


$router->post('/save-home', function($request) {
    $controller = new QuizController();
    $controller->saveHome();
});

$router->post('/save-answer', function($request) {
    $controller = new QuizController();
    $controller->saveAnswer();
});

$router->post('/submit-quiz', function($request) {
    $controller = new QuizController();
    $controller->submitQuiz();
});

$router->get('/quiz', function($request) {
    include "quiz.php";
});

$router->get('/result', function($request) {
    include "result.php";
});

