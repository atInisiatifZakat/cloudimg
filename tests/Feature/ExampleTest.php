<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
