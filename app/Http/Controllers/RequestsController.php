<?php

namespace App\Http\Controllers;

use App\Requests;
use App\Offers;
use App\Users;
use App\Reviews;
use Illuminate\Http\Request;
use App\Http\Requests\RequestsStoreFormRequest;
use App\Http\Requests\RequestsUpdateFormRequest;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Requests::all());
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
    public function store(RequestsStoreFormRequest $request)
    {
        $req = new Requests();
        // TODO: id will be loged in id
        $req->stylist_id = \App\Users::query()->first()->id;
        $req->offer_id = $request->input('offer_id');
        $req->price = $request->input('price');
        $req->comment = $request->input('comment');
        $req->save();
        return response($req, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Requests::find($id));
    }

    /**
     * Display the all requests received for customer's offer sent last time
     * @param Integer customer id
     * @return \App\Requests
     */
    public function received($cx_id)
    {
        // offer
        $offer_query = Offers::query();
        $offer_query->where('cx_id', $cx_id);
        $offer_query->where('is_closed', false);
        $offer_query->orderBy('id', 'desc');
        $offer = $offer_query->first();
        if (empty($offer)) return response([]);

        // requests
        $request_query = Requests::query();
        $request_query->where('requests.offer_id', $offer->id);
        $request_query->leftJoin('users', 'users.id', '=', 'requests.stylist_id');
        $requests = $request_query->get(['requests.id as request_id', 'users.last_name', 'users.first_name', 'users.image_url']);

        return response($requests);
    }

    /**
     * Display detail of the request for custommer's offer
     * @param Integer request id
     * @return \App\Requests
     */
    public function detail($request_id)
    {
        // stylist detail
        $request_query = Requests::query();
        $request_query->where('requests.id', $request_id);
        $request_query->leftJoin('users', 'users.id', '=', 'requests.stylist_id');
        $request_detail = $request_query->first([
            'requests.id as request_id', 'users.id as stylist_id', 'users.last_name',
            'users.first_name', 'users.image_url', 'users.status_comment', 'requests.price', 'requests.comment',
            'users.salon_name', 'users.salon_address'
        ]);

        // reviews
        $review_query = Reviews::query();
        $review_query->where('reviews.deal_user_id', $request_detail->stylist_id);
        $review_query->leftJoin('users', 'users.id', '=', 'reviews.write_user_id');
        $reviews = $review_query->get(['users.last_name', 'users.first_name', 'reviews.evaluate_star', 'reviews.review', 'reviews.created_at']);

        // star avetage
        $star_average = $review_query->avg('reviews.evaluate_star');
        $request_detail['star_average'] = floatval($star_average);

        $results = ['request_detail' => $request_detail, 'reviews' => $reviews];
        return response($results);
    }

    /**
     * Display all requests history for customer's offer
     * @param Integer customer id
     * @return \App\Requests
     */
    public function history($cx_id)
    {
        // offer
        $offer_query = Offers::query();
        $offer_query->where('cx_id', $cx_id);
        $offer_query->orderBy('id', 'desc');
        $offer = $offer_query->first();
        if (empty($offer)) return response([]);

        // requests
        $request_query = Requests::query();
        $request_query->where('requests.offer_id', $offer->id);
        $request_query->leftJoin('users', 'users.id', '=', 'requests.stylist_id');
        $request_query->leftJoin('offers', 'offers.id', '=', 'requests.offer_id');
        $requests = $request_query->get([
            'requests.id as request_id', 'users.last_name', 'users.first_name', 'users.image_url', 'requests.created_at as request_date',
            'offers.menu', 'requests.price', 'requests.is_matched'
        ]);

        return response($requests);
    }

    /**
     * Display detail of requests history for customer's offer
     * @param Integer request id
     * @return \App\Requests
     */
    public function history_detail($request_id)
    {
        // stylist detail
        $request_query = Requests::query();
        $request_query->where('requests.id', $request_id);
        $request_query->leftJoin('users', 'users.id', '=', 'requests.stylist_id');
        $request_query->leftJoin('offers', 'offers.id', '=', 'requests.offer_id');
        $request_query->leftJoin('charities', 'charities.id', '=', 'offers.charity_id');
        $request_detail = $request_query->first([
            'requests.id as request_id', 'users.id as stylist_id', 'users.last_name',
            'users.first_name', 'users.image_url', 'requests.price','charities.title as charity_title',
            'offers.date_time', 'offers.hair_type', 'offers.comment'
        ]);

        return response($request_detail);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function edit(Requests $requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function update(RequestsUpdateFormRequest $req, Requests $request)
    {
        if ($req->input('is_matched')) {
            $request->is_matched = $req->input('is_matched');
        }

        $request->save();
        return response($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests $requests)
    {
        //
    }
}
