<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
