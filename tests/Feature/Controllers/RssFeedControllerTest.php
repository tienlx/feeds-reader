<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class RssFeedControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetInstance()
    {
        $controller = \App::make(\App\Http\Controllers\RssFeedController::class);
        $this->assertNotNull($controller);
    }

    public function testGetList()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPaginated()
    {
        factory(\App\Models\RssFeedItem::class, 16)->create();
        $response = $this->get('/?page=2');
        $response->assertStatus(200);
        $view_value = $this->getResponseViewContent($response, 'models');
        $number_model_items = $view_value->items();
        $this->assertEquals(count($number_model_items), 5);

        $response = $this->get('/?page=4');
        $response->assertStatus(200);
        $view_value = $this->getResponseViewContent($response, 'models');
        $number_model_items = $view_value->items();
        $this->assertEquals(count($number_model_items), 1);

        $response = $this->get('/?page=5');
        $response->assertStatus(200);
        $view_value = $this->getResponseViewContent($response, 'models');
        $number_model_items = $view_value->items();
        $this->assertEquals(count($number_model_items), 0);
    }

    public function testSearch()
    {
        factory(\App\Models\RssFeedItem::class, 10)->create();
        factory(\App\Models\RssFeedItem::class, 3)->states('test_category')->create();

        $response = $this->get('/?search_category='.'test+category');
        $response->assertStatus(200);
        $view_value = $this->getResponseViewContent($response, 'models');
        $number_model_items = $view_value->items();
        $this->assertEquals(count($number_model_items), 3);
    }

    public function testCreateModel()
    {
        $response = $this->get('/feeds/create');
        $response->assertStatus(200);
    }

    public function testStoreModel()
    {
        $rss_feed = factory(\App\Models\RssFeedItem::class)->make();
        $postData = $rss_feed->toFillableArray();
        $response = $this->post('/feeds',[
                '_token' => csrf_token(),
            ] + $postData);
        $response->assertStatus(302);
        $response->assertRedirect('/feeds/');
    }

    public function testEditModel()
    {
        $rss_feed = factory(\App\Models\RssFeedItem::class)->create();
        $response = $this->get('/feeds/'.$rss_feed->id);
        $response->assertStatus(200);
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $rss_feed = factory(\App\Models\RssFeedItem::class)->create();

        $title = $faker->sentence;
        $id = $rss_feed->id;
        $rss_feed->title = $title;

        $response = $this->put('/feeds/'.$id, [
                '_token' => csrf_token(),
            ] + $rss_feed->toFillableArray());
        $response->assertStatus(302);
        $response->assertRedirect('/feeds/'.$id);

        $newArticle = \App\Models\RssFeedItem::find($id);
        $this->assertEquals($title, $newArticle->title);
    }

    public function testDeleteModel()
    {
        $rss_feed = factory(\App\Models\RssFeedItem::class)->create();

        $id = $rss_feed->id;

        $response = $this->delete('/feeds/'.$id, [
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/feeds/');

        $checkArticle = \App\Models\RssFeedItem::find($id);
        $this->assertNull($checkArticle);
    }
}