<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 01/11/2018
 * Time: 21:56
 */


class QuizController
{
    public function saveAnswer()
    {
        $user_id = $_POST['user_id'];
        $quiz_id = $_POST['quiz_id'];
        $question_id = $_POST['question_id'];
        $option_id = $_POST['option_id'];

        $this->storeAnswer($user_id, $question_id, $option_id);

        echo true;
    }

    public function saveHome()
    {
        $db = new DB();
        $user_name = $_POST['name'];
        $quiz_id = $_POST['quiz_id'];


        $save_user_query = 'insert into users (name) values ("' . $user_name . '")';
        $user_id = $db->insertAndGetInsertedId($save_user_query);
        $save_user_quiz_query = "insert into user_quiz (user_id, quiz_id) values ($user_id, $quiz_id)";
        $db->execute($save_user_quiz_query);

        $redirect_url = "/quiz?user_id={$user_id}&quiz_id={$quiz_id}";
        json_encode($redirect_url);
        echo $redirect_url;
    }

    public function submitQuiz()
    {
        $user_id = $_POST['user_id'];
        $quiz_id = $_POST['quiz_id'];
        $question_id = $_POST['question_id'];
        $option_id = $_POST['option_id'];
        $this->storeAnswer($user_id, $question_id, $option_id);

        $get_result_query = "SELECT COUNT(*) as result
                            FROM answers
                            JOIN `options` on answers.option_id = `options`.id and `options`.mark = 1
                            WHERE answers.user_id = {$user_id}";
        $db = new DB();
        $result = $db->getData($get_result_query);

        $save_result_query = "insert into results (user_id, quiz_id, result) values ($user_id, $quiz_id, {$result[0]['result']})";

        $db->execute($save_result_query);
        $redirect_url = "/result?user_id={$user_id}";
        json_encode($redirect_url);
        echo $redirect_url;
    }


    private function storeAnswer($user_id, $question_id, $option_id)
    {

        $db = new DB();

        $save_answer_query = "insert into answers 
                              (user_id, question_id, option_id)
                              values ($user_id, $question_id, $option_id)
                              ";

        $db->execute($save_answer_query);

    }


}