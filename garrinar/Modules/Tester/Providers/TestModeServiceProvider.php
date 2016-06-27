<?php
/**
 * Created by PhpStorm.
 * User: garrinar
 * Date: 23.06.16
 * Time: 15:10
 */

namespace Garrinar\Modules\Tester\Providers;


use Illuminate\Support\ServiceProvider;

class TesterServiceProvider extends ServiceProvider
{
    protected $testerMode;
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        $this->testerMode = env('APP_TESTER_MODE', false);
        config(['testerMode' => $this->testMode]);

        parent::__construct($app);
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->testMode) {
            $this->testMode();
        }
    }

    /**
     * Action on test mode
     */
    public function testMode()
    {
        config([
            'mail.driver' => 'mail',
            'mail.host' => 'localhost'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}