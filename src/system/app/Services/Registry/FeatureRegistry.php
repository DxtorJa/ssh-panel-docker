<?php

namespace App\Services\Registry;

use App\Feature;

class FeatureRegistry {
    
    /**
     * Feature wrapper.
     * 
     * @var array
     */
    protected $features = [];

    /**
     * Register new feature. 
     * 
     * @param  string       $key
     * @param  App\Feature  $feature
     * @return void
     */
    public function register($key, Feature $feature) {
        $this->features[$key] = $feature;
    }

    /**
     * Get Feature.
     * 
     * @param  string $key 
     * @return App\Feature
     */
    public function get($key) {
        if(array_key_exists($key, $this->features)) {
            return $this->features[$key];
        }

        throw new \Exception('Undefined features! (' . $key . ')');
    }

    /**
     * Get all Feature. 
     * 
     * @return array
     */
    public function getAll() {
        return $this->features;
    }

}