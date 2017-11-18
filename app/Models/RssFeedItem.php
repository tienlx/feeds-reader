<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RssFeedItem extends Base
{
    use SoftDeletes;

    protected $table = 'rss_feed_items';

    protected $fillable = ['title', 'link', 'categories', 'pub_date', 'guid'];

    protected $dates = ['created_at', 'updated_at', 'pub_date', 'deleted_at'];

    // Relations

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'           => $this->id,
            'title'         => $this->title,
            'link' => $this->link,
            'categories' => $this->categories,
            'pub_date'        => $this->pub_date,
            'guid'         => $this->guid,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'deleted_at'      => $this->deleted_at,
        ];
    }
}