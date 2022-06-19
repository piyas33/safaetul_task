<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageFollower extends Model
{
    use HasFactory;

    public $table = "page_followers";
    protected $fillable = [
        'follow_from_person',
        'follow_to_page'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pages()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * check already follow page or not
     * @param $follow_from_person
     * @param $follow_to_page
     * @return mixed
     */
    public static function isAlreadyPageFollowed($follow_from_person,$follow_to_page) {
        return PageFollower::where('follow_from_person',$follow_from_person)
            ->where('follow_to_page',$follow_to_page)
            ->exists();
    }

}
