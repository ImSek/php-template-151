<?php

namespace imsek\Controller;

use imsek\SimpleTemplateEngine;
use imsek\Service\Register\RegisterService;
use imsek\Service\Security\CSRFProtectionService;

class RegisterController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	private $registerService;

	private $csrfService;
	/**
	 * @param ihrname\SimpleTemplateEngine
	 * @param PDO
	 */
	public function __construct(SimpleTemplateEngine $template, RegisterService $registerService, CSRFProtectionService $csrfProtection)
	{
		$this->template = $template;
		$this->registerService = $registerService;
		$this->csrfService = $csrfProtection;
	}

	public function showRegister()
	{
		echo $this->template->render("register.html.php", ["csrf" => $this->csrfService->getHtmlCode("csrfRegister")]);
	}

	public function register(array $data)
	{
		if(array_key_exists("csrf", $data))
		{
			if(!$this->csrfService->validateToken("csrfRegister", $data["csrf"]))
			{
				$this->showRegister();
				return;
			}
		}
		else
		{
			$this->showRegister();
			return;
		}
		if(!array_key_exists("email", $data) OR !array_key_exists("password", $data))
		{
			$this->showRegister();
			return;
		}
		if($this->registerService->reg($data["email"], $data["password"]))
		{
			header("Location: /");
		}
		else
		{
			$this->showRegister();
			echo "User with this email already exists";
		}
	}

	public function activate(array $data)
	{
		if(!array_key_exists("url", $data) OR !array_key_exists("user_id", $data))
		{
			echo "Not found";
			return;
		}
		else
		{
			$this->registerService->acti($data["url"], $data["user_id"]);
		}
	}
	public function changePw(array $data)
	{
		if(array_key_exists("csrf", $data))
		{
			if(!$this->csrfService->validateToken("csrfChangePW", $data["csrf"]))
			{
				$this->showChangePw(true);
				return;
			}
		}
		else
		{
			$this->showChangePw(true);
			return;
		}
		if(!array_key_exists("password", $data) OR !array_key_exists("code", $data))
		{
			$this->showChangePw(true);
		}
		else
		{
			$this->registerService->chpw($data["password"], $data["code"]);
			header("Location:/ ");
		}
	}

	public function showChangePw($codeSent)
	{
		echo $this->template->render("changePassword.html.php", array('codeSent' => $codeSent, "csrf" => $this->csrfService->getHtmlCode("csrfChangePW")));
	}

	public function sendChangePwCode(array $email)
	{
		$this->registerService->sendCode($email['email']);
	}
}
