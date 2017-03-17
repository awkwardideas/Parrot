<?php
namespace AwkwardIdeas\SwitchBlade;

use AwkwardIdeas\Parrot\ParrotModel;
use Illuminate\Support\Facades\Blade;

class Directive{
    public static function AddCustomDirectives()
    {
        Blade::directive('parrot', function ($expression) {
            $args = self::GetArguments($expression);
            $include = $args[0];
            $varsToParrot = (array_key_exists(1,$args)) ? $args[1] : [];
            $parrotVars = [];
            foreach($varsToParrot as $key=>$value){
                $parrotVars[$key]=new ParrotModel(["modelName"=>$key]);
            }

            return "<?php echo \$__env->make($include, $parrotVars, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });
    }
    public static function GetArguments($expression){
        return explode(',', $expression);
    }
}
