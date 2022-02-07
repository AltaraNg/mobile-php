<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class GenerateServiceCommand extends GeneratorCommand
{
   /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';
    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $className = $name . "Service";
        $stub = parent::replaceClass($stub, $className);
        return $this->replaceModel($stub);
    }

     /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceModel(string $stub): string
    {
        $name = $this->argument('name');
        $modelPath = $this->laravel['path'] . '/Models/' . $name . '.php';
        return str_replace(['{{MODEL_NAME}}'], $this->argument('name'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/stubs/service.stub';
        return app_path() . '/Console' . $relativePath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return 'App\Services';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Service.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service'],
        ];
    }
}
