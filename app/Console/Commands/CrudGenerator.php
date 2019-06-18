<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "crud:generator
    {name : Class (singular) for example User} {option?}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create CRUD operations";

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
        $name = $this->argument("name");
        $this->menu($name);
        $options = $this->argument("option");
        if($options){
            $options = str_split($options);
            $this->crudGenWithOption($name, $options);
            return;
        }
        $this->crudGen($name);
    }

    protected function crudGen($name){
        $this->controller($name);
        $this->model($name);
        $this->migration($name);
        $this->create($name);
        $this->index($name);
        $this->edit($name);
    }

    protected function crudGenWithOption($name, $options){
        $this->controller($name);
        $this->model($name);
        $this->migration($name);
        if(in_array("c", $options)){
            $this->create($name);
        }
        if(in_array("r", $options)){
            $this->index($name);
        }
        if(in_array("u", $options)){
            $this->edit($name);
        }
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function migration($name)
    {
        $modelTemplate = str_replace(
            [
                "{{modelNamePluralLowerCase}}",
                "{{modelNamePluralUcCase}}"
            ],
            [
                strtolower(str_plural($name)),
                ucfirst(str_plural($name))
            ],
            $this->getStub("Migration")
        );
        $tableName = strtolower(str_plural($name));
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
            foreach($table as $val){
                if($tableName == $val){
                    $this->error("{$name} table already exists");
                    return;
                }
            }
        }

        $fileName = "_create_{$tableName}_table.php";

        foreach(glob(base_path("database/migrations/*.php")) as $file) {
            if(strpos($file, $fileName)){
                $this->error("{$name} migration already exists");
                return;
            }
        }

        $fileName = date("Y_m_d")."_".substr(time(), -6).$fileName;

        file_put_contents(base_path("database/migrations/{$fileName}"), $modelTemplate);
        $this->info("{$name} migration file created successfully");
        $this->call('migrate');
    }

    protected function model($name)
    {
        $baseModelTemplate = str_replace(
            ["{{modelName}}"],
            [$name],
            $this->getStub("BaseModel")
        );

        $modelTemplate = str_replace(
            ["{{modelName}}"],
            [$name],
            $this->getStub("Model")
        );

        if(file_exists(app_path("/baseModels/{$name}.php"))){
            $this->error("{$name} model already exists");
            return;
        }

        if (!is_dir(app_path("baseModels"))) {
            mkdir(app_path("baseModels"), 0777, true);
        }

        file_put_contents(app_path("/baseModels/{$name}.php"), $baseModelTemplate);
        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
        $this->info("{$name} model file created successfully");
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                "{{modelName}}",
                "{{modelNamePluralLowerCase}}"
            ],
            [
                $name,
                strtolower(str_plural($name))
            ],
            $this->getStub("Controller")
        );

        if(file_exists(app_path("Http/Controllers/{$name}Controller.php"))){
            $this->error("{$name} controller already exists");
            return;
        }

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
        $this->info("{$name} controller file created successfully");
    }

    protected function index($name)
    {
        $controllerTemplate = str_replace(
            [
                "{{modelNamePluralUcCase}}",
                "{{modelNamePluralLowerCase}}",
            ],
            [
                ucfirst(str_plural($name)),
                strtolower(str_plural($name)),
            ],
            $this->getStub("Index")
        );
        $folderName = strtolower(str_plural($name));

        if(file_exists(base_path("resources/views/{$folderName}/index.blade.php"))){
            $this->error("{$name} index view already exists");
            return;
        }

        if (!is_dir(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/index.blade.php"), $controllerTemplate);
        $this->info("{$name} index view file created successfully");
    }

    protected function create($name)
    {
        $controllerTemplate = str_replace(
            [
                "{{modelName}}",
                "{{modelNamePluralLowerCase}}",
                "{{modelNamePluralUcCase}}"
            ],
            [
                $name,
                strtolower(str_plural($name)),
                ucfirst(str_plural($name)),
            ],
            $this->getStub("Create")
        );

        $folderName = strtolower(str_plural($name));

        if(file_exists(base_path("resources/views/{$folderName}/create.blade.php"))){
            $this->error("{$name} create view already exists");
            return;
        }

        if (!is_dir(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/create.blade.php"), $controllerTemplate);
        $this->info("{$name} create view file created successfully");
    }

    protected function edit($name)
    {
        $controllerTemplate = str_replace(
            [
                "{{modelName}}",
                "{{modelNamePluralLowerCase}}",
                "{{modelNamePluralUcCase}}"
            ],
            [
                $name,
                strtolower(str_plural($name)),
                ucfirst(str_plural($name)),
            ],
            $this->getStub("Edit")
        );

        $folderName = strtolower(str_plural($name));

        if(file_exists(base_path("resources/views/{$folderName}/edit.blade.php"))){
            $this->error("{$name} edit view already exists");
            return;
        }

        if (!is_dir(base_path("resources/views/{$folderName}"))) {
            mkdir(base_path("resources/views/{$folderName}"), 0777, true);
        }

        file_put_contents(base_path("resources/views/{$folderName}/edit.blade.php"), $controllerTemplate);
        $this->info("{$name} edit view file created successfully");
    }

    protected function menu($name){
        $this->sidebar($name);
        $this->access($name);
        $this->resource($name);
    }

    protected function sidebar($name)
    {
        $path = app_path("Helpers/SidebarGenerator.php");
        $menus = file_get_contents($path);
        $section = ucfirst(str_plural($name));
        $route = strtolower(str_plural($name)).".index";
        $sidebar = "'{$section}|{$route}|fas fa-user' => []";
        if(strpos($menus, $sidebar)){
            return;
        }
        $str = "{$sidebar},\n\t\t\t\t//--endmenu--";

        $menuTemplate = str_replace("//--endmenu--", $str, $menus);

        file_put_contents($path, $menuTemplate);
    }

    protected function access($name)
    {
        $path = app_path("Helpers/Access.php");
        $menus = file_get_contents($path);
        $section = ucfirst(str_plural($name));
        if(strpos($menus, $section)){
            return;
        }
        $str = "'{$section}',\n\t\t\t//--endsection--";
        $menuTemplate = str_replace("//--endsection--", $str, $menus);
        file_put_contents($path, $menuTemplate);
    }

    protected function resource($name)
    {
        $path = base_path("routes/web.php");
        $menus = file_get_contents($path);
        $section = strtolower(str_plural($name));
        $resourceLine = "Route::resource('{$section}','{$name}Controller')->except(['show']);";
        if(strpos($menus, $resourceLine)){
            return;
        }
        $str = "{$resourceLine}\n\t\t//--endresource--";
        $menuTemplate = str_replace("//--endresource--", $str, $menus);
        file_put_contents($path, $menuTemplate);
    }
}
