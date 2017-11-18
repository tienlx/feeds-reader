<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use FeedReader;
use App\Repositories\RssFeedItemRepositoryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class LoadRSSFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rssfeeds:load {url=http://www.feedforall.com/sample.xml : Feed URL}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import RSS Feeds into database';

    /** @var \App\Repositories\ContactRepositoryInterface */
    protected $rssFeedItemRepository;

    protected $log;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RssFeedItemRepositoryInterface $rssFeedItemRepository)
    {
        parent::__construct();
        $this->rssFeedItemRepository = $rssFeedItemRepository;
        $this->log = new Logger(env('APP_ENV').'_load_feed_log');
        $this->log->pushHandler(new StreamHandler(storage_path('logs/'.env('LOAD_FEED_LOG')), Logger::INFO));
    }

    /**
     * Execute the console command.
     *
     * @return $status_code: 1 is success and 2 is error
     */
    public function handle()
    {
        $feed_urls = explode(',', $this->argument('url'));
        $feed_urls = array_map('trim', $feed_urls);

        $feed_reader = FeedReader::read($feed_urls);

        if ($feed_reader->error()) {
            $errors = $feed_reader->error();
            foreach ($errors as $error) {
                $this->log->error($error);
                $this->error($error);
            }
            return 2;
        }

        $this->comment('Load feeds...');
        $this->log->info('Load feeds...');
        $items = $feed_reader->get_items();
        $items_number = count($items);

        $rss_feed_items = array_map(function($item) {

            return [
                'title' => $item->get_title(),
                'link' => $item->get_link(),
                'categories' => $item->get_category()?$item->get_category()->get_label():'Uncategorized',
                'pub_date' => $item->get_date('U'),
                'guid' => $item->get_id(),
            ];
        }, $items);

        $this->comment('Found ' . $items_number . ' items...');
        $this->log->info('Found ' . $items_number . ' items...');
        $this->comment('Start import'.PHP_EOL);

        $progress_bar = $this->output->createProgressBar($items_number);
        foreach ($rss_feed_items as $rss_feed_item) {
            $this->rssFeedItemRepository->create($rss_feed_item);
            $progress_bar->advance();
        }
        $progress_bar->finish();
        $this->line(PHP_EOL);
        $this->info('Import success');
        $this->log->info('Import success');
        return 1;
    }
}
