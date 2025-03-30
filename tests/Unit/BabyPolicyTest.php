<?php

use App\Models\Baby;
use App\Models\User;
use App\Policies\BabyPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('any authenticated user can view any babies', function () {
    $user = User::factory()->create();
    $policy = new BabyPolicy();

    expect($policy->viewAny($user))->toBeTrue();
});

test('user can view their own baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);
    $policy = new BabyPolicy();

    expect($policy->view($user, $baby))->toBeTrue();
});

test('user cannot view other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);
    $policy = new BabyPolicy();

    expect($policy->view($user, $baby))->toBeFalse();
});

test('any authenticated user can create a baby', function () {
    $user = User::factory()->create();
    $policy = new BabyPolicy();

    expect($policy->create($user))->toBeTrue();
});

test('user can update their own baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);
    $policy = new BabyPolicy();

    expect($policy->update($user, $baby))->toBeTrue();
});

test('user cannot update other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);
    $policy = new BabyPolicy();

    expect($policy->update($user, $baby))->toBeFalse();
});

test('user can delete their own baby', function () {
    $user = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $user->id]);
    $policy = new BabyPolicy();

    expect($policy->delete($user, $baby))->toBeTrue();
});

test('user cannot delete other users baby', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $baby = Baby::factory()->create(['user_id' => $otherUser->id]);
    $policy = new BabyPolicy();

    expect($policy->delete($user, $baby))->toBeFalse();
}); 