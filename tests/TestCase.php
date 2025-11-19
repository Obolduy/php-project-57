<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create fake Vite manifest for tests
        $buildPath = public_path('build');
        if (!is_dir($buildPath)) {
            mkdir($buildPath, 0755, true);
        }
        
        $manifestPath = $buildPath . '/manifest.json';
        if (!file_exists($manifestPath)) {
            file_put_contents($manifestPath, json_encode([
                'resources/css/app.css' => [
                    'file' => 'assets/app.css',
                    'src' => 'resources/css/app.css',
                ],
                'resources/js/app.js' => [
                    'file' => 'assets/app.js',
                    'src' => 'resources/js/app.js',
                ],
            ]));
        }
    }
}
