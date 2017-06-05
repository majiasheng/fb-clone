<?php
	class Comment{
		
		private $author;
		private $comment_id;
		private $post_id;
		private $edit_time;
		private $comment_time;
		private $comment_content;
		private $isEdited;

		function setAuthor($arg){
			$this->author = $arg;
		}

		function setIsEdited($arg){
			$this->isEdited = $arg;
		}

		function setCommentId($arg){
			$this->comment_id = $arg;
		}

		function setCommentContent($arg){
			$this->comment_content = $arg;
		}

		function setPostId($arg){
			$this->post_id = $arg;
		}

		function setEditTime($arg){
			$this->edit_time = $arg;
		}

		function setCommentTime($arg){
			$this->comment_time = $arg;
		}

		function getAuthor(){
			return $this->author;
		}

		function getCommentID(){
			return $this->comment_id;
		}

		function getPostId(){
			return $this->post_id;
		}

		function getEditTime(){
			return $this->edit_time;
		}

		function getCommentTime(){
			return $this->comment_time;
		}

		function getCommentContent(){
			return $this->comment_content;
		}

		function getIsEdited(){
			return $this->isEdited;
		}
	
	}

?>



