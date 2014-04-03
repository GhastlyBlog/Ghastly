<?php

namespace Ghastly\Post;

/** 
 * Represents a blog post
 */
class Post {

    /**
     * The title of a post
     * @var string
     */
	private $title;

    /**
     * The formatted date of a post
     * @var string
     */
	private $date;

    /**
     * A posts slug
     * @var string
     */
	private $slug;

    /**
     * A posts tags
     * @var array
     */
	private $tags;

    /**
     * A posts html content
     * @var string
     */
	private $content;

    /**
     * The post summary
     * @var string
     */
	private $summary;

    /**
     * Add a tag to the post's tag array
     * @param string $tag
     */
	public function addTag($tag)
	{
		array_push($this->tags, trim($tag));
	}

	/** Getters and Setters **/

    /**
     * @return string
     */
	public function getTitle()
	{
		return $this->title;
	}

    /**
     * @return string
     */
	public function getDate() 
	{
		return $this->date;
	}

    /**
     * @return string
     */
	public function getSlug()
	{
		return $this->slug;
	}

    /**
     * @return array
     */    
	public function getTags() 
	{
		return $this->tags;
	}

    /**
     * @return string
     */
	public function getContent() 
	{
		return $this->content;
	}

    /**
     * @return string
     */
	public function getSummary()
	{
		return $this->summary;
	}

    /**
     * @param string $title
     */
	public function setTitle($title) 
	{
		$this->title = $title;
	}

    /**
     * @param string $date a formatted date string
     */
	public function setDate($date) 
	{
		$this->date = $date;
	}

    /**
     * @param string $slug
     */
	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

    /**
     * @param array $tags
     */
	public function setTags($tags) 
	{
		$this->tags = $tags;
	}

    /**
     * @param string $content
     */
	public function setContent($content)
	{
		$this->content = $content;
	}

    /**
     * @param string $summary
     */
	public function setSummary($summary)
	{
		$this->summary = $summary;
	}

}
