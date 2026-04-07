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

/* security/index.html.twig */
class __TwigTemplate_38e31d53baad84e547ec4f4bc637b37a extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/index.html.twig"));

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

        yield "Seguridad - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.title")]));
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
            ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "flashes", ["error"], "method", false, false, false, 20));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 21
            yield "                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        yield "
            <div class=\"row\">
                <div class=\"col-md-6 mb-4\">
                    <div class=\"card h-100\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"bi bi-shield-lock-fill\"></i> ";
        // line 32
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.two_factor"), "html", null, true);
        yield "
                            </h5>
                            <p class=\"text-muted\">
                                ";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.2fa_description"), "html", null, true);
        yield "
                            </p>

                            ";
        // line 38
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 38, $this->source); })()), "totpEnabled", [], "any", false, false, false, 38)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 39
            yield "                                <div class=\"alert alert-success\">
                                    <i class=\"bi bi-check-circle-fill\"></i> ";
            // line 40
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.2fa_enabled"), "html", null, true);
            yield "
                                </div>
                                <p class=\"small text-muted\">
                                    ";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.recovery_codes_available"), "html", null, true);
            yield ": <strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["recoveryCodes"]) || array_key_exists("recoveryCodes", $context) ? $context["recoveryCodes"] : (function () { throw new RuntimeError('Variable "recoveryCodes" does not exist.', 43, $this->source); })()), "html", null, true);
            yield "</strong>
                                </p>
                                <button type=\"button\" class=\"btn btn-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#disable2FAModal\">
                                    <i class=\"bi bi-x-circle\"></i> ";
            // line 46
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.disable_2fa"), "html", null, true);
            yield "
                                </button>
                            ";
        } else {
            // line 49
            yield "                                <div class=\"alert alert-warning\">
                                    <i class=\"bi bi-exclamation-triangle\"></i> ";
            // line 50
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.2fa_disabled"), "html", null, true);
            yield "
                                </div>
                                <a href=\"";
            // line 52
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security_2fa_enable");
            yield "\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-shield-check\"></i> ";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.enable_2fa"), "html", null, true);
            yield "
                                </a>
                            ";
        }
        // line 56
        yield "                        </div>
                    </div>
                </div>

                <div class=\"col-md-6 mb-4\">
                    <div class=\"card h-100\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"bi bi-key-fill\"></i> ";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.title"), "html", null, true);
        yield "
                            </h5>
                            <p class=\"text-muted\">
                                ";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.last_update"), "html", null, true);
        yield ":
                                ";
        // line 68
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 68, $this->source); })()), "passwordChangedAt", [], "any", false, false, false, 68)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 68, $this->source); })()), "passwordChangedAt", [], "any", false, false, false, 68), "d/m/Y H:i"), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.never"), "html", null, true)));
        yield "
                            </p>
                            <p class=\"small text-muted\">
                                ";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.password_recommendation"), "html", null, true);
        yield "
                            </p>
                            <a href=\"";
        // line 73
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_change_password");
        yield "\" class=\"btn btn-primary\">
                                <i class=\"bi bi-shield-lock\"></i> ";
        // line 74
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield "
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card mb-4\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">
                        <i class=\"bi bi-laptop\"></i> ";
        // line 84
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.sessions"), "html", null, true);
        yield "
                    </h5>
                    <p class=\"text-muted\">";
        // line 86
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.devices_recently"), "html", null, true);
        yield "</p>

                    ";
        // line 88
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["activeSessions"]) || array_key_exists("activeSessions", $context) ? $context["activeSessions"] : (function () { throw new RuntimeError('Variable "activeSessions" does not exist.', 88, $this->source); })())) > 0)) {
            // line 89
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table\">
                                <thead>
                                    <tr>
                                        <th>";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.device"), "html", null, true);
            yield "</th>
                                        <th>IP</th>
                                        <th>";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.last_activity"), "html", null, true);
            yield "</th>
                                        <th>";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.action"), "html", null, true);
            yield "</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 100
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["activeSessions"]) || array_key_exists("activeSessions", $context) ? $context["activeSessions"] : (function () { throw new RuntimeError('Variable "activeSessions" does not exist.', 100, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["session"]) {
                // line 101
                yield "                                        <tr>
                                            <td>
                                                <i class=\"bi bi-laptop\"></i>
                                                ";
                // line 104
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["session"], "userAgent", [], "any", false, false, false, 104), 0, 50), "html", null, true);
                yield "...
                                            </td>
                                            <td>";
                // line 106
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["session"], "ipAddress", [], "any", false, false, false, 106), "html", null, true);
                yield "</td>
                                            <td>";
                // line 107
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["session"], "lastActivityAt", [], "any", false, false, false, 107), "d/m/Y H:i"), "html", null, true);
                yield "</td>
                                            <td>
                                                <form method=\"post\" action=\"";
                // line 109
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security_session_revoke", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["session"], "id", [], "any", false, false, false, 109)]), "html", null, true);
                yield "\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\" class=\"btn btn-sm btn-outline-danger\"
                                                            onclick=\"return confirm('¿Revocar esta sesión?')\">
                                                        <i class=\"bi bi-x-circle\"></i> Revocar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['session'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 119
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 123
            yield "                        <p class=\"text-muted\">No hay sesiones activas.</p>
                    ";
        }
        // line 125
        yield "                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">
                        <i class=\"bi bi-clock-history\"></i> Eventos de Seguridad Recientes
                    </h5>
                    <div class=\"table-responsive\">
                        <table class=\"table table-sm\">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Evento</th>
                                    <th>IP</th>
                                    <th>Severidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 144
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["securityEvents"]) || array_key_exists("securityEvents", $context) ? $context["securityEvents"] : (function () { throw new RuntimeError('Variable "securityEvents" does not exist.', 144, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 145
            yield "                                    <tr>
                                        <td>";
            // line 146
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 146), "d/m/Y H:i"), "html", null, true);
            yield "</td>
                                        <td>";
            // line 147
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 147), ["_" => " "])), "html", null, true);
            yield "</td>
                                        <td>";
            // line 148
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "ipAddress", [], "any", false, false, false, 148), "html", null, true);
            yield "</td>
                                        <td>
                                            <span class=\"badge bg-";
            // line 150
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 150) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 150) == "WARNING")) ? ("warning") : ("info"))));
            yield "\">
                                                ";
            // line 151
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 151), "html", null, true);
            yield "
                                            </span>
                                        </td>
                                    </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 156
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para deshabilitar 2FA -->
<div class=\"modal fade\" id=\"disable2FAModal\" tabindex=\"-1\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Deshabilitar 2FA</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
            </div>
            <form method=\"post\" action=\"";
        // line 173
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security_2fa_disable");
        yield "\">
                <div class=\"modal-body\">
                    <p>Para deshabilitar la autenticación de dos factores, ingresa tu código 2FA actual:</p>
                    <input type=\"text\" name=\"verification_code\" class=\"form-control\"
                           placeholder=\"Código de 6 dígitos\" required pattern=\"[0-9]{6}\">
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                    <button type=\"submit\" class=\"btn btn-danger\">Deshabilitar</button>
                </div>
            </form>
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
        return "security/index.html.twig";
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
        return array (  421 => 173,  402 => 156,  391 => 151,  387 => 150,  382 => 148,  378 => 147,  374 => 146,  371 => 145,  367 => 144,  346 => 125,  342 => 123,  336 => 119,  320 => 109,  315 => 107,  311 => 106,  306 => 104,  301 => 101,  297 => 100,  290 => 96,  286 => 95,  281 => 93,  275 => 89,  273 => 88,  268 => 86,  263 => 84,  250 => 74,  246 => 73,  241 => 71,  235 => 68,  231 => 67,  225 => 64,  215 => 56,  209 => 53,  205 => 52,  200 => 50,  197 => 49,  191 => 46,  183 => 43,  177 => 40,  174 => 39,  172 => 38,  166 => 35,  160 => 32,  152 => 26,  142 => 22,  139 => 21,  135 => 20,  132 => 19,  122 => 15,  119 => 14,  115 => 13,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Seguridad - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'security.title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            {% for message in app.flashes('error') %}
                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"row\">
                <div class=\"col-md-6 mb-4\">
                    <div class=\"card h-100\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"bi bi-shield-lock-fill\"></i> {{ 'security.two_factor'|trans }}
                            </h5>
                            <p class=\"text-muted\">
                                {{ 'security.2fa_description'|trans }}
                            </p>

                            {% if user.totpEnabled %}
                                <div class=\"alert alert-success\">
                                    <i class=\"bi bi-check-circle-fill\"></i> {{ 'security.2fa_enabled'|trans }}
                                </div>
                                <p class=\"small text-muted\">
                                    {{ 'security.recovery_codes_available'|trans }}: <strong>{{ recoveryCodes }}</strong>
                                </p>
                                <button type=\"button\" class=\"btn btn-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#disable2FAModal\">
                                    <i class=\"bi bi-x-circle\"></i> {{ 'security.disable_2fa'|trans }}
                                </button>
                            {% else %}
                                <div class=\"alert alert-warning\">
                                    <i class=\"bi bi-exclamation-triangle\"></i> {{ 'security.2fa_disabled'|trans }}
                                </div>
                                <a href=\"{{ path('app_security_2fa_enable') }}\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-shield-check\"></i> {{ 'security.enable_2fa'|trans }}
                                </a>
                            {% endif %}
                        </div>
                    </div>
                </div>

                <div class=\"col-md-6 mb-4\">
                    <div class=\"card h-100\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"bi bi-key-fill\"></i> {{ 'password.title'|trans }}
                            </h5>
                            <p class=\"text-muted\">
                                {{ 'security.last_update'|trans }}:
                                {{ user.passwordChangedAt ? user.passwordChangedAt|date('d/m/Y H:i') : ('common.never'|trans) }}
                            </p>
                            <p class=\"small text-muted\">
                                {{ 'security.password_recommendation'|trans }}
                            </p>
                            <a href=\"{{ path('app_profile_change_password') }}\" class=\"btn btn-primary\">
                                <i class=\"bi bi-shield-lock\"></i> {{ 'password.change'|trans }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"card mb-4\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">
                        <i class=\"bi bi-laptop\"></i> {{ 'security.sessions'|trans }}
                    </h5>
                    <p class=\"text-muted\">{{ 'security.devices_recently'|trans }}</p>

                    {% if activeSessions|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table\">
                                <thead>
                                    <tr>
                                        <th>{{ 'security.device'|trans }}</th>
                                        <th>IP</th>
                                        <th>{{ 'security.last_activity'|trans }}</th>
                                        <th>{{ 'common.action'|trans }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for session in activeSessions %}
                                        <tr>
                                            <td>
                                                <i class=\"bi bi-laptop\"></i>
                                                {{ session.userAgent|slice(0, 50) }}...
                                            </td>
                                            <td>{{ session.ipAddress }}</td>
                                            <td>{{ session.lastActivityAt|date('d/m/Y H:i') }}</td>
                                            <td>
                                                <form method=\"post\" action=\"{{ path('app_security_session_revoke', {id: session.id}) }}\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\" class=\"btn btn-sm btn-outline-danger\"
                                                            onclick=\"return confirm('¿Revocar esta sesión?')\">
                                                        <i class=\"bi bi-x-circle\"></i> Revocar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <p class=\"text-muted\">No hay sesiones activas.</p>
                    {% endif %}
                </div>
            </div>

            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">
                        <i class=\"bi bi-clock-history\"></i> Eventos de Seguridad Recientes
                    </h5>
                    <div class=\"table-responsive\">
                        <table class=\"table table-sm\">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Evento</th>
                                    <th>IP</th>
                                    <th>Severidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for event in securityEvents %}
                                    <tr>
                                        <td>{{ event.createdAt|date('d/m/Y H:i') }}</td>
                                        <td>{{ event.eventType|replace({'_': ' '})|title }}</td>
                                        <td>{{ event.ipAddress }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para deshabilitar 2FA -->
<div class=\"modal fade\" id=\"disable2FAModal\" tabindex=\"-1\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Deshabilitar 2FA</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
            </div>
            <form method=\"post\" action=\"{{ path('app_security_2fa_disable') }}\">
                <div class=\"modal-body\">
                    <p>Para deshabilitar la autenticación de dos factores, ingresa tu código 2FA actual:</p>
                    <input type=\"text\" name=\"verification_code\" class=\"form-control\"
                           placeholder=\"Código de 6 dígitos\" required pattern=\"[0-9]{6}\">
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                    <button type=\"submit\" class=\"btn btn-danger\">Deshabilitar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}
", "security/index.html.twig", "/var/www/html/proyecto/templates/security/index.html.twig");
    }
}
