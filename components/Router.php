<?php
	
class Router
{

	//Это массив в котором хранится маршруты
	
	private $routes;
	private $params;
	public function __construct(array $params)
	{
		// В свойстве routes сохраняем массив маршруты из файла /config/routes.php
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include_once($routesPath);
		$this->params = $params;
	}

	// Метод для получения строку запроса

	private function getUri()
	{
		if (!empty($_SERVER['REQUEST_URI'])) 
		{
			return trim($_SERVER['REQUEST_URI'],'/');
		}
	}

	// Анализ запроса и передача управления
	public function run()
	{	
		// Получить строку запроса
			
			$uri = $this->getUri();
				
		// Проверим наличие такого запроса ва routes.php

				foreach ($this->routes as $uriPattern => $path) {
					
					// Сравниваем $uriPattern и $uri

					if (preg_match("~$uriPattern~", $uri)) {
						
						//Получаем внутренный путь из внешнего согласно правилу

						$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

						
						
						// Определим какой контроллер и метод обрабатывает запрос а также определим парметри

						$segments = explode('/', $internalRoute);

						// Получаем имя контроллера

						$controllerName = array_shift($segments).'Controller';
						$controllerName = ucfirst($controllerName);
						
						// Получаем имя метода 

						$actionName = array_shift($segments);
						$actionName = 'action'.ucfirst($actionName);

						$parameters = $segments;


						// Подключаем файлы класса - контроллера

						$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

						if (file_exists($controllerFile)) {
							include_once($controllerFile);
						}
						
						// Создаём объект и визываем метод и передаём параметры.
						$controllerObject = new $controllerName($this->params);	
						$result = call_user_func_array(array($controllerObject,$actionName), $parameters);

						if ($result !=null) {
							break;
						}
					}
					
				}

				exit();

				//print_r($this->routes);
		
	}
}

?>