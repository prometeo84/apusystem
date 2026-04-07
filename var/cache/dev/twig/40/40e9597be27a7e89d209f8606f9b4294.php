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

/* system/monitoring.html.twig */
class __TwigTemplate_6f621718df6bcfe1924deb98dab7d95b extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/monitoring.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/monitoring.html.twig"));

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

        yield "Monitoreo - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.monitoring_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-database-fill ";
        // line 18
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 18, $this->source); })()), "database", [], "any", false, false, false, 18), "status", [], "any", false, false, false, 18) == "ok")) ? ("text-success") : ("text-danger"));
        yield "\"></i>
                                ";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.database"), "html", null, true);
        yield "
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-";
        // line 22
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 22, $this->source); })()), "database", [], "any", false, false, false, 22), "status", [], "any", false, false, false, 22) == "ok")) ? ("success") : ("danger"));
        yield "\">
                                    ";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 23, $this->source); })()), "database", [], "any", false, false, false, 23), "status", [], "any", false, false, false, 23)), "html", null, true);
        yield "
                                </span>
                            </p>
                            <small class=\"text-muted\">";
        // line 26
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 26, $this->source); })()), "database", [], "any", false, false, false, 26), "message", [], "any", false, false, false, 26), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-hdd-fill ";
        // line 35
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 35, $this->source); })()), "cache", [], "any", false, false, false, 35), "status", [], "any", false, false, false, 35) == "ok")) ? ("text-success") : ("text-danger"));
        yield "\"></i>
                                ";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.cache"), "html", null, true);
        yield "
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-";
        // line 39
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 39, $this->source); })()), "cache", [], "any", false, false, false, 39), "status", [], "any", false, false, false, 39) == "ok")) ? ("success") : ("danger"));
        yield "\">
                                    ";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 40, $this->source); })()), "cache", [], "any", false, false, false, 40), "status", [], "any", false, false, false, 40)), "html", null, true);
        yield "
                                </span>
                            </p>
                            <small class=\"text-muted\">";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.size"), "html", null, true);
        yield ": ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 43, $this->source); })()), "cache", [], "any", false, false, false, 43), "size", [], "any", false, false, false, 43), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-people-fill ";
        // line 52
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 52, $this->source); })()), "sessions", [], "any", false, false, false, 52), "status", [], "any", false, false, false, 52) == "ok")) ? ("text-success") : ("text-danger"));
        yield "\"></i>
                                ";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.sessions"), "html", null, true);
        yield "
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-";
        // line 56
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 56, $this->source); })()), "sessions", [], "any", false, false, false, 56), "status", [], "any", false, false, false, 56) == "ok")) ? ("success") : ("danger"));
        yield "\">
                                    ";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 57, $this->source); })()), "sessions", [], "any", false, false, false, 57), "status", [], "any", false, false, false, 57)), "html", null, true);
        yield "
                                </span>
                            </p>
                            <small class=\"text-muted\">";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 60, $this->source); })()), "sessions", [], "any", false, false, false, 60), "active", [], "any", false, false, false, 60), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.active_label"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-hdd ";
        // line 69
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 69, $this->source); })()), "disk_usage", [], "any", false, false, false, 69), "status", [], "any", false, false, false, 69) == "ok")) ? ("text-success") : ("text-warning"));
        yield "\"></i>
                                ";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.disk"), "html", null, true);
        yield "
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-";
        // line 73
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 73, $this->source); })()), "disk_usage", [], "any", false, false, false, 73), "status", [], "any", false, false, false, 73) == "ok")) ? ("success") : ("warning"));
        yield "\">
                                    ";
        // line 74
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 74, $this->source); })()), "disk_usage", [], "any", false, false, false, 74), "status", [], "any", false, false, false, 74)), "html", null, true);
        yield "
                                </span>
                            </p>
                            <small class=\"text-muted\">
                                ";
        // line 78
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 78, $this->source); })()), "disk_usage", [], "any", false, false, false, 78), "used", [], "any", false, false, false, 78), "html", null, true);
        yield " / ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 78, $this->source); })()), "disk_usage", [], "any", false, false, false, 78), "total", [], "any", false, false, false, 78), "html", null, true);
        yield "
                                (";
        // line 79
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["monitoring"]) || array_key_exists("monitoring", $context) ? $context["monitoring"] : (function () { throw new RuntimeError('Variable "monitoring" does not exist.', 79, $this->source); })()), "disk_usage", [], "any", false, false, false, 79), "percent", [], "any", false, false, false, 79), "html", null, true);
        yield "%)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bug-fill\"></i> ";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.recent_errors"), "html", null, true);
        yield "</h5>
                </div>
                <div class=\"card-body\">
                    ";
        // line 91
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 91, $this->source); })())) > 0)) {
            // line 92
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-sm table-hover\">
                                <thead>
                                    <tr>
                                        <th style=\"width: 180px;\">";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.datetime"), "html", null, true);
            yield "</th>
                                        <th style=\"width: 100px;\">";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.level"), "html", null, true);
            yield "</th>
                                        <th>";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.message"), "html", null, true);
            yield "</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 102
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 102, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 103
                yield "                                        <tr>
                                            <td><small>";
                // line 104
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "date", [], "any", false, false, false, 104), "html", null, true);
                yield "</small></td>
                                            <td>
                                                <span class=\"badge bg-";
                // line 106
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 106) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 106) == "ERROR")) ? ("danger") : ("warning"))));
                yield "\">
                                                    ";
                // line 107
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["error"], "level", [], "any", false, false, false, 107), "html", null, true);
                yield "
                                                </span>
                                            </td>
                                            <td><small>";
                // line 110
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["error"], "message", [], "any", false, false, false, 110), 0, 150), "html", null, true);
                yield "...</small></td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['error'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 113
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 117
            yield "                        <p class=\"text-muted text-center py-3\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_recent_errors"), "html", null, true);
            yield "</p>
                    ";
        }
        // line 119
        yield "                </div>
                <div class=\"card-footer bg-white\">
                    <a href=\"";
        // line 121
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_errors");
        yield "\" class=\"text-decoration-none\">
                        ";
        // line 122
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.view_all_errors"), "html", null, true);
        yield " <i class=\"bi bi-arrow-right\"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh cada 30 segundos
