<?php

namespace Ghastly\Post;

use \Michelf\Markdown;

/** 
 * Can parse a post file 
 */
class PostParser implements Parsable{
    
    /**
     * Parse the inputfile
     * @param file $inputFIle
     * @return Post
     */
	public function parse($inputFile)
	{
		$splitFile = $this->_splitFile($inputFile);

		$front_matter = $this->_parseFrontMatter($splitFile);
		$content = $this->_parseContent($splitFile);
		$slug = $this->_parseSlug($inputFile);
		$date = $this->_parseDate($inputFile);
		$summary = isset($front_matter['summary']) ? $front_matter['summary'] : $this->_parseSummary($content);
		$tags = isset($front_matter['tags']) ? array_map('trim',explode(',', $front_matter['tags'])) : [];

		$post = new Post();
		$post->setTitle($front_matter['title']);
		$post->setDate($date);
		$post->setSlug($slug);
		$post->setTags($tags);
		$post->setContent($content);
		$post->setSummary($summary);

		return $post;
	}

    /**
     * Split a file by its front matter
     * @param file $inputFile
     * @return array
     */
	private function _splitFile($inputFile)
	{
		return explode('---', $inputFile['content']);
	}

    /**
     * Parse the front matter into a key/value array
     * @param array $splitFIle a file already split from _splitFile
     * @return array
     */
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

    /**
     * Parse the Markdown content
     * @param array $splitFile
     * @return string
     */
	private function _parseContent($splitFile)
	{
		return Markdown::defaultTransform($splitFile[2]);
	}

    /**
     * Parse a slug
     * @param file $inputFile
     * @return string
     */
	private function _parseSlug($inputFile)
	{
		return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($inputFile['filename'])));
	}

    /**
     * Parse a date
     * @param file $inputFile
     * @return string
     */
	private function _parseDate($inputFile)
	{
		return $inputFile['date']->format('Y-m-d');
	}

    /**
     * Parse a summary from front matter or content
     * @param string $content
     * @return string
     */
	private function _parseSummary($content)
	{
		$summary = '';

        if(str_word_count($content) > 50){
            $summary = implode(' ', array_slice(explode(' ', $content), 0, 50));
        }

        return $summary;
	}

}
