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

/* security/recovery_codes.html.twig */
class __TwigTemplate_e9998aac8faa67cb5e682e83700c5603 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/recovery_codes.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/recovery_codes.html.twig"));

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

        yield "Códigos de Recuperación - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.recovery_codes_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-key-fill\"></i> ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.recovery_codes_title"), "html", null, true);
        yield "
                            </h4>

                            <div class=\"alert alert-warning\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i>
                                <strong>";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.important"), "html", null, true);
        yield ":</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.save_important"), "html", null, true);
        yield ".
                                ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.one_time_use"), "html", null, true);
        yield ". ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.use_if_lost"), "html", null, true);
        yield ".
                            </div>

                            <div class=\"card bg-light mb-4\">
                                <div class=\"card-body\">
                                    <div class=\"row\" id=\"recoveryCodes\">
                                        ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recoveryCodes"]) || array_key_exists("recoveryCodes", $context) ? $context["recoveryCodes"] : (function () { throw new RuntimeError('Variable "recoveryCodes" does not exist.', 30, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["code"]) {
            // line 31
            yield "                                            <div class=\"col-md-6 mb-2\">
                                                <code class=\"d-block p-2 bg-white rounded text-center\" style=\"font-size: 1.1rem; letter-spacing: 0.1em;\">
                                                    ";
            // line 33
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["code"], "html", null, true);
            yield "
                                                </code>
                                            </div>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['code'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        yield "                                    </div>
                                </div>
                            </div>

                            <div class=\"d-flex gap-2 justify-content-center mb-4\">
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"printCodes()\">
                                    <i class=\"bi bi-printer\"></i> ";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.print_codes"), "html", null, true);
        yield "
                                </button>
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"downloadCodes()\">
                                    <i class=\"bi bi-download\"></i> ";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.download_codes"), "html", null, true);
        yield "
                                </button>
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"copyCodes()\">
                                    <i class=\"bi bi-clipboard\"></i> ";
        // line 49
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.copy_codes"), "html", null, true);
        yield "
                                </button>
                            </div>

                            <div class=\"alert alert-info\">
                                <h6><i class=\"bi bi-info-circle\"></i> ";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.how_to_use"), "html", null, true);
        yield "</h6>
                                <ol class=\"mb-0\">
                                    <li>";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.if_lose_device"), "html", null, true);
        yield "</li>
                                    <li>";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.use_recovery_click"), "html", null, true);
        yield "</li>
                                    <li>";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.enter_code"), "html", null, true);
        yield "</li>
                                    <li>";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.code_invalidated"), "html", null, true);
        yield "</li>
                                </ol>
                            </div>

                            <form method=\"post\" class=\"text-center\" onsubmit=\"return confirm('";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.regenerate_confirm"), "html", null, true);
        yield "')\">
                                <button type=\"submit\" class=\"btn btn-warning\">
                                    <i class=\"bi bi-arrow-clockwise\"></i> ";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security_2fa.regenerate_button"), "html", null, true);
        yield "
                                </button>
                            </form>

                            <div class=\"text-center mt-3\">
                                <a href=\"";
        // line 70
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-arrow-left\"></i> Volver a Seguridad
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printCodes() {
    window.print();
}

