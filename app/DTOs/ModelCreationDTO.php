<?php

namespace App\DTOs;




/**
 * This DTO should be used when a Model instance is created
 *
 * have fillable associative array of attributes to mass assign
 *
 * have non-fillable associative array to individually assign the attribute to the Model instance
 *
 */
class ModelCreationDTO
{

    /** @var array */
    public $fill;

    /** @var array */
    public $nonFillable;

    public function __construct(array $fillable, array $nonFillable)
    {
        $this->fill = $fillable;
        $this->nonFillable = $nonFillable;
    }


    public function getFillable(): array
    {
        return $this->fill;
    }

    public function getNonFillable(): array
    {
        return $this->nonFillable;
    }

}
