<?php

namespace App;



use Illuminate\Support\Facades\DB;

class Tables
{
    private $connection_basic;

    public function __construct()
    {
        $this->connection_basic = DB::connection('mongodb');
    }

    public function users()
    {
        return $this->connection_basic->table('users');
    }

    public function sessions()
    {
        return $this->connection_basic->table('sessions');
    }
}
