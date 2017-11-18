<?php
namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\RssFeedItem;
use Tests\TestCase;

class RssFeedItemTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetInstance()
    {
        $contact = new RssFeedItem();
        $this->assertNotNull($contact);
    }

    public function testStoreNew()
    {
        $rss_feed_item_model = new RssFeedItem();

        $rss_feed_item_data = factory(RssFeedItem::class)->make();
        foreach( $rss_feed_item_data->toFillableArray() as $key => $value ) {
            $rss_feed_item_model->$key = $value;
        }
        $rss_feed_item_model->save();

        $this->assertNotNull(RssFeedItem::find($rss_feed_item_model->id));
    }

}
