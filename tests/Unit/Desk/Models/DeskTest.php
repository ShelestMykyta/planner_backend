<?php

namespace Tests\Unit\Task\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Desk;

class DeskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_title()
    {
        $desk = new Desk();
        $desk->title = 'Test Title';

        $this->assertEquals('Test Title', $desk->title);
    }

    public function test_it_has_a_description()
    {
        $desk = new Desk();
        $desk->description = 'Test Description';

        $this->assertEquals('Test Description', $desk->description);
    }

    public function test_it_can_set_and_get_title()
    {
        $desk = new Desk();
        $desk->title = 'New Title';

        $this->assertEquals('New Title', $desk->title);
    }

    public function test_it_can_set_and_get_description()
    {
        $desk = new Desk();
        $desk->description = 'New Description';

        $this->assertEquals('New Description', $desk->description);
    }

    public function test_it_can_create_a_desc_instance()
    {
        $desk = new Desk([
            'title' => 'Sample Title',
            'description' => 'Sample Description'
        ]);

        $this->assertInstanceOf(Desk::class, $desk);
        $this->assertEquals('Sample Title', $desk->title);
        $this->assertEquals('Sample Description', $desk->description);
    }
}