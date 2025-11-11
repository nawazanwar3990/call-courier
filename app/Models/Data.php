<?php

namespace App\Models;

use App\Enums\TableEnum;
use App\Traits\Relations\BelongToUser;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use  BelongToUser;
    protected $table=TableEnum::DATA;
    protected $fillable=[
      'user_id',
      'cn_no'
    ];
}
