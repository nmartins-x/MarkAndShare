<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
include 'Includes/Utilities.php';

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
    
    protected $base_route = null;
    protected $base_model = null;
    
    /**
     * User will be authenticated
     */
    protected function act_as_auth_user($user = null) {
        $user = $user ?? factory(User::class)->create();
        $this->actingAs($user);
        
        return $user;
    }
    
    protected function setBaseRoute($route) {
        $this->base_route = $route;
    }
    
    protected function setBaseModel($model) {
        $this->base_model= $model;
    }
    
    protected function generic_create($attributes = [], $model = '', $route = '') {
         $this->withoutExceptionHandling();
         
         $route = $this->base_route ? "{$this->base_route}.store" : $route;
         $model = $this->base_model ?? $model;
         
         $attributes = raw($model, $attributes);
         
         if (! auth()->user()) {
             $this->expectException(\Illuminate\Auth\AuthenticationException::class);
         }

         $response = $this->postJson(route($route), $attributes)->assertSuccessful();
         
         $model = new $model;
         
         $this->assertDatabaseHas($model->getTable(), $attributes);
         
         return $response;
    }
    
    protected function generic_update($attributes = [], $model = '', $route = '') {
        
    }
    
    protected function generic_destroy($model = '', $route = '') {
        
    }
}
