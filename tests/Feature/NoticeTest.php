<?php

use App\Models\Notice;

test('notices are displayed on the home page', function () {
    $notice = Notice::create([
        'title' => 'Important Announcement',
        'content' => 'This is a very important announcement.',
        'is_active' => true,
    ]);

    $this->get('/')
        ->assertStatus(200)
        ->assertSee($notice->title);
});

test('notice list page shows active notices', function () {
    $notice = Notice::create([
        'title' => 'Notice List Test',
        'content' => 'Content for list test.',
        'is_active' => true,
    ]);

    $inactiveNotice = Notice::create([
        'title' => 'Inactive Notice',
        'content' => 'Should not see this.',
        'is_active' => false,
    ]);

    $this->get(route('notices.index'))
        ->assertStatus(200)
        ->assertSee($notice->title)
        ->assertDontSee($inactiveNotice->title);
});

test('notice show page displays correct content', function () {
    $notice = Notice::create([
        'title' => 'Individual Notice',
        'content' => '<p>Detailed content here.</p>',
        'is_active' => true,
    ]);

    $this->get(route('notices.show', $notice))
        ->assertStatus(200)
        ->assertSee($notice->title)
        ->assertSee('Detailed content here.');
});
