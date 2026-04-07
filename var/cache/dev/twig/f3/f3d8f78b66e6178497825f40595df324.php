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

/* @Maker/registration/Test.WithVerify.tpl.php */
class __TwigTemplate_d7f76141838ce52f01df866cc2a0c6af extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/registration/Test.WithVerify.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/registration/Test.WithVerify.tpl.php"));

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
        // self::assertResponseRedirects('/');  @TODO: set the appropriate path that the user is redirected to.
        self::assertCount(1, \$this->userRepository->findAll());
        self::assertFalse((\$user = \$this->userRepository->findAll()[0])->isVerified());

        // Ensure the verification email was sent
        // Use either assertQueuedEmailCount() || assertEmailCount() depending on your mailer setup
        // self::assertQueuedEmailCount(1);
        self::assertEmailCount(1);

        self::assertCount(1, \$messages = \$this->getMailerMessages());
        self::assertEmailAddressContains(\$messages[0], 'from', '<?= \$from_email ?>');
        self::assertEmailAddressContains(\$messages[0], 'to', 'me@example.com');
        self::assertEmailTextBodyContains(\$messages[0], 'This link will expire in 1 hour.');

        // Login the new user
        \$this->client->followRedirect();
        \$this->client->loginUser(\$user);

        // Get the verification link from the email
        /** @var TemplatedEmail \$templatedEmail */
        \$templatedEmail = \$messages[0];
        \$messageBody = \$templatedEmail->getHtmlBody();
        self::assertIsString(\$messageBody);

        preg_match('#(http://localhost/verify/email.+)\">#', \$messageBody, \$resetLink);

        // \"Click\" the link and see if the user is verified
        \$this->client->request('GET', \$resetLink[1]);
        \$this->client->followRedirect();

        self::assertTrue(static::getContainer()->get(<?= \$repository_class_name ?>::class)->findAll()[0]->isVerified());
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
        return "@Maker/registration/Test.WithVerify.tpl.php";
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
        // self::assertResponseRedirects('/');  @TODO: set the appropriate path that the user is redirected to.
        self::assertCount(1, \$this->userRepository->findAll());
        self::assertFalse((\$user = \$this->userRepository->findAll()[0])->isVerified());

        // Ensure the verification email was sent
        // Use either assertQueuedEmailCount() || assertEmailCount() depending on your mailer setup
        // self::assertQueuedEmailCount(1);
        self::assertEmailCount(1);

        self::assertCount(1, \$messages = \$this->getMailerMessages());
        self::assertEmailAddressContains(\$messages[0], 'from', '<?= \$from_email ?>');
        self::assertEmailAddressContains(\$messages[0], 'to', 'me@example.com');
        self::assertEmailTextBodyContains(\$messages[0], 'This link will expire in 1 hour.');

        // Login the new user
        \$this->client->followRedirect();
        \$this->client->loginUser(\$user);

        // Get the verification link from the email
        /** @var TemplatedEmail \$templatedEmail */
        \$templatedEmail = \$messages[0];
        \$messageBody = \$templatedEmail->getHtmlBody();
        self::assertIsString(\$messageBody);

        preg_match('#(http://localhost/verify/email.+)\">#', \$messageBody, \$resetLink);

        // \"Click\" the link and see if the user is verified
        \$this->client->request('GET', \$resetLink[1]);
        \$this->client->followRedirect();

        self::assertTrue(static::getContainer()->get(<?= \$repository_class_name ?>::class)->findAll()[0]->isVerified());
    }
}
", "@Maker/registration/Test.WithVerify.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/registration/Test.WithVerify.tpl.php");
    }
}
