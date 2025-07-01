<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class RollbackExceptBatch extends Command
{
    protected $signature = 'migrate:rollback-except-batch 
                            {--except= : Comma-separated keywords to exclude (e.g. users,posts)}';

    protected $description = 'Rollback latest migration batch except specified migrations';

    public function handle()
    {
        $except = collect(explode(',', $this->option('except')))
                    ->map(fn($v) => trim($v))
                    ->filter();

        $latestBatch = DB::table('migrations')->max('batch');

        if (!$latestBatch) {
            $this->info('✅ No migrations to rollback.');
            return;
        }

        $migrations = DB::table('migrations')
            ->where('batch', $latestBatch)
            ->orderByDesc('id')
            ->get();

        $rollbackList = $migrations->filter(function ($migration) use ($except) {
            foreach ($except as $keyword) {
                if (str_contains($migration->migration, $keyword)) {
                    return false; // Skip
                }
            }
            return true;
        });

        if ($rollbackList->isEmpty()) {
            $this->info("✅ No eligible migrations to rollback in batch {$latestBatch}.");
            return;
        }

        foreach ($rollbackList as $migration) {
            $filePath = database_path("migrations/{$migration->migration}.php");

            if (!File::exists($filePath)) {
                $this->warn("⚠️ Migration file not found: {$migration->migration}");
                continue;
            }

            $this->info("🔁 Rolling back: {$migration->migration}");
            Artisan::call('migrate:rollback', [
                '--path' => 'database/migrations/' . $migration->migration . '.php',
                '--force' => true,
            ]);
            DB::table('migrations')
                ->where('migration', $migration->migration)
                ->delete();
        }

        $this->info("🏁 Completed rollback (excluding specified).");
    }
}
