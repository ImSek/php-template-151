<?php
namespace livio\Service\Homepage;

Interface HomepageService
{
	public function getAllPost();
	public function getAllLikes();
	public function getLikeByUserIdAndPostId($user_id, $post_id);
	public function addLike($user_id, $post_id, $isDislike);
	public function changeLike($user_id, $post_id, $isDislike);
	public function removeLike($user_id, $post_id);
}