<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Service name without "Service" suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Service class in app/Services';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = str($this->argument('name'))->studly()->value();
        $serviceClass = "{$name}Service";

        $serDir = app_path('Services');
        $serPath = "{$serDir}/{$serviceClass}.php";

        // Ensure the directory exists
        File::ensureDirectoryExists($serDir);

        // Prevent overwriting
        if (File::exists($serPath)) {
            $this->error("❌ Service already exists: {$serviceClass}.php");
            return 1;
        }

        // Stub template
        $serviceStub = <<<PHP
<?php

namespace App\Services;

class {$serviceClass}
{
    public function __construct()
    {
        //
    }
}
PHP;

        // Create the file
        File::put($serPath, $serviceStub);

          $this->info("Service Class created:Services/{$serviceClass}.php");
        return 0;
    }
}
