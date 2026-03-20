<?php

namespace App\Service;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class TimezoneProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        // Asegurar que la fecha use la zona horaria de Guayaquil
        $datetime = $record->datetime->setTimezone(new \DateTimeZone('America/Guayaquil'));

        return $record->with(datetime: $datetime);
    }
}
