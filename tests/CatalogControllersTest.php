<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CatalogControllersTest extends TestCase
{
    public function testEquipmentControllerHasCrudMethods()
    {
        $rc = new \ReflectionClass(\App\Controller\Catalog\EquipmentController::class);
        $this->assertTrue($rc->hasMethod('listJson'));
        $this->assertTrue($rc->hasMethod('create'));
        $this->assertTrue($rc->hasMethod('edit'));
        $this->assertTrue($rc->hasMethod('deleteConfirm'));
        $this->assertTrue($rc->hasMethod('delete'));
    }

    public function testLaborControllerHasCrudMethods()
    {
        $rc = new \ReflectionClass(\App\Controller\Catalog\LaborController::class);
        $this->assertTrue($rc->hasMethod('listJson'));
        $this->assertTrue($rc->hasMethod('create'));
        $this->assertTrue($rc->hasMethod('edit'));
        $this->assertTrue($rc->hasMethod('deleteConfirm'));
        $this->assertTrue($rc->hasMethod('delete'));
    }

    public function testMaterialControllerHasCrudMethods()
    {
        $rc = new \ReflectionClass(\App\Controller\Catalog\MaterialController::class);
        $this->assertTrue($rc->hasMethod('listJson'));
        $this->assertTrue($rc->hasMethod('create'));
        $this->assertTrue($rc->hasMethod('edit'));
        $this->assertTrue($rc->hasMethod('deleteConfirm'));
        $this->assertTrue($rc->hasMethod('delete'));
    }

    public function testTransportControllerHasCrudMethods()
    {
        $rc = new \ReflectionClass(\App\Controller\Catalog\TransportController::class);
        $this->assertTrue($rc->hasMethod('listJson'));
        $this->assertTrue($rc->hasMethod('create'));
        $this->assertTrue($rc->hasMethod('edit'));
        $this->assertTrue($rc->hasMethod('deleteConfirm'));
        $this->assertTrue($rc->hasMethod('delete'));
    }
}
