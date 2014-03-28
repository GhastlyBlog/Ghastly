<?php

/* header.html */
class __TwigTemplate_65bcf66bcbd32f4b86a25c5a46000676b4fd9a99e66ccc0a50d3bfb0adff6a59 extends Twig_Template
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
        echo "<header id=\"header\">
    <h1>";
        // line 2
        echo (isset($context["blog_title"]) ? $context["blog_title"] : null);
        echo "</h1>
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
        return "header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 4,  26 => 3,  22 => 2,  104 => 39,  102 => 38,  98 => 36,  90 => 33,  84 => 31,  78 => 29,  76 => 28,  66 => 25,  62 => 23,  56 => 21,  54 => 20,  49 => 18,  44 => 15,  40 => 14,  36 => 12,  34 => 6,  23 => 3,  19 => 1,);
    }
}
