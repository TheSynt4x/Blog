<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Comment Model
 */
class Comment extends Model
{
    /**
     * Fillable columns in the table
     * @var array
     */
    protected $fillable = [
        'post_id',
        'username',
        'comment'
    ];

    /**
     * Table timestamps
     * @var bool
     */
    public $timestamps = true;

    /**
     * Retrieves the user avatar by username
     * @param  string $username Username for the search
     * @return string           The avatar itself
     */
    public function getAvatar($username)
    {
        return User::where('username', $username)->first()->avatar;
    }

    /**
     * Sets a relationship with the post model
     * @return object
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
