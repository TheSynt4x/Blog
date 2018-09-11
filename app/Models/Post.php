<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Post Model
 */
class Post extends Model
{
    /**
     * Fillable columns in the table
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'content',
        'author'
    ];

    /**
     * Table timestamps
     * @var bool
     */
    public $timestamps = true;

    /**
     * Sets relationship with the comment model
     * @return object
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'DESC');
    }
}
