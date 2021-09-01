<?php 

include_once(ROOT.'/components/Db.php');

class User
{

		public static function chekUser($email)
		{
			if ($email) {

				$db = Db::getConnection();

				$user = [];

				$result = $db->query("SELECT * FROM users 
												WHERE email=$email");

				//$result->setFetchMode(PDO::FETCH_ASSOC);

				// $user = $result->fetch();
				
				return $result;
			}
		} 

		public static function chekUserWithPhone($phone)
		{
			if ($phone) {

				$db = Db::getConnection();

				$user = [];

				$result = $db->query("SELECT * FROM users 
												WHERE phone=$phone");
				
				return $result;
			}
		} 

}



?>