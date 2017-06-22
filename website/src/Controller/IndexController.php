<?php

namespace livio\Controller;

use livio\SimpleTemplateEngine;
use livio\Service\Homepage\HomepageService;

class IndexController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  private $homepageService;
  
  private $pdo;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, HomepageService $homepageService, \PDO $pdo)
  {
     $this->template = $template;
     $this->homepageService = $homepageService;
     $this->pdo = $pdo;
  }
  
  public function homepage() 
  {
  	
  	/*$posts = $this->homepageService->getAllPost();
  	$this->template->render('hello.html.php', array('posts' => $posts));*/
  	$likes = $this->homepageService->getAllLikes();
  	$posts = $this->homepageService->getAllPost();
    echo $this->template->render("hello.html.php", array('posts' => $posts, 'likes' => $likes)); 
  }
  
  public function like(array $data)
  {
  	$like = $this->homepageService->getLikeByUserIdAndPostId($_SESSION['user_id'], $data{"post_id"});
  	if($like != false)
  	{
  		if ($like['isDislike'] == 1)
  		{
  			$this->homepageService->changeLike($_SESSION['user_id'], $data{"post_id"}, 0);
  		}
  		if ($like['isDislike'] == 0)
  		{
  			$this->homepageService->removeLike($_SESSION['user_id'], $data{"post_id"});
  		}
  	}
  	else
  	{
  		$this->homepageService->addLike($_SESSION['user_id'], $data{"post_id"}, 0);
  	}
  }
  
  public function dislike(array $data)
  {
  	$like = $this->homepageService->getLikeByUserIdAndPostId($_SESSION['user_id'], $data{"post_id"});
  	if($like != false)
  	{
  		if ($like['isDislike'] == 1)
  		{
  			$this->homepageService->removeLike($_SESSION['user_id'], $data{"post_id"});
  		}
  		if ($like['isDislike'] == 0)
  		{
  			$this->homepageService->changeLike($_SESSION['user_id'], $data{"post_id"}, 1);
  		}
  	}
  	else
  	{
  		$this->homepageService->addLike($_SESSION['user_id'], $data{"post_id"}, 1);
  	}
  }
  
  public function greet($name) 
  {
  	echo $this->template->render("hello.html.php", ["name" => $name]);
  }
}
