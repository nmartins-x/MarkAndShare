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
    
    /**
     * Generic API POST with store action 
     */
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
    
     /**
     * Generic API PATCH with update action 
     */
    protected function generic_update($attributes = [], $model = '', $route = '') {
        $this->withoutExceptionHandling();
         
        $route = $this->base_route ? "{$this->base_route}.update" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model, $attributes);

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->patchJson(route($route, $model->id), $model->toArray());

        tap($model->fresh(), function ($model) use ($attributes) {
            collect($attributes)->each(function($value, $key) use ($model) {
                $this->assertEquals($value, $model[$key]);
            });
        });

        return $response;
    }
    
     /**
     * Generic API DELETE with destroy action 
     */
    protected function generic_destroy($attributes = [], $model = '', $route = '') {
        $this->withoutExceptionHandling();

        $route = $this->base_route ? "{$this->base_route}.destroy" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model, $attributes);

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->deleteJson(route($route, $model->id));

        $this->assertDatabaseMissing($model->getTable(), $attributes);

        return $response;
    }
}
