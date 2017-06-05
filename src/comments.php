<?php
	class Comment{
		
		private $author;
		private $comment_id;
		private $post_id;
		private $edit_time;
		private $post_time;

		function setAuthor($arg){
			$this->author = $arg;
		}

		function setCommentId($arg){
			$this->comment_id = $arg;
		}

		function setPostId($arg){
			$this->post_id = $arg;
		}

		function setEditTime($arg){
			$this->edit_time = $arg;
		}

		function setPostTime($arg){
			$this->post_time = $arg;
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
		function getPostTime(){
			return $this->post_time;
		}
	
	}

?>



