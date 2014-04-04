---
title: Introducing Ghastly
tags: blogging, software
summary: Ghastly is a markdown blog with a Ghost-like theme that doesn't require you to run any generator commands. Just put your formatted markdown files in the posts directory wherever you're hosting your website and 
---


Ghastly is a markdown blog with a Ghost-like theme that doesn't require you to run any generator commands. Just put your formatted markdown files in the posts directory wherever you're hosting your website and thats it.

Ghastly features a simple, responsive theme as well as archives and syntax functionality out of the box. You can extend Ghastly by writing your own plugins and themes.

## Installation

- `git clone https://github.com/chrisgillis/Ghastly.git`
- `composer install`
- Edit `config.php` and upload files to your PHP 5.4+ host

<pre><code class="language-php">/**
 * Summon Ghastly
 */
$Ghastly = new \Ghastly\Ghastly();

/**
 * Ghastly, Run!
 */
$Ghastly->run();
</code></pre>

You can [download Ghastly](https://github.com/chrisgillis/Ghastly) on Github.

