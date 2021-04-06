<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommonUser extends User
{
    use HasFactory;

    protected $table = 'users';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->where('type', '=', 'common');
    }
}
