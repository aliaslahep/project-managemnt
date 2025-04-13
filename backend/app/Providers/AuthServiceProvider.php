<?php

use Laravel\Passport\Passport;

public function boot() {
    
    $this->registerPolicies();

    Passport::routes(); // Important!
}