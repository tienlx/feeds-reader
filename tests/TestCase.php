<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected static $baseUrl = 'http://8bit-feed-reader.app/';

    protected static $testFolderPath;

    public function setUp()
    {
        self::$testFolderPath = dirname(__FILE__);
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function getResponseViewContent(TestResponse $response, $key)
    {
        $org_content = $response->baseResponse->getOriginalContent();
        $value = $org_content->getData()[$key];
        return $value;
    }
}
