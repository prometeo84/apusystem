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

/* security/enable_2fa.html.twig */
class __TwigTemplate_0a6ff256ebaee0b3009bb56bdb5fff09 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/enable_2fa.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/enable_2fa.html.twig"));

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

        yield "Habilitar 2FA - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.enable_2fa_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-shield-check\"></i> ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.configure_2fa"), "html", null, true);
        yield "
                            </h4>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <h5>";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.step_1"), "html", null, true);
        yield "</h5>
                                    <p class=\"text-muted\">
                                        ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.use_auth_app"), "html", null, true);
        yield "
                                        ";
        // line 26
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.scan_with_app"), "html", null, true);
        yield ":
                                    </p>

                                    <div class=\"text-center mb-3\">
                                        <img src=\"";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["qrCode"]) || array_key_exists("qrCode", $context) ? $context["qrCode"] : (function () { throw new RuntimeError('Variable "qrCode" does not exist.', 30, $this->source); })()), "html", null, true);
        yield "\" alt=\"QR Code\" class=\"img-fluid\" style=\"max-width: 250px;\">
                                    </div>

                                    <div class=\"alert alert-info\">
                                        <strong>Clave secreta:</strong>
                                        <code>";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["secret"]) || array_key_exists("secret", $context) ? $context["secret"] : (function () { throw new RuntimeError('Variable "secret" does not exist.', 35, $this->source); })()), "html", null, true);
        yield "</code>
                                        <p class=\"small mb-0 mt-2\">
                                            ";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.manual_key"), "html", null, true);
        yield "
                                            ";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.in_your_app"), "html", null, true);
        yield ".
                                        </p>
                                    </div>
                                </div>

                                <div class=\"col-md-6\">
                                    <h5>";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.step_2"), "html", null, true);
        yield "</h5>
                                    <p class=\"text-muted\">
                                        ";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.enter_6_digit"), "html", null, true);
        yield "
                                        ";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_config"), "html", null, true);
        yield ":
                                    </p>

                                    <form method=\"post\" action=\"";
        // line 50
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security_2fa_enable");
        yield "\">
                                        <div class=\"mb-3\">
                                            <label class=\"form-label\">";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verification_code"), "html", null, true);
        yield "</label>
                                            <input type=\"text\" name=\"verification_code\" class=\"form-control form-control-lg text-center\"
                                                   placeholder=\"000000\" required pattern=\"[0-9]{6}\" maxlength=\"6\"
                                                   style=\"letter-spacing: 0.5em; font-size: 1.5rem;\">
                                        </div>

                                        <div class=\"alert alert-warning\">
                                            <i class=\"bi bi-exclamation-triangle\"></i>
                                            <strong>Importante:</strong> Una vez habilitado el 2FA, necesitarás
                                            tu contraseña y un código de verificación para iniciar sesión.
                                        </div>

                                        <div class=\"d-grid gap-2\">
                                            <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                                <i class=\"bi bi-check-circle\"></i> ";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_enable"), "html", null, true);
        yield "
                                            </button>
                                            <a href=\"";
        // line 68
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\" class=\"btn btn-outline-secondary\">
                                                <i class=\"bi bi-x-circle\"></i> ";
        // line 69
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.cancel"), "html", null, true);
        yield "
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <hr class=\"my-4\">

                            <div class=\"alert alert-primary\">
                                <h6><i class=\"bi bi-info-circle\"></i> Aplicaciones Recomendadas</h6>
                                <ul class=\"mb-0\">
                                    <li><strong>Google Authenticator:</strong> Disponible para iOS y Android</li>
                                    <li><strong>Microsoft Authenticator:</strong> Disponible para iOS y Android</li>
                                    <li><strong>Authy:</strong> Disponible para iOS, Android y Desktop</li>
                                </ul>
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
        return "security/enable_2fa.html.twig";
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
        return array (  216 => 69,  212 => 68,  207 => 66,  190 => 52,  185 => 50,  179 => 47,  175 => 46,  170 => 44,  161 => 38,  157 => 37,  152 => 35,  144 => 30,  137 => 26,  133 => 25,  128 => 23,  120 => 18,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Habilitar 2FA - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'security_2fa.enable_2fa_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-shield-check\"></i> {{ 'security_2fa.configure_2fa'|trans }}
                            </h4>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <h5>{{ 'security_2fa.step_1'|trans }}</h5>
                                    <p class=\"text-muted\">
                                        {{ 'security.use_auth_app'|trans }}
                                        {{ 'security_2fa.scan_with_app'|trans }}:
                                    </p>

                                    <div class=\"text-center mb-3\">
                                        <img src=\"{{ qrCode }}\" alt=\"QR Code\" class=\"img-fluid\" style=\"max-width: 250px;\">
                                    </div>

                                    <div class=\"alert alert-info\">
                                        <strong>Clave secreta:</strong>
                                        <code>{{ secret }}</code>
                                        <p class=\"small mb-0 mt-2\">
                                            {{ 'security_2fa.manual_key'|trans }}
                                            {{ 'security.in_your_app'|trans }}.
                                        </p>
                                    </div>
                                </div>

                                <div class=\"col-md-6\">
                                    <h5>{{ 'security_2fa.step_2'|trans }}</h5>
                                    <p class=\"text-muted\">
                                        {{ 'security_2fa.enter_6_digit'|trans }}
                                        {{ 'security_2fa.verify_config'|trans }}:
                                    </p>

                                    <form method=\"post\" action=\"{{ path('app_security_2fa_enable') }}\">
                                        <div class=\"mb-3\">
                                            <label class=\"form-label\">{{ 'security_2fa.verification_code'|trans }}</label>
                                            <input type=\"text\" name=\"verification_code\" class=\"form-control form-control-lg text-center\"
                                                   placeholder=\"000000\" required pattern=\"[0-9]{6}\" maxlength=\"6\"
                                                   style=\"letter-spacing: 0.5em; font-size: 1.5rem;\">
                                        </div>

                                        <div class=\"alert alert-warning\">
                                            <i class=\"bi bi-exclamation-triangle\"></i>
                                            <strong>Importante:</strong> Una vez habilitado el 2FA, necesitarás
                                            tu contraseña y un código de verificación para iniciar sesión.
                                        </div>

                                        <div class=\"d-grid gap-2\">
                                            <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                                <i class=\"bi bi-check-circle\"></i> {{ 'security_2fa.verify_enable'|trans }}
                                            </button>
                                            <a href=\"{{ path('app_security') }}\" class=\"btn btn-outline-secondary\">
                                                <i class=\"bi bi-x-circle\"></i> {{ 'buttons.cancel'|trans }}
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <hr class=\"my-4\">

                            <div class=\"alert alert-primary\">
                                <h6><i class=\"bi bi-info-circle\"></i> Aplicaciones Recomendadas</h6>
                                <ul class=\"mb-0\">
                                    <li><strong>Google Authenticator:</strong> Disponible para iOS y Android</li>
                                    <li><strong>Microsoft Authenticator:</strong> Disponible para iOS y Android</li>
                                    <li><strong>Authy:</strong> Disponible para iOS, Android y Desktop</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "security/enable_2fa.html.twig", "/var/www/html/proyecto/templates/security/enable_2fa.html.twig");
    }
}
