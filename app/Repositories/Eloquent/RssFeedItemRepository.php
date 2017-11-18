<?php
namespace App\Repositories\Eloquent;

use App\Repositories\RssFeedItemRepositoryInterface;
use App\Models\RssFeedItem;

class RssFeedItemRepository extends SingleKeyModelRepository implements RssFeedItemRepositoryInterface
{
    public function getBlankModel()
    {
        return new RssFeedItem();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}