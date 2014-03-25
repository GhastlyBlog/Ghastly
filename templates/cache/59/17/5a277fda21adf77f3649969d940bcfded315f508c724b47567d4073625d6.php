<?php

/* single_post_layout.html */
class __TwigTemplate_59175a277fda21adf77f3649969d940bcfded315f508c724b47567d4073625d6 extends Twig_Template
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
        echo "
<!doctype html>
<head>
    <title>";
        // line 4
        echo (isset($context["blog_title"]) ? $context["blog_title"] : null);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <link rel=\"stylesheet\" href=\"assets/css/main.css\" type=\"media/screen\">
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
";
        // line 12
        $this->env->loadTemplate("single_post_header.html")->display($context);
        // line 13
        echo "
<section class=\"posts\">
    ";
        // line 15
        if ((isset($context["post"]) ? $context["post"] : null)) {
            // line 16
            echo "        <article class=\"post\">
            <header> 
                <h4>
                    ";
            // line 19
            echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "date");
            echo "

                    ";
            // line 21
            if ($this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "tags")) {
                // line 22
                echo "                    <span> on ";
                echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "tags");
                echo "</span>
                    ";
            }
            // line 24
            echo "                </h4>

                <h3>";
            // line 26
            echo $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "metadata"), "title");
            echo "</h3>
                ";
            // line 27
            echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "content");
            echo "
            </header> 
        </article>
    ";
        }
        // line 31
        echo "</section>

";
        // line 33
        $this->env->loadTemplate("footer.html")->display($context);
        // line 34
        echo "</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "single_post_layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 34,  80 => 33,  76 => 31,  69 => 27,  65 => 26,  61 => 24,  55 => 22,  53 => 21,  48 => 19,  43 => 16,  41 => 15,  37 => 13,  35 => 12,  24 => 4,  19 => 1,);
    }
}
