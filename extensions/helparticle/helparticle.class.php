<?php

class helpArticle {
	
	public $title;
	public $author;
	public $article;
	public $date_created;
	public $section;
	public $category;
	public $last_modified;
	
	function createArticle() {
		$article = array ("title" => $this->title, "article" => $this->article, "author" => $this->author, "date_created" => $this->date_created, "section" => $this->section, "category" => $this->category, "last_modified" => $this->last_modified );
		return $article;
	}
	
	function getArticleFromRequest() {
		if (isset ( $_REQUEST ['title'] )) {
			$this->title = $_REQUEST ['title'];
		}
		if (isset ( $_REQUEST ['article'] )) {
			$this->article = $_REQUEST ['article'];
		}
		if (isset ( $_REQUEST ['author'] )) {
			$this->author = $_REQUEST ['author'];
		}
		if (isset ( $_REQUEST ['date_created'] )) {
			$this->date_created = $_REQUEST ['date_created'];
		}
		if (isset ( $_REQUEST ['section'] )) {
			$this->section = $_REQUEST ['section'];
		}
		if (isset ( $_REQUEST ['last_modified'] )) {
			$this->last_modified = $_REQUEST ['last_modified'];
		}
		
		return $this->createArticle ();
	}

}