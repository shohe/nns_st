<?php

namespace App\Http\Controllers;

use App\Charities;
use App\Users;
use Illuminate\Http\Request;
use App\Http\Requests\CharitiesStoreFromRequest;
use App\Http\Requests\CharitiesUpdateFromRequest;

class CharitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Charities::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharitiesStoreFromRequest $request)
    {
        $charity = new Charities();
        // TODO: id will be loged in id
        $charity->title = $request->input('title');
        $charity->short_detail = $request->input('short_detail');
        $charity->detail_url = $request->input('detail_url');
        $charity->thumbnail_url = $request->input('thumbnail_url');
        $charity->save();
        return response($charity, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Charities  $charities
     * @return \Illuminate\Http\Response
     */
    public function show(Charities $charities)
    {
        //
    }

    /**
     * Display all charities with check which charity you checked.
     *
     * @param  \App\Users  $user_id
     * @return \Illuminate\Http\Response
     */
    public function with_user_id($user_id)
    {
        $charity_query = Charities::query();
        $charity_query->where('is_closed', false);
        $charities = $charity_query->get(['id', 'title', 'short_detail', 'detail_url', 'thumbnail_url']);
        $user = Users::find($user_id);

        foreach ($charities as $charity) {
            $charity['is_checked'] = ($user->charity_id == $charity->id) ? true : false;
        }

        return response($charities);
    }

    /**
     * Check if user selected the charity closed already
     *
     * @param  \App\Users  $user_id
     * @return \Illuminate\Http\Response : true -> closed (needs to notice), false -> still open
     */
    public function check_is_close($user_id)
    {
        $user = Users::find($user_id);
        $charity = Charities::find($user->charity_id);

        return response($charity->is_closed);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Charities  $charities
     * @return \Illuminate\Http\Response
     */
    public function edit(Charities $charities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Charities  $charities
     * @return \Illuminate\Http\Response
     */
    public function update(CharitiesUpdateFromRequest $request, Charities $charity)
    {
        if ($request->input('title')) {
            $charity->title = $request->input('title');
        }
        if ($request->input('short_detail')) {
            $charity->short_detail = $request->input('short_detail');
        }
        if ($request->input('detail_url')) {
            $charity->detail_url = $request->input('detail_url');
        }
        if ($request->input('thumbnail_url')) {
            $charity->thumbnail_url = $request->input('thumbnail_url');
        }
        if ($request->input('is_closed')) {
            $charity->is_closed = $request->input('is_closed');
        }

        $charity->save();
        return response($charity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Charities  $charities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charities $charities)
    {
        //
    }
}
