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

/* @Maker/resetPassword/Test.ResetPasswordController.tpl.php */
class __TwigTemplate_de151605eaca4ca49f099e4296484513 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/resetPassword/Test.ResetPasswordController.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/resetPassword/Test.ResetPasswordController.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>
namespace App\\Tests;

<?= \$use_statements ?>

class ResetPasswordControllerTest extends WebTestCase
{
    private KernelBrowser \$client;
    private EntityManagerInterface \$em;
    private <?= \$user_repo_short_name ?> \$userRepository;

    protected function setUp(): void
    {
        \$this->client = static::createClient();

        // Ensure we have a clean database
        \$container = static::getContainer();

        /** @var EntityManagerInterface \$em */
        \$em = \$container->get('doctrine')->getManager();
        \$this->em = \$em;

        \$this->userRepository = \$container->get(<?= \$user_repo_short_name ?>::class);

        foreach (\$this->userRepository->findAll() as \$user) {
            \$this->em->remove(\$user);
        }

        \$this->em->flush();
    }

    public function testResetPasswordController(): void
    {
        // Create a test user
        \$user = (new <?= \$user_short_name ?>())
            ->setEmail('me@example.com')
            ->setPassword('a-test-password-that-will-be-changed-later')
        ;
        \$this->em->persist(\$user);
        \$this->em->flush();

        // Test Request reset password page
        \$this->client->request('GET', '/reset-password');

        self::assertResponseIsSuccessful();
        self::assertPageTitleContains('Reset your password');

        // Submit the reset password form and test email message is queued / sent
        \$this->client->submitForm('Send password reset email', [
            'reset_password_request_form[email]' => 'me@example.com',
        ]);

        // Ensure the reset password email was sent
        // Use either assertQueuedEmailCount() || assertEmailCount() depending on your mailer setup
        // self::assertQueuedEmailCount(1);
        self::assertEmailCount(1);

        self::assertCount(1, \$messages = \$this->getMailerMessages());

        self::assertEmailAddressContains(\$messages[0], 'from', '<?= \$from_email ?>');
        self::assertEmailAddressContains(\$messages[0], 'to', 'me@example.com');
        self::assertEmailTextBodyContains(\$messages[0], 'This link will expire in 1 hour.');

        self::assertResponseRedirects('/reset-password/check-email');

        // Test check email landing page shows correct \"expires at\" time
        \$crawler = \$this->client->followRedirect();

        self::assertPageTitleContains('Password Reset Email Sent');
        self::assertStringContainsString('This link will expire in 1 hour', \$crawler->html());

        // Test the link sent in the email is valid
        \$email = \$messages[0]->toString();
        preg_match('#(/reset-password/reset/[a-zA-Z0-9]+)#', \$email, \$resetLink);

        \$this->client->request('GET', \$resetLink[1]);

        self::assertResponseRedirects('/reset-password/reset');

        \$this->client->followRedirect();

        // Test we can set a new password
        \$this->client->submitForm('Reset password', [
            'change_password_form[plainPassword][first]' => 'newStrongPassword',
            'change_password_form[plainPassword][second]' => 'newStrongPassword',
        ]);

        self::assertResponseRedirects('<?= \$success_route_path ?>');

        \$user = \$this->userRepository->findOneBy(['email' => 'me@example.com']);

        self::assertInstanceOf(<?= \$user_short_name ?>::class, \$user);

        /** @var UserPasswordHasherInterface \$passwordHasher */
        \$passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        self::assertTrue(\$passwordHasher->isPasswordValid(\$user, 'newStrongPassword'));
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
        return "@Maker/resetPassword/Test.ResetPasswordController.tpl.php";
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

class ResetPasswordControllerTest extends WebTestCase
{
    private KernelBrowser \$client;
    private EntityManagerInterface \$em;
    private <?= \$user_repo_short_name ?> \$userRepository;

    protected function setUp(): void
    {
        \$this->client = static::createClient();

        // Ensure we have a clean database
        \$container = static::getContainer();

        /** @var EntityManagerInterface \$em */
        \$em = \$container->get('doctrine')->getManager();
        \$this->em = \$em;

        \$this->userRepository = \$container->get(<?= \$user_repo_short_name ?>::class);

        foreach (\$this->userRepository->findAll() as \$user) {
            \$this->em->remove(\$user);
        }

        \$this->em->flush();
    }

    public function testResetPasswordController(): void
    {
        // Create a test user
        \$user = (new <?= \$user_short_name ?>())
            ->setEmail('me@example.com')
            ->setPassword('a-test-password-that-will-be-changed-later')
        ;
        \$this->em->persist(\$user);
        \$this->em->flush();

        // Test Request reset password page
        \$this->client->request('GET', '/reset-password');

        self::assertResponseIsSuccessful();
        self::assertPageTitleContains('Reset your password');

        // Submit the reset password form and test email message is queued / sent
        \$this->client->submitForm('Send password reset email', [
            'reset_password_request_form[email]' => 'me@example.com',
        ]);

        // Ensure the reset password email was sent
        // Use either assertQueuedEmailCount() || assertEmailCount() depending on your mailer setup
        // self::assertQueuedEmailCount(1);
        self::assertEmailCount(1);

        self::assertCount(1, \$messages = \$this->getMailerMessages());

        self::assertEmailAddressContains(\$messages[0], 'from', '<?= \$from_email ?>');
        self::assertEmailAddressContains(\$messages[0], 'to', 'me@example.com');
        self::assertEmailTextBodyContains(\$messages[0], 'This link will expire in 1 hour.');

        self::assertResponseRedirects('/reset-password/check-email');

        // Test check email landing page shows correct \"expires at\" time
        \$crawler = \$this->client->followRedirect();

        self::assertPageTitleContains('Password Reset Email Sent');
        self::assertStringContainsString('This link will expire in 1 hour', \$crawler->html());

        // Test the link sent in the email is valid
        \$email = \$messages[0]->toString();
        preg_match('#(/reset-password/reset/[a-zA-Z0-9]+)#', \$email, \$resetLink);

        \$this->client->request('GET', \$resetLink[1]);

        self::assertResponseRedirects('/reset-password/reset');

        \$this->client->followRedirect();

        // Test we can set a new password
        \$this->client->submitForm('Reset password', [
            'change_password_form[plainPassword][first]' => 'newStrongPassword',
            'change_password_form[plainPassword][second]' => 'newStrongPassword',
        ]);

        self::assertResponseRedirects('<?= \$success_route_path ?>');

        \$user = \$this->userRepository->findOneBy(['email' => 'me@example.com']);

        self::assertInstanceOf(<?= \$user_short_name ?>::class, \$user);

        /** @var UserPasswordHasherInterface \$passwordHasher */
        \$passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        self::assertTrue(\$passwordHasher->isPasswordValid(\$user, 'newStrongPassword'));
    }
}
", "@Maker/resetPassword/Test.ResetPasswordController.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/resetPassword/Test.ResetPasswordController.tpl.php");
    }
}
