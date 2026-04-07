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

/* emails/password_reset.html.twig */
class __TwigTemplate_1b9e83466f751033113d0238ec8604d7 extends Template
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
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "emails/password_reset.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "emails/password_reset.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"es\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .content p {
            color: #333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .button:hover {
            opacity: 0.9;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🔐 APU System</h1>
            <p style=\"margin: 10px 0 0 0;\">Restablecimiento de Contraseña</p>
        </div>

        <div class=\"content\">
            <p>Hola <strong>";
        // line 83
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 83, $this->source); })()), "firstName", [], "any", false, false, false, 83), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 83, $this->source); })()), "lastName", [], "any", false, false, false, 83), "html", null, true);
        yield "</strong>,</p>

            <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en APU System.</p>

            <p>Para crear una nueva contraseña, haz clic en el siguiente botón:</p>

            <div style=\"text-align: center;\">
                <a href=\"";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["resetUrl"]) || array_key_exists("resetUrl", $context) ? $context["resetUrl"] : (function () { throw new RuntimeError('Variable "resetUrl" does not exist.', 90, $this->source); })()), "html", null, true);
        yield "\" class=\"button\">
                    Restablecer Contraseña
                </a>
            </div>

            <div class=\"info-box\">
                <strong>📧 También puedes copiar y pegar este enlace en tu navegador:</strong><br>
                <a href=\"";
        // line 97
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["resetUrl"]) || array_key_exists("resetUrl", $context) ? $context["resetUrl"] : (function () { throw new RuntimeError('Variable "resetUrl" does not exist.', 97, $this->source); })()), "html", null, true);
        yield "\" style=\"color: #667eea; word-break: break-all;\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["resetUrl"]) || array_key_exists("resetUrl", $context) ? $context["resetUrl"] : (function () { throw new RuntimeError('Variable "resetUrl" does not exist.', 97, $this->source); })()), "html", null, true);
        yield "</a>
            </div>

            <div class=\"warning\">
                <strong>⏰ Importante:</strong><br>
                Este enlace expirará el <strong>";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate((isset($context["expiresAt"]) || array_key_exists("expiresAt", $context) ? $context["expiresAt"] : (function () { throw new RuntimeError('Variable "expiresAt" does not exist.', 102, $this->source); })()), "d/m/Y H:i"), "html", null, true);
        yield "</strong> (zona horaria: America/Guayaquil).<br>
                Si no solicitaste este cambio, puedes ignorar este correo.
            </div>

            <p>Si no solicitaste restablecer tu contraseña, por favor ignora este correo. Tu cuenta permanece segura.</p>

            <hr style=\"border: none; border-top: 1px solid #eee; margin: 30px 0;\">

            <p style=\"font-size: 12px; color: #666;\">
                <strong>Consejos de seguridad:</strong><br>
                • Nunca compartas tu contraseña con nadie<br>
                • Usa una contraseña única para esta cuenta<br>
                • Habilita la autenticación de dos factores (2FA) para mayor seguridad
            </p>
        </div>

        <div class=\"footer\">
            <p><strong>APU System</strong> - Sistema de Análisis de Precios Unitarios</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>© ";
        // line 121
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " APU System. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "emails/password_reset.html.twig";
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
        return array (  186 => 121,  164 => 102,  154 => 97,  144 => 90,  132 => 83,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"es\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .content p {
            color: #333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .button:hover {
            opacity: 0.9;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🔐 APU System</h1>
            <p style=\"margin: 10px 0 0 0;\">Restablecimiento de Contraseña</p>
        </div>

        <div class=\"content\">
            <p>Hola <strong>{{ user.firstName }} {{ user.lastName }}</strong>,</p>

            <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en APU System.</p>

            <p>Para crear una nueva contraseña, haz clic en el siguiente botón:</p>

            <div style=\"text-align: center;\">
                <a href=\"{{ resetUrl }}\" class=\"button\">
                    Restablecer Contraseña
                </a>
            </div>

            <div class=\"info-box\">
                <strong>📧 También puedes copiar y pegar este enlace en tu navegador:</strong><br>
                <a href=\"{{ resetUrl }}\" style=\"color: #667eea; word-break: break-all;\">{{ resetUrl }}</a>
            </div>

            <div class=\"warning\">
                <strong>⏰ Importante:</strong><br>
                Este enlace expirará el <strong>{{ expiresAt|date('d/m/Y H:i') }}</strong> (zona horaria: America/Guayaquil).<br>
                Si no solicitaste este cambio, puedes ignorar este correo.
            </div>

            <p>Si no solicitaste restablecer tu contraseña, por favor ignora este correo. Tu cuenta permanece segura.</p>

            <hr style=\"border: none; border-top: 1px solid #eee; margin: 30px 0;\">

            <p style=\"font-size: 12px; color: #666;\">
                <strong>Consejos de seguridad:</strong><br>
                • Nunca compartas tu contraseña con nadie<br>
                • Usa una contraseña única para esta cuenta<br>
                • Habilita la autenticación de dos factores (2FA) para mayor seguridad
            </p>
        </div>

        <div class=\"footer\">
            <p><strong>APU System</strong> - Sistema de Análisis de Precios Unitarios</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>© {{ 'now'|date('Y') }} APU System. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
", "emails/password_reset.html.twig", "/var/www/html/proyecto/templates/emails/password_reset.html.twig");
    }
}
