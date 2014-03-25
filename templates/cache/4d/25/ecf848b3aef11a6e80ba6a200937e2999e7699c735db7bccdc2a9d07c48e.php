<?php

/* layout.html */
class __TwigTemplate_4d25ecf848b3aef11a6e80ba6a200937e2999e7699c735db7bccdc2a9d07c48e extends Twig_Template
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
        echo "<!doctype html>
<head>
    <title>";
        // line 3
        echo (isset($context["blog_title"]) ? $context["blog_title"] : null);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <link rel=\"stylesheet\" href=\"assets/css/main.css\" type=\"media/screen\">
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
";
        // line 11
        $this->env->loadTemplate("header.html")->display($context);
        // line 12
        echo "
<section class=\"posts\">
    ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["posts"]) ? $context["posts"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 15
            echo "        <article class=\"post\">
            <header> 
                <h4>
                    ";
            // line 18
            echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "date");
            echo "

                    ";
            // line 20
            if ($this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "tags")) {
                // line 21
                echo "                    <span> on ";
                echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "tags");
                echo "</span>
                    ";
            }
            // line 23
            echo "                </h4>

                <h3><a href=\"";
            // line 25
            echo (isset($context["blog_url"]) ? $context["blog_url"] : null);
            echo "/";
            echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "slug");
            echo "\">";
            echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "title");
            echo "</a></h3>
            </header> 

            ";
            // line 28
            if ($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "summary")) {
                // line 29
                echo "                ";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "summary");
                echo " ...
            ";
            } else {
                // line 31
                echo "                ";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "content");
                echo "
            ";
            }
            // line 33
            echo "
        </article>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "</section>

";
        // line 38
        $this->env->loadTemplate("footer.html")->display($context);
        // line 39
        echo "</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 39,  102 => 38,  98 => 36,  90 => 33,  84 => 31,  78 => 29,  76 => 28,  66 => 25,  62 => 23,  56 => 21,  54 => 20,  49 => 18,  44 => 15,  40 => 14,  36 => 12,  34 => 11,  23 => 3,  19 => 1,);
    }
}
