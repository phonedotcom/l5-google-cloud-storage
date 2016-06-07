<?php

namespace Websight\GcsProvider;

use ErrorException;
use Google_Auth_AssertionCredentials;
use Google_Client;
use Google_Service_Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Storage;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

/**
 * Class CloudStorageServiceProvider
 * Configures Google Cloud Storage Access for flysystem
 *
 * @package Websight\GcsProvider
 */
class CloudStorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('gcs', function ($app, $config) {
            $client = new Google_Client();
            $client->setAuthConfig($config['service_account_json']);

            $service = new Google_Service_Storage($client);
            $adapter = new GoogleStorageAdapter($service, $config['bucket']);

            return new Filesystem($adapter);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Not needed
    }
}
