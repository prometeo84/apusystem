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

/* system/errors.html.twig */
class __TwigTemplate_7d033a8c3631ba99c3e7a3ba12861a0c extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/errors.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/errors.html.twig"));

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

        yield "Errores del Sistema - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bug-fill text-danger\"></i> ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.error_log"), "html", null, true);
        yield "</h5>
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" class=\"btn btn-sm btn-outline-secondary active\" data-filter=\"all\">
                            ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.filter_all"), "html", null, true);
        yield "
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"CRITICAL\">
                            ";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.filter_critical"), "html", null, true);
        yield "
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"ERROR\">
                            ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.filter_errors"), "html", null, true);
        yield "
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-warning\" data-filter=\"WARNING\">
                            ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.filter_warnings"), "html", null, true);
        yield "
                        </button>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    ";
        // line 32
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 32, $this->source); })())) > 0)) {
            // line 33
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover mb-0\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th style=\"width: 180px;\">";
            // line 37
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.datetime"), "html", null, true);
            yield "</th>
                                        <th style=\"width: 100px;\">";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.level"), "html", null, true);
            yield "</th>
                                        <th>";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.error_message"), "html", null, true);
            yield "</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 43
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 43, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 44
                yield "                                        <tr data-level=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 44), "html", null, true);
                yield "\">
                                            <td><small>";
                // line 45
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "date", [], "any", false, false, false, 45), "html", null, true);
                yield "</small></td>
                                            <td>
                                                <span class=\"badge bg-";
                // line 47
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 47) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 47) == "ERROR")) ? ("danger") : ("warning"))));
                yield "\">
                                                    ";
                // line 48
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 48), "html", null, true);
                yield "
                                                </span>
                                            </td>
                                            <td>
                                                <code class=\"text-break\" style=\"font-size: 0.85rem;\">";
                // line 52
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "message", [], "any", false, false, false, 52), "html", null, true);
                yield "</code>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['error'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 56
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 60
            yield "                        <div class=\"text-center py-5\">
                            <i class=\"bi bi-check-circle-fill text-success\" style=\"font-size: 3rem;\"></i>
                            <p class=\"text-muted mt-3\">";
            // line 62
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_errors.no_errors_found"), "html", null, true);
            yield "</p>
                        </div>
                    ";
        }
        // line 65
        yield "                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const rows = document.querySelectorAll('tbody tr[data-level]');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;

            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            rows.forEach(row => {
                if (filter === 'all' || row.dataset.level === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
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
        return "system/errors.html.twig";
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
        return array (  223 => 65,  217 => 62,  213 => 60,  207 => 56,  197 => 52,  190 => 48,  186 => 47,  181 => 45,  176 => 44,  172 => 43,  165 => 39,  161 => 38,  157 => 37,  151 => 33,  149 => 32,  141 => 27,  135 => 24,  129 => 21,  123 => 18,  117 => 15,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Errores del Sistema - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system_errors.title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bug-fill text-danger\"></i> {{ 'system.error_log'|trans }}</h5>
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" class=\"btn btn-sm btn-outline-secondary active\" data-filter=\"all\">
                            {{ 'system_errors.filter_all'|trans }}
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"CRITICAL\">
                            {{ 'system_errors.filter_critical'|trans }}
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"ERROR\">
                            {{ 'system_errors.filter_errors'|trans }}
                        </button>
                        <button type=\"button\" class=\"btn btn-sm btn-outline-warning\" data-filter=\"WARNING\">
                            {{ 'system_errors.filter_warnings'|trans }}
                        </button>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    {% if errors|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-hover mb-0\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th style=\"width: 180px;\">{{ 'system.datetime'|trans }}</th>
                                        <th style=\"width: 100px;\">{{ 'system.level'|trans }}</th>
                                        <th>{{ 'system.error_message'|trans }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for error in errors %}
                                        <tr data-level=\"{{ error.level }}\">
                                            <td><small>{{ error.date }}</small></td>
                                            <td>
                                                <span class=\"badge bg-{{ error.level == 'CRITICAL' ? 'danger' : (error.level == 'ERROR' ? 'danger' : 'warning') }}\">
                                                    {{ error.level }}
                                                </span>
                                            </td>
                                            <td>
                                                <code class=\"text-break\" style=\"font-size: 0.85rem;\">{{ error.message }}</code>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <div class=\"text-center py-5\">
                            <i class=\"bi bi-check-circle-fill text-success\" style=\"font-size: 3rem;\"></i>
                            <p class=\"text-muted mt-3\">{{ 'system_errors.no_errors_found'|trans }}</p>
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const rows = document.querySelectorAll('tbody tr[data-level]');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;

            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            rows.forEach(row => {
                if (filter === 'all' || row.dataset.level === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
{% endblock %}
", "system/errors.html.twig", "/var/www/html/proyecto/templates/system/errors.html.twig");
    }
}
