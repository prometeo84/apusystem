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

/* admin/index.html.twig */
class __TwigTemplate_ea56be2dfbba0dc379e015db9ae44b0e extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/index.html.twig"));

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

        yield "Administración - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.panel")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row\">
                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-primary\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.total_users"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 20, $this->source); })()), "html", null, true);
        yield "</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-people-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <a href=\"";
        // line 28
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users");
        yield "\" class=\"text-white text-decoration-none\">
                                ";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.view_all"), "html", null, true);
        yield " <i class=\"bi bi-arrow-right\"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-success\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.active_users"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["activeUsers"]) || array_key_exists("activeUsers", $context) ? $context["activeUsers"] : (function () { throw new RuntimeError('Variable "activeUsers" does not exist.', 41, $this->source); })()), "html", null, true);
        yield "</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-person-check-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 49
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((((isset($context["activeUsers"]) || array_key_exists("activeUsers", $context) ? $context["activeUsers"] : (function () { throw new RuntimeError('Variable "activeUsers" does not exist.', 49, $this->source); })()) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 49, $this->source); })())) * 100)), "html", null, true);
        yield "% ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.of_total"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-warning\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.with_2fa"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["users2FA"]) || array_key_exists("users2FA", $context) ? $context["users2FA"] : (function () { throw new RuntimeError('Variable "users2FA" does not exist.', 60, $this->source); })()), "html", null, true);
        yield "</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-shield-check\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((((isset($context["users2FA"]) || array_key_exists("users2FA", $context) ? $context["users2FA"] : (function () { throw new RuntimeError('Variable "users2FA" does not exist.', 68, $this->source); })()) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 68, $this->source); })())) * 100)), "html", null, true);
        yield "% del total</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-danger\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 78
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.events_today"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 79
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["eventsToday"]) || array_key_exists("eventsToday", $context) ? $context["eventsToday"] : (function () { throw new RuntimeError('Variable "eventsToday" does not exist.', 79, $this->source); })()), "html", null, true);
        yield "</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-exclamation-triangle-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <a href=\"";
        // line 87
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_logs");
        yield "\" class=\"text-white text-decoration-none\">
                                ";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.view_logs"), "html", null, true);
        yield " <i class=\"bi bi-arrow-right\"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-md-8 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-activity\"></i> ";
        // line 99
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.recent_activity"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-hover\">
                                    <thead>
                                        <tr>
                                            <th>";
        // line 106
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.user"), "html", null, true);
        yield "</th>
                                            <th>";
        // line 107
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.event"), "html", null, true);
        yield "</th>
                                            <th>";
        // line 108
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.date"), "html", null, true);
        yield "</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
        // line 113
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentEvents"]) || array_key_exists("recentEvents", $context) ? $context["recentEvents"] : (function () { throw new RuntimeError('Variable "recentEvents" does not exist.', 113, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 114
            yield "                                            <tr>
                                                <td>";
            // line 115
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 115), "email", [], "any", false, false, false, 115), "html", null, true);
            yield "</td>
                                                <td>";
            // line 116
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 116), ["_" => " "])), "html", null, true);
            yield "</td>
                                                <td>";
            // line 117
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 117), "d/m/Y H:i"), "html", null, true);
            yield "</td>
                                                <td>";
            // line 118
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "ipAddress", [], "any", false, false, false, 118), "html", null, true);
            yield "</td>
                                            </tr>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 121
        yield "                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-4 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-gear-fill\"></i> ";
        // line 131
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.quick_actions"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"d-grid gap-2\">
                                <a href=\"";
        // line 135
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_create");
        yield "\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-person-plus\"></i> ";
        // line 136
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.create_user"), "html", null, true);
        yield "
                                </a>
                                <a href=\"";
        // line 138
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users");
        yield "\" class=\"btn btn-outline-primary\">
                                    <i class=\"bi bi-people\"></i> ";
        // line 139
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.manage_users"), "html", null, true);
        yield "
                                </a>
                                <a href=\"";
        // line 141
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_logs");
        yield "\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-file-text\"></i> ";
        // line 142
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.view_security_logs"), "html", null, true);
        yield "
                                </a>
                                ";
        // line 144
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 145
            yield "                                    <a href=\"";
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_tenant");
            yield "\" class=\"btn btn-outline-warning\">
                                        <i class=\"bi bi-building\"></i> ";
            // line 146
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.configure_company"), "html", null, true);
            yield "
                                    </a>
                                ";
        }
        // line 149
        yield "                            </div>
                        </div>
                    </div>

                    <div class=\"card mt-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-speedometer2\"></i> ";
        // line 155
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.system_status"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <ul class=\"list-unstyled mb-0\">
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    ";
        // line 161
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.database"), "html", null, true);
        yield ": <strong>OK</strong>
                                </li>
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    ";
        // line 165
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.sessions"), "html", null, true);
        yield ": <strong>OK</strong>
                                </li>
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    Email: <strong>OK</strong>
                                </li>
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
        return "admin/index.html.twig";
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
        return array (  382 => 165,  375 => 161,  366 => 155,  358 => 149,  352 => 146,  347 => 145,  345 => 144,  340 => 142,  336 => 141,  331 => 139,  327 => 138,  322 => 136,  318 => 135,  311 => 131,  299 => 121,  290 => 118,  286 => 117,  282 => 116,  278 => 115,  275 => 114,  271 => 113,  263 => 108,  259 => 107,  255 => 106,  245 => 99,  231 => 88,  227 => 87,  216 => 79,  212 => 78,  199 => 68,  188 => 60,  184 => 59,  169 => 49,  158 => 41,  154 => 40,  140 => 29,  136 => 28,  125 => 20,  121 => 19,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Administración - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'admin.panel'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row\">
                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-primary\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'admin.total_users'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ totalUsers }}</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-people-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <a href=\"{{ path('app_admin_users') }}\" class=\"text-white text-decoration-none\">
                                {{ 'system.view_all'|trans }} <i class=\"bi bi-arrow-right\"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-success\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'admin.active_users'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ activeUsers }}</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-person-check-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ ((activeUsers / totalUsers) * 100)|round }}% {{ 'system.of_total'|trans }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-warning\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'admin.with_2fa'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ users2FA }}</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-shield-check\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ ((users2FA / totalUsers) * 100)|round }}% del total</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3 mb-4\">
                    <div class=\"card text-white bg-danger\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'admin.events_today'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ eventsToday }}</h2>
                                </div>
                                <div>
                                    <i class=\"bi bi-exclamation-triangle-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <a href=\"{{ path('app_admin_logs') }}\" class=\"text-white text-decoration-none\">
                                {{ 'admin.view_logs'|trans }} <i class=\"bi bi-arrow-right\"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-md-8 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-activity\"></i> {{ 'system.recent_activity'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-hover\">
                                    <thead>
                                        <tr>
                                            <th>{{ 'common.user'|trans }}</th>
                                            <th>{{ 'system.event'|trans }}</th>
                                            <th>{{ 'common.date'|trans }}</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for event in recentEvents %}
                                            <tr>
                                                <td>{{ event.user.email }}</td>
                                                <td>{{ event.eventType|replace({'_': ' '})|title }}</td>
                                                <td>{{ event.createdAt|date('d/m/Y H:i') }}</td>
                                                <td>{{ event.ipAddress }}</td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-4 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-gear-fill\"></i> {{ 'system.quick_actions'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"d-grid gap-2\">
                                <a href=\"{{ path('app_admin_users_create') }}\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-person-plus\"></i> {{ 'admin.create_user'|trans }}
                                </a>
                                <a href=\"{{ path('app_admin_users') }}\" class=\"btn btn-outline-primary\">
                                    <i class=\"bi bi-people\"></i> {{ 'admin.manage_users'|trans }}
                                </a>
                                <a href=\"{{ path('app_admin_logs') }}\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-file-text\"></i> {{ 'admin.view_security_logs'|trans }}
                                </a>
                                {% if is_granted('ROLE_SUPER_ADMIN') %}
                                    <a href=\"{{ path('app_admin_tenant') }}\" class=\"btn btn-outline-warning\">
                                        <i class=\"bi bi-building\"></i> {{ 'admin.configure_company'|trans }}
                                    </a>
                                {% endif %}
                            </div>
                        </div>
                    </div>

                    <div class=\"card mt-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-speedometer2\"></i> {{ 'admin.system_status'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <ul class=\"list-unstyled mb-0\">
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    {{ 'admin.database'|trans }}: <strong>OK</strong>
                                </li>
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    {{ 'admin.sessions'|trans }}: <strong>OK</strong>
                                </li>
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-check-circle-fill text-success\"></i>
                                    Email: <strong>OK</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "admin/index.html.twig", "/var/www/html/proyecto/templates/admin/index.html.twig");
    }
}
