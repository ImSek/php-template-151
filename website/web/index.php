<?php

use livio\Controller;
use livio\Factory;

error_reporting(E_ALL);

session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new Factory($config);
$tmpl = $factory->getTemplateEngine();
$pdo = $factory->getPDO();

if($_SERVER["REQUEST_METHOD"] == "PUT") {
	die();
}
if(strpos($_SERVER["REQUEST_URI"], '/activate') !== false)
{
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$registerService = $factory->getRegisterService();
		$ctr = new Controller\RegisterController($tmpl, $registerService);
		$ctr->activate($_GET);
	}
}
else
{
	switch($_SERVER["REQUEST_URI"]) {
		case "/":
			$homepageService = $factory->getHomepageService();
			$ctr = new Controller\IndexController($tmpl, $homepageService, $pdo);
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(array_key_exists('like',$_POST)){
					$ctr->like($_POST);
				}
			}
			$ctr->homepage();
			break;
		case "/login":
			$loginService = $factory->getLoginService();
			$ctr = new Controller\LoginController($tmpl, $loginService);
			if($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->showLogin();
			}
			else
			{
				$ctr->login($_POST);
			}
			break;
		case "/changepw":
			$registerService = $factory->getRegisterService();
			$ctr = new Controller\RegisterController($tmpl, $registerService);
			if($_SERVER["REQUEST_METHOD"] == "GET") 
			{
				$ctr->sendChangePwCode();
				$ctr->showChangePw();
			}
			else
			{
				$ctr->changePw($_POST);
			}
			break;
		case "/register":
			$registerService = $factory->getRegisterService();
			$ctr = new Controller\RegisterController($tmpl, $registerService);
			if($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->showRegister();
			}
			else
			{
				$ctr->register($_POST);
			}
			break;
		default:
			$matches = [];
			if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
				(new livio\Controller\IndexController($tmpl))->greet($matches[1]);
				break;
			}
			echo "Not Found";
	}

}

