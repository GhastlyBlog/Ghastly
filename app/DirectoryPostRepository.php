<?php

namespace Spook;

use \Michelf\Markdown;

/**
 * Sometimes bloggers are SO lazy that they don't even want to issue the
 * generate command for static sites. I benchmarked ~30 requests / second
 * on my very average desktop with 1000 blog posts in the directory.
 * Good enough for most people, I imagine.
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

    public function __construct()
    {
        $options = Config::getInstance()->options;
        $this->directory = $options['posts_dir'];
        $this->file_extension = $options['post_file_extension'];
    }

    public function find_all($limit=5)
    {
        foreach(new \DirectoryIterator($this->directory) as $file)
        {
            if($file->isDot()){ continue; }

            $filename = $file->getBasename('.'.$this->file_extension);

            preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $filename, $matches); 
            $date = $matches[1];

            $posts[] = array(
                'filename'=> $filename, 
                'date' => new \DateTime($date)
            ); 

        }

        usort($posts, function($a, $b){
            $a_date = $a['date'];
            $b_date = $b['date'];

            if($a_date == $b_date){
                return 0;
            }

            return $a_date < $b_date ? 1 : -1;
        });

        if($limit && $limit !== 0) { array_splice($posts, $limit); };  
        
        return $posts;
    }

    public function find($id)
    {
        if(is_array($id)){
            $id = $id['filename'];
        }
        $id = $this->_escape_filename($id);
        $filepath = $this->directory.DIRECTORY_SEPARATOR.$id.'.'.$this->file_extension;

        if(file_exists($filepath))
        {
            return $filepath;
        } else {
            return false;
        }
    }

    public function read($id)
    {
        if( !is_array($id)) 
        {
            preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $id, $matches); 
            $date = $matches[1];
            $id = array('filename'=>$id, 'date'=>new \DateTime($date));
        } 

        $post = $this->find($id);
        if(! $post){ return false; }

        $post = file_get_contents($post);

        $post_config_lines = array();
        $config_options = array();

        $post_config = explode('-----', $post);
        $post_config = explode(PHP_EOL, $post_config[1]);
        $post_config = array_filter($post_config, function($n){ return $n; });
        $post_config = array_map(function($n){ return explode(':', $n); }, $post_config);

        foreach($post_config as $option){
            $config_options[trim($option[0])] = trim($option[1]);
        }

        $config_options['slug'] = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($id['filename'])));

        $config_options['date'] = $id['date']->format('Y-m-d');

        $post = explode('-----'.PHP_EOL, $post);
        $post = $post[2];
        $post = Markdown::defaultTransform($post);

        $post_summary = false;
        if(str_word_count($post) > 50){
            $post_summary = implode(' ', array_slice(explode(' ', $post), 0, 50));
        }  

        return array('metadata'=>$config_options, 'content'=>$post, 'summary'=>$post_summary);
    }

    private function _escape_filename($filename)
    {
        return str_replace('/', '', $filename);
    }
}
