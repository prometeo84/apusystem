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

/* @Maker/webhook/WebhookConsumer.tpl.php */
class __TwigTemplate_a919b0464d280780ed581484b5ce3ae5 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/webhook/WebhookConsumer.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/webhook/WebhookConsumer.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

use Symfony\\Component\\RemoteEvent\\Attribute\\AsRemoteEventConsumer;
use Symfony\\Component\\RemoteEvent\\Consumer\\ConsumerInterface;
use Symfony\\Component\\RemoteEvent\\RemoteEvent;

#[AsRemoteEventConsumer('<?= \$webhook_name ?>')]
final class <?= \$class_name ?> implements ConsumerInterface
{
    public function __construct()
    {
    }

    public function consume(RemoteEvent \$event): void
    {
        // Implement your own logic here
    }
}
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
        return "@Maker/webhook/WebhookConsumer.tpl.php";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

use Symfony\\Component\\RemoteEvent\\Attribute\\AsRemoteEventConsumer;
use Symfony\\Component\\RemoteEvent\\Consumer\\ConsumerInterface;
use Symfony\\Component\\RemoteEvent\\RemoteEvent;

#[AsRemoteEventConsumer('<?= \$webhook_name ?>')]
final class <?= \$class_name ?> implements ConsumerInterface
{
    public function __construct()
    {
    }

    public function consume(RemoteEvent \$event): void
    {
        // Implement your own logic here
    }
}
", "@Maker/webhook/WebhookConsumer.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/webhook/WebhookConsumer.tpl.php");
    }
}
