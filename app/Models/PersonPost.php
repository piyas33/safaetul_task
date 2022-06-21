<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * get person own post
     * @param $person_id
     * @return array
     */
    public static function getOwnPost($person_id)
    {
        $post = DB::table('person_posts')
            ->where('person_id',$person_id)
            ->get();

        $all_post = [];
        if (count($post)) {
            foreach ($post as $data) {
                $content = [];
                $content['post_content'] = $data->post_content;
                $content['created_at'] = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
                $content['is_published'] = filter_var($data->is_published, FILTER_VALIDATE_BOOLEAN);
                $all_post[] = $content;
            }
        }

        return $all_post;
    }

    /**
     * get all following person post
     * @param $person_id
     * @return array
     */
    public static function getAllPersonPost($person_id)
    {
        $post = DB::table('person_posts')
            ->join('person_followers', 'person_posts.person_id', '=', 'person_followers.follow_to')
            ->where('person_followers.follow_from',$person_id)
            ->get();

        $all_post = [];
        if (count($post)) {
            foreach ($post as $data) {
                $content = [];
                $content['post_content'] = $data->post_content;
                $content['created_at'] = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
                $content['is_published'] = filter_var($data->is_published, FILTER_VALIDATE_BOOLEAN);
                $all_post[] = $content;
            }
        }

        return $all_post;
    }

}
