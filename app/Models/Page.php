<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public $table = "pages";
    protected $fillable = [
        'person_id',
        'page_name',
        'page_status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page_posts()
    {
        return $this->belongsTo(PagePost::class);
    }

    public function page_followers()
    {
        return $this->belongsTo(PageFollower::class);
    }

    /**
     *
     * check page exists or not by page id
     *
     * @param $id
     * @return mixed
     */
    public static function isPageExists($id)
    {
        return Page::where('id',$id)->exists();
    }

}
