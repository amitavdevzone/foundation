<?php

namespace Inferno\Foundation\Commands;

use Illuminate\Console\Command;
use Inferno\Foundation\FoundationServiceProvider;
use Inferno\Foundation\Seeders\InfernoUserSeeder;

class InstallCommand extends Command
{
	/**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inferno:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Inferno Admin package';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function fire()
    {
    	$this->info('Installing Inferno...');
    	$this->publishFiles();
    	$this->seedBasicData();
    }

    /**
     * This function will publish the assets for Inferno
     */
    protected function publishFiles()
    {
    	$this->info('Copying required files like Assets, Database migrations etc.');
    	$this->call('vendor:publish', ['--provider' => FoundationServiceProvider::class]);
    }

    /**
     * This function will seeder the default data for Inferno Foundation
     * to work with Users, Roles and Permissions.
     */
    private function seedBasicData()
    {
    	$this->info('Adding data to database...');
    	(new InfernoUserSeeder())->run();
    }
}
