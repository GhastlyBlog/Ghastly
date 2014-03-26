<?php

class Archive extends Plugin {
    public $archive_page = false;
    public $events;
    public $postRepository;
    public $postModel;
    public $options;

    public $archive_month;
    public $archive_year;

    public function __construct()
    {
        $this->events = array(
            array('event'=>'Ghastly.route', 'func'=>'onGhastlyRoute'),
            array('event'=>'Ghastly.pre_render', 'func'=>'onGhastlyPreRender')
        );

        $this->options = \Ghastly\Config::getInstance()->options; 
        $this->postRepository = new \Ghastly\DirectoryPostRepository();
        $this->postModel = new \Ghastly\PostModel($this->postRepository);

    }

    public function onGhastlyRoute(\Ghastly\GhastlyRouteEvent $event){
        $event->router->respond('/archive', function($request){
            $this->archive_page = true;
            $this->archive_month = date('m');
            $this->archive_year = date('Y');
        });
        $event->router->respond('/archive/[:month]/[:year]', function($request){
            $this->archive_page = true; 
            $this->archive_month = $request->month;
            $this->archive_year = $request->year;
        });
    }

    public function onGhastlyPreRender(\Ghastly\GhastlyPreRenderEvent $event){
        $event->template_vars['archives_url'] = "archive";

        if( ! $this->archive_page){ return; }

        $posts = $this->getPosts();

        $event->template_vars['archive_links'] = $this->generateLinks($posts);
        $event->template_vars['posts'] = $this->getPostsForMonthYear($posts, $this->archive_month, $this->archive_year);
        $event->template_vars['archive_page_title'] = "My Archive Page Title";
        $event->template_dirs[] = "plugins/archive";
        $event->template = "archive.html";
    }

    public function getPosts() {
        $posts = $this->postModel->findAll(0);
        return $posts;
    }

    public function getPostsForMonthYear($posts, $month, $year)
    {
        $posts = array_filter($posts, function($post) use ($month, $year){
            $post_month = $post['date']->format('m');
            $post_year  = $post['date']->format('Y');

            return $post_month == $month && $post_year == $year;
        });

        foreach($posts as $key => $post) {
            $posts[$key] = $this->postModel->getPostById($post);
        }

        return $posts;
    }

    public function generateLinks($posts)
    {
        $newest_date = $posts[0]['date'];
        $month_year = $newest_date->format('Y-m');
        $counts = [];

        foreach($posts as $post)
        {
            $post_month_year = $post['date']->format('Y-m');

            if($post_month_year == $month_year) {
                $counts[$month_year] = (isset($counts[$month_year])) ? ++$counts[$month_year] : 1;
            } else {
                $counts[$post_month_year] = (isset($counts[$post_month_year])) ? ++$counts[$post_month_year] : 1;
            } 

            $month_year = $post_month_year;
        }
        
        $links = [];
        foreach($counts as $key => $count)
        {
            $date = new DateTime($key.'-01');
            $links[] = [
                'month_name'=>$date->format('F Y'), 
                'month'=>$date->format('m'), 
                'year'=>$date->format('Y'), 
                'num_posts'=>$count
            ];
        } 

        return $links;
    }
}
