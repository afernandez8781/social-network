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

    	$response = $this->post(route('register'), $this->userValidData());

    	$response->assertRedirect('/');

    	$this->assertDatabaseHas('users', [
    		'name' => 'AlfredoFernandez2',
    		'first_name' => 'Alfredo',
    		'last_name' => 'Fernandez',
    		'email' => 'alfredo@ceanla.com',
    	]);

    	$this->assertTrue(
    		Hash::check('secret', User::first()->password),
    		'The password needs to be hashed'
    	);
    }

    /** @test */
    public function the_name_is_required()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['name' => null])
	    )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_a_string()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['name' => 1332])
	    )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_not_be_greater_than_60_characters()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['name' => str_random(61)])
	    )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['name' => 'as'])
    	)->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
    	factory(User::class)->create(['name' => 'AlfredoFernandez']);

    	$this->post(
    		route('register'),
    		$this->userValidData(['name' => 'AlfredoFernandez'])
    	)->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_only_contain_letters_and_numbers()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['name' => 'Alfredo Fernandez'])
    	)->assertSessionHasErrors('name');

    	$this->post(
    		route('register'),
    		$this->userValidData(['name' => 'AlfredoFernandez<>'])
    	)->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_first_name_is_required()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['first_name' => null])
	    )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['first_name' => 1332])
	    )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_60_characters()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['first_name' => str_random(61)])
	    )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['first_name' => 'as'])
    	)->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['first_name' => 'Alfredo2'])
    	)->assertSessionHasErrors('first_name');

    	$this->post(
    		route('register'),
    		$this->userValidData(['first_name' => 'Alfredo<>'])
    	)->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_last_name_is_required()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['last_name' => null])
	    )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['last_name' => 1332])
	    )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_60_characters()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['last_name' => str_random(61)])
	    )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['last_name' => 'as'])
    	)->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['last_name' => 'Alfredo2'])
    	)->assertSessionHasErrors('last_name');

    	$this->post(
    		route('register'),
    		$this->userValidData(['last_name' => 'Alfredo<>'])
    	)->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_email_is_required()
    {
	    $this->post(
	    	route('register'), 
	    	$this->userValidData(['email' => null])
	    )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['email' => 'invalid@email'])
    	)->assertSessionHasErrors('email');
    }

     /** @test */
    public function the_email_must_be_unique()
    {
    	factory(User::class)->create(['email' => 'alfredo@ceanla.com']);

    	$this->post(
    		route('register'),
    		$this->userValidData(['email' => 'alfredo@ceanla.com'])
    	)->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['password' => 1332])
    	)->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_6_characters()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData(['password' => 'asdfg'])
    	)->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
    	$this->post(
    		route('register'),
    		$this->userValidData([
    			'password' => 'secret',
    			'password_confirmation' => null
    		])
    	)->assertSessionHasErrors('password');
    }

    /**
    * @param array @overrides
    * @return array
    */
    protected function userValidData($overrides = []): array
    {
    	return array_merge([
    		'name' => 'AlfredoFernandez2',
    		'first_name' => 'Alfredo',
    		'last_name' => 'Fernandez',
    		'email' => 'alfredo@ceanla.com',
    		'password' => 'secret',
    		'password_confirmation' => 'secret',
    	], $overrides);
    }
}