setTimeout(() => {
    location.reload();
}, 30000);
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
        return "system/monitoring.html.twig";
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
        return array (  339 => 122,  335 => 121,  331 => 119,  325 => 117,  319 => 113,  310 => 110,  304 => 107,  300 => 106,  295 => 104,  292 => 103,  288 => 102,  281 => 98,  277 => 97,  273 => 96,  267 => 92,  265 => 91,  259 => 88,  247 => 79,  241 => 78,  234 => 74,  230 => 73,  224 => 70,  220 => 69,  206 => 60,  200 => 57,  196 => 56,  190 => 53,  186 => 52,  172 => 43,  166 => 40,  162 => 39,  156 => 36,  152 => 35,  140 => 26,  134 => 23,  130 => 22,  124 => 19,  120 => 18,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Monitoreo - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system.monitoring_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-database-fill {{ monitoring.database.status == 'ok' ? 'text-success' : 'text-danger' }}\"></i>
                                {{ 'system.database'|trans }}
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-{{ monitoring.database.status == 'ok' ? 'success' : 'danger' }}\">
                                    {{ monitoring.database.status|upper }}
                                </span>
                            </p>
                            <small class=\"text-muted\">{{ monitoring.database.message }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-hdd-fill {{ monitoring.cache.status == 'ok' ? 'text-success' : 'text-danger' }}\"></i>
                                {{ 'system.cache'|trans }}
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-{{ monitoring.cache.status == 'ok' ? 'success' : 'danger' }}\">
                                    {{ monitoring.cache.status|upper }}
                                </span>
                            </p>
                            <small class=\"text-muted\">{{ 'system.size'|trans }}: {{ monitoring.cache.size }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-people-fill {{ monitoring.sessions.status == 'ok' ? 'text-success' : 'text-danger' }}\"></i>
                                {{ 'system.sessions'|trans }}
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-{{ monitoring.sessions.status == 'ok' ? 'success' : 'danger' }}\">
                                    {{ monitoring.sessions.status|upper }}
                                </span>
                            </p>
                            <small class=\"text-muted\">{{ monitoring.sessions.active }} {{ 'system.active_label'|trans }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">
                                <i class=\"bi bi-hdd {{ monitoring.disk_usage.status == 'ok' ? 'text-success' : 'text-warning' }}\"></i>
                                {{ 'system.disk'|trans }}
                            </h6>
                            <p class=\"mb-0\">
                                <span class=\"badge bg-{{ monitoring.disk_usage.status == 'ok' ? 'success' : 'warning' }}\">
                                    {{ monitoring.disk_usage.status|upper }}
                                </span>
                            </p>
                            <small class=\"text-muted\">
                                {{ monitoring.disk_usage.used }} / {{ monitoring.disk_usage.total }}
                                ({{ monitoring.disk_usage.percent }}%)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bug-fill\"></i> {{ 'system.recent_errors'|trans }}</h5>
                </div>
                <div class=\"card-body\">
                    {% if errors|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-sm table-hover\">
                                <thead>
                                    <tr>
                                        <th style=\"width: 180px;\">{{ 'system.datetime'|trans }}</th>
                                        <th style=\"width: 100px;\">{{ 'system.level'|trans }}</th>
                                        <th>{{ 'system.message'|trans }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for error in errors %}
                                        <tr>
                                            <td><small>{{ error.date }}</small></td>
                                            <td>
                                                <span class=\"badge bg-{{ error.level == 'CRITICAL' ? 'danger' : (error.level == 'ERROR' ? 'danger' : 'warning') }}\">
                                                    {{ error.level }}
                                                </span>
                                            </td>
                                            <td><small>{{ error.message|slice(0, 150) }}...</small></td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <p class=\"text-muted text-center py-3\">{{ 'system.no_recent_errors'|trans }}</p>
                    {% endif %}
                </div>
                <div class=\"card-footer bg-white\">
                    <a href=\"{{ path('app_system_errors') }}\" class=\"text-decoration-none\">
                        {{ 'system.view_all_errors'|trans }} <i class=\"bi bi-arrow-right\"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh cada 30 segundos
setTimeout(() => {
    location.reload();
}, 30000);
</script>
{% endblock %}
", "system/monitoring.html.twig", "/var/www/html/proyecto/templates/system/monitoring.html.twig");
    }
}