function downloadCodes() {
    const codes = document.querySelectorAll('#recoveryCodes code');
    let text = 'APU System - Códigos de Recuperación\\n\\n';
    text += 'Generado: ' + new Date().toLocaleString() + '\\n\\n';
    codes.forEach((code, index) => {
        text += (index + 1) + '. ' + code.textContent.trim() + '\\n';
    });
    text += '\\n⚠️ Guarda estos códigos en un lugar seguro.\\n';
    text += 'Cada código solo se puede usar una vez.\\n';

    const blob = new Blob([text], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'recovery-codes-' + Date.now() + '.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function copyCodes() {
    const codes = document.querySelectorAll('#recoveryCodes code');
    let text = '';
    codes.forEach(code => {
        text += code.textContent.trim() + '\\n';
    });

    navigator.clipboard.writeText(text).then(() => {
        alert('Códigos copiados al portapapeles');
    }).catch(err => {
        console.error('Error al copiar:', err);
    });
}
</script>

<style>
@media print {
    .sidebar, .navbar, .btn, .alert { display: none !important; }
    .card { border: none; box-shadow: none; }
}
</style>
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
        return "security/recovery_codes.html.twig";
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
        return array (  228 => 70,  220 => 65,  215 => 63,  208 => 59,  204 => 58,  200 => 57,  196 => 56,  191 => 54,  183 => 49,  177 => 46,  171 => 43,  163 => 37,  153 => 33,  149 => 31,  145 => 30,  134 => 24,  128 => 23,  120 => 18,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Códigos de Recuperación - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'security_2fa.recovery_codes_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-key-fill\"></i> {{ 'security_2fa.recovery_codes_title'|trans }}
                            </h4>

                            <div class=\"alert alert-warning\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i>
                                <strong>{{ 'common.important'|trans }}:</strong> {{ 'security_2fa.save_important'|trans }}.
                                {{ 'security_2fa.one_time_use'|trans }}. {{ 'security_2fa.use_if_lost'|trans }}.
                            </div>

                            <div class=\"card bg-light mb-4\">
                                <div class=\"card-body\">
                                    <div class=\"row\" id=\"recoveryCodes\">
                                        {% for code in recoveryCodes %}
                                            <div class=\"col-md-6 mb-2\">
                                                <code class=\"d-block p-2 bg-white rounded text-center\" style=\"font-size: 1.1rem; letter-spacing: 0.1em;\">
                                                    {{ code }}
                                                </code>
                                            </div>
                                        {% endfor %}
                                    </div>
                                </div>
                            </div>

                            <div class=\"d-flex gap-2 justify-content-center mb-4\">
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"printCodes()\">
                                    <i class=\"bi bi-printer\"></i> {{ 'security_2fa.print_codes'|trans }}
                                </button>
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"downloadCodes()\">
                                    <i class=\"bi bi-download\"></i> {{ 'security_2fa.download_codes'|trans }}
                                </button>
                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"copyCodes()\">
                                    <i class=\"bi bi-clipboard\"></i> {{ 'security_2fa.copy_codes'|trans }}
                                </button>
                            </div>

                            <div class=\"alert alert-info\">
                                <h6><i class=\"bi bi-info-circle\"></i> {{ 'security_2fa.how_to_use'|trans }}</h6>
                                <ol class=\"mb-0\">
                                    <li>{{ 'security.if_lose_device'|trans }}</li>
                                    <li>{{ 'security_2fa.use_recovery_click'|trans }}</li>
                                    <li>{{ 'security_2fa.enter_code'|trans }}</li>
                                    <li>{{ 'security_2fa.code_invalidated'|trans }}</li>
                                </ol>
                            </div>

                            <form method=\"post\" class=\"text-center\" onsubmit=\"return confirm('{{ 'security_2fa.regenerate_confirm'|trans }}')\">
                                <button type=\"submit\" class=\"btn btn-warning\">
                                    <i class=\"bi bi-arrow-clockwise\"></i> {{ 'security_2fa.regenerate_button'|trans }}
                                </button>
                            </form>

                            <div class=\"text-center mt-3\">
                                <a href=\"{{ path('app_security') }}\" class=\"btn btn-outline-secondary\">
                                    <i class=\"bi bi-arrow-left\"></i> Volver a Seguridad
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printCodes() {
    window.print();
}

function downloadCodes() {
    const codes = document.querySelectorAll('#recoveryCodes code');
    let text = 'APU System - Códigos de Recuperación\\n\\n';
    text += 'Generado: ' + new Date().toLocaleString() + '\\n\\n';
    codes.forEach((code, index) => {
        text += (index + 1) + '. ' + code.textContent.trim() + '\\n';
    });
    text += '\\n⚠️ Guarda estos códigos en un lugar seguro.\\n';
    text += 'Cada código solo se puede usar una vez.\\n';

    const blob = new Blob([text], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'recovery-codes-' + Date.now() + '.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function copyCodes() {
    const codes = document.querySelectorAll('#recoveryCodes code');
    let text = '';
    codes.forEach(code => {
        text += code.textContent.trim() + '\\n';
    });

    navigator.clipboard.writeText(text).then(() => {
        alert('Códigos copiados al portapapeles');
    }).catch(err => {
        console.error('Error al copiar:', err);
    });
}
</script>

<style>
@media print {
    .sidebar, .navbar, .btn, .alert { display: none !important; }
    .card { border: none; box-shadow: none; }
}
</style>
{% endblock %}
", "security/recovery_codes.html.twig", "/var/www/html/proyecto/templates/security/recovery_codes.html.twig");
    }
}
