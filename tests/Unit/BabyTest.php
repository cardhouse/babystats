<?php

use App\Models\Baby;
use App\Models\Diaper;
use App\Models\Feeding;
use App\Models\Sleep;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('baby belongs to a user', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);

    expect($baby->user)->toBeInstanceOf(User::class)
        ->and($baby->user->id)->toBe($user->id);
});

test('baby has many diapers', function () {
    $baby = Baby::factory()->create();
    $diapers = Diaper::factory()->count(3)->create(['baby_id' => $baby->id]);

    expect($baby->diapers)->toHaveCount(3)
        ->and($baby->diapers->first())->toBeInstanceOf(Diaper::class);
});

test('baby has many feedings', function () {
    $baby = Baby::factory()->create();
    $feedings = Feeding::factory()->count(3)->create(['baby_id' => $baby->id]);

    expect($baby->feedings)->toHaveCount(3)
        ->and($baby->feedings->first())->toBeInstanceOf(Feeding::class);
});

test('baby has many sleeps', function () {
    $baby = Baby::factory()->create();
    $sleeps = Sleep::factory()->count(3)->create(['baby_id' => $baby->id]);

    expect($baby->sleeps)->toHaveCount(3)
        ->and($baby->sleeps->first())->toBeInstanceOf(Sleep::class);
});

test('baby can get history for a specific date', function () {
    $baby = Baby::factory()->create();
    $date = Carbon::now()->format('Y-m-d');
    
    // Create some history items for today
    $feeding = Feeding::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => Carbon::now(),
    ]);
    
    $diaper = Diaper::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => Carbon::now(),
    ]);

    $history = $baby->getHistoryForDate($date);

    expect($history)->toHaveCount(2)
        ->and($history->pluck('id')->contains($feeding->id))->toBeTrue()
        ->and($history->pluck('id')->contains($diaper->id))->toBeTrue();
});

test('baby history is sorted by date time', function () {
    $baby = Baby::factory()->create();
    $date = Carbon::now()->format('Y-m-d');
    
    // Create items with different times
    $feeding = Feeding::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => Carbon::now()->subHour(),
    ]);
    
    $diaper = Diaper::factory()->create([
        'baby_id' => $baby->id,
        'date_time' => Carbon::now(),
    ]);

    $history = $baby->getHistoryForDate($date);

    expect($history->first()->id)->toBe($diaper->id)
        ->and($history->last()->id)->toBe($feeding->id);
}); 