<?php

namespace App\Command;

use App\Entity\User;
use App\Service\EncryptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:migrate:encrypt-totp',
    description: 'Migra los TOTP secrets existentes a formato encriptado'
)]
class EncryptTotpSecretsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private EncryptionService $encryptionService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Migración de TOTP Secrets a formato encriptado');

        // Obtener todos los usuarios con TOTP habilitado
        $users = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.totpEnabled = true')
            ->andWhere('u.totpSecret IS NOT NULL')
            ->getQuery()
            ->getResult();

        if (count($users) === 0) {
            $io->success('No hay usuarios con TOTP habilitado para migrar.');
            return Command::SUCCESS;
        }

        $io->note(sprintf('Se encontraron %d usuarios con TOTP habilitado.', count($users)));

        $migrated = 0;
        $skipped = 0;
        $errors = 0;

        $io->progressStart(count($users));

        foreach ($users as $user) {
            try {
                $totpSecret = $user->getTotpSecret();

                if (empty($totpSecret)) {
                    $skipped++;
                    $io->progressAdvance();
                    continue;
                }

                // Intentar desencriptar para ver si ya está encriptado
                $decrypted = $this->encryptionService->decryptOrNull($totpSecret);

                if ($decrypted !== null) {
                    // Ya está encriptado
                    $skipped++;
                    $io->progressAdvance();
                    continue;
                }

                // No está encriptado, proceder a encriptar
                $encrypted = $this->encryptionService->encrypt($totpSecret);
                $user->setTotpSecret($encrypted);

                $migrated++;
                $io->progressAdvance();
            } catch (\Exception $e) {
                $errors++;
                $io->error(sprintf(
                    'Error al procesar usuario %s: %s',
                    $user->getEmail(),
                    $e->getMessage()
                ));
            }
        }

        $io->progressFinish();

        // Guardar cambios
        if ($migrated > 0) {
            $this->em->flush();
            $io->success(sprintf('Se encriptaron %d TOTP secrets exitosamente.', $migrated));
        }

        if ($skipped > 0) {
            $io->info(sprintf('%d usuarios ya tenían secrets encriptados o vacíos.', $skipped));
        }

        if ($errors > 0) {
            $io->warning(sprintf('Se encontraron %d errores durante la migración.', $errors));
            return Command::FAILURE;
        }

        $io->success('Migración completada exitosamente.');

        return Command::SUCCESS;
    }
}
