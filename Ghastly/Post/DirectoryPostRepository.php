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
 * <code>
 * $repo->findAll->limit(5)->getResults();
 * </code>
 */
class DirectoryPostRepository implements PostRepositoryInterface {

    /**
     * The directory all of the entities are located in 
     * @var string
     */
    private $directory;

    /**
     * The file extension of the entities
     * @var string
     */
    private $file_extension;

    /**
     * A collection of files
     * @var array
     */
    private $entities;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->directory = $config->options['posts_dir'];
        $this->file_extension = $config->options['post_file_extension'];
    }


    /**
     * Grabs all files in the directory sorted by date desc
     * @return DirectoryPostRepository
     */
    public function findAll()
    {
        $posts = [];

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
     * @param string $filename
     * @return DirectoryPostRepository
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

    /**
     * Limits the $entities
     * @param int $limit Will reduce $entities to only $limit
     * @return DirectoryPostRepository
     */
    public function limit($limit)
    {
        if($limit && $limit !== 0) { 
            array_splice($this->entities, $limit); 
        }; 

        return $this;
    }

    /**
     * Will return the file descriptor or the actual file
     * @param bool $headers_only if true, will only return descriptor of file
     * @return array
     */
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

    /**
     * Return the content of a file
     * @return Post 
     */
    public function getResult()
    {
        $this->entities[0]['content'] = file_get_contents($this->directory.DS.$this->entities[0]['filename'].'.'.$this->file_extension);
        
        return $this->entities[0];
    }

    /**
     * Gets a date from a filename in the format Y-m-d-name-of-file
     * @param string $filename The name of the file to find a date in
     * @return DateTime
     */
    private function _getDateFromFilename($filename)
    {
        preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $filename, $matches); 
        return isset($matches[1]) ? new \DateTime($matches[1]) : null;
    }

    /**
     * Will remove slashes from a filename
     * @param string $filename The filename to remove slashes from
     * @return string
     */
    private function _escape_filename($filename)
    {
        return str_replace('/', '', $filename);
    }

    /**
     * Sorts an array of posts by date descending
     * @param array $posts The posts to sort
     * @return array
     */
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
