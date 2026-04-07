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

/* @Maker/test/Functional.tpl.php */
class __TwigTemplate_beb64e99109e5c4d710dd25a52463ff4 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/test/Functional.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/test/Functional.tpl.php"));

        // line 1
        yield "<?php /* @deprecated remove this method when removing make:unit-test and make:functional-test */ ?>
<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements ?>

class <?= \$class_name ?> extends <?= \$panther_is_available ? 'PantherTestCase' : 'WebTestCase' ?><?= \"\\n\" ?>
{
    public function testSomething(): void
    {
<?php if (\$panther_is_available): ?>
        \$client = static::createPantherClient();
<?php else: ?>
        \$client = static::createClient();
<?php endif ?>
        \$crawler = \$client->request('GET', '/');

<?php if (\$web_assertions_are_available): ?>
<?php if (!\$panther_is_available): ?>
        \$this->assertResponseIsSuccessful();
<?php endif ?>
        \$this->assertSelectorTextContains('h1', 'Hello World');
<?php else: ?>
<?php if (!\$panther_is_available): ?>
        \$this->assertSame(200, \$client->getResponse()->getStatusCode());
<?php endif ?>
        \$this->assertStringContainsString('Hello World', \$crawler->filter('h1')->text());
<?php endif ?>
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
        return "@Maker/test/Functional.tpl.php";
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
        return new Source("<?php /* @deprecated remove this method when removing make:unit-test and make:functional-test */ ?>
<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements ?>

class <?= \$class_name ?> extends <?= \$panther_is_available ? 'PantherTestCase' : 'WebTestCase' ?><?= \"\\n\" ?>
{
    public function testSomething(): void
    {
<?php if (\$panther_is_available): ?>
        \$client = static::createPantherClient();
<?php else: ?>
        \$client = static::createClient();
<?php endif ?>
        \$crawler = \$client->request('GET', '/');

<?php if (\$web_assertions_are_available): ?>
<?php if (!\$panther_is_available): ?>
        \$this->assertResponseIsSuccessful();
<?php endif ?>
        \$this->assertSelectorTextContains('h1', 'Hello World');
<?php else: ?>
<?php if (!\$panther_is_available): ?>
        \$this->assertSame(200, \$client->getResponse()->getStatusCode());
<?php endif ?>
        \$this->assertStringContainsString('Hello World', \$crawler->filter('h1')->text());
<?php endif ?>
    }
}
", "@Maker/test/Functional.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/test/Functional.tpl.php");
    }
}
