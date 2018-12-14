<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {

    	$userData = [
    		'name' => 'AlfredoFernandez',
    		'first_name' => 'Alfredo',
    		'last_name' => 'Fernandez',
    		'email' => 'alfredo@ceanla.com',
    		'password' => 'secret',
    		'password_confirmation' => 'secret',
    	];

    	$response = $this->post(route('register'), $userData);

    	$response->assertRedirect('/');

    	$this->assertDatabaseHas('users', [
    		'name' => 'AlfredoFernandez',
    		'first_name' => 'Alfredo',
    		'last_name' => 'Fernandez',
    		'email' => 'alfredo@ceanla.com',
    	]);

    	$this->assertTrue(
    		Hash::check('secret', User::first()->password),
    		'The password needs to be hashed'
    	);
    }
}
