<?php
namespace AwkwardIdeas\Parrot;

use AwkwardIdeas\Parrot\ParrotModel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Directive{
    public static function AddCustomDirectives()
    {
        Blade::directive('parrot', function ($expression) {
            $expression = self::MakeParrotExpression($expression);
            return "<?php echo \$__env->make({$expression}, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });

        Blade::directive('parrotif', function ($expression) {
            $expression = self::MakeParrotExpression($expression);
            return "<?php if (\$__env->exists({$expression})) echo \$__env->make({$expression}, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });

        Blade::directive('parrotClass', function($expression){
            return '<?php echo (isset($parrotClass) ? $parrotClass : ""); ?>';
        });

        Blade::directive('parrotID', function($expression){
            return '<?php echo (isset($parrotID) ? "id=\'$parrotID\'" : ""); ?>';
        });

        Blade::directive('onParrot', function($expression){
            return '<?php if(isset($parrotClass)): ?>';
        });

        Blade::directive('endOnParrot', function($expression){
            return '<?php endif; ?>';
        });

        Blade::directive('noParrot', function($expression){
            return '<?php if(!isset($parrotClass)): ?>';
        });

        Blade::directive('endNoParrot', function($expression){
            return '<?php endif; ?>';
        });
    }

    public static function GetArguments($expression){
        $expression = self::stripParentheses($expression);
        $args = preg_split('/(?!\B\[[^\]]*),(?![^\[]*\]\B)/m', $expression);
        foreach($args as $key=>$arg){
            $arg = self::parseData(self::stripNewlines($arg));
            if(preg_match("/^\[[\s\S]*\]$/m", $arg, $matches)){
                $args[$key] = self::StringArrayToArray($arg);
            }
        }
        return $args;
    }

    /**
     * Strip the parentheses from the given expression.
     *
     * @param  string  $expression
     * @return string
     */
    public static function stripParentheses($expression)
    {
        if (Str::startsWith($expression, '(')) {
            $expression = substr($expression, 1, -1);
        }

        return $expression;
    }
    public static function stripNewlines($string){
        return trim(preg_replace("/\r|\n|\\r|\\n/", "", preg_replace('/\s+/', ' ', $string)));
    }

    protected static function MakeParrotExpression($expression){
        $args = self::GetArguments($expression);
        $include = $args[0];
        $varsToParrot = (array_key_exists(1,$args)) ? $args[1] : [];
        $parrotVars = [];
        foreach($varsToParrot as $key=>$value){
            if($key!="parrotClass" && $key !="parrotID"){
                $parrotVars[$key]="Parrot::Model('{$key}')";
            }else{
                $parrotVars[$key]="'{$value}'";
            }
        }
        if(!array_key_exists('parrotClass', $parrotVars)){
            $parrotVars["parrotClass"]="'parrotTemplate'";
        }
        $args[1]=self::ArrayToStringArray($parrotVars);
        return implode(',',$args);
    }

    /**
     * Parse the given data into a raw array.
     *
     * @param  mixed  $data
     * @return array
     */
    protected static function parseData($data)
    {
        return $data instanceof Arrayable ? $data->toArray() : $data;
    }

    protected static function StringArrayToArray($strArray){
        $strArray = trim($strArray, " \t\n\r\0\x0B[]");
        $arraySets = explode(',',$strArray);
        $builtArray = [];
        foreach($arraySets as $arraySet){
            list($key, $value) = explode('=>',$arraySet);
            $builtArray[trim($key," '\"")] = trim($value," '\"");
        }
        return $builtArray;
    }

    protected static function ArrayToStringArray($array){
        $strArray = "[";
        $keyCount = 0;
        foreach($array as $key=>$value){
            if($keyCount>0){
                $strArray.=",";
            }

            $strArray .= "'{$key}'=>{$value}";
            $keyCount++;
        }
        return $strArray . "]";
    }
}
