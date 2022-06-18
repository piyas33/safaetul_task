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

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function pages()
    {
        return $this->belongsTo(Page::class);
    }

    public static function isAlreadyPageFollowed($follow_from_person,$follow_to_page) {
        return PageFollower::where('follow_from_person',$follow_from_person)
            ->where('follow_to_page',$follow_to_page)
            ->exists();
    }

}
