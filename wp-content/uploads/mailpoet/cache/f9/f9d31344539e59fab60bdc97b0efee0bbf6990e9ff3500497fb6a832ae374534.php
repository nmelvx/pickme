<?php

/* form/templates/preview.hbs */
class __TwigTemplate_179bedebfa1e551ba6144d3e2ddb75f024adb1e562b54ec15628d69a4955bd16 extends Twig_Template
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
        echo "<style type=\"text/css\" id=\"mailpoet_form_preview_styles\">
\t.mailpoet_hp_email_label { display: none; }
\t{{{ css }}}
</style>
<div class=\"mailpoet_form\">
  <div class=\"mailpoet_message\">
    <p class=\"mailpoet_validate_success\">";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("This is what the success message looks like.");
        echo "</p>
    <p class=\"mailpoet_validate_error\">";
        // line 8
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("This is what the error message looks like.");
        echo "</p>
  </div>
  {{{ html }}}
</div>
";
    }

    public function getTemplateName()
    {
        return "form/templates/preview.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 8,  27 => 7,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form/templates/preview.hbs", "C:\\xampp\\htdocs\\pickme\\wp-content\\plugins\\mailpoet\\views\\form\\templates\\preview.hbs");
    }
}
