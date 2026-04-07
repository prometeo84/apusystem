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

/* test/logs.html.twig */
class __TwigTemplate_107916b85e46235271197d9ae692cb05 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "test/logs.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "test/logs.html.twig"));

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

        yield "Test de Logs - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.logs_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "flashes", ["success"], "method", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 14
            yield "                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> ";
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
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-bug\"></i> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.test_system"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"alert alert-info\">
                                <h6><i class=\"bi bi-clock\"></i> ";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.timezone_info"), "html", null, true);
        yield "</h6>
                                <ul class=\"mb-0\">
                                    <li><strong>";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.current_timezone"), "html", null, true);
        yield ":</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["timezone"]) || array_key_exists("timezone", $context) ? $context["timezone"] : (function () { throw new RuntimeError('Variable "timezone" does not exist.', 30, $this->source); })()), "html", null, true);
        yield "</li>
                                    <li><strong>";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.current_time"), "html", null, true);
        yield ":</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["time"]) || array_key_exists("time", $context) ? $context["time"] : (function () { throw new RuntimeError('Variable "time" does not exist.', 31, $this->source); })()), "html", null, true);
        yield "</li>
                                    <li><strong>";
        // line 32
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.system_datetime"), "html", null, true);
        yield ":</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y-m-d H:i:s T"), "html", null, true);
        yield "</li>
                                </ul>
                            </div>

                            <h6 class=\"mt-4\">";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.logs_generated"), "html", null, true);
        yield "</h6>
                            <ul>
                                <li><span class=\"badge bg-secondary\">DEBUG</span> ";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.debug_message"), "html", null, true);
        yield "</li>
                                <li><span class=\"badge bg-info\">INFO</span> ";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.info_message"), "html", null, true);
        yield "</li>
                                <li><span class=\"badge bg-warning\">WARNING</span> ";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.warning_message"), "html", null, true);
        yield "</li>
                                <li><span class=\"badge bg-danger\">ERROR</span> ";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.error_message"), "html", null, true);
        yield "</li>
                                <li><span class=\"badge bg-dark\">CRITICAL</span> ";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.critical_message"), "html", null, true);
        yield "</li>
                            </ul>

                            <div class=\"alert alert-success mt-4\">
                                <h6><i class=\"bi bi-check-circle\"></i> ";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.log_files"), "html", null, true);
        yield "</h6>
                                <p class=\"mb-2\">";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.logs_saved"), "html", null, true);
        yield ":</p>
                                <ul class=\"mb-0\">
                                    <li><code>/var/www/html/proyecto/var/log/dev.log</code> - ";
        // line 49
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.main_log"), "html", null, true);
        yield "</li>
                                    <li><code>/var/www/html/proyecto/var/log/error.log</code> - ";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.errors_only"), "html", null, true);
        yield "</li>
                                    <li><code>/var/www/html/proyecto/var/log/security.log</code> - ";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.security_events"), "html", null, true);
        yield "</li>
                                    <li><code>/var/log/php_errors.log</code> - ";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.php_errors"), "html", null, true);
        yield "</li>
                                </ul>
                            </div>

                            <div class=\"mt-4\">
                                <h6>";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.other_tests"), "html", null, true);
        yield ":</h6>
                                <div class=\"btn-group\" role=\"group\">
                                    <a href=\"";
        // line 59
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_test_error");
        yield "\" class=\"btn btn-danger\"
                                       onclick=\"return confirm('";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.generate_error"), "html", null, true);
        yield "')\">
                                        <i class=\"bi bi-exclamation-triangle\"></i> ";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.generate_error"), "html", null, true);
        yield "
                                    </a>
                                    <a href=\"";
        // line 63
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_forgot");
        yield "\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-envelope\"></i> ";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.test_email"), "html", null, true);
        yield "
                                    </a>
                                    <a href=\"";
        // line 66
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_errors");
        yield "\" class=\"btn btn-secondary\">
                                        <i class=\"bi bi-file-text\"></i> ";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.view_system_logs"), "html", null, true);
        yield "
                                    </a>
                                </div>
                            </div>

                            <div class=\"mt-4\">
                                <a href=\"";
        // line 73
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system");
        yield "\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-arrow-left\"></i> ";
        // line 74
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.back_dashboard"), "html", null, true);
        yield "
                                </a>
                            </div>
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
        return "test/logs.html.twig";
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
        return array (  273 => 74,  269 => 73,  260 => 67,  256 => 66,  251 => 64,  247 => 63,  242 => 61,  238 => 60,  234 => 59,  229 => 57,  221 => 52,  217 => 51,  213 => 50,  209 => 49,  204 => 47,  200 => 46,  193 => 42,  189 => 41,  185 => 40,  181 => 39,  177 => 38,  172 => 36,  163 => 32,  157 => 31,  151 => 30,  146 => 28,  139 => 24,  132 => 19,  122 => 15,  119 => 14,  115 => 13,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Test de Logs - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'test.logs_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-bug\"></i> {{ 'test.test_system'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"alert alert-info\">
                                <h6><i class=\"bi bi-clock\"></i> {{ 'test.timezone_info'|trans }}</h6>
                                <ul class=\"mb-0\">
                                    <li><strong>{{ 'test.current_timezone'|trans }}:</strong> {{ timezone }}</li>
                                    <li><strong>{{ 'test.current_time'|trans }}:</strong> {{ time }}</li>
                                    <li><strong>{{ 'test.system_datetime'|trans }}:</strong> {{ 'now'|date('Y-m-d H:i:s T') }}</li>
                                </ul>
                            </div>

                            <h6 class=\"mt-4\">{{ 'test.logs_generated'|trans }}</h6>
                            <ul>
                                <li><span class=\"badge bg-secondary\">DEBUG</span> {{ 'test.debug_message'|trans }}</li>
                                <li><span class=\"badge bg-info\">INFO</span> {{ 'test.info_message'|trans }}</li>
                                <li><span class=\"badge bg-warning\">WARNING</span> {{ 'test.warning_message'|trans }}</li>
                                <li><span class=\"badge bg-danger\">ERROR</span> {{ 'test.error_message'|trans }}</li>
                                <li><span class=\"badge bg-dark\">CRITICAL</span> {{ 'test.critical_message'|trans }}</li>
                            </ul>

                            <div class=\"alert alert-success mt-4\">
                                <h6><i class=\"bi bi-check-circle\"></i> {{ 'test.log_files'|trans }}</h6>
                                <p class=\"mb-2\">{{ 'test.logs_saved'|trans }}:</p>
                                <ul class=\"mb-0\">
                                    <li><code>/var/www/html/proyecto/var/log/dev.log</code> - {{ 'test.main_log'|trans }}</li>
                                    <li><code>/var/www/html/proyecto/var/log/error.log</code> - {{ 'test.errors_only'|trans }}</li>
                                    <li><code>/var/www/html/proyecto/var/log/security.log</code> - {{ 'test.security_events'|trans }}</li>
                                    <li><code>/var/log/php_errors.log</code> - {{ 'test.php_errors'|trans }}</li>
                                </ul>
                            </div>

                            <div class=\"mt-4\">
                                <h6>{{ 'test.other_tests'|trans }}:</h6>
                                <div class=\"btn-group\" role=\"group\">
                                    <a href=\"{{ path('app_test_error') }}\" class=\"btn btn-danger\"
                                       onclick=\"return confirm('{{ 'test.generate_error'|trans }}')\">
                                        <i class=\"bi bi-exclamation-triangle\"></i> {{ 'test.generate_error'|trans }}
                                    </a>
                                    <a href=\"{{ path('app_password_forgot') }}\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-envelope\"></i> {{ 'test.test_email'|trans }}
                                    </a>
                                    <a href=\"{{ path('app_system_errors') }}\" class=\"btn btn-secondary\">
                                        <i class=\"bi bi-file-text\"></i> {{ 'test.view_system_logs'|trans }}
                                    </a>
                                </div>
                            </div>

                            <div class=\"mt-4\">
                                <a href=\"{{ path('app_system') }}\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-arrow-left\"></i> {{ 'test.back_dashboard'|trans }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "test/logs.html.twig", "/var/www/html/proyecto/templates/test/logs.html.twig");
    }
}
