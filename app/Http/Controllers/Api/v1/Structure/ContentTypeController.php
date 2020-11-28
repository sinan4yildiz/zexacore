<?php

namespace App\Http\Controllers\Api\v1\Structure;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentType;
use App\Http\Requests\Structure\ContentTypeRequest;
use App\Http\Resources\Structure\ContentTypeResource;

class ContentTypeController extends Controller
{
    protected $sortable = [];

    protected $sorted = 'sort_order';
    protected $ordered = 'asc';

    /**
     * List of content types
     *
     */
    public function index()
    {
        $content_types = ContentType::with('translation')->orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));

        /*$content_types = ContentType::join('content_type_translations AS ctt',
            function ($join) {
                $join->on('content_types.id', '=', 'ctt.content_type_id')->where('ctt.language_id', '=', 'en');
            })
            ->groupBy('countries.id')
            ->orderBy('t.name', 'desc')
            ->with('translations')
            ->get();*/


        /**
         * Query
         */
        $content_types = $content_types->paginate(10);


        /**
         * Response structure
         */
        return ContentTypeResource::collection($content_types)->additional([
            'meta' => [
                'sorting' => [
                    'sorted'   => request('sorted', $this->sorted),
                    'ordered'  => request('ordered', $this->ordered),
                    'sortable' => array_keys($this->sortable)
                ]
            ]
        ]);
    }

    /**
     * Create the new content type
     *
     * @param  \App\Http\Requests\Structure\ContentTypeRequest  $request
     * @param $id
     *
     */
    public function create(ContentTypeRequest $request)
    {
        /**
         * Store the content type
         */
        $item = new ContentType();
        $item->name = request('name');
        $item->native = request('native');
        $item->code = request('code');
        $item->locale = request('locale');
        $item->sort_order = request('sort_order', 1);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.create', [
            'name' => request('name')
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Update the existing content type
     *
     * @param  \App\Http\Requests\Structure\ContentTypeRequest  $request
     * @param $id
     *
     */
    public function update(ContentTypeRequest $request, $id)
    {
        /**
         * Save the content type data
         */
        $item = ContentType::findOrFail($id);
        $item->name = request('name');
        $item->native = request('native');
        $item->code = request('code');
        $item->locale = request('locale');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.update', [
            'name' => request('name')
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Order the content type
     *
     */
    public function order()
    {
        collect(request('orders'))->each(function ($order) {
            $item = ContentType::find($order['id']);

            if ($item) {
                $item->sort_order = $order['order'];
                $item->save();
            }
        });
    }

    /**
     * Activate the content type
     *
     * @param $id
     *
     */
    public function activate($id)
    {
        /**
         * Activate
         */
        $item = ContentType::findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.activate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Deactivate the content type
     *
     * @param $id
     *
     */
    public function deactivate($id)
    {
        /**
         * Deactivate
         */
        $item = ContentType::findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.deactivate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Remove the content type
     *
     * @param $id
     *
     */
    public function remove($id)
    {
        /**
         * Remove
         */
        $item = ContentType::with('translation')->findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.remove', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }
}
