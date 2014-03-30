<?php

namespace Ghastly\Post;

use \Michelf\Markdown;


class PostParser {

	public function parse($inputFile)
	{
		$inputFile = $inputFile;
		$splitFile = $this->_splitFile($inputFile);

		$front_matter = $this->_parseFrontMatter($splitFile);
		$content = $this->_parseContent($splitFile);
		$slug = $this->_parseSlug($inputFile);
		$date = $this->_parseDate($inputFile);
		$summary = isset($front_matter['summary']) ? $front_matter['summary'] : $this->_parseSummary($content);
		$tags = isset($front_matter['tags']) ? explode(',', $front_matter['tags']) : [];

		$post = new Post();
		$post->setTitle($front_matter['title']);
		$post->setDate($date);
		$post->setSlug($slug);
		$post->setTags($tags);
		$post->setContent($content);
		$post->setSummary($summary);

		return $post;
	}

	private function _splitFile($inputFile)
	{
		return explode('-----', $inputFile['content']);
	}

	private function _parseFrontMatter($splitFile)
	{
		$ret = [];
		$front_matter = $splitFile[1];

		$front_matter = explode(PHP_EOL, $front_matter);
		$front_matter = array_filter($front_matter, function($n){ return trim($n); });	
		$front_matter = array_map(function($n){ return explode(':', $n); }, $front_matter);
		
		foreach($front_matter as $attr){
            $ret[trim($attr[0])] = trim($attr[1]);
        }

        return $ret;
	}

	private function _parseContent($splitFile)
	{
		return Markdown::defaultTransform($splitFile[2]);
	}

	private function _parseSlug($inputFile)
	{
		return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($inputFile['filename'])));
	}

	private function _parseDate($inputFile)
	{
		return $inputFile['date']->format('Y-m-d');
	}

	private function _parseSummary($content)
	{
		$summary = '';

        if(str_word_count($content) > 50){
            $summary = implode(' ', array_slice(explode(' ', $content), 0, 50));
        }

        return $summary;
	}

}
