<?php

namespace Ghastly\Post;

use Ghastly\Config\Config;

/**
 * Expects the directory it's reading to contain files in a format
 * of yyyy-mm-dd-name-of-file.ext  
 *
 * Entire file should match ([0-9]{4}-[0-9]{2}-[0-9]{2})[A-Za-z0-9-]+
 *
 * This classes methods are chainable.
 *  $repo->findAll->limit(5)->getResults();
 */
class DirectoryPostRepository implements PostRepositoryInterface {

    /**
     * The directory all of the entities are located in 
     */
    protected $directory;

    /**
     * The file extension of the entities
     */
    protected $file_extension;

    /**
     * A collection of files
     */
    protected $entities;

    public function __construct()
    {
        $options = Config::getInstance()->options;

        $this->directory = $options['posts_dir'];
        $this->file_extension = $options['post_file_extension'];
    }


    /**
     * Grabs all files in the directory sorted by date desc
     */
    public function findAll()
    {
        // Loop over every file in the data directory
        foreach(new \DirectoryIterator($this->directory) as $file)
        {
            // Skip hidden files
            if($file->isDot()){ continue; }

            // Get the filename of the file
            $filename = $file->getBasename('.'.$this->file_extension);

            // Build post
            $posts[] = array(
                'filename'=> $filename, 
                'date' => $this->_getDateFromFilename($filename)
            ); 
        }

        // Sort results by date desc
        $this->entities = $this->_sortByDateDesc($posts);

        return $this;
    }

    /** 
     * Returns a single file / date from a filename
     */
    public function find($filename)
    {
        $filename = $this->_escape_filename($filename);
        $filepath = $this->directory.DS.$filename.'.'.$this->file_extension;

        $post = array(
            'filename' => $filename,
            'date' => $this->_getDateFromFilename($filename)
        );
        
        $this->entities = (file_exists($filepath)) ? array($post) : array();

        return $this;
    }

    public function limit($limit)
    {
        if($limit && $limit !== 0) { 
            array_splice($this->entities, $limit); 
        }; 

        return $this;
    }

    public function getResults($headers_only = false)
    {
        if(! $headers_only)
        {
            foreach($this->entities as $key => $entity) {
                $this->entities[$key]['content'] = file_get_contents($this->directory.DS.$entity['filename'].'.'.$this->file_extension);
            }
        }

        return $this->entities;
    }

    public function getResult()
    {
        $this->entities[0]['content'] = file_get_contents($this->directory.DS.$this->entities[0]['filename'].'.'.$this->file_extension);
        
        return $this->entities[0];
    }

    private function _getDateFromFilename($filename)
    {
        preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $filename, $matches); 
        return isset($matches[1]) ? new \DateTime($matches[1]) : null;
    }

    private function _escape_filename($filename)
    {
        return str_replace('/', '', $filename);
    }

    private function _sortByDateDesc($posts)
    {
        usort($posts, function($a, $b){
            $a_date = $a['date'];
            $b_date = $b['date'];

            if($a_date == $b_date){
                return 0;
            }

            return $a_date < $b_date ? 1 : -1;
        }); 

        return $posts;
    }
   
}
