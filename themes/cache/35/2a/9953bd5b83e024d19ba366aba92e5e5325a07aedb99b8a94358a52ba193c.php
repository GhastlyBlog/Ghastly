<?php

/* single_post_header.html */
class __TwigTemplate_352a9953bd5b83e024d19ba366aba92e5e5325a07aedb99b8a94358a52ba193c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<header id=\"single-post-header\">
    <h1><a href=\"";
        // line 2
        echo (isset($context["blog_url"]) ? $context["blog_url"] : null);
        echo "\">";
        echo (isset($context["blog_title"]) ? $context["blog_title"] : null);
        echo "</a></h1>
    ";
        // line 3
        if ((isset($context["blog_description"]) ? $context["blog_description"] : null)) {
            // line 4
            echo "        <h2>";
            echo (isset($context["blog_description"]) ? $context["blog_description"] : null);
            echo "</h2>
    ";
        }
        // line 6
        echo "</header>
";
    }

    public function getTemplateName()
    {
        return "single_post_header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 6,  30 => 4,  28 => 3,  22 => 2,  82 => 34,  80 => 33,  76 => 31,  69 => 27,  65 => 26,  61 => 24,  55 => 22,  53 => 21,  48 => 19,  43 => 16,  41 => 15,  37 => 13,  35 => 12,  24 => 4,  19 => 1,);
    }
}
