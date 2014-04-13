<?php

namespace Ghastly\Post;

/**
 * Represents a post file without any of its contents
 */
class PostFile {

	/**
	 * The filename of the post file
	 * @var string
	 */
	private $filename;
	
	/**
	 * The date extract from the filename used for sorting
	 * @var DateTime
	 */
	private $date;

	/**
	 * The content of the file
	 * @var string
	 */
	private $content;

	public function __construct($filename, $date, $content='')
	{
		$this->filename = $filename;
		$this->date = $date;
		$this->content = $content;
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param string $filename The filename to set
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	/**
	 * @param DateTime $date The date to set
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * @param string $contents The content of the file
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

}