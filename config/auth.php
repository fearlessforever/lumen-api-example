<?php

return [
  'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
  ],
  'guards' => [
    'web' => [
        'driver' => 'token',
        'provider' => 'users',
    ], 
  ], 
  'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class,
    ], 
  ]
];