<?php

namespace App\Command;

use App\Entity\User;
use App\Service\RecoveryCodeHasher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:migrate:hash-recovery-codes',
    description: 'Migra los recovery codes existentes a formato hasheado con Argon2ID'
)]
class HashRecoveryCodesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private RecoveryCodeHasher $recoveryCodeHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Migración de Recovery Codes a formato hasheado');

        $io->warning([
            'ADVERTENCIA: Esta operación es irreversible.',
            'Los recovery codes en texto plano serán reemplazados por hashes.',
            'Esto es necesario por seguridad OWASP A02:2026.',
        ]);

        if (!$io->confirm('¿Desea continuar con la migración?', false)) {
            $io->info('Migración cancelada por el usuario.');
            return Command::SUCCESS;
        }

        // Buscar tabla user_recovery_codes
        $connection = $this->em->getConnection();

        // Verificar si la tabla existe
        $schemaManager = $connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

        if (!in_array('user_recovery_codes', $tables)) {
            $io->error('La tabla user_recovery_codes no existe. Primero debe crear la estructura de 2FA.');
            return Command::FAILURE;
        }

        // Obtener recovery codes
        $recoveryCodes = $connection->fetchAllAssociative(
            'SELECT id, user_id, code, used FROM user_recovery_codes WHERE used = 0'
        );

        if (count($recoveryCodes) === 0) {
            $io->success('No hay recovery codes para migrar.');
            return Command::SUCCESS;
        }

        $io->note(sprintf('Se encontraron %d recovery codes para migrar.', count($recoveryCodes)));

        $migrated = 0;
        $skipped = 0;
        $errors = 0;

        $io->progressStart(count($recoveryCodes));

        foreach ($recoveryCodes as $recoveryCode) {
            try {
                $code = $recoveryCode['code'];

                // Verificar si ya está hasheado (empieza con $argon2id$)
                if (str_starts_with($code, '$argon2id$') || str_starts_with($code, '$argon2i$') || str_starts_with($code, '$2y$')) {
                    $skipped++;
                    $io->progressAdvance();
                    continue;
                }

                // Hashear el código
                $hashedCode = $this->recoveryCodeHasher->hash($code);

                // Actualizar en BD
                $connection->executeStatement(
                    'UPDATE user_recovery_codes SET code = ? WHERE id = ?',
                    [$hashedCode, $recoveryCode['id']]
                );

                $migrated++;
                $io->progressAdvance();
            } catch (\Exception $e) {
                $errors++;
                $io->error(sprintf(
                    'Error al procesar recovery code ID %d: %s',
                    $recoveryCode['id'],
                    $e->getMessage()
                ));
            }
        }

        $io->progressFinish();

        if ($migrated > 0) {
            $io->success(sprintf('Se hashearon %d recovery codes exitosamente.', $migrated));
        }

        if ($skipped > 0) {
            $io->info(sprintf('%d recovery codes ya estaban hasheados.', $skipped));
        }

        if ($errors > 0) {
            $io->warning(sprintf('Se encontraron %d errores durante la migración.', $errors));
            return Command::FAILURE;
        }

        $io->success('Migración completada exitosamente.');

        $io->note([
            'IMPORTANTE: Los recovery codes originales ya no son recuperables.',
            'Asegúrese de que los usuarios tengan backup de sus códigos.',
            'Si perdieron acceso, deberán regenerar nuevos códigos desde su perfil.',
        ]);

        return Command::SUCCESS;
    }
}
