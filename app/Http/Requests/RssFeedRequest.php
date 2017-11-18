<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use App\Repositories\RssFeedItemRepositoryInterface;

class RssFeedRequest extends BaseRequest
{
    protected $rss_feed_item_repository;

    public function __construct(RssFeedItemRepositoryInterface $rss_feed_item_repository)
    {
        $this->rss_feed_item_repository = $rss_feed_item_repository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rss_feed_item_repository->rules();
    }

    public function messages()
    {
        return $this->rss_feed_item_repository->messages();
    }
}
