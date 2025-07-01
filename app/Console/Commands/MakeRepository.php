<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name : Repository name without "Repository" suffix}';
    protected $description = 'Generate a Repository class with Interface';

    public function handle()
    {
        $name = trim($this->argument('name'));
        $name = str($name)->studly()->value();

        $repositoryClass = "{$name}Repository";
        $interfaceName = "{$name}RepositoryInterface";

        $repoDir = app_path('Repositories');
        $contractDir =app_path("Interfaces");

        $repoPath = "{$repoDir}/{$repositoryClass}.php";
         $interfacePath = "{$contractDir}/{$interfaceName}.php";

        // Make directories if they don't exist
        File::ensureDirectoryExists($repoDir);
        File::ensureDirectoryExists($contractDir);

        // Prevent overwrite
        if (File::exists($repoPath) || File::exists($interfacePath)) {
            $this->error("❌ Repository or Interface already exists.");
            return 1;
        }

        // Interface content
        $interfaceStub = <<<PHP
<?php

namespace App\Interfaces;

interface {$interfaceName}
{
    //
}

PHP;

        // Repository content
        $repositoryStub = <<<PHP
<?php

namespace App\Repositories;

use App\Interface\{$interfaceName};

class {$repositoryClass} implements {$interfaceName}
{
    //
}

PHP;

        File::put($interfacePath, $interfaceStub);
        File::put($repoPath, $repositoryStub);

        $this->info("✅ Interface created: Interface/{$interfaceName}.php");
        $this->info("✅ Repository created: Repositories/{$repositoryClass}.php");

        // Optional: auto-bind
     

        return 0;
    }
}
