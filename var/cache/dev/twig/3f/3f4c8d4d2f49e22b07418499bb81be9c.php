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

/* security/login.html.twig */
class __TwigTemplate_0e325896122a7bedd334628f45293e06 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/login.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/login.html.twig"));

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

        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.login"), "html", null, true);
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
        yield "<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <h1 class=\"h3 mb-3 fw-bold\" style=\"color: var(--primary-color);\">
                                <i class=\"bi bi-calculator\"></i> APU System
                            </h1>
                            <p class=\"text-muted\">";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.system_description"), "html", null, true);
        yield "</p>
                        </div>

                        ";
        // line 19
        if ((($tmp = (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 19, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 20
            yield "                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i>
                                ";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(CoreExtension::getAttribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 22, $this->source); })()), "messageKey", [], "any", false, false, false, 22), CoreExtension::getAttribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 22, $this->source); })()), "messageData", [], "any", false, false, false, 22), "security"), "html", null, true);
            yield "
                            </div>
                        ";
        }
        // line 25
        yield "
                        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 26, $this->source); })()), "flashes", ["error"], "method", false, false, false, 26));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 27
            yield "                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 28
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        yield "
                        ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 32, $this->source); })()), "flashes", ["success"], "method", false, false, false, 32));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 33
            yield "                            <div class=\"alert alert-success\">
                                <i class=\"bi bi-check-circle-fill\"></i> ";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        yield "
                        <form method=\"post\" action=\"";
        // line 38
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_login");
        yield "\">
                            <div class=\"mb-3\">
                                <label for=\"username\" class=\"form-label\">
                                    <i class=\"bi bi-person\"></i> ";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.email_or_username"), "html", null, true);
        yield "
                                </label>
                                <input
                                    type=\"text\"
                                    class=\"form-control form-control-lg\"
                                    id=\"username\"
                                    name=\"_username\"
                                    value=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new RuntimeError('Variable "last_username" does not exist.', 48, $this->source); })()), "html", null, true);
        yield "\"
                                    required
                                    autofocus
                                    placeholder=\"";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.enter_email_username"), "html", null, true);
        yield "\"
                                >
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password\" class=\"form-label\">
                                    <i class=\"bi bi-lock\"></i> ";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.password"), "html", null, true);
        yield "
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password\"
                                        name=\"_password\"
                                        required
                                        placeholder=\"";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.enter_password"), "html", null, true);
        yield "\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePassword\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"mb-3 form-check\">
                                <input type=\"checkbox\" class=\"form-check-input\" id=\"remember_me\" name=\"_remember_me\">
                                <label class=\"form-check-label\" for=\"remember_me\">
                                    ";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.remember_session"), "html", null, true);
        yield "
                                </label>
                            </div>

                            <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken("authenticate"), "html", null, true);
        yield "\">

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-box-arrow-in-right\"></i> ";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.login"), "html", null, true);
        yield "
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"";
        // line 90
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_forgot");
        yield "\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-question-circle\"></i> ";
        // line 91
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.forgot_password"), "html", null, true);
        yield "
                                </a>
                            </div>
                        </form>

                        <hr class=\"my-4\">

                        <div class=\"text-center text-muted small\">
                            <p class=\"mb-0\">
                                <i class=\"bi bi-shield-check\"></i> ";
        // line 100
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.secure_connection"), "html", null, true);
        yield "
                            </p>
                            <p class=\"mb-0 mt-2\">
                                <i class=\"bi bi-fingerprint\"></i> ";
        // line 103
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.protected_2fa"), "html", null, true);
        yield "
                            </p>
                        </div>
                    </div>
                </div>

                <div class=\"text-center mt-4 text-white\">
                    <p class=\"mb-0\">APU System &copy; ";
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "</p>
                    <p class=\"small\">Multi-Tenant Analysis System v1.0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        // Toggle el tipo de input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Cambiar el ícono
        if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
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
        return "security/login.html.twig";
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
        return array (  283 => 110,  273 => 103,  267 => 100,  255 => 91,  251 => 90,  243 => 85,  236 => 81,  229 => 77,  215 => 66,  203 => 57,  194 => 51,  188 => 48,  178 => 41,  172 => 38,  169 => 37,  160 => 34,  157 => 33,  153 => 32,  150 => 31,  141 => 28,  138 => 27,  134 => 26,  131 => 25,  125 => 22,  121 => 20,  119 => 19,  113 => 16,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}{{ 'auth.login'|trans }} - APU System{% endblock %}

{% block body %}
<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <h1 class=\"h3 mb-3 fw-bold\" style=\"color: var(--primary-color);\">
                                <i class=\"bi bi-calculator\"></i> APU System
                            </h1>
                            <p class=\"text-muted\">{{ 'common.system_description'|trans }}</p>
                        </div>

                        {% if error %}
                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i>
                                {{ error.messageKey|trans(error.messageData, 'security') }}
                            </div>
                        {% endif %}

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

                        <form method=\"post\" action=\"{{ path('app_login') }}\">
                            <div class=\"mb-3\">
                                <label for=\"username\" class=\"form-label\">
                                    <i class=\"bi bi-person\"></i> {{ 'auth.email_or_username'|trans }}
                                </label>
                                <input
                                    type=\"text\"
                                    class=\"form-control form-control-lg\"
                                    id=\"username\"
                                    name=\"_username\"
                                    value=\"{{ last_username }}\"
                                    required
                                    autofocus
                                    placeholder=\"{{ 'auth.enter_email_username'|trans }}\"
                                >
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password\" class=\"form-label\">
                                    <i class=\"bi bi-lock\"></i> {{ 'auth.password'|trans }}
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password\"
                                        name=\"_password\"
                                        required
                                        placeholder=\"{{ 'auth.enter_password'|trans }}\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePassword\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"mb-3 form-check\">
                                <input type=\"checkbox\" class=\"form-check-input\" id=\"remember_me\" name=\"_remember_me\">
                                <label class=\"form-check-label\" for=\"remember_me\">
                                    {{ 'auth.remember_session'|trans }}
                                </label>
                            </div>

                            <input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token('authenticate') }}\">

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-box-arrow-in-right\"></i> {{ 'auth.login'|trans }}
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"{{ path('app_password_forgot') }}\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-question-circle\"></i> {{ 'auth.forgot_password'|trans }}
                                </a>
                            </div>
                        </form>

                        <hr class=\"my-4\">

                        <div class=\"text-center text-muted small\">
                            <p class=\"mb-0\">
                                <i class=\"bi bi-shield-check\"></i> {{ 'auth.secure_connection'|trans }}
                            </p>
                            <p class=\"mb-0 mt-2\">
                                <i class=\"bi bi-fingerprint\"></i> {{ 'auth.protected_2fa'|trans }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class=\"text-center mt-4 text-white\">
                    <p class=\"mb-0\">APU System &copy; {{ 'now'|date('Y') }}</p>
                    <p class=\"small\">Multi-Tenant Analysis System v1.0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        // Toggle el tipo de input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Cambiar el ícono
        if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    });
});
</script>
{% endblock %}
", "security/login.html.twig", "/var/www/html/proyecto/templates/security/login.html.twig");
    }
}
