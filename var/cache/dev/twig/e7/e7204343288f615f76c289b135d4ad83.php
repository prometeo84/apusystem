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

/* system/alerts.html.twig */
class __TwigTemplate_0ef67c3d8a783867704a3db847c556fb extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/alerts.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/alerts.html.twig"));

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

        yield "Alertas del Sistema - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_alerts.title_page")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">

            <!-- Estadísticas de Alertas -->
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0\">";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 19, $this->source); })()), "total", [], "any", false, false, false, 19), "html", null, true);
        yield "</h3>
                            <small class=\"text-muted\">";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.total_alerts"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-danger\">";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 27, $this->source); })()), "critical", [], "any", false, false, false, 27), "html", null, true);
        yield "</h3>
                            <small class=\"text-muted\">";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.critical_alerts"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-warning\">";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 35, $this->source); })()), "security", [], "any", false, false, false, 35), "html", null, true);
        yield "</h3>
                            <small class=\"text-muted\">";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.security_alerts"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-info\">";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 43, $this->source); })()), "billing", [], "any", false, false, false, 43), "html", null, true);
        yield "</h3>
                            <small class=\"text-muted\">";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.billing_alerts"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bell-fill text-warning\"></i> ";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_alerts.active_alerts_section"), "html", null, true);
        yield "</h5>
                </div>
                <div class=\"card-body\">
                    ";
        // line 55
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["alerts"]) || array_key_exists("alerts", $context) ? $context["alerts"] : (function () { throw new RuntimeError('Variable "alerts" does not exist.', 55, $this->source); })())) > 0)) {
            // line 56
            yield "                        <div class=\"list-group\">
                            ";
            // line 57
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["alerts"]) || array_key_exists("alerts", $context) ? $context["alerts"] : (function () { throw new RuntimeError('Variable "alerts" does not exist.', 57, $this->source); })()));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["alert"]) {
                // line 58
                yield "                                <div class=\"list-group-item list-group-item-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "type", [], "any", false, false, false, 58), "html", null, true);
                yield "\">
                                    <div class=\"d-flex w-100 justify-content-between align-items-start\">
                                        <div class=\"flex-grow-1\">
                                            <div class=\"d-flex align-items-center mb-2\">
                                                ";
                // line 62
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "category", [], "any", false, false, false, 62) == "security")) {
                    // line 63
                    yield "                                                    <span class=\"badge bg-danger me-2\">SEGURIDAD</span>
                                                ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 64
$context["alert"], "category", [], "any", false, false, false, 64) == "billing")) {
                    // line 65
                    yield "                                                    <span class=\"badge bg-warning me-2\">FACTURACIÓN</span>
                                                ";
                } else {
                    // line 67
                    yield "                                                    <span class=\"badge bg-secondary me-2\">SISTEMA</span>
                                                ";
                }
                // line 69
                yield "                                                <h6 class=\"mb-0\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "title", [], "any", false, false, false, 69), "html", null, true);
                yield "</h6>
                                            </div>
                                            <p class=\"mb-2\">";
                // line 71
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "message", [], "any", false, false, false, 71), "html", null, true);
                yield "</p>

                                            ";
                // line 73
                if (CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "details", [], "any", true, true, false, 73)) {
                    // line 74
                    yield "                                                <div class=\"mt-2\">
                                                    <button class=\"btn btn-sm btn-outline-secondary\" type=\"button\"
                                                            data-bs-toggle=\"collapse\"
                                                            data-bs-target=\"#details";
                    // line 77
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 77), "html", null, true);
                    yield "\">
                                                        <i class=\"bi bi-info-circle\"></i> ";
                    // line 78
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.view_details"), "html", null, true);
                    yield "
                                                    </button>
                                                    <div class=\"collapse mt-2\" id=\"details";
                    // line 80
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 80), "html", null, true);
                    yield "\">
                                                        <div class=\"card card-body bg-light\">
                                                            <pre class=\"mb-0\"><small>";
                    // line 82
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "details", [], "any", false, false, false, 82), Twig\Extension\CoreExtension::constant("JSON_PRETTY_PRINT")), "html", null, true);
                    yield "</small></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                }
                // line 87
                yield "
                                            <small class=\"text-muted d-block mt-2\">
                                                <i class=\"bi bi-clock\"></i> ";
                // line 89
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["alert"], "date", [], "any", false, false, false, 89), "d/m/Y H:i:s"), "html", null, true);
                yield "
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['alert'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            yield "                        </div>
                    ";
        } else {
            // line 97
            yield "                        <div class=\"text-center py-5\">
                            <i class=\"bi bi-check-circle-fill text-success\" style=\"font-size: 3rem;\"></i>
                            <p class=\"text-muted mt-3\">";
            // line 99
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_alerts.no_active_alerts_msg"), "html", null, true);
            yield "</p>
                        </div>
                    ";
        }
        // line 102
        yield "                </div>
            </div>

            <div class=\"card mt-4\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-shield-check\"></i> ";
        // line 107
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.alert_types"), "html", null, true);
        yield "</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h6 class=\"text-danger\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ";
        // line 112
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.suspicious_connections"), "html", null, true);
        yield "</h6>
                            <ul class=\"small\">
                                <li><strong>";
        // line 114
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.ip_change"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 115
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.browser_change"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 116
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.multiple_sessions"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 117
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.bot_pattern"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 118
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.suspicious_ip"), "html", null, true);
        yield "</strong></li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h6 class=\"text-warning\"><i class=\"bi bi-credit-card\"></i> ";
        // line 122
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.billing"), "html", null, true);
        yield "</h6>
                            <ul class=\"small\">
                                <li><strong>";
        // line 124
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.plan_expiring"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 125
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.plan_expired"), "html", null, true);
        yield "</strong></li>
                                <li><strong>";
        // line 126
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.user_limit"), "html", null, true);
        yield "</strong></li>
                            </ul>
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
        return "system/alerts.html.twig";
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
        return array (  363 => 126,  359 => 125,  355 => 124,  350 => 122,  343 => 118,  339 => 117,  335 => 116,  331 => 115,  327 => 114,  322 => 112,  314 => 107,  307 => 102,  301 => 99,  297 => 97,  293 => 95,  273 => 89,  269 => 87,  261 => 82,  256 => 80,  251 => 78,  247 => 77,  242 => 74,  240 => 73,  235 => 71,  229 => 69,  225 => 67,  221 => 65,  219 => 64,  216 => 63,  214 => 62,  206 => 58,  189 => 57,  186 => 56,  184 => 55,  178 => 52,  167 => 44,  163 => 43,  153 => 36,  149 => 35,  139 => 28,  135 => 27,  125 => 20,  121 => 19,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Alertas del Sistema - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system_alerts.title_page'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">

            <!-- Estadísticas de Alertas -->
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0\">{{ stats.total }}</h3>
                            <small class=\"text-muted\">{{ 'system.total_alerts'|trans }}</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-danger\">{{ stats.critical }}</h3>
                            <small class=\"text-muted\">{{ 'system.critical_alerts'|trans }}</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-warning\">{{ stats.security }}</h3>
                            <small class=\"text-muted\">{{ 'system.security_alerts'|trans }}</small>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card border-0 shadow-sm\">
                        <div class=\"card-body text-center\">
                            <h3 class=\"mb-0 text-info\">{{ stats.billing }}</h3>
                            <small class=\"text-muted\">{{ 'system.billing_alerts'|trans }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-bell-fill text-warning\"></i> {{ 'system_alerts.active_alerts_section'|trans }}</h5>
                </div>
                <div class=\"card-body\">
                    {% if alerts|length > 0 %}
                        <div class=\"list-group\">
                            {% for alert in alerts %}
                                <div class=\"list-group-item list-group-item-{{ alert.type }}\">
                                    <div class=\"d-flex w-100 justify-content-between align-items-start\">
                                        <div class=\"flex-grow-1\">
                                            <div class=\"d-flex align-items-center mb-2\">
                                                {% if alert.category == 'security' %}
                                                    <span class=\"badge bg-danger me-2\">SEGURIDAD</span>
                                                {% elseif alert.category == 'billing' %}
                                                    <span class=\"badge bg-warning me-2\">FACTURACIÓN</span>
                                                {% else %}
                                                    <span class=\"badge bg-secondary me-2\">SISTEMA</span>
                                                {% endif %}
                                                <h6 class=\"mb-0\">{{ alert.title }}</h6>
                                            </div>
                                            <p class=\"mb-2\">{{ alert.message }}</p>

                                            {% if alert.details is defined %}
                                                <div class=\"mt-2\">
                                                    <button class=\"btn btn-sm btn-outline-secondary\" type=\"button\"
                                                            data-bs-toggle=\"collapse\"
                                                            data-bs-target=\"#details{{ loop.index }}\">
                                                        <i class=\"bi bi-info-circle\"></i> {{ 'common.view_details'|trans }}
                                                    </button>
                                                    <div class=\"collapse mt-2\" id=\"details{{ loop.index }}\">
                                                        <div class=\"card card-body bg-light\">
                                                            <pre class=\"mb-0\"><small>{{ alert.details|json_encode(constant('JSON_PRETTY_PRINT')) }}</small></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            {% endif %}

                                            <small class=\"text-muted d-block mt-2\">
                                                <i class=\"bi bi-clock\"></i> {{ alert.date|date('d/m/Y H:i:s') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <div class=\"text-center py-5\">
                            <i class=\"bi bi-check-circle-fill text-success\" style=\"font-size: 3rem;\"></i>
                            <p class=\"text-muted mt-3\">{{ 'system_alerts.no_active_alerts_msg'|trans }}</p>
                        </div>
                    {% endif %}
                </div>
            </div>

            <div class=\"card mt-4\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-shield-check\"></i> {{ 'system.alert_types'|trans }}</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h6 class=\"text-danger\"><i class=\"bi bi-exclamation-triangle-fill\"></i> {{ 'system.suspicious_connections'|trans }}</h6>
                            <ul class=\"small\">
                                <li><strong>{{ 'system.ip_change'|trans }}</strong></li>
                                <li><strong>{{ 'system.browser_change'|trans }}</strong></li>
                                <li><strong>{{ 'system.multiple_sessions'|trans }}</strong></li>
                                <li><strong>{{ 'system.bot_pattern'|trans }}</strong></li>
                                <li><strong>{{ 'system.suspicious_ip'|trans }}</strong></li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h6 class=\"text-warning\"><i class=\"bi bi-credit-card\"></i> {{ 'system.billing'|trans }}</h6>
                            <ul class=\"small\">
                                <li><strong>{{ 'system.plan_expiring'|trans }}</strong></li>
                                <li><strong>{{ 'system.plan_expired'|trans }}</strong></li>
                                <li><strong>{{ 'system.user_limit'|trans }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "system/alerts.html.twig", "/var/www/html/proyecto/templates/system/alerts.html.twig");
    }
}
