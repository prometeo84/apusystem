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

/* base.html.twig */
class __TwigTemplate_41d80ecc4b178f95e9f28778aadff37d extends Template
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

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"";
        // line 2
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 2, $this->source); })()), "request", [], "any", false, false, false, 2), "locale", [], "any", false, false, false, 2), "html", null, true);
        yield "\" data-theme=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["user_theme"] ?? null), "mode", [], "any", true, true, false, 2)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user_theme"]) || array_key_exists("user_theme", $context) ? $context["user_theme"] : (function () { throw new RuntimeError('Variable "user_theme" does not exist.', 2, $this->source); })()), "mode", [], "any", false, false, false, 2), "light")) : ("light")), "html", null, true);
        yield "\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    <link rel=\"icon\" href=\"/favicon.ico\">
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\"
          integrity=\"sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM\"
          crossorigin=\"anonymous\">
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css\"
          crossorigin=\"anonymous\">
    <style>
        :root {
            --primary-color: ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["user_theme"] ?? null), "primary_color", [], "any", true, true, false, 15)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user_theme"]) || array_key_exists("user_theme", $context) ? $context["user_theme"] : (function () { throw new RuntimeError('Variable "user_theme" does not exist.', 15, $this->source); })()), "primary_color", [], "any", false, false, false, 15), "#667eea")) : ("#667eea")), "html", null, true);
        yield ";
            --secondary-color: ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["user_theme"] ?? null), "secondary_color", [], "any", true, true, false, 16)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user_theme"]) || array_key_exists("user_theme", $context) ? $context["user_theme"] : (function () { throw new RuntimeError('Variable "user_theme" does not exist.', 16, $this->source); })()), "secondary_color", [], "any", false, false, false, 16), "#764ba2")) : ("#764ba2")), "html", null, true);
        yield ";
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        /* Estilos Base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Modo Oscuro */
        html[data-theme=\"dark\"] body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .card {
            background-color: #2d2d2d;
            color: #e0e0e0;
            border: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .sidebar {
            background: #2d2d2d !important;
            border-right: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .sidebar .nav-link {
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .navbar {
            background: #2d2d2d !important;
            border-bottom: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .form-control,
        html[data-theme=\"dark\"] .form-select {
            background-color: #3d3d3d;
            color: #e0e0e0;
            border-color: #505050;
        }

        html[data-theme=\"dark\"] .table {
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .table-hover tbody tr:hover {
            background-color: #3d3d3d;
        }

        html[data-theme=\"dark\"] .modal-content {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .text-muted {
            color: #aaa !important;
        }

        html[data-theme=\"dark\"] .container-fluid {
            background: #1a1a2e !important;
        }

        html[data-theme=\"dark\"] .bg-white {
            background-color: #2d2d2d !important;
        }

        html[data-theme=\"dark\"] .alert-success {
            background-color: #1a4d2e;
            border-color: #2d7a4f;
            color: #90ee90;
        }

        html[data-theme=\"dark\"] .badge {
            filter: brightness(0.8);
        }

        /* Estilos para contenido principal */
        .content-wrapper {
            background: #f5f5f5;
            min-height: calc(100vh - 56px);
            padding: 1.5rem;
        }

        html[data-theme=\"dark\"] .content-wrapper {
            background: #1a1a2e !important;
        }

        /* Headers de cards */
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        html[data-theme=\"dark\"] .card-header {
            background-color: #2d2d2d !important;
            border-bottom: 1px solid #404040 !important;
            color: #e0e0e0;
        }

        /* Botones con colores personalizados */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border: none !important;
            color: white !important;
            padding: 12px 30px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        .text-primary,
        a {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        /* Cards */
        .main-content {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Navbar y Sidebar */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar {
            min-height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white !important;
        }

        html[data-theme=\"dark\"] .sidebar .nav-link:hover,
        html[data-theme=\"dark\"] .sidebar .nav-link.active {
            color: white !important;
        }
    </style>
    ";
        // line 208
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 209
        yield "</head>
<body>
    ";
        // line 211
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 212
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"
            integrity=\"sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz\"
            crossorigin=\"anonymous\"></script>

    ";
        // line 218
        yield "    <script>
        (function() {
            const html = document.documentElement;
            const currentMode = html.getAttribute('data-theme');

            if (currentMode === 'auto') {
                // Detectar preferencia del sistema
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');

                // Escuchar cambios en el tema del sistema
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (html.getAttribute('data-theme') === 'auto') {
                        html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    }
                });
            }
        })();
    </script>

    ";
        // line 238
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 239
        yield "</body>
</html>
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
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

        yield "APU System";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 208
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 211
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

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 238
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
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
        return array (  394 => 238,  372 => 211,  350 => 208,  327 => 6,  314 => 239,  312 => 238,  290 => 218,  283 => 212,  281 => 211,  277 => 209,  275 => 208,  80 => 16,  76 => 15,  64 => 6,  55 => 2,  52 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"{{ app.request.locale }}\" data-theme=\"{{ user_theme.mode|default('light') }}\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{% block title %}APU System{% endblock %}</title>
    <link rel=\"icon\" href=\"/favicon.ico\">
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\"
          integrity=\"sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM\"
          crossorigin=\"anonymous\">
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css\"
          crossorigin=\"anonymous\">
    <style>
        :root {
            --primary-color: {{ user_theme.primary_color|default('#667eea') }};
            --secondary-color: {{ user_theme.secondary_color|default('#764ba2') }};
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        /* Estilos Base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Modo Oscuro */
        html[data-theme=\"dark\"] body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .card {
            background-color: #2d2d2d;
            color: #e0e0e0;
            border: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .sidebar {
            background: #2d2d2d !important;
            border-right: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .sidebar .nav-link {
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .navbar {
            background: #2d2d2d !important;
            border-bottom: 1px solid #404040;
        }

        html[data-theme=\"dark\"] .form-control,
        html[data-theme=\"dark\"] .form-select {
            background-color: #3d3d3d;
            color: #e0e0e0;
            border-color: #505050;
        }

        html[data-theme=\"dark\"] .table {
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .table-hover tbody tr:hover {
            background-color: #3d3d3d;
        }

        html[data-theme=\"dark\"] .modal-content {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }

        html[data-theme=\"dark\"] .text-muted {
            color: #aaa !important;
        }

        html[data-theme=\"dark\"] .container-fluid {
            background: #1a1a2e !important;
        }

        html[data-theme=\"dark\"] .bg-white {
            background-color: #2d2d2d !important;
        }

        html[data-theme=\"dark\"] .alert-success {
            background-color: #1a4d2e;
            border-color: #2d7a4f;
            color: #90ee90;
        }

        html[data-theme=\"dark\"] .badge {
            filter: brightness(0.8);
        }

        /* Estilos para contenido principal */
        .content-wrapper {
            background: #f5f5f5;
            min-height: calc(100vh - 56px);
            padding: 1.5rem;
        }

        html[data-theme=\"dark\"] .content-wrapper {
            background: #1a1a2e !important;
        }

        /* Headers de cards */
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        html[data-theme=\"dark\"] .card-header {
            background-color: #2d2d2d !important;
            border-bottom: 1px solid #404040 !important;
            color: #e0e0e0;
        }

        /* Botones con colores personalizados */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border: none !important;
            color: white !important;
            padding: 12px 30px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        .text-primary,
        a {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        /* Cards */
        .main-content {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Navbar y Sidebar */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar {
            min-height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white !important;
        }

        html[data-theme=\"dark\"] .sidebar .nav-link:hover,
        html[data-theme=\"dark\"] .sidebar .nav-link.active {
            color: white !important;
        }
    </style>
    {% block stylesheets %}{% endblock %}
</head>
<body>
    {% block body %}{% endblock %}

    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"
            integrity=\"sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz\"
            crossorigin=\"anonymous\"></script>

    {# Script para modo automático #}
    <script>
        (function() {
            const html = document.documentElement;
            const currentMode = html.getAttribute('data-theme');

            if (currentMode === 'auto') {
                // Detectar preferencia del sistema
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');

                // Escuchar cambios en el tema del sistema
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (html.getAttribute('data-theme') === 'auto') {
                        html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    }
                });
            }
        })();
    </script>

    {% block javascripts %}{% endblock %}
</body>
</html>
", "base.html.twig", "/var/www/html/proyecto/templates/base.html.twig");
    }
}
