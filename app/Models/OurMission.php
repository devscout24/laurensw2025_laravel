<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurMission extends Model
{
    protected $table = 'our_missions';

    protected $primaryKey = 'id';
    public $incrementing  = false;

    protected $fillable = [
        'header',
        'title',
        'description',
        'image_1',
        'image_2',
    ];
}
