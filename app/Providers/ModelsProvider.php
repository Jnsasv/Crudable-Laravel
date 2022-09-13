<?php
namespace App\Providers;

use App\Models\Crudable;

class ModelsProvider
{

    public static array $available_models   = [];
    private static $instance;

    protected function __construct()
    {
    }
    protected function __clone()
    {
    }
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): ModelsProvider
    {
        if (!self::$instance instanceof self) {
            self::$available_models = self::load_available_models();
            self::$instance = new self;
        }

        return self::$instance;
    }


    protected static function load_available_models()
    {
        $composer  = require base_path('/vendor/autoload.php');
        if (false === empty($composer)) {
            $classes  = collect(array_keys($composer->getClassMap()))->filter(function ($e) {
                return (substr($e, 0, 11) === 'App\\Models\\')  && is_subclass_of($e, Crudable::class);
            })
                ->mapWithKeys(
                    function ($v) {
                        return [(new $v())->model_name => $v];
                    }
                );
            return  $classes->toArray() ;
        }
    }
}
