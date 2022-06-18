<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagePost extends Model
{
    use HasFactory;

    public $table = "page_posts";
    protected $fillable = [
        'person_id',
        'page_id',
        'post_content',
        'is_published'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function pages()
    {
        return $this->belongsTo(Page::class);
    }


}
