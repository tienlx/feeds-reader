<?php
namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoaderTest extends TestCase
{
    use DatabaseMigrations;

    protected static $sampleFeed;
    protected $sampleFeedURL;
    protected $useDatabase = true;

    public function setUp()
    {
        parent::setUp();
        $rss_sample = file_get_contents(parent::$testFolderPath . '/Assets/RSS/sample.xml');
        $sampleFeed = new \SimplePie();
        $sampleFeed->set_raw_data($rss_sample);
        $sampleFeed->init();
        self::$sampleFeed = $sampleFeed;

        $this->sampleFeedURL = 'http://www.feedforall.com/sample.xml';
    }

    public function testLoadFeed()
    {
        \Awjudd\FeedReader\Facades\FeedReader::shouldReceive('read')
            ->once()
            ->with([$this->sampleFeedURL])
            ->andReturn(self::$sampleFeed);

        $result_status = \Illuminate\Support\Facades\Artisan::call('rssfeeds:load', [
            'url' => $this->sampleFeedURL,
        ]);
        $this->assertEquals(1, $result_status);

        $sampleItem = self::$sampleFeed->get_item();

        $this->assertDatabaseHas('rss_feed_items', [
            'title' => $sampleItem->get_title(),
            'link' => $sampleItem->get_link(),
            'categories' => $sampleItem->get_category()->get_label(),
            'guid' => $sampleItem->get_id(),
        ]);
    }

    public function testLoadFeedWithTwoURL()
    {
        $sampleFeedURL2nd = 'http://www.feedforall.com/sample-feed.xml';
        $result_status = \Illuminate\Support\Facades\Artisan::call('rssfeeds:load', [
            'url' => $this->sampleFeedURL.','. $sampleFeedURL2nd,
        ]);
        $this->assertEquals(1, $result_status);
    }

    public function testLoadFeedWithURLNoRSS()
    {
        $result_status = \Illuminate\Support\Facades\Artisan::call('rssfeeds:load', [
            'url' => 'https://google.com',
        ]);
        $this->assertEquals(2, $result_status);

        $result_status = \Illuminate\Support\Facades\Artisan::call('rssfeeds:load', [
            'url' => 'https://google.com,https://facebook.com',
        ]);
        $this->assertEquals(2, $result_status);
    }
}