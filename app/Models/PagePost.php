<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pages()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     *
     * get own page post
     *
     * @param $person_id
     * @return array
     */
    public static function getOwnPagePost($person_id)
    {
        $post = DB::table('page_posts')
            ->where('person_id',$person_id)
            ->get();

        $all_post = [];
        if (count($post)) {
            foreach ($post as $data) {
                $content = [];
                $content['id'] = $data->id;
                $content['post_content'] = $data->post_content;
                $content['created_at'] = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
                $content['is_published'] = filter_var($data->is_published, FILTER_VALIDATE_BOOLEAN);
                $all_post[] = $content;
            }
        }

        return $all_post;
    }

    /**
     *
     * get all following page post
     *
     * @param $person_id
     * @return array
     */
    public static function getAllPagePost($person_id)
    {
        $post = DB::table('page_posts')
            ->join('page_followers', 'page_posts.page_id', '=', 'page_followers.follow_to_page')
            ->where('page_followers.follow_from_person',$person_id)
            ->get();

        $all_post = [];
        if (count($post)) {
            foreach ($post as $data) {
                $content = [];
                $content['id'] = $data->id;
                $content['post_content'] = $data->post_content;
                $content['created_at'] = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
                $content['is_published'] = filter_var($data->is_published, FILTER_VALIDATE_BOOLEAN);
                $all_post[] = $content;
            }
        }

        return $all_post;
    }

}
