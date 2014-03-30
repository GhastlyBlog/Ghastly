<?php

namespace Ghastly\Post;

class Post {

	protected $title;
	protected $date;
	protected $slug;
	protected $tags;
	protected $content;
	protected $summary;

	public function addTag($tag)
	{
		array_push($this->tags, $tag);
	}

	/** Getters and Setters **/

	public function getTitle()
	{
		return $this->title;
	}

	public function getDate() 
	{
		return $this->date;
	}

	public function getSlug()
	{
		return $this->slug;
	}
	
	public function getTags() 
	{
		return $this->tags;
	}

	public function getContent() 
	{
		return $this->content;
	}

	public function getSummary()
	{
		return $this->summary;
	}


	public function setTitle($title) 
	{
		$this->title = $title;
	}

	public function setDate($date) 
	{
		$this->date = $date;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	public function setTags($tags) 
	{
		$this->tags = $tags;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setSummary($summary)
	{
		$this->summary = $summary;
	}

}