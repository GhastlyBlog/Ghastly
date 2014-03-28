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

## Themes

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

### Installing new Plugins and Themes

Ghastly plugins and themes are available via Composer. Add them to your `composer.json` and run `composer update`.

### Publishing Plugins and Themes

Your repository must contain a `composer.json` file that references a type of `ghastly-plugin` or `ghastly-theme` and must require `ghastly/plugin-installer` or `ghastly/theme-installer` as dependencies. Your repository must also be available on [Packagist](http://packagist.org)

    {
        "name" : "ghastly/archive",
        "description" : "An archive plugin for Ghastly",
        "type" : "ghastly-plugin",
        "license" : "UNLICENSE",
        "require" : {
            "ghastly/plugin-installer" : "@dev"
        }
    }


### Plugins

The plugin API is changing a lot while I play around with it. You can copy the provided 'archive' plugin to create your own, but be aware it will probably be broken in future versions of Ghastly.

##### Archive

Archive is a Ghastly plugin that adds an Archives page to your blog. Archive exposes:

Variable              | Explanation
----------------------|:------------
 `archive_links`      | An array of archive links
     `link.month`     | An archive month
     `link.year`      | An archive year
     `link.active`    | True/false if this month/year is active
     `link.month_name`| The spelled out name of the month
     `link.num_posts` | Number of posts in the month


