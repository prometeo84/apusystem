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

/* system/index.html.twig */
class __TwigTemplate_0dbefaee1b4ebe1f419f5a410a37c016 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/index.html.twig"));

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

        yield "Sistema - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.supervision")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-primary\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.total_tenants"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 20, $this->source); })()), "total_tenants", [], "any", false, false, false, 20), "html", null, true);
        yield "</h2>
                                </div>
                                <i class=\"bi bi-building\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 26
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 26, $this->source); })()), "active_tenants", [], "any", false, false, false, 26), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.active_label"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-success\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.total_users"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 37, $this->source); })()), "total_users", [], "any", false, false, false, 37), "html", null, true);
        yield "</h2>
                                </div>
                                <i class=\"bi bi-people-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 43, $this->source); })()), "active_users", [], "any", false, false, false, 43), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.active_label"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-warning\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.users_2fa"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 54, $this->source); })()), "users_2fa", [], "any", false, false, false, 54), "html", null, true);
        yield "</h2>
                                </div>
                                <i class=\"bi bi-shield-check\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 60, $this->source); })()), "users_2fa", [], "any", false, false, false, 60) / CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 60, $this->source); })()), "total_users", [], "any", false, false, false, 60)) * 100)), "html", null, true);
        yield "% ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.of_total"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-info\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.active_sessions"), "html", null, true);
        yield "</h6>
                                    <h2 class=\"mb-0\">";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 71, $this->source); })()), "active_sessions", [], "any", false, false, false, 71), "html", null, true);
        yield "</h2>
                                </div>
                                <i class=\"bi bi-activity\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.right_now"), "html", null, true);
        yield "</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-md-8 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header d-flex justify-content-between align-items-center\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-exclamation-triangle-fill text-danger\"></i> ";
        // line 87
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.critical_events"), "html", null, true);
        yield "</h5>
                            <a href=\"";
        // line 88
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_errors");
        yield "\" class=\"btn btn-sm btn-outline-secondary\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.view_all"), "html", null, true);
        yield "</a>
                        </div>
                        <div class=\"card-body\">
                            ";
        // line 91
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["criticalEvents"]) || array_key_exists("criticalEvents", $context) ? $context["criticalEvents"] : (function () { throw new RuntimeError('Variable "criticalEvents" does not exist.', 91, $this->source); })())) > 0)) {
            // line 92
            yield "                                <div class=\"table-responsive\">
                                    <table class=\"table table-sm table-hover\">
                                        <thead>
                                            <tr>
                                                <th>";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.date"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.company"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.user"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 99
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.event"), "html", null, true);
            yield "</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ";
            // line 104
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["criticalEvents"]) || array_key_exists("criticalEvents", $context) ? $context["criticalEvents"] : (function () { throw new RuntimeError('Variable "criticalEvents" does not exist.', 104, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 105
                yield "                                                <tr>
                                                    <td><small>";
                // line 106
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 106), "d/m/Y H:i"), "html", null, true);
                yield "</small></td>
                                                    <td>";
                // line 107
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "tenant", [], "any", false, false, false, 107), "name", [], "any", false, false, false, 107), "html", null, true);
                yield "</td>
                                                    <td>";
                // line 108
                yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 108)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 108), "email", [], "any", false, false, false, 108), "html", null, true)) : ("-"));
                yield "</td>
                                                    <td>
                                                        <span class=\"badge bg-danger\">
                                                            ";
                // line 111
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 111), ["_" => " "])), "html", null, true);
                yield "
                                                        </span>
                                                    </td>
                                                    <td><code class=\"small\">";
                // line 114
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "ipAddress", [], "any", false, false, false, 114), "html", null, true);
                yield "</code></td>
                                                </tr>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 117
            yield "                                        </tbody>
                                    </table>
                                </div>
                            ";
        } else {
            // line 121
            yield "                                <p class=\"text-muted text-center py-3\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_critical_events"), "html", null, true);
            yield "</p>
                            ";
        }
        // line 123
        yield "                        </div>
                    </div>

                    <div class=\"card mt-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-clock-history\"></i> ";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.recent_activity"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            ";
        // line 131
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["recentEvents"]) || array_key_exists("recentEvents", $context) ? $context["recentEvents"] : (function () { throw new RuntimeError('Variable "recentEvents" does not exist.', 131, $this->source); })())) > 0)) {
            // line 132
            yield "                                <div class=\"table-responsive\">
                                    <table class=\"table table-sm table-hover\">
                                        <thead>
                                            <tr>
                                                <th>";
            // line 136
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.hour"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.company"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 138
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.user"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 139
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.event"), "html", null, true);
            yield "</th>
                                                <th>";
            // line 140
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.severity"), "html", null, true);
            yield "</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ";
            // line 144
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentEvents"]) || array_key_exists("recentEvents", $context) ? $context["recentEvents"] : (function () { throw new RuntimeError('Variable "recentEvents" does not exist.', 144, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 145
                yield "                                                <tr>
                                                    <td><small>";
                // line 146
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 146), "H:i:s"), "html", null, true);
                yield "</small></td>
                                                    <td>";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "tenant", [], "any", false, false, false, 147), "name", [], "any", false, false, false, 147), "html", null, true);
                yield "</td>
                                                    <td>";
                // line 148
                yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 148)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 148), "email", [], "any", false, false, false, 148), "html", null, true)) : ("-"));
                yield "</td>
                                                    <td>";
                // line 149
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 149), ["_" => " "])), "html", null, true);
                yield "</td>
                                                    <td>
                                                        <span class=\"badge bg-";
                // line 151
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 151) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 151) == "WARNING")) ? ("warning") : ("info"))));
                yield "\">
                                                            ";
                // line 152
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 152), "html", null, true);
                yield "
                                                        </span>
                                                    </td>
                                                </tr>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 157
            yield "                                        </tbody>
                                    </table>
                                </div>
                            ";
        } else {
            // line 161
            yield "                                <p class=\"text-muted text-center py-3\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_recent_activity"), "html", null, true);
            yield "</p>
                            ";
        }
        // line 163
        yield "                        </div>
                    </div>
                </div>

                <div class=\"col-md-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> ";
        // line 170
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.active_tenants_list"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <ul class=\"list-unstyled mb-0\">
                                ";
        // line 174
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["activeTenants"]) || array_key_exists("activeTenants", $context) ? $context["activeTenants"] : (function () { throw new RuntimeError('Variable "activeTenants" does not exist.', 174, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["tenant"]) {
            // line 175
            yield "                                    <li class=\"mb-3\">
                                        <div class=\"d-flex justify-content-between align-items-center\">
                                            <div>
                                                <strong>";
            // line 178
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "name", [], "any", false, false, false, 178), "html", null, true);
            yield "</strong><br>
                                                <small class=\"text-muted\">";
            // line 179
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.code"), "html", null, true);
            yield ": ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "slug", [], "any", false, false, false, 179), "html", null, true);
            yield "</small>
                                            </div>
                                            <span class=\"badge bg-";
            // line 181
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 181) == "enterprise")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 181) == "professional")) ? ("warning") : ("secondary"))));
            yield "\">
                                                ";
            // line 182
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 182)), "html", null, true);
            yield "
                                            </span>
                                        </div>
                                    </li>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tenant'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 187
        yield "                            </ul>
                        </div>
                        <div class=\"card-footer bg-white\">
                            <a href=\"";
        // line 190
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants");
        yield "\" class=\"text-decoration-none\">
                                ";
        // line 191
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.view_all_tenants"), "html", null, true);
        yield " <i class=\"bi bi-arrow-right\"></i>
                            </a>
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
        return "system/index.html.twig";
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
        return array (  474 => 191,  470 => 190,  465 => 187,  454 => 182,  450 => 181,  443 => 179,  439 => 178,  434 => 175,  430 => 174,  423 => 170,  414 => 163,  408 => 161,  402 => 157,  391 => 152,  387 => 151,  382 => 149,  378 => 148,  374 => 147,  370 => 146,  367 => 145,  363 => 144,  356 => 140,  352 => 139,  348 => 138,  344 => 137,  340 => 136,  334 => 132,  332 => 131,  326 => 128,  319 => 123,  313 => 121,  307 => 117,  298 => 114,  292 => 111,  286 => 108,  282 => 107,  278 => 106,  275 => 105,  271 => 104,  263 => 99,  259 => 98,  255 => 97,  251 => 96,  245 => 92,  243 => 91,  235 => 88,  231 => 87,  218 => 77,  209 => 71,  205 => 70,  190 => 60,  181 => 54,  177 => 53,  162 => 43,  153 => 37,  149 => 36,  134 => 26,  125 => 20,  121 => 19,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Sistema - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system.supervision'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-primary\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'system.total_tenants'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ stats.total_tenants }}</h2>
                                </div>
                                <i class=\"bi bi-building\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ stats.active_tenants }} {{ 'system.active_label'|trans }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-success\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'system.total_users'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ stats.total_users }}</h2>
                                </div>
                                <i class=\"bi bi-people-fill\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ stats.active_users }} {{ 'system.active_label'|trans }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-warning\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'system.users_2fa'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ stats.users_2fa }}</h2>
                                </div>
                                <i class=\"bi bi-shield-check\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ ((stats.users_2fa / stats.total_users) * 100)|round }}% {{ 'system.of_total'|trans }}</small>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-3\">
                    <div class=\"card text-white bg-info\">
                        <div class=\"card-body\">
                            <div class=\"d-flex justify-content-between align-items-center\">
                                <div>
                                    <h6 class=\"card-title mb-0\">{{ 'system.active_sessions'|trans }}</h6>
                                    <h2 class=\"mb-0\">{{ stats.active_sessions }}</h2>
                                </div>
                                <i class=\"bi bi-activity\" style=\"font-size: 3rem; opacity: 0.5;\"></i>
                            </div>
                        </div>
                        <div class=\"card-footer bg-transparent border-0\">
                            <small>{{ 'system.right_now'|trans }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-md-8 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-header d-flex justify-content-between align-items-center\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-exclamation-triangle-fill text-danger\"></i> {{ 'system.critical_events'|trans }}</h5>
                            <a href=\"{{ path('app_system_errors') }}\" class=\"btn btn-sm btn-outline-secondary\">{{ 'system.view_all'|trans }}</a>
                        </div>
                        <div class=\"card-body\">
                            {% if criticalEvents|length > 0 %}
                                <div class=\"table-responsive\">
                                    <table class=\"table table-sm table-hover\">
                                        <thead>
                                            <tr>
                                                <th>{{ 'common.date'|trans }}</th>
                                                <th>{{ 'common.company'|trans }}</th>
                                                <th>{{ 'common.user'|trans }}</th>
                                                <th>{{ 'system.event'|trans }}</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% for event in criticalEvents %}
                                                <tr>
                                                    <td><small>{{ event.createdAt|date('d/m/Y H:i') }}</small></td>
                                                    <td>{{ event.tenant.name }}</td>
                                                    <td>{{ event.user ? event.user.email : '-' }}</td>
                                                    <td>
                                                        <span class=\"badge bg-danger\">
                                                            {{ event.eventType|replace({'_': ' '})|title }}
                                                        </span>
                                                    </td>
                                                    <td><code class=\"small\">{{ event.ipAddress }}</code></td>
                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                    </table>
                                </div>
                            {% else %}
                                <p class=\"text-muted text-center py-3\">{{ 'system.no_critical_events'|trans }}</p>
                            {% endif %}
                        </div>
                    </div>

                    <div class=\"card mt-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-clock-history\"></i> {{ 'system.recent_activity'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            {% if recentEvents|length > 0 %}
                                <div class=\"table-responsive\">
                                    <table class=\"table table-sm table-hover\">
                                        <thead>
                                            <tr>
                                                <th>{{ 'system.hour'|trans }}</th>
                                                <th>{{ 'common.company'|trans }}</th>
                                                <th>{{ 'common.user'|trans }}</th>
                                                <th>{{ 'system.event'|trans }}</th>
                                                <th>{{ 'system.severity'|trans }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% for event in recentEvents %}
                                                <tr>
                                                    <td><small>{{ event.createdAt|date('H:i:s') }}</small></td>
                                                    <td>{{ event.tenant.name }}</td>
                                                    <td>{{ event.user ? event.user.email : '-' }}</td>
                                                    <td>{{ event.eventType|replace({'_': ' '})|title }}</td>
                                                    <td>
                                                        <span class=\"badge bg-{{ event.severity == 'CRITICAL' ? 'danger' : (event.severity == 'WARNING' ? 'warning' : 'info') }}\">
                                                            {{ event.severity }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                    </table>
                                </div>
                            {% else %}
                                <p class=\"text-muted text-center py-3\">{{ 'system.no_recent_activity'|trans }}</p>
                            {% endif %}
                        </div>
                    </div>
                </div>

                <div class=\"col-md-4\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> {{ 'system.active_tenants_list'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <ul class=\"list-unstyled mb-0\">
                                {% for tenant in activeTenants %}
                                    <li class=\"mb-3\">
                                        <div class=\"d-flex justify-content-between align-items-center\">
                                            <div>
                                                <strong>{{ tenant.name }}</strong><br>
                                                <small class=\"text-muted\">{{ 'common.code'|trans }}: {{ tenant.slug }}</small>
                                            </div>
                                            <span class=\"badge bg-{{ tenant.plan == 'enterprise' ? 'danger' : (tenant.plan == 'professional' ? 'warning' : 'secondary') }}\">
                                                {{ tenant.plan|upper }}
                                            </span>
                                        </div>
                                    </li>
                                {% endfor %}
                            </ul>
                        </div>
                        <div class=\"card-footer bg-white\">
                            <a href=\"{{ path('app_system_tenants') }}\" class=\"text-decoration-none\">
                                {{ 'system.view_all_tenants'|trans }} <i class=\"bi bi-arrow-right\"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "system/index.html.twig", "/var/www/html/proyecto/templates/system/index.html.twig");
    }
}
