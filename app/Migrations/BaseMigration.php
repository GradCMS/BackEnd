<?php

namespace App\Migrations;


use Illuminate\Database\Migrations\Migration;

class BaseMigration extends Migration
{
    protected $order;

    public function __construct()
    {
        $this->order = 0;
    }

    public function order($order)
    {
        $this->order = $order;
    }
}
