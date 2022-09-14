<?php
namespace App\Providers;

use App\Models\Crudable;

class ModelsProvider
{

    /**
     * available crudable models
     *
     * @var array
    */
    public static $available_models   = [];

    /**
     * singleton current instance
     *
     * @var ModelProvider
    */
    private static $instance;

    /**
     * Class Constructor
     *
    */
    protected function __construct()
    {
    }

    /**
     * return singleton to load only a time the available models
     *
     * @return ModelsProvider
    */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$available_models = self::load_available_models();
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * load the current Crudable Models
     *
     * @return array
    */
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
