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

/* password/forgot.html.twig */
class __TwigTemplate_93255c49d12714aaf34ffad4852a5575 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "password/forgot.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "password/forgot.html.twig"));

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

        yield "Recuperar Contraseña - APU System";
        
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
        yield "<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <h1 class=\"h3 mb-3 fw-bold\" style=\"color: var(--primary-color);\">
                                <i class=\"bi bi-key\"></i> ";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.forgot_title"), "html", null, true);
        yield "
                            </h1>
                            <p class=\"text-muted\">";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.forgot_description"), "html", null, true);
        yield "</p>
                        </div>

                        ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "flashes", ["error"], "method", false, false, false, 19));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 20
            yield "                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 21
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        yield "
                        ";
        // line 25
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 25, $this->source); })()), "flashes", ["success"], "method", false, false, false, 25));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 26
            yield "                            <div class=\"alert alert-success\">
                                <i class=\"bi bi-check-circle-fill\"></i> ";
            // line 27
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        yield "
                        <form method=\"post\" action=\"";
        // line 31
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_forgot");
        yield "\">
                            <div class=\"mb-3\">
                                <label for=\"email\" class=\"form-label\">
                                    <i class=\"bi bi-envelope\"></i> Correo Electrónico
                                </label>
                                <input
                                    type=\"email\"
                                    class=\"form-control form-control-lg\"
                                    id=\"email\"
                                    name=\"email\"
                                    required
                                    autofocus
                                    placeholder=\"tu-email@ejemplo.com\"
                                >
                                <small class=\"form-text text-muted\">
                                    📧 Para pruebas usa: admin@demo.com, admin@abc.com o user@abc.com
                                </small>
                            </div>

                            <div class=\"alert alert-info\">
                                <i class=\"bi bi-info-circle\"></i>
                                <small>
                                    Recibirás un correo con un enlace para restablecer tu contraseña.
                                    El enlace expirará en 1 hora.
                                </small>
                            </div>

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-send\"></i> ";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.send_link"), "html", null, true);
        yield "
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"";
        // line 65
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_login");
        yield "\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-arrow-left\"></i> ";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.back_to_login"), "html", null, true);
        yield "
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class=\"text-center mt-4 text-white\">
                    <p class=\"mb-0\">APU System &copy; ";
        // line 74
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "</p>
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
        return "password/forgot.html.twig";
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
        return array (  214 => 74,  203 => 66,  199 => 65,  191 => 60,  159 => 31,  156 => 30,  147 => 27,  144 => 26,  140 => 25,  137 => 24,  128 => 21,  125 => 20,  121 => 19,  115 => 16,  110 => 14,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Recuperar Contraseña - APU System{% endblock %}

{% block body %}
<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <h1 class=\"h3 mb-3 fw-bold\" style=\"color: var(--primary-color);\">
                                <i class=\"bi bi-key\"></i> {{ 'password.forgot_title'|trans }}
                            </h1>
                            <p class=\"text-muted\">{{ 'password.forgot_description'|trans }}</p>
                        </div>

                        {% for message in app.flashes('error') %}
                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                            </div>
                        {% endfor %}

                        {% for message in app.flashes('success') %}
                            <div class=\"alert alert-success\">
                                <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                            </div>
                        {% endfor %}

                        <form method=\"post\" action=\"{{ path('app_password_forgot') }}\">
                            <div class=\"mb-3\">
                                <label for=\"email\" class=\"form-label\">
                                    <i class=\"bi bi-envelope\"></i> Correo Electrónico
                                </label>
                                <input
                                    type=\"email\"
                                    class=\"form-control form-control-lg\"
                                    id=\"email\"
                                    name=\"email\"
                                    required
                                    autofocus
                                    placeholder=\"tu-email@ejemplo.com\"
                                >
                                <small class=\"form-text text-muted\">
                                    📧 Para pruebas usa: admin@demo.com, admin@abc.com o user@abc.com
                                </small>
                            </div>

                            <div class=\"alert alert-info\">
                                <i class=\"bi bi-info-circle\"></i>
                                <small>
                                    Recibirás un correo con un enlace para restablecer tu contraseña.
                                    El enlace expirará en 1 hora.
                                </small>
                            </div>

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-send\"></i> {{ 'password.send_link'|trans }}
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"{{ path('app_login') }}\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-arrow-left\"></i> {{ 'password.back_to_login'|trans }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class=\"text-center mt-4 text-white\">
                    <p class=\"mb-0\">APU System &copy; {{ 'now'|date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "password/forgot.html.twig", "/var/www/html/proyecto/templates/password/forgot.html.twig");
    }
}
