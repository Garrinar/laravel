<?php

namespace Garrinar\Modules\Filesystem\Distributed\Commands;


use Illuminate\Console\Command;

/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 06.05.2016
 * Time: 20:05
 */
class CreateFilesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the files database table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = glob(__DIR__ . '/../Migrations/*');
        natsort($files);
        $migDir = $this->getLaravel()->basePath() . '/database/migrations/';
        if (count($files)) {
            collect($files)
                ->each(function ($item) use ($migDir) {
                    $fileName = mb_substr(date('Y_m_d_His_') . basename($item), 0, -1);
                    if (copy($item, $migDir . $fileName)) {
                        echo "Migration $fileName successfully created";
                    } else {
                        echo "Could'n create migration $fileName";
                    }
                    sleep(1);
                });
        }
    }
}