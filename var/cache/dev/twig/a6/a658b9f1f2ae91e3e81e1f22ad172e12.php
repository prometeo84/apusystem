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

/* test/mail.html.twig */
class __TwigTemplate_8aa5f587fd223cfbd2c2f061062b05bf extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "test/mail.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "test/mail.html.twig"));

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

        yield "Test de Email - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-envelope\"></i> ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.test_email"), "html", null, true);
        yield "</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"alert alert-warning\">
                        <h6><i class=\"bi bi-exclamation-triangle\"></i> Importante para Pruebas</h6>
                        <p class=\"mb-0\">
                            <strong>Debes usar un correo que EXISTA en la base de datos.</strong>
                            Por seguridad, el sistema no avisa si el correo no existe.
                        </p>
                    </div>

                    <h6><i class=\"bi bi-envelope-check\"></i> Correos Válidos para Prueba:</h6>
                    <ul class=\"list-group mb-3\">
                        <li class=\"list-group-item\">
                            <code>admin@demo.com</code> - Super Admin
                        </li>
                        <li class=\"list-group-item\">
                            <code>admin@abc.com</code> - Administrador ABC
                        </li>
                        <li class=\"list-group-item\">
                            <code>user@abc.com</code> - Usuario ABC
                        </li>
                    </ul>

                    <p>";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.description"), "html", null, true);
        yield ":</p>

                    <div class=\"alert alert-info\">
                        <h6><i class=\"bi bi-info-circle\"></i> ";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.steps_to_test"), "html", null, true);
        yield ":</h6>
                        <ol>
                            <li>";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.goto_recovery"), "html", null, true);
        yield " <a href=\"";
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_forgot");
        yield "\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.recovery_link"), "html", null, true);
        yield "</a></li>
                            <li>";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.enter_email"), "html", null, true);
        yield "</li>
                            <li>";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.send_reset_link"), "html", null, true);
        yield "</li>
                            <li>";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.check_mailpit"), "html", null, true);
        yield ": <a href=\"http://localhost:8025\" target=\"_blank\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.mailpit_url"), "html", null, true);
        yield "</a></li>
                            <li>";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test.verify_email_and_link"), "html", null, true);
        yield "</li>
                        </ol>
                    </div>

                    <div class=\"btn-group\" role=\"group\">
                        <a href=\"";
        // line 53
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_password_forgot");
        yield "\" class=\"btn btn-primary\">
                            <i class=\"bi bi-envelope\"></i> ";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("test_mail.goto_password_recovery"), "html", null, true);
        yield "
                        </a>
                        <a href=\"http://localhost:8025\" target=\"_blank\" class=\"btn btn-outline-primary\">
                            <i class=\"bi bi-mailbox\"></i> Abrir Mailpit
                        </a>
                        <a href=\"";
        // line 59
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_test_logs");
        yield "\" class=\"btn btn-outline-secondary\">
                            <i class=\"bi bi-file-text\"></i> Probar Logs
                        </a>
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
        return "test/mail.html.twig";
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
        return array (  197 => 59,  189 => 54,  185 => 53,  177 => 48,  171 => 47,  167 => 46,  163 => 45,  155 => 44,  150 => 42,  144 => 39,  117 => 15,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Test de Email - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'test_mail.title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-envelope\"></i> {{ 'test.test_email'|trans }}</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"alert alert-warning\">
                        <h6><i class=\"bi bi-exclamation-triangle\"></i> Importante para Pruebas</h6>
                        <p class=\"mb-0\">
                            <strong>Debes usar un correo que EXISTA en la base de datos.</strong>
                            Por seguridad, el sistema no avisa si el correo no existe.
                        </p>
                    </div>

                    <h6><i class=\"bi bi-envelope-check\"></i> Correos Válidos para Prueba:</h6>
                    <ul class=\"list-group mb-3\">
                        <li class=\"list-group-item\">
                            <code>admin@demo.com</code> - Super Admin
                        </li>
                        <li class=\"list-group-item\">
                            <code>admin@abc.com</code> - Administrador ABC
                        </li>
                        <li class=\"list-group-item\">
                            <code>user@abc.com</code> - Usuario ABC
                        </li>
                    </ul>

                    <p>{{ 'test_mail.description'|trans }}:</p>

                    <div class=\"alert alert-info\">
                        <h6><i class=\"bi bi-info-circle\"></i> {{ 'test.steps_to_test'|trans }}:</h6>
                        <ol>
                            <li>{{ 'test_mail.goto_recovery'|trans }} <a href=\"{{ path('app_password_forgot') }}\">{{ 'test_mail.recovery_link'|trans }}</a></li>
                            <li>{{ 'test_mail.enter_email'|trans }}</li>
                            <li>{{ 'test.send_reset_link'|trans }}</li>
                            <li>{{ 'test_mail.check_mailpit'|trans }}: <a href=\"http://localhost:8025\" target=\"_blank\">{{ 'test_mail.mailpit_url'|trans }}</a></li>
                            <li>{{ 'test.verify_email_and_link'|trans }}</li>
                        </ol>
                    </div>

                    <div class=\"btn-group\" role=\"group\">
                        <a href=\"{{ path('app_password_forgot') }}\" class=\"btn btn-primary\">
                            <i class=\"bi bi-envelope\"></i> {{ 'test_mail.goto_password_recovery'|trans }}
                        </a>
                        <a href=\"http://localhost:8025\" target=\"_blank\" class=\"btn btn-outline-primary\">
                            <i class=\"bi bi-mailbox\"></i> Abrir Mailpit
                        </a>
                        <a href=\"{{ path('app_test_logs') }}\" class=\"btn btn-outline-secondary\">
                            <i class=\"bi bi-file-text\"></i> Probar Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "test/mail.html.twig", "/var/www/html/proyecto/templates/test/mail.html.twig");
    }
}
