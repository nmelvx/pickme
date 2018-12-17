<?php

/* form/templates/settings/validate.hbs */
class __TwigTemplate_87025c16e6a767bd7f39343f72655ab5ece50cb56fa889b9a3d254b05c996a85 extends Twig_Template
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
        echo "<p class=\"clearfix\">
  <label>";
        // line 2
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Validate for:");
        echo "</label>
  <select name=\"params[validate]\">
    <option {{#ifCond params.validate '==' ''}}selected=\"selected\"{{/ifCond}}
      value=\"\">
      ";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Nothing");
        echo "
    </option>

    <option {{#ifCond params.validate '==' 'number'}}selected=\"selected\"{{/ifCond}}
      value=\"number\">
      ";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Numbers only");
        echo "
    </option>

    <option {{#ifCond params.validate '==' 'alphanum'}}selected=\"selected\"{{/ifCond}}
      value=\"alphanum\">
      ";
        // line 16
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Alphanumerical");
        echo "
    </option>

    <option {{#ifCond params.validate '==' 'phone'}}selected=\"selected\"{{/ifCond}}
      value=\"phone\">
      ";
        // line 21
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Phone number, (+,-,#,(,) and spaces allowed)");
        echo "
    </option>
  </select>
</p>";
    }

    public function getTemplateName()
    {
        return "form/templates/settings/validate.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 21,  45 => 16,  37 => 11,  29 => 6,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form/templates/settings/validate.hbs", "C:\\xampp\\htdocs\\pickme\\wp-content\\plugins\\mailpoet\\views\\form\\templates\\settings\\validate.hbs");
    }
}