<?php

test('home page can be rendered', function () {
    $this->seed(\Database\Seeders\RealDataSeeder::class);
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Admission Portal');
    $response->assertSee('Northern University');
    $response->assertSee('Featured Departments');
    $response->assertSee('Notice Board');
    $response->assertSee('Ready to Start Your Journey?');
});
