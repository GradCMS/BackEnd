<?php

namespace App\Traits;

use App\DTOs\ModelCreationDTO;

trait DTOBuilder
{

    public function buildDTO($fillableKeysToCopy, $nonFillableKeysToCopy, $data):ModelCreationDTO
    {
        $fillableData = [];
        $nonFillableData = [];

        foreach ($fillableKeysToCopy as $key)  // dynamically build the fillable array based on user input
        {
            if(isset($data[$key]))
            {
                $fillableData[$key] = $data[$key];
            }
        }

        foreach ($nonFillableKeysToCopy as $key)
        {
            if(isset($data[$key]))
            {
                $nonFillableData[$key] = $data[$key];
            }
        }
        return new ModelCreationDTO($fillableData, $nonFillableData);
    }

}
