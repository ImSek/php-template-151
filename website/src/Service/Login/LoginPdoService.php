<?php
namespace livio\Service\Login;

class LoginPdoService implements  LoginService
{
	/**
	 *  @ var \PDO
	 */
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function authenticate($username, $password)
	{
		$stmt = $this->pdo->prepare("Select * FROM user WHERE email=? AND password=?");
		$stmt->bindValue(1,$username);
		$stmt->bindValue(2,$password);
		$stmt->execute();
		
		if($stmt->rowCount() === 1)
		{
			$_SESSION["email"] = $username;
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	public function getuseridbyemail($email)
	{
		$stmt = $this->pdo->prepare("Select * FROM user WHERE email=?");
		$stmt->bindValue(1,$email);
		$stmt->execute();
		if($stmt->rowCount() === 1)
		{
			foreach ($stmt as $row)
			{
				return $row['id'];
			}
		}
		else
		{
			return false;
		}
	}
}