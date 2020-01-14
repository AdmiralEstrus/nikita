<?php
require __DIR__ . "/../exceptions/HttpNotFoundException.php";
require __DIR__ . "/../controllers/ErrorController.php";

class Router
{
    /**
     * Содержит путь к файлу routes.php, где определены все пути
     * @var $routes
     */
    private $routes;


    /**
     * Router конструктор - подключается список возможных rout'ов.
     */
    public function __construct()
    {
        $routesPath = __DIR__ . '/../config/routes.php';
        $this->routes = include($routesPath);
    }


    /**
     * Возвращает строку с адресом страницы
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return false;
    }


    /**
     * Запустить работу
     */
    public function run()
    {
        /**
         * @param uri - получат строку запроса из функции @see getURI()
         */
        $uri = $this->getURI();
        /**
         * Ищем наш запрос в routes.php
         */
        try {
            foreach ($this->routes as $uriPattern => $path) {
                if (preg_match("~$uriPattern~", $uri, $matches)) {
                    /**
                     * @param $uriPattern - паттерн вида id([0-9]+) (из routes)
                     * @param $path - путь, который мы задаем судя по нашему $uriPattern в routes.php
                     * @param $uri - что написано в адресной строке после mysite.com/
                     */
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                    /**
                     * Функция explode делит строку на массив, разделитель: '/'
                     */
                    $segments = explode('/', $internalRoute);
                    /**
                     * @param $controllerName - имя класса контроллера для обработки нашей страницы
                     * Функция ucfirst - Upper Case First
                     */
                    $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                    /**
                     * @param $actionName - имя метода класса, которому мы передаем управление
                     * Функция ucfirst - Upper Case First
                     */
                    $actionName = 'action' . ucfirst(array_shift($segments));
                    /**
                     * @param $parameters - записываем в переменную оставшиеся
                     */
                    $parameters = $segments;
                    /**
                     * @param $controllerFile - указываем путь к файлу, в котором обрабатываем нужную страницу
                     */
                    $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
                    /**
                     * @param $controllerFile - если существует, то мы его подключаем и выполняем
                     * иначе бросаем ошибку типа HttpException
                     */

                    if (file_exists($controllerFile)) {
                        include_once($controllerFile);
                    } else {
                        throw new HttpException();
                    }
                    /**
                     * @param $controllerObject - создаем объект типа класса, в соответствии с  нашим адресом
                     */
                    $controllerObject = new $controllerName();
                    /** @var $result - получает значение функции call_user_func_array,
                     * в котором мы в функцию @param $actionName
                     * метода @param $controllerObject
                     * передаем наши параметры @param $parameters
                     */
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                    /**
                     * Выходим из цикла foreach, если нашли наш обработчик
                     */
                    if ($result) {
                        return true;
                    } else
                        return false;
                }
            }
        } catch (HttpException $httpException) {
            $controllerObject = new ErrorController();
            $controllerObject->actionError($httpException->getCode(), $httpException->getMessage());
        }
        return false;
    }
}