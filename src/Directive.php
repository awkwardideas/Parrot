<?php namespace AwkwardIdeas\Parrot;

use Illuminate\Support\ServiceProvider;

class ParrotModel
{
    private $modelName="";

    public static function Model($modelName){
        return new ParrotModel(['modelName'=>$modelName]);
    }

    public function __construct( $params = array() ){
        if( $params ){
            foreach( $params as $property => $value ){
                $this->__set( $property, $value );
            }
        }
    }

    public function Get( $property ){
        return $this->__get( $property );
    }

    public function Set( $property, $value ){
        return $this->__set( $property, $value );
    }

    public function ObjectToArray(){
        return get_object_vars( $this );
    }

    public function __get( $property ) {
        $methodName = 'Get'. ucwords( $property );

        if( method_exists( $this, $methodName ) ){
            return $this->$methodName();
        }else if( property_exists( $this, $property ) ) {
            return $this->$property;
        }else{
            return self::ReturnAsJavascriptParrot($property);
        }
    }

    public function __set( $property, $value ) {

        $methodName = 'Set'. ucwords( $property );

        if( method_exists( $this, $methodName ) )
            return $this->$methodName( $value );
        else if( property_exists( $this, $property ) ) {
            $this->$property = $value;
            return true;
        }else{
            return false;
        }
    }

    public function __toString()
    {
        return "{{" . $this->Get("modelName") . "}}";
    }


    public function ReturnAsJavascriptParrot($property){
        if($this->Get("modelName") != ""){
            return "{{" . $this->Get("modelName") . "." . $property . "}}";
        }else {
            return "{{$property}}";
        }
    }
}