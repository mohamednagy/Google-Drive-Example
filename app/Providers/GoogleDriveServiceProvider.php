<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(base_path('gd_client_secret.json'));
        $client->addScope([\Google_Service_Drive::DRIVE, \Google_Service_Drive::DRIVE_METADATA]);

        $redirect_uri = url('callback');
        $client->setRedirectUri($redirect_uri);

        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        $this->app['GDClient'] = $client;
    }
}
