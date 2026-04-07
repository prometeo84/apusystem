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

/* @Maker/registration/Test.WithoutVerify.tpl.php */
class __TwigTemplate_daa7e0d1d6981ed19ee806ef1665bf90 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/registration/Test.WithoutVerify.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/registration/Test.WithoutVerify.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>
namespace App\\Tests;

<?= \$use_statements ?>

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser \$client;
    private <?= \$repository_class_name ?> \$userRepository;

    protected function setUp(): void
    {
        \$this->client = static::createClient();

        // Ensure we have a clean database
        \$container = static::getContainer();

        /** @var EntityManager \$em */
        \$em = \$container->get('doctrine')->getManager();
        \$this->userRepository = \$container->get(<?= \$repository_class_name ?>::class);

        foreach (\$this->userRepository->findAll() as \$user) {
            \$em->remove(\$user);
        }

        \$em->flush();
    }

    public function testRegister(): void
    {
        // Register a new user
        \$this->client->request('GET', '/register');
        self::assertResponseIsSuccessful();
        self::assertPageTitleContains('Register');

        \$this->client->submitForm('Register', [
            'registration_form[email]' => 'me@example.com',
            'registration_form[plainPassword]' => 'password',
            'registration_form[agreeTerms]' => true,
        ]);

        // Ensure the response redirects after submitting the form, the user exists, and is not verified
        // self::assertResponseRedirects('/'); @TODO: set the appropriate path that the user is redirected to.
        self::assertCount(1, \$this->userRepository->findAll());
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
        return "@Maker/registration/Test.WithoutVerify.tpl.php";
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
namespace App\\Tests;

<?= \$use_statements ?>

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser \$client;
    private <?= \$repository_class_name ?> \$userRepository;

    protected function setUp(): void
    {
        \$this->client = static::createClient();

        // Ensure we have a clean database
        \$container = static::getContainer();

        /** @var EntityManager \$em */
        \$em = \$container->get('doctrine')->getManager();
        \$this->userRepository = \$container->get(<?= \$repository_class_name ?>::class);

        foreach (\$this->userRepository->findAll() as \$user) {
            \$em->remove(\$user);
        }

        \$em->flush();
    }

    public function testRegister(): void
    {
        // Register a new user
        \$this->client->request('GET', '/register');
        self::assertResponseIsSuccessful();
        self::assertPageTitleContains('Register');

        \$this->client->submitForm('Register', [
            'registration_form[email]' => 'me@example.com',
            'registration_form[plainPassword]' => 'password',
            'registration_form[agreeTerms]' => true,
        ]);

        // Ensure the response redirects after submitting the form, the user exists, and is not verified
        // self::assertResponseRedirects('/'); @TODO: set the appropriate path that the user is redirected to.
        self::assertCount(1, \$this->userRepository->findAll());
    }
}
", "@Maker/registration/Test.WithoutVerify.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/registration/Test.WithoutVerify.tpl.php");
    }
}
