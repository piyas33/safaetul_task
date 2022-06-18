<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonPost extends Model
{
    use HasFactory;

    public $table = "person_posts";
    protected $fillable = [
        'person_id',
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


}
