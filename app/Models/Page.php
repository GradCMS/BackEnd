<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/* if u want to make an abstract model(class), make abstract class and make it extend Model class
 then make a model via command to create the child and instead of extending Model make it extend
 the abstract model (class)

*/

class Page extends Model
{
    use HasFactory;
}
