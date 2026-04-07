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

/* password/reset.html.twig */
class __TwigTemplate_431d59825a1ca3222a7149f6b8a8fd55 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "password/reset.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "password/reset.html.twig"));

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

        yield "Restablecer Contraseña - APU System";
        
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
                                <i class=\"bi bi-shield-lock\"></i> ";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.reset_title"), "html", null, true);
        yield "
                            </h1>
                            <p class=\"text-muted\">";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.reset_description"), "html", null, true);
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
                        <form method=\"post\" action=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_reset", ["token" => (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 25, $this->source); })())]), "html", null, true);
        yield "\">
                            <div class=\"alert alert-info mb-3\">
                                <strong>Requisitos de la contraseña:</strong>
                                <ul class=\"mb-0 mt-2\">
                                    <li>Mínimo 8 caracteres</li>
                                    <li>Se recomienda usar letras, números y símbolos</li>
                                </ul>
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password\" class=\"form-label\">
                                    <i class=\"bi bi-lock\"></i> ";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.new_password"), "html", null, true);
        yield "
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password\"
                                        name=\"password\"
                                        required
                                        minlength=\"8\"
                                        placeholder=\"Ingrese su nueva contraseña\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePassword\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password_confirm\" class=\"form-label\">
                                    <i class=\"bi bi-lock-fill\"></i> ";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.confirm_new_password"), "html", null, true);
        yield "
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password_confirm\"
                                        name=\"password_confirm\"
                                        required
                                        minlength=\"8\"
                                        placeholder=\"Confirme su nueva contraseña\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePasswordConfirm\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon2\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-check-circle\"></i> ";
        // line 76
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.reset_button"), "html", null, true);
        yield "
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"";
        // line 81
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_login");
        yield "\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-arrow-left\"></i> Volver al Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class=\"text-center mt-4 text-white\">
                    <p class=\"mb-0\">APU System &copy; ";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    });

    // Toggle para password confirm
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirm');
    const toggleIcon2 = document.getElementById('toggleIcon2');

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);

        if (type === 'text') {
            toggleIcon2.classList.remove('bi-eye');
            toggleIcon2.classList.add('bi-eye-slash');
        } else {
            toggleIcon2.classList.remove('bi-eye-slash');
            toggleIcon2.classList.add('bi-eye');
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
        return "password/reset.html.twig";
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
        return array (  220 => 90,  208 => 81,  200 => 76,  177 => 56,  154 => 36,  140 => 25,  137 => 24,  128 => 21,  125 => 20,  121 => 19,  115 => 16,  110 => 14,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Restablecer Contraseña - APU System{% endblock %}

{% block body %}
<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <h1 class=\"h3 mb-3 fw-bold\" style=\"color: var(--primary-color);\">
                                <i class=\"bi bi-shield-lock\"></i> {{ 'password.reset_title'|trans }}
                            </h1>
                            <p class=\"text-muted\">{{ 'password.reset_description'|trans }}</p>
                        </div>

                        {% for message in app.flashes('error') %}
                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                            </div>
                        {% endfor %}

                        <form method=\"post\" action=\"{{ path('app_password_reset', {token: token}) }}\">
                            <div class=\"alert alert-info mb-3\">
                                <strong>Requisitos de la contraseña:</strong>
                                <ul class=\"mb-0 mt-2\">
                                    <li>Mínimo 8 caracteres</li>
                                    <li>Se recomienda usar letras, números y símbolos</li>
                                </ul>
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password\" class=\"form-label\">
                                    <i class=\"bi bi-lock\"></i> {{ 'password.new_password'|trans }}
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password\"
                                        name=\"password\"
                                        required
                                        minlength=\"8\"
                                        placeholder=\"Ingrese su nueva contraseña\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePassword\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"password_confirm\" class=\"form-label\">
                                    <i class=\"bi bi-lock-fill\"></i> {{ 'password.confirm_new_password'|trans }}
                                </label>
                                <div class=\"input-group\">
                                    <input
                                        type=\"password\"
                                        class=\"form-control form-control-lg\"
                                        id=\"password_confirm\"
                                        name=\"password_confirm\"
                                        required
                                        minlength=\"8\"
                                        placeholder=\"Confirme su nueva contraseña\"
                                    >
                                    <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"togglePasswordConfirm\">
                                        <i class=\"bi bi-eye\" id=\"toggleIcon2\"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=\"d-grid gap-2 mb-3\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-check-circle\"></i> {{ 'password.reset_button'|trans }}
                                </button>
                            </div>

                            <div class=\"text-center\">
                                <a href=\"{{ path('app_login') }}\" class=\"text-decoration-none\" style=\"color: var(--primary-color);\">
                                    <i class=\"bi bi-arrow-left\"></i> Volver al Login
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    });

    // Toggle para password confirm
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirm');
    const toggleIcon2 = document.getElementById('toggleIcon2');

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);

        if (type === 'text') {
            toggleIcon2.classList.remove('bi-eye');
            toggleIcon2.classList.add('bi-eye-slash');
        } else {
            toggleIcon2.classList.remove('bi-eye-slash');
            toggleIcon2.classList.add('bi-eye');
        }
    });
});
</script>
{% endblock %}
", "password/reset.html.twig", "/var/www/html/proyecto/templates/password/reset.html.twig");
    }
}
