<?php
namespace Tests\Unit\Repositories;

use App\Models\RssFeedItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContactRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetInstance()
    {
        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $rss_feed_items = factory(RssFeedItem::class, 3)->create();
        $rss_feed_itemIds = $rss_feed_items->pluck('id')->toArray();

        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);

        $rss_feed_items_check = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(RssFeedItem::class, $rss_feed_items_check[0]);

        $rss_feed_items_check = $repository->getByIds($rss_feed_itemIds);
        $this->assertEquals(3, count($rss_feed_items_check));
    }

    public function testFind()
    {
        $rss_feed_items = factory(RssFeedItem::class, 3)->create();
        $rss_feed_itemIds = $rss_feed_items->pluck('id')->toArray();

        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);

        $rss_feed_items_check = $repository->find($rss_feed_itemIds[0]);
        $this->assertEquals($rss_feed_itemIds[0], $rss_feed_items_check->id);
    }

    public function testCreate()
    {
        $rss_feed_item_data = factory(RssFeedItem::class)->make();

        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);

        $rss_feed_items_check = $repository->create($rss_feed_item_data->toFillableArray());
        $this->assertNotNull($rss_feed_items_check);
    }

    public function testUpdate()
    {
        $rss_feed_item_data = factory(RssFeedItem::class)->create();

        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);

        $rss_feed_items_check = $repository->update($rss_feed_item_data, $rss_feed_item_data->toFillableArray());
        $this->assertNotNull($rss_feed_items_check);
    }

    public function testDelete()
    {
        $rss_feed_item_data = factory(RssFeedItem::class)->create();

        $repository = \App::make(\App\Repositories\RssFeedItemRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($rss_feed_item_data);

        $rss_feed_items_check = $repository->find($rss_feed_item_data->id);
        $this->assertNull($rss_feed_items_check);
    }

}
