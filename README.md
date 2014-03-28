# Ghastly
-----

Ghastly is a markdown blog with a Ghost-like theme. You can extend Ghastly with custom plugins and themes.

![ProjectImage](http://ghastlyblog.github.io/Ghastly/ghastly.png)

## Installation

Clone the repository, run `composer install` and edit `config.php`. That's it. If you're installing in a sub directory, add `RewriteBase /path/to/dir` to `.htaccess`.

## Posting

Create posts in `posts/` in the format of `2014-12-28-my-blog-post-title.md`.

A post should have a jekyll-like front matter. An example post would look like:

    -----
    title: My blog post title!
    tags: something, stuff
    -----

    Lorem ipsum dolor sit amet...

The `tags:` line is optional.

## Installing new Plugins and Themes

Ghastly plugins and themes are available via Composer. Add them to your `composer.json` and run `composer update`.

## Developing Themes

Ghastly uses the `spooky` theme by default. You can copy it to a folder and rename it to something else to make your own theme. You can modify the html files however you like. Ghastly uses the [Twig](https://github.com/fabpot/twig) template engine.

Your template must have a `layout.html` file and a `single_post_layout.html` file.

### Template Variables

Ghastly exposes the following variables for you to use in your templates:

Variable              | Explanation
----------------------|:------------
 `posts`              | This is an array of posts
 `post`               | A single post
 `post.metadata.date` | The date of a post
 `post.metadata.tags` | The tags of a post
 `post.metadata.title`| The title of a post
 `post.metadata.summary` | The summary of a post if supplied through front matter
 `post.content`       | The html content of a post
 
All of the options in `config.php` are available as template variables.

### Publishing your theme for others

Your theme must be in a repository and it must contain a `composer.json` file that references a type of `ghastly-theme` and must require  `ghastly/theme-installer` as a dependency. Your repository must also be available on [Packagist](http://packagist.org)

```javascript
{
    "name" : "ghastly/spooky",
    "description" : "An excellent theme for Ghastly",
    "type" : "ghastly-theme",
    "license" : "UNLICENSE",
    "require" : {
        "ghastly/theme-installer" : "@dev"
    }
}
````
### Developing Plugins

Before you embark on creating Ghastly plugins, be aware that the plugin API is likely going to be changing a lot as I play around with it.

Create a class that extends `Plugin` and put it in a folder with a name the same as the class you just created. . Your class should populate a public class property `$this->events` with any events the plugin will subscribe to.

```php
class Archive extends Plugin {
    public $events;
    public function __construct()
    {
        $this->events = [
            ['event'=>'Ghastly.route', 'func'=>'onGhastlyRoute'],
            ['event'=>'Ghastly.pre_render', 'func'=>'onGhastlyPreRender']
        ];
    }
}
```

Add the plugin to the `plugins` config option in `config.php` to enable it.

Event                 |Event Properties
----------------------|:---------------
 `Ghastly.route`      | Make your plugin respond to routes
 `Ghastly.pre_render` | Inject template variables prior to rendering

Note that all events are passed an instance of $Ghastly.

##### Ghastly.route

Your Ghastly plugin can respond to routes by subscribing to this event. Example:

    class Hello extends Plugin {
        public $events;
        public function __construct()
        {
            $this->events = [
                ['event'=>'Ghastly.route', 'func'=>'onGhastlyRoute'],
            ];
        }
        
        public function onGhastlyRoute(\Ghastly\GhastlyRouteEvent $event){
            $event->router->respond('/some_route', function() use ($event){
                $this->Ghastly->template_vars['greeting'] = 'Hello World!'; 
                $this->Ghastly->template = 'hello_world.html';
            });
        }
    }

The `hello_world.html` template now has `{{ greeting }}` available to it when Ghastly is responding to `some_route`. You can modify existing template variables in the same manner. 

##### Ghastly.pre_render

This event lets you modify the Ghastly instance on any route after it and all plugins have responded to the route.


##### Publishing your plugin for others

Your plugin must be in a repository and it must contain a `composer.json` file that references a type of `ghastly-plugin` and must require `ghastly/plugin-installer` as a dependency. Your repository must also be available on [Packagist](http://packagist.org)

    {
        "name" : "ghastly/archive",
        "description" : "An archive plugin for Ghastly",
        "type" : "ghastly-plugin",
        "license" : "UNLICENSE",
        "require" : {
            "ghastly/plugin-installer" : "@dev"
        }
    }
