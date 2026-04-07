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

/* @Maker/crud/test/Test.EntityManager.tpl.php */
class __TwigTemplate_195f7434af34a49d0ce7d65b2e5ac53d extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/crud/test/Test.EntityManager.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/crud/test/Test.EntityManager.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>
<?php use Symfony\\Bundle\\MakerBundle\\Str; ?>

namespace <?= \$namespace ?>;

<?= \$class_data->getUseStatements(); ?>

<?= \$class_data->getClassDeclaration() ?>

{
    private KernelBrowser \$client;
    private EntityManagerInterface \$manager;
    private EntityRepository \$<?= lcfirst(\$entity_var_singular); ?>Repository;
    private string \$path = '<?= \$route_path; ?>/';

    protected function setUp(): void
    {
        \$this->client = static::createClient();
        \$this->manager = static::getContainer()->get('doctrine')->getManager();
        \$this-><?= lcfirst(\$entity_var_singular); ?>Repository = \$this->manager->getRepository(<?= \$entity_class_name; ?>::class);

        foreach (\$this-><?= lcfirst(\$entity_var_singular); ?>Repository->findAll() as \$object) {
            \$this->manager->remove(\$object);
        }

        \$this->manager->flush();
    }

    public function testIndex(): void
    {
        \$this->client->followRedirects();
        \$crawler = \$this->client->request('GET', \$this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('<?= ucfirst(\$entity_var_singular); ?> index');

        // Use the \$crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', \$crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        \$this->client->request('GET', sprintf('%snew', \$this->path));

        self::assertResponseStatusCodeSame(200);

        \$this->client->submitForm('Save', [
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
            '<?= \$form_field_prefix; ?>[<?= \$form_field; ?>]' => 'Testing',
<?php endforeach; ?>
        ]);

        self::assertResponseRedirects('<?= \$route_path; ?>');

        self::assertSame(1, \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->count([]));

        \$this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('My Title');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s', \$this->path, \$fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('<?= ucfirst(\$entity_var_singular); ?>');

        // Use assertions to check that the properties are properly displayed.
        \$this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('Value');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s/edit', \$this->path, \$fixture->getId()));

        \$this->client->submitForm('Update', [
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
            '<?= \$form_field_prefix; ?>[<?= \$form_field; ?>]' => 'Something New',
<?php endforeach; ?>
        ]);

        self::assertResponseRedirects('<?= \$route_path; ?>');

        \$fixture = \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->findAll();

<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        self::assertSame('Something New', \$fixture[0]->get<?= Str::asCamelCase(\$form_field); ?>());
<?php endforeach; ?>

        \$this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('Value');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s', \$this->path, \$fixture->getId()));
        \$this->client->submitForm('Delete');

        self::assertResponseRedirects('<?= \$route_path; ?>');
        self::assertSame(0, \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->count([]));

        \$this->markTestIncomplete('This test was generated');
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
        return "@Maker/crud/test/Test.EntityManager.tpl.php";
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
<?php use Symfony\\Bundle\\MakerBundle\\Str; ?>

namespace <?= \$namespace ?>;

<?= \$class_data->getUseStatements(); ?>

<?= \$class_data->getClassDeclaration() ?>

{
    private KernelBrowser \$client;
    private EntityManagerInterface \$manager;
    private EntityRepository \$<?= lcfirst(\$entity_var_singular); ?>Repository;
    private string \$path = '<?= \$route_path; ?>/';

    protected function setUp(): void
    {
        \$this->client = static::createClient();
        \$this->manager = static::getContainer()->get('doctrine')->getManager();
        \$this-><?= lcfirst(\$entity_var_singular); ?>Repository = \$this->manager->getRepository(<?= \$entity_class_name; ?>::class);

        foreach (\$this-><?= lcfirst(\$entity_var_singular); ?>Repository->findAll() as \$object) {
            \$this->manager->remove(\$object);
        }

        \$this->manager->flush();
    }

    public function testIndex(): void
    {
        \$this->client->followRedirects();
        \$crawler = \$this->client->request('GET', \$this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('<?= ucfirst(\$entity_var_singular); ?> index');

        // Use the \$crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', \$crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        \$this->client->request('GET', sprintf('%snew', \$this->path));

        self::assertResponseStatusCodeSame(200);

        \$this->client->submitForm('Save', [
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
            '<?= \$form_field_prefix; ?>[<?= \$form_field; ?>]' => 'Testing',
<?php endforeach; ?>
        ]);

        self::assertResponseRedirects('<?= \$route_path; ?>');

        self::assertSame(1, \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->count([]));

        \$this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('My Title');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s', \$this->path, \$fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('<?= ucfirst(\$entity_var_singular); ?>');

        // Use assertions to check that the properties are properly displayed.
        \$this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('Value');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s/edit', \$this->path, \$fixture->getId()));

        \$this->client->submitForm('Update', [
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
            '<?= \$form_field_prefix; ?>[<?= \$form_field; ?>]' => 'Something New',
<?php endforeach; ?>
        ]);

        self::assertResponseRedirects('<?= \$route_path; ?>');

        \$fixture = \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->findAll();

<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        self::assertSame('Something New', \$fixture[0]->get<?= Str::asCamelCase(\$form_field); ?>());
<?php endforeach; ?>

        \$this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        \$fixture = new <?= \$entity_class_name; ?>();
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
        \$fixture->set<?= Str::asCamelCase(\$form_field); ?>('Value');
<?php endforeach; ?>

        \$this->manager->persist(\$fixture);
        \$this->manager->flush();

        \$this->client->request('GET', sprintf('%s%s', \$this->path, \$fixture->getId()));
        \$this->client->submitForm('Delete');

        self::assertResponseRedirects('<?= \$route_path; ?>');
        self::assertSame(0, \$this-><?= lcfirst(\$entity_var_singular); ?>Repository->count([]));

        \$this->markTestIncomplete('This test was generated');
    }
}
", "@Maker/crud/test/Test.EntityManager.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/crud/test/Test.EntityManager.tpl.php");
    }
}
