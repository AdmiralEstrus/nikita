<?php

require_once __DIR__ . "/../models/Database.php";

class SiteController {

    /**
     * @var Database
     */
    private $model;

    public function __construct() {
        $this->model = new Database();
    }

    /**
     * Отображает страницу с панелью администратора
     */
    public function actionIndex() {
        global $errors;
        $errors = [];
        if (isset($_POST['send_data'])) {
            try {
                $a = $this->model->addLessonInfo($_POST['group_number'], $_POST['type'], $_POST['length'], $_POST['subject']);
                if (!$a) {
                    throw new Exception('Не удалось записать информацию в базу groups.');
                }

                $a = $this->model->addProfessorInfo($_POST['professor'], $_POST['subject']);
                if (!$a) {
                    throw new Exception('Не удалось записать информацию в базу professors.');
                }

                header('Location: /');
                die;
            } catch (Exception $Ex) {
                $errors[] = $Ex->getMessage();
            }
        }

        require_once(__DIR__ . '/../public/views/site/index.php');
    }

    public function actionReset() {
        if ($this->model->resetAll()) {
            echo "reset ok";
        } else {
            echo "reset not ok";
        }
    }
}
