<?php

use App\Kernel;

// En hosting compartido (InfinityFree), el /tmp del sistema no es escribible.
// Se establece el directorio temporal y de sesiones al directorio del proyecto
// antes de cargar el kernel, para que FlockStore y las sesiones PHP funcionen.
$projectTmp = dirname(__DIR__) . '/tmp';
if (!is_dir($projectTmp)) {
    @mkdir($projectTmp, 0777, true);
}
putenv('TMPDIR=' . $projectTmp);
@ini_set('sys_temp_dir', $projectTmp);
// session_save_path() y ini_set para máxima compatibilidad
// Debe llamarse antes de que Symfony inicie la sesión
if (!headers_sent()) {
    session_save_path($projectTmp);
    @ini_set('session.save_path', $projectTmp);
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
