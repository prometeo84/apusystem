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

/* security/2fa_verify.html.twig */
class __TwigTemplate_f9c96eae32024b59129367fb18f7aca8 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/2fa_verify.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/2fa_verify.html.twig"));

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

        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_title"), "html", null, true);
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
                <div class=\"card mt-5\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <div class=\"bg-primary rounded-circle text-white mx-auto mb-3 d-flex align-items-center justify-content-center\"
                                 style=\"width: 80px; height: 80px; font-size: 2rem;\">
                                <i class=\"bi bi-shield-lock\"></i>
                            </div>
                            <h1 class=\"h3 mb-3 fw-bold\">";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_title"), "html", null, true);
        yield "</h1>
                            <p class=\"text-muted\">";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_description"), "html", null, true);
        yield "</p>
                        </div>

                        ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 21, $this->source); })()), "flashes", ["error"], "method", false, false, false, 21));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 22
            yield "                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        yield "
                        <form method=\"post\">
                            <div class=\"mb-4\">
                                <label for=\"code\" class=\"form-label text-center w-100\">
                                    ";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.enter_code"), "html", null, true);
        yield "
                                </label>
                                <input
                                    type=\"text\"
                                    class=\"form-control form-control-lg text-center\"
                                    id=\"code\"
                                    name=\"code\"
                                    required
                                    autofocus
                                    maxlength=\"6\"
                                    pattern=\"[0-9]{6}\"
                                    placeholder=\"000000\"
                                    style=\"font-size: 2rem; letter-spacing: 0.5rem;\"
                                >
                                <div class=\"form-text text-center\">
                                    ";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.code_from_app"), "html", null, true);
        yield "
                                </div>
                            </div>

                            <div class=\"d-grid gap-2\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-check-circle\"></i> ";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.verify_button"), "html", null, true);
        yield "
                                </button>
                            </div>
                        </form>

                        <hr class=\"my-4\">

                        <div class=\"text-center\">
                            <p class=\"mb-2\">
                                <a href=\"";
        // line 60
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\" class=\"text-decoration-none\">
                                    <i class=\"bi bi-key\"></i> ";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.use_recovery_code"), "html", null, true);
        yield "
                                </a>
                            </p>
                            <p class=\"mb-0\">
                                <a href=\"";
        // line 65
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        yield "\" class=\"text-muted text-decoration-none small\">
                                    <i class=\"bi bi-arrow-left\"></i> ";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.back_to_login"), "html", null, true);
        yield "
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');

    // Auto-submit cuando se ingresan 6 dígitos
    codeInput.addEventListener('input', function() {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');

        // Auto-submit cuando se completan 6 dígitos
        if (this.value.length === 6) {
            this.form.submit();
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
        return "security/2fa_verify.html.twig";
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
        return array (  200 => 66,  196 => 65,  189 => 61,  185 => 60,  173 => 51,  164 => 45,  146 => 30,  140 => 26,  131 => 23,  128 => 22,  124 => 21,  118 => 18,  114 => 17,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}{{ 'security_2fa.verify_title'|trans }} - APU System{% endblock %}

{% block body %}
<div class=\"main-content\">
    <div class=\"container\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-5\">
                <div class=\"card mt-5\">
                    <div class=\"card-body p-5\">
                        <div class=\"text-center mb-4\">
                            <div class=\"bg-primary rounded-circle text-white mx-auto mb-3 d-flex align-items-center justify-content-center\"
                                 style=\"width: 80px; height: 80px; font-size: 2rem;\">
                                <i class=\"bi bi-shield-lock\"></i>
                            </div>
                            <h1 class=\"h3 mb-3 fw-bold\">{{ 'security_2fa.verify_title'|trans }}</h1>
                            <p class=\"text-muted\">{{ 'security_2fa.verify_description'|trans }}</p>
                        </div>

                        {% for message in app.flashes('error') %}
                            <div class=\"alert alert-danger\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                            </div>
                        {% endfor %}

                        <form method=\"post\">
                            <div class=\"mb-4\">
                                <label for=\"code\" class=\"form-label text-center w-100\">
                                    {{ 'security_2fa.enter_code'|trans }}
                                </label>
                                <input
                                    type=\"text\"
                                    class=\"form-control form-control-lg text-center\"
                                    id=\"code\"
                                    name=\"code\"
                                    required
                                    autofocus
                                    maxlength=\"6\"
                                    pattern=\"[0-9]{6}\"
                                    placeholder=\"000000\"
                                    style=\"font-size: 2rem; letter-spacing: 0.5rem;\"
                                >
                                <div class=\"form-text text-center\">
                                    {{ 'security_2fa.code_from_app'|trans }}
                                </div>
                            </div>

                            <div class=\"d-grid gap-2\">
                                <button type=\"submit\" class=\"btn btn-primary btn-lg\">
                                    <i class=\"bi bi-check-circle\"></i> {{ 'security_2fa.verify_button'|trans }}
                                </button>
                            </div>
                        </form>

                        <hr class=\"my-4\">

                        <div class=\"text-center\">
                            <p class=\"mb-2\">
                                <a href=\"{{ path('app_security') }}\" class=\"text-decoration-none\">
                                    <i class=\"bi bi-key\"></i> {{ 'security_2fa.use_recovery_code'|trans }}
                                </a>
                            </p>
                            <p class=\"mb-0\">
                                <a href=\"{{ path('app_logout') }}\" class=\"text-muted text-decoration-none small\">
                                    <i class=\"bi bi-arrow-left\"></i> {{ 'buttons.back_to_login'|trans }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');

    // Auto-submit cuando se ingresan 6 dígitos
    codeInput.addEventListener('input', function() {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');

        // Auto-submit cuando se completan 6 dígitos
        if (this.value.length === 6) {
            this.form.submit();
        }
    });
});
</script>
{% endblock %}
", "security/2fa_verify.html.twig", "/var/www/html/proyecto/templates/security/2fa_verify.html.twig");
    }
}
