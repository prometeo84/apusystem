<?php

namespace App\Tests\Unit\Service;

use App\Service\PasswordPolicyService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

/**
 * UC-01: Política de contraseñas
 * Reglas: >= 12 chars, mayúscula, minúscula, dígito, símbolo
 */
class PasswordPolicyServiceTest extends TestCase
{
    private PasswordPolicyService $service;

    protected function setUp(): void
    {
        $this->service = new PasswordPolicyService();
    }

    // ---- CONTRASEÑAS VÁLIDAS ----

    #[Test]
    public function strongPasswordPassesAllRules(): void
    {
        $this->assertTrue($this->service->isStrongPassword('Admin123!SecurePass'));
    }

    #[Test]
    public function passwordWithExactly12CharsIsValid(): void
    {
        // Exactly 12: Has upper, lower, digit, symbol
        $this->assertTrue($this->service->isStrongPassword('P@ssword1234'));
    }

    #[Test]
    public function passwordWithUnderscoreCountsAsSymbol(): void
    {
        // \W includes _ ([\W_] pattern in service)
        $this->assertTrue($this->service->isStrongPassword('P4ssword_Long'));
    }

    // ---- CONTRASEÑAS INVÁLIDAS ----

    #[Test]
    public function shortPasswordFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('P@ss1'));
    }

    #[Test]
    public function passwordWithExactly11CharsFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('P@ssword123'));
    }

    #[Test]
    public function passwordWithoutUppercaseFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('p@ssword1234'));
    }

    #[Test]
    public function passwordWithoutLowercaseFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('P@SSWORD1234'));
    }

    #[Test]
    public function passwordWithoutDigitFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('P@sswordLong!'));
    }

    #[Test]
    public function passwordWithoutSymbolFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword('Password12345'));
    }

    #[Test]
    public function emptyPasswordFails(): void
    {
        $this->assertFalse($this->service->isStrongPassword(''));
    }

    /** @return array<string, array{string}> */
    public static function weakPasswordProvider(): array
    {
        return [
            'too short'             => ['Ab1!'],
            'no uppercase'          => ['abcd1234!@#$'],
            'no lowercase'          => ['ABCD1234!@#$'],
            'no digit'              => ['AbcDef!@#$Long'],
            'no symbol'             => ['Password12345'],
            'eleven chars'          => ['P@ssword123'],
            'all same char'         => ['aaaaaaaaaaaa'],
            'spaces only 12'        => ['            '],
        ];
    }

    #[DataProvider('weakPasswordProvider')]
    public function testWeakPasswordsFail(string $password): void
    {
        $this->assertFalse($this->service->isStrongPassword($password));
    }
}
