<?php

use App\Models\Baby;
use App\Models\User;
use App\Models\Diaper;
use App\Models\Feeding;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can view their baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('babies.show', ['baby' => $baby])
        ->assertSee($baby->name);
});

test('user cannot view other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);

    Livewire::actingAs($user)
        ->test('babies.show', ['baby' => $baby])
        ->assertStatus(403);
});

test('user can create a new baby', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('babies.create')
        ->set('newName', 'Test Baby')
        ->set('newBirthDate', '2024-01-01')
        ->call('createBaby')
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('babies', [
        'name' => 'Test Baby',
        'birth_date' => '2024-01-01 00:00:00',
        'user_id' => $user->id,
    ]);
});

test('user can add a diaper to their baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('diapers.add', ['baby' => $baby])
        ->set('newDiaperCategory', 'wet')
        ->call('addDiaper');

    $this->assertDatabaseHas('diapers', [
        'category' => 'wet',
        'baby_id' => $baby->id,
    ]);
});

test('user cannot add a diaper to other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);

    Livewire::actingAs($user)
        ->test('diapers.add', ['baby' => $baby])
        ->assertStatus(403);
});

test('user can add a feeding to their baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('feedings.add', ['baby' => $baby])
        ->set('newFeedingCategory', 'bottle')
        ->set('newFeedingAmount', 120)
        ->set('newFeedingUnit', 'ml')
        ->call('addFeeding');

    $this->assertDatabaseHas('feedings', [
        'category' => 'bottle',
        'amount' => 120,
        'unit' => 'ml',
        'baby_id' => $baby->id,
    ]);
});

test('user cannot add a feeding to other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);

    Livewire::actingAs($user)
        ->test('feedings.add', ['baby' => $baby])
        ->assertStatus(403);
});

test('baby history shows correct items for selected date', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);
    $today = now();
    $yesterday = now()->subDay();

    // Create items for today
    $todayFeeding = Feeding::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => $today,
        'category' => 'breast',
    ]);

    $todayDiaper = Diaper::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => $today,
        'category' => 'wet',
    ]);

    // Create items for yesterday
    $yesterdayFeeding = Feeding::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => $yesterday,
        'category' => 'bottle',
    ]);

    $yesterdayDiaper = Diaper::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => $yesterday,
        'category' => 'dirty',
    ]);

    $todayDate = $today->format('Y-m-d');
    $yesterdayDate = $yesterday->format('Y-m-d');

    // Test today's view
    $component = Livewire::actingAs($user)
        ->test('babies.show', ['baby' => $baby])
        ->set('selectedDate', $todayDate);

    // Should see today's items
    $component->assertSeeText([$todayFeeding->category, $todayDiaper->category]);

    // Should not see yesterday's items
    $component->assertDontSeeText([$yesterdayFeeding->category, $yesterdayDiaper->category]);

    // Test yesterday's view
    $component->set('selectedDate', $yesterdayDate);

    // Should see yesterday's items
    $component->assertSeeText([$yesterdayFeeding->category, $yesterdayDiaper->category]);

    // Should not see today's items
    $component->assertDontSeeText([$todayFeeding->category, $todayDiaper->category]);
}); 