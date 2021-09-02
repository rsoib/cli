<?php 
include_once(ROOT.'/models/User.php');
include_once(ROOT.'/models/Sale.php');
class IndexController 
{

	public $cliParams;
	public function __construct(array $params)
    {
        $this->cliParams = $params;
    }

	public function actionShow()
	{

		$params = [];
		$sendCommands = [$this->cliParams[1], $this->cliParams[2]];
		foreach ($this->cliParams as $argument) {
    		preg_match('/^-(.+)=(.+)$/', $argument, $matches);
    		if (!empty($matches)) {
        		$paramName = $matches[1];
        		$paramValue = $matches[2];
		        $params[$paramName] = $paramValue;
    		}
		}	

		if ($sendCommands[0] === 'send' && $sendCommands[1] === 'msg'){
			$this->processingСliCommands($params);
		}else{
			echo "Не правильно введен параметр!";
		}
	
	}

	public function processingСliCommands($params){
		if (isset($params['notificationtype']) && isset($params['userEmail']) || isset($params['userPhone'])) {
			
			if ($params['notificationtype'] == 'email') {
			
				$isHasUser = User::chekUser($params['userEmail']);
			
				if ($isHasUser === true) {
					$this->sendNotificationWithEmail($params['userEmail']);
					if (isset($params['product']) && isset($params['price'])) {
						$this->addSale($params['product'], $params['price']);
					}else{
						echo "Не все параметры переданы!";
					}
			
				}else{
					echo "Упс( нету такого клиента в базе!";
				}
			}else if ($params['notificationtype'] === 'phone') {
				
				$isHasUser = User::chekUserWithPhone($params['userPhone']);
				if ($isHasUser === true) {
					$this->sendNotificationWithPhone($params['userPhone']);
				}else{
					echo "Упс( нету такого клиента в базе!";
				}
			
			}else{
				echo "Не правильно введен тип уведомления!";
			}
		
		}else{
			echo "Не правильно введен параметр!";
		}
	}

	public function sendNotificationWithEmail($email){
		$from = 'rsoib1996@gmail.com';
    	$to = $email;
    	$subject = 'Notification';
    	$body = "From: $from Message:\n It`s notifaction";
		mail ($to, $subject, $body, $from);
	}

	public function sendNotificationWithPhone($phone){
		
	}

	public function addSale($product, $price){
		$sale = new Sale($product, $price);
	}
}
?>