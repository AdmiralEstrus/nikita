<?php

class ErrorController
{
    public function actionError($code, $message)
    {
        require_once(__DIR__ . "/../public/views/errors/error404.php");
        return true;
    }
}