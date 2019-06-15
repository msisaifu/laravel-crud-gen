<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator
    {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->controller($name);
        $this->model($name);
        $this->migration($name);
        $this->index($name);
        $this->create($name);
        $this->edit($name);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function migration($name)
    {
        $modelTemplate = str_replace(
            [
                '{{modelNamePluralLowerCase}}',
                '{{modelNamePluralUcCase}}'
            ],
            [
                strtolower(str_plural($name)),
                ucfirst(str_plural($name))
            ],
            $this->getStub('Migration')
        );

        $fileName = date("Y_m_d")."_".substr(time(), -6)."_create_".strtolower(str_plural($name));

        file_put_contents(base_path("database/migrations/{$fileName}_table.php"), $modelTemplate);
    }

    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    protected function index($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelNamePluralUcCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                ucfirst(str_plural($name)),
                strtolower(str_plural($name)),
            ],
            $this->getStub('Index')
        );
        $folderName = strtolower(str_plural($name));

        if (!file_exists(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/index.blade.php"), $controllerTemplate);
    }

    protected function create($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNamePluralUcCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                ucfirst(str_plural($name)),
            ],
            $this->getStub('Create')
        );

        $folderName = strtolower(str_plural($name));

        if (!file_exists(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/create.blade.php"), $controllerTemplate);
    }

    protected function edit($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNamePluralUcCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                ucfirst(str_plural($name)),
            ],
            $this->getStub('Edit')
        );

        $folderName = strtolower(str_plural($name));

        if (!file_exists(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/edit.blade.php"), $controllerTemplate);
    }


}
