<?php

test('home page can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Shape Your Future');
    $response->assertSee('Northern University');
});

