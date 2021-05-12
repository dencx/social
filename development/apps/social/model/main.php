<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE->model
 * @package Model\Main
 */
namespace Model;
class Main
{
	use \Library\Shared;

	public function uniwebhook(String $type = '', String $value = '', Int $code = 0):?array {
		$result = null;
		switch ($type) {
			case 'message':
				if ($value == 'вихід') {
					$result = ['type' => 'context', 'set' => null];
				} elseif ($value == '/start'){
					$result = [
						'to' => $GLOBALS['uni.user'],
						'type' => 'message',
						'value' => "Вітаємо! Сервіс `Подача заяв на соціальну стипендію`.",
						'keyboard' => [
							'inline' => true,
							'buttons' => [
								[['id' => 1, 'title' => 'Повернутися', 'request' => 'message', 'value' => 'вихід'],
								['id' => 5, 'title' => 'Подати заяву']]
							]
						]
					];
				} elseif ($value == '/back') { 
					$result = [
						'to' => $GLOBALS['uni.user'],
						'type' => 'message',
						'value' => "Ви повертаєтесь до головного розділу",
						'keyboard' => [
							'inline' => true,
							'buttons' => [
								[['id' => 1, 'title' => 'Повернутися', 'request' => 'message', 'value' => 'вихід'],
								['id' => 2, 'title' => 'Надати номер', 'request' => 'contact'],
								['id' => 3, 'title' => 'Ввести підставу']]
								//TODO: додати можливість прикріплювати копії довідок
							]
						]
					];
				}
				else
				$result = [
					'to' => $GLOBALS['uni.user'],
					'type' => 'message',
					'value' => "Сервіс `Подача заяв на соціальну стипендію` отримав повідомлення $value"
				];
				break;
			case 'click':
					if ($code == 1) {
						$result = ['type' => 'context', 'set' => null];
					} elseif ($code == 2) {
						$result = [
							'to' => $GLOBALS['uni.user'],
							'type' => 'message',
							'value' => "Ви у новому розділі",
							'keyboard' => [
								'inline' => false,
								'buttons' => [
									[['id' => 1, 'title' => 'Повернутися', 'request' => 'message', 'value' => 'вихід'],
									['id' => 2, 'title' => 'Надати номер', 'request' => 'contact']]
								]
							]
						];
					} elseif ($code == 3) {
						$result = [
							'to' => $GLOBALS['uni.user'],
							'type' => 'message',
							'value' => "Функція поки що не реалізована"
						];

					} else {
						$result = [
							'to' => $GLOBALS['uni.user'],
							'type' => 'message',
							'value' => "Оберіть дію",
							'keyboard' => [
								'inline' => true,
								'buttons' => [
									[['id' => 1, 'title' => 'Повернутися', 'request' => 'message', 'value' => 'вихід'],
									['id' => 2, 'title' => 'Надати номер', 'request' => 'contact'],
									['id' => 3, 'title' => 'Ввести підставу']]
								]
							]
						];
					}
					break;
			case 'contact':
					$result = [
						'to' => $GLOBALS['uni.user'],
						'type' => 'message',
						'value' => "Сервіс `Подача заяв на соціальну стипендію`. Отримано номер $value"
					];
					break;
		}

		return $result;
	}

	public function formsubmitAmbassador(String $firstname, String $secondname, String $phone, String $position = ''):?array {
		$result = null;
		$chat = 891022220;
		$this->TG->alert("Нова заявка в *Цифрові Амбасадори*:\n$firstname $secondname, $position\n*Зв'язок*: $phone");
		$result = [];
		return $result;
	}

	public function __construct() {
		$this->db = new \Library\MySQL('core',
			\Library\MySQL::connect(
				$this->getVar('DB_HOST', 'e'),
				$this->getVar('DB_USER', 'e'),
				$this->getVar('DB_PASS', 'e')
			) );
		$this->setDB($this->db);
	}
}