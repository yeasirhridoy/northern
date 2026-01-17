<?php

use App\Models\Department;
use Livewire\Volt\Volt;

test('departments page can be rendered', function () {
    Department::factory()->create(['name' => 'Computer Science', 'code' => 'CSE']);

    $this->get(route('departments.index'))
        ->assertOk()
        ->assertSee('Departments')
        ->assertSee('Computer Science');
});

test('departments page shows details of selected department', function () {
    $dept = Department::factory()->create([
        'name' => 'Computer Science', 
        'code' => 'CSE',
        'description' => 'Best Dept',
        'costing' => [['label' => 'Fee', 'amount' => '100', 'type' => 'One-time']]
    ]);

    Volt::test('departments.index')
        ->assertSee('Computer Science')
        ->call('selectDepartment', $dept->id)
        ->assertSee('Best Dept')
        ->assertSee('Fee');
});
