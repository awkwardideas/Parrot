<?php
namespace AwkwardIdeas\Parrot\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Parrot extends BaseFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'parrot.model'; }


}
