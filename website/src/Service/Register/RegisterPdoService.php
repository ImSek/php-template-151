<?php
namespace livio\Service\Register;

class RegisterPdoService implements  RegisterService
{
	/**
	 *  @ var \PDO
	 */
	private $pdo;
	private $mailer;

	public function __construct(\PDO $pdo, $mailer)
	{
		$this->pdo = $pdo;
		$this->mailer = $mailer;
	}
	
	public function chpw($pw, $url)
	{
		if(isset($_SESSION['userid']))
		{
			$userid = $_SESSION['userid'];
			if($url == $this->getactivationCodeById($userid))
			{
				$stmt = $this->pdo->prepare("UPDATE `user` SET password=? WHERE id=?");
				$stmt->bindValue(1,$pw);
				$stmt->bindValue(2,$userid);
				$stmt->execute();
				echo "password has been changed";
			}
		}
		else
		{
			echo "you are not nollged in <a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
		}
	}
	
	public function sendCode()
	{
		$user = $this->getCurrentUser();
		$activationCode = $user['activationCode'];
		$this->mailer->send(
				\Swift_Message::newInstance("Change PW")
				->setContentType("text/html")
				->setFrom(["gibz.module.151@gmail.com" => "WebProject"])
				->setTo($user['email'])
				->setBody("<p>Change PW Code:</p> .$activationCode.")
				);
	}
	
	public function acti($url, $userid)
	{
		if($url == $this->getactivationCodeById($userid))
		{
			$stmt = $this->pdo->prepare("UPDATE `user` SET isActivated=? WHERE id=?");
			$stmt->bindValue(1,'1');
			$stmt->bindValue(2,$userid);
			$stmt->execute();
			echo "<p>Your Acc has been activated</p>";
			echo "<a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
			return;
		}
		else
		{
			echo "wrong activationcode";
			return;
		}
	}
	
	public function reg($email, $pw)
	{
		if ($this->userNotExist($email) == true)
		{
			$url = $this->generateRandomString();
			$this->createUser($email, $pw, $url);
			$this->sendRegistrationEmail($email, $url, $this->getUserIdByEmail($email));
			echo "email  with register link has been sent to .$email.";
		}
		else
		{
			echo "user with this email already exists";
		}	
	}
	
	private function getUserIdByEmail($email)
	{
		$stmt = $this->pdo->prepare("Select * FROM user WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		foreach ($stmt as $row)
		{
			return $row['id'];
			break;
		}
	}
	
	private function getCurrentUser()
	{
		if(isset($_SESSION['userid']))
		{
			$userid = $_SESSION['userid'];
			$stmt = $this->pdo->prepare("Select * FROM user WHERE id=?");
			$stmt->bindValue(1, $userid);
			$stmt->execute();
			foreach ($stmt as $row)
			{
				return $row;
				break;
			}
		}
		else
		{
			echo "you are not nollged in <a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
		}
		
	}
	
	private function getactivationCodeById($userid)
	{
		$stmt = $this->pdo->prepare("Select * FROM user WHERE id=?");
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		foreach ($stmt as $row)
		{
			return $row['activationCode'];
			break;
		}
	}
	
	private function userNotExist($email) {
		$stmt = $this->pdo->prepare("SELECT email FROM user WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	private function createUser($email,$pw, $url) {
		$stmt = $this->pdo->prepare("INSERT INTO user(right_id,email,password,isActivated,activationCode) VALUES(1,?,?,0,?)");
		$stmt->bindValue(1, $email);
		$stmt->bindValue(2, $pw);
		$stmt->bindValue(3, $url);
		$stmt->execute();
		if($stmt->errorCode()==="00000") {
			return $url;
		}
		else {
			return null;
		}
	}
	
	private function sendRegistrationEmail($email, $url, $userid)
	{
		$this->mailer->send(
				\Swift_Message::newInstance("Registrierung")
				->setContentType("text/html")
				->setFrom(["gibz.module.151@gmail.com" => "WebProject"])
				->setTo($email)
				->setBody("Registrierungsformular<br><a href=https://".$_SERVER['HTTP_HOST']."/activate?url=".$url."&userid=".$userid.">Link</a>")
				);
	}
	
	private function generateRandomString($length = 20)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}