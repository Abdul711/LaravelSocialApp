<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateExcept extends Command
{
    protected $signature = 'migrate:except {tables*}';
    protected $description = 'Run all migrations except the ones that create the specified tables';

    public function handle()
    {
        $exceptTables = $this->argument('tables');
        $migrationsPath = database_path('migrations');

        $migrationFiles = File::files($migrationsPath);

        foreach ($migrationFiles as $file) {
            $contents = File::get($file->getRealPath());

            $shouldSkip = false;

            foreach ($exceptTables as $table) {
                if (str_contains($contents, "Schema::create('$table'") || str_contains($contents, "Schema::create(\"$table\"")) {
                    $shouldSkip = true;
                    break;
                }
            }

            if (!$shouldSkip) {
                $this->info("Running: " . $file->getFilename());
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/' . $file->getFilename(),
                    '--force' => true,
                ]);
                $this->line(Artisan::output());
            } else {
                $this->warn("Skipped: " . $file->getFilename());
            }
        }

        return 0;
    }
}
