<?php
namespace Spook;

use \Michelf\Markdown;

class DirectoryPostRepository implements PostRepositoryInterface {
    protected $directory;
    protected $file_extension;

    public function __construct($directory, $file_extension)
    {
        $this->directory = $directory;
        $this->file_extension = 'md';
    }

    public function find_all($limit=5)
    {
        foreach(new \DirectoryIterator($this->directory) as $file)
        {
            if($file->isDot()){ continue; }
            $posts[] = $file->getBasename('.'.$this->file_extension); 
        }

        usort($posts, function($a, $b){
            preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $a, $matches); 
            $a = $matches[1];
            preg_match("/.*([0-9]{4}-[0-9]{2}-[0-9]{2}).*/", $b, $matches); 
            $b = $matches[1];

            $a_date = new \DateTime($a);
            $b_date = new \DateTime($b);

            if($a_date == $b_date){
                return 0;
            }

            return $a_date < $b_date ? 1 : -1;
        });

        if($limit) { array_splice($posts, $limit); };  
        
        return $posts;
    }

    public function find($id)
    {
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

        $config_options['slug'] = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($id)));
        $post = explode('-----'.PHP_EOL, $post);
        $post = $post[2];
        $post = Markdown::defaultTransform($post);

        $post_summary = false;
        if(str_word_count($post) > 50){
            $post_summary = implode(' ', array_slice(explode(' ', $post), 0, 50));
        }  

        return array('metadata'=>$config_options, 'content'=>$post, 'summary'=>$post_summary);
    }
}