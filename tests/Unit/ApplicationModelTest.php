<?php

namespace Tests\Unit;

use App\Models\Application;
use PHPUnit\Framework\TestCase;

class ApplicationModelTest extends TestCase
{
    public function test_application_has_status_relation_method()
    {
        $application = new Application;

        $this->assertTrue(
            method_exists($application, 'status'),
        );
    }
}
