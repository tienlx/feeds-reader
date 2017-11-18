# PHP Developer assignment

## Task

Laravel application is a feeds reader. The app can read feed from multiple feeds and store them to database. Sample feeds http://www.feedforall.com/sample-feeds.htm.

*(update 22/06/2017)*
# Project Setup Local Environment
1. Setup Homestead: https://laravel.com/docs/5.4/homestead

2. Get code from GitHub

3. Install dependencies

```bash
$ composer install
```

4. Start and SSH to Vagrant

```bash
$ vagrant up
$ vagrant ssh
```

5. Go to source code location and setup some Laravel environment variables

```bash
$ cp .env.example .env # sets up some Laravel environment variables for you
$ php artisan key:generate # set the application key
```

**.env file**

*Database setting*

```
(...)
DB_CONNECTION=mysql

DB_HOST=127.0.0.1 
DB_PORT=3306
DB_DATABASE=feed_reader 
DB_USERNAME=homestead
DB_PASSWORD=secret


TEST_DB_HOST=127.0.0.1
TEST_DB_PORT=3306
TEST_DB_DATABASE=test_feed_reader
TEST_DB_USERNAME=homestead
TEST_DB_PASSWORD=secret
(...)
```

*Load Feed log file setting location of this file is /souce_code_path/storage/logs/LOAD_FEED_LOG_filename*
```
(...)
LOAD_FEED_LOG=load_feed_log.log
(...)
```

6. Migrate database

```bash
$ php artisan migrate # migrate database for develop
$ php artisan migrate --database=testing_mysql # migrate database for testing database
```

7. Load RSS Feeds

```bash
$ php artisan rssfeeds:load http://your-feed1.com/rss,
  http://your-feed2.com/rss, etc
```

8. To running unit test (you need migrate testing database first need run only one time)

```bash
$ vendor/bin/phpunit
```

9. Play with the application.
