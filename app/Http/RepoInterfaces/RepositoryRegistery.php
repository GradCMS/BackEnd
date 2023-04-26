<?php

namespace App\Http\RepoInterfaces;

use Exception;
use http\Exception\InvalidArgumentException;

class RepositoryRegistery implements RepoRegisteryInterface
{

    private static $instance;

    public static function getInstance(): self   // singleton for the registery class
    {
        if (!isset(self::$instance)) {  // if there is no instances of the wanted key, create one
            self::$instance = new self;
        }

        return self::$instance; // send the created insatnce
    }


    private  $bindings = []; // carries the bindinds between the 'keys' we're going to set and the concrete classes

    public function register(string $key, CRUDRepoInterface $concrete)  // registers the bindings (key, concrete class)
    {
        $this->bindings[$key] = $concrete;
//        dump($key, $concrete);
    }

    public function get(string $key): CRUDRepoInterface  // returns the object of the concrete class
    {
        if(!isset($this->bindings[$key])){
            throw new InvalidArgumentException("No implementation registered for key: $key");
        }
        return $this->bindings[$key];
    }

}
