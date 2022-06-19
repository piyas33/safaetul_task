<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonFollower extends Model
{
    use HasFactory;

    public $table = "person_followers";
    protected $fillable = [
        'follow_from',
        'follow_to'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * check already follow or not
     *
     * @param $follow_from
     * @param $follow_to
     * @return mixed
     */
    public static function isAlreadyFollow($follow_from,$follow_to) {
        return PersonFollower::where('follow_from',$follow_from)
            ->where('follow_to',$follow_to)
            ->exists();
    }

}
