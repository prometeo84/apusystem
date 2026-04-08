<?php

namespace App\Service;

use Webauthn\MetadataService\StatusReportRepository;
use Webauthn\MetadataService\Statement\StatusReport;

final class SimpleStatusReportRepository implements StatusReportRepository
{
    /**
     * @return StatusReport[]
     */
    public function findStatusReportsByAAGUID(string $aaguid): array
    {
        return [];
    }
}
