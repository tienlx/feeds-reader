<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RssFeedRequest;
use App\Repositories\RssFeedItemRepositoryInterface;
use Illuminate\Http\Request;

class RssFeedController extends Controller
{
    protected $rss_feed_item_repository;


    public function __construct(
        RssFeedItemRepositoryInterface $rss_feed_item_repository
    )
    {
        $this->rss_feed_item_repository = $rss_feed_item_repository;
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return \Response
     */
    public function index(Request $request)
    {
        $search_category = $request->get('search_category');
        if (isset($search_category)) {
            $where_condition = [
                ['categories','like', '%'.$search_category.'%']
            ];
            $rss_feeds = $this->rss_feed_item_repository->paginate($this->page_number, $where_condition);
        } else {
            $rss_feeds = $this->rss_feed_item_repository->paginate($this->page_number);
        }


        return view('pages.rss_feed.index', [
            'models' => $rss_feeds,
            'search_category' => $search_category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.rss_feed.edit', [
            'isNew' => true,
            'model' => $this->rss_feed_item_repository->getBlankModel(),
        ]);
    }

    /**
     * @param RssFeedRequest $request
     *
     * @return \Response
     */
    public function store(RssFeedRequest $request)
    {
        $input = $request->only([
            'title',
            'link',
            'categories',
            'pub_date',
            'guid'
        ]);
        $model = $this->rss_feed_item_repository->create($input);
        if (empty($model)) {
            return redirect()->back()->withErrors('Save Failed');
        }
        return redirect()->action('RssFeedController@index')->with('message-success', 'Create Success');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function show($id)
    {
        $model = $this->rss_feed_item_repository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.rss_feed.edit', [
            'isNew' => false,
            'model' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param RssFeedRequest $request
     *
     * @return \Response
     */
    public function update($id, RssFeedRequest $request)
    {
        $rss_feed_item = $this->rss_feed_item_repository->find($id);
        if (empty($rss_feed_item)) {
            abort(404);
        }
        $input = $request->only([
            'title',
            'link',
            'categories',
            'pub_date',
            'guid'
        ]);

        $this->rss_feed_item_repository->update($rss_feed_item, $input);
        return redirect()->action('RssFeedController@show', [$id])->with('message-success', 'Update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function destroy($id)
    {
        $model = $this->rss_feed_item_repository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->rss_feed_item_repository->delete($model);

        return redirect()->action('RssFeedController@index')->with('message-success', 'Delete Success');
    }
}