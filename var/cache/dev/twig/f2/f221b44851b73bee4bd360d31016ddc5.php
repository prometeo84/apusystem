<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* profile/change_password.html.twig */
class __TwigTemplate_6645fe6ddb6fb056fb14a6c45659588b extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/change_password.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/change_password.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield " - APU System";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "<div class=\"d-flex\">
    ";
        // line 7
        yield from $this->load("partials/_sidebar.html.twig", 7)->unwrap()->yield($context);
        // line 8
        yield "
    <div class=\"flex-grow-1\">
        ";
        // line 10
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "flashes", ["error"], "method", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 14
            yield "                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 15
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        yield "
            <div class=\"row justify-content-center\">
                <div class=\"col-md-6\">
                    <div class=\"card\">
                        <div class=\"card-body p-4\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-key-fill\"></i> ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield "
                            </h4>

                            <div class=\"alert alert-info\">
                                <i class=\"bi bi-info-circle\"></i>
                                <strong>";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.security_requirements"), "html", null, true);
        yield ":</strong>
                                <ul class=\"mb-0 mt-2\">
                                    <li>";
        // line 32
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.min_8_chars"), "html", null, true);
        yield "</li>
                                    <li>";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.recommended_chars"), "html", null, true);
        yield "</li>
                                </ul>
                            </div>

                            <form method=\"post\">
                                <div class=\"mb-3\">
                                    <label for=\"current_password\" class=\"form-label\">";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.current"), "html", null, true);
        yield " *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"current_password\"
                                           name=\"current_password\" required>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"new_password\" class=\"form-label\">";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.new"), "html", null, true);
        yield " *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"new_password\"
                                           name=\"new_password\" required minlength=\"8\">
                                </div>

                                <div class=\"mb-4\">
                                    <label for=\"confirm_password\" class=\"form-label\">";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.confirm_new"), "html", null, true);
        yield " *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"confirm_password\"
                                           name=\"confirm_password\" required minlength=\"8\">
                                </div>

                                <div class=\"d-flex justify-content-between\">
                                    <a href=\"";
        // line 57
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> ";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.cancel"), "html", null, true);
        yield "
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-shield-lock\"></i> ";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield "
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "profile/change_password.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  204 => 61,  198 => 58,  194 => 57,  185 => 51,  176 => 45,  167 => 39,  158 => 33,  154 => 32,  149 => 30,  141 => 25,  133 => 19,  123 => 15,  120 => 14,  116 => 13,  112 => 11,  110 => 10,  106 => 8,  104 => 7,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}{{ 'password.change'|trans }} - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'password.change'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('error') %}
                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"row justify-content-center\">
                <div class=\"col-md-6\">
                    <div class=\"card\">
                        <div class=\"card-body p-4\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-key-fill\"></i> {{ 'password.change'|trans }}
                            </h4>

                            <div class=\"alert alert-info\">
                                <i class=\"bi bi-info-circle\"></i>
                                <strong>{{ 'password.security_requirements'|trans }}:</strong>
                                <ul class=\"mb-0 mt-2\">
                                    <li>{{ 'password.min_8_chars'|trans }}</li>
                                    <li>{{ 'password.recommended_chars'|trans }}</li>
                                </ul>
                            </div>

                            <form method=\"post\">
                                <div class=\"mb-3\">
                                    <label for=\"current_password\" class=\"form-label\">{{ 'password.current'|trans }} *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"current_password\"
                                           name=\"current_password\" required>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"new_password\" class=\"form-label\">{{ 'password.new'|trans }} *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"new_password\"
                                           name=\"new_password\" required minlength=\"8\">
                                </div>

                                <div class=\"mb-4\">
                                    <label for=\"confirm_password\" class=\"form-label\">{{ 'password.confirm_new'|trans }} *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"confirm_password\"
                                           name=\"confirm_password\" required minlength=\"8\">
                                </div>

                                <div class=\"d-flex justify-content-between\">
                                    <a href=\"{{ path('app_profile') }}\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> {{ 'buttons.cancel'|trans }}
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-shield-lock\"></i> {{ 'password.change'|trans }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "profile/change_password.html.twig", "/var/www/html/proyecto/templates/profile/change_password.html.twig");
    }
}
