<?php

class Archive extends Plugin {
    public $events;
    public $Ghastly;

    public function __construct()
    {
        $this->events = [
            ['event'=>'Ghastly.route', 'func'=>'onGhastlyRoute'],
            ['event'=>'Ghastly.pre_render', 'func'=>'onGhastlyPreRender']
        ];
    }

    /** Respond to new routes **/
    public function onGhastlyRoute(\Ghastly\GhastlyRouteEvent $event){
        $event->router->with('/archive', function() use ($event) {
            $this->Ghastly= $event->Ghastly;

            $posts = $this->Ghastly->postModel->findAllHeaders(0);
            $this->Ghastly->template_dirs[] = "plugins/archive";
            $this->Ghastly->template = "archive.html";

            $event->router->respond('/?', function() use ($posts, $event){
                $this->Ghastly->template_vars['archive_links'] = $this->generateLinks($posts, date('m'), date('Y'));
                $this->Ghastly->template_vars['posts'] = $this->getPostsForMonthYear($posts, date('m'), date('Y'));                
            });

            $event->router->respond('/[:month]/[:year]', function($req) use ($posts, $event){
                $this->Ghastly->template_vars['archive_links'] = $this->generateLinks($posts, $req->month, $req->year);
                $this->Ghastly->template_vars['posts'] = $this->getPostsForMonthYear($posts, $req->month, $req->year);
            });
        });
    }

    /** Add variables to all templates on all routes **/
    public function onGhastlyPreRender(\Ghastly\GhastlyPreRenderEvent $event){
        $event->Ghastly->template_vars['archives_url'] = "archive";
    }

    public function getPostsForMonthYear($posts, $month, $year)
    {
        $posts = array_filter($posts, function($post) use ($month, $year){;
            $post_month = $post['date']->format('m');
            $post_year  = $post['date']->format('Y');

            return $post_month == $month && $post_year == $year;
        });

        foreach($posts as $key => $post) {
            $posts[$key] = $this->Ghastly->postModel->getPostById($post['filename']);
        }

        return $posts;
    }

    public function generateLinks($posts, $active_month=false, $active_year=false)
    {
        $month_year = $posts[0]['date']->format('Y-m');
        $counts = $links = [];

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
        
        foreach($counts as $key => $count)
        {
            $date = new DateTime($key.'-01');
            $links[] = [
                'month_name'=>$date->format('F Y'), 
                'month'=>$date->format('m'), 
                'year'=>$date->format('Y'), 
                'num_posts'=>$count,
                'active' => ($date->format('m-Y')==$active_month.'-'.$active_year) ? true : false
            ];
        } 

        return $links;
    }
}