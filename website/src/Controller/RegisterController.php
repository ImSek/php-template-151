<?php

namespace livio\Controller;

use livio\SimpleTemplateEngine;
use livio\Service\Register\RegisterService;

class RegisterController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	private $registerService;
	/**
	 * @param ihrname\SimpleTemplateEngine
	 * @param PDO
	 */
	public function __construct(SimpleTemplateEngine $template, RegisterService $registerService)
	{
		$this->template = $template;
		$this->registerService = $registerService;
	}

	public function showRegister()
	{
		echo $this->template->render("register.html.php");
	}
	
	public function register(array $data)
	{
		if(!array_key_exists("email", $data) OR !array_key_exists("password", $data))
		{
			$this->showRegister();
			return;
		}
		$this->registerService->reg($data{"email"}, $data{"password"});
	}
	
	public function activate(array $data)
	{
		if(!array_key_exists("url", $data) OR !array_key_exists("userid", $data))
		{
			echo "Not found";
			return;
		}
		else
		{
			$this->registerService->acti($data{"url"}, $data{"userid"});	
		}
	}
	
	public function changePw(array $data)
	{
		if(!array_key_exists("password", $data) OR !array_key_exists("code", $data))
		{
			echo $this->template->render("changepw.html.php");
		}
		else
		{
			$this->registerService->chpw($data{"password"}, $data{"code"});
		}
	}
	
	public function showChangePw()
	{
		echo $this->template->render("changepw.html.php");
	}
	
	public function sendChangePwCode()
	{
		$this->registerService->sendCode();
	}
}

