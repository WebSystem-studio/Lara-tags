<?php

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            Websystem\Tags\TagServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
        Eloquent::unguard();
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    public function tearDown(): void
    {
        \Schema::drop('lessons');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        \Schema::create('lessons', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
}
