<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {
		include ROOT . '/model/config/patterns.php'; //підключаємо файл з паттернами
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);

		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];
					foreach ($details['params'] as $param) {
						$var = $this->getVar($param['name'], $param['source']);
						// if ($var)
						//	$request[$param['name']] = $var;

						
						if (!empty($var)) { //перевіряємо чи змінна не пуста
							if(isset($param['pattern'])) { //перевіряємо чи встановлено паттерн
								if(preg_match($patterns[$param['pattern']]['regex'], $var)) { //перевіряємо чи змінна відповідає встановленому паттерну
									if(isset($patterns[$param['pattern']]['callback'])) //перевіряємо чи підтримується callback-функція та викликаємо її, якщо підтримується (присвоюємо нове значення змінній)
										$var = preg_replace_callback($patterns[$param['pattern']]['regex'], $patterns[$param['pattern']]['callback'], $var);
									$request[$param['name']] = $var;
								} else 
									throw new \Exception('REQUEST_INCORRECT'); //"некоректний запит"
							} else 
								$request[$param['name']] = $var;
						} elseif (!$param['required']) { //перевіряємо чи параметр необовязковий до введення
							if(isset($param['default'])) //перевіряємо чи існує значення за замовчуванням та присвоюємо це значення, якщо існує
								$request[$param['name']] = $param['default']; 
							else 
								throw new \Exception('INTERNAL_ERROR'); //"внутрішня помилка"

						} else {
							throw new \Exception('REQUEST_INCOMPLETE'); //"неповний запит"
						}
						
							
					}
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];
						$result = $method($request);
					} /*else {
						throw new \Exception('REQUEST_UNKNOWN'); //"метод не підтримується"
					}*/

				}

			}
		}

		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$front = $this -> getVar('FRONT', 'e');
		foreach ( [$front] as $allowed )
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}