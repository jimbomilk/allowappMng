<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Login extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function login()
    {
        dump('testLogin');
        $response = $this->get('http://colegio1.allowapp.test');

        $response->assertStatus(200);
    }
}
