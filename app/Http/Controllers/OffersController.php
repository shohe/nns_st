<?php

namespace App\Http\Controllers;

use App\Offers;
use App\Users;
use Illuminate\Http\Request;
use App\Http\Requests\OffersStoreFormRequest;
use App\Http\Requests\OffersUpdateFormRequest;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Offers::all());
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
    public function store(OffersStoreFormRequest $request)
    {
        $offer = new Offers();
        // TODO: id will be loged in id
        $offer->cx_id = \App\Users::query()->first()->id;
        $offer->menu = $request->input('menu');
        $offer->price = $request->input('price');
        $offer->date_time = $request->input('date_time');
        $offer->distance_range = $request->input('distance_range');
        $offer->setLocationAttribute($request->input('user_location'));
        $offer->hair_type = $request->input('hair_type');
        $offer->comment = $request->input('comment');
        $offer->charity_id = $request->input('charity_id');
        $offer->save();
        return response($offer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    // public function show(Offers $offers)
    // {
    //     //
    // }
    public function show($id)
    {
        return response(Offers::find($id));
    }

    /**
     * Display the all requests received for customer's offer sent last time
     * @param -
     * @return \App\Offers
     */
    public function received($id)
    {
        $query_with_stylist = Offers::query();
        $query_with_stylist->where('is_closed', false);
        $query_with_stylist->where('stylist_id', $id);
        $query_with_stylist->orderBy('id', 'desc');
        // $offer_with_stylist = $query_with_stylist->get();

        $user = Users::find($id);
        if (empty($user->salon_location)) return;
        $salon_location = Users::getLocationAttribute($user->salon_location);
        $one_km = 0.0089831601679492;
        $query_without_stylist = Offers::query();
        $query_without_stylist->where('is_closed', false);
        $query_without_stylist->where('stylist_id', '=', null);
        $query_without_stylist->whereRaw("GLENGTH(GEOMFROMTEXT(CONCAT('LINESTRING(',?,' ',?, ',',X(user_location),' ',Y(user_location),')'))) <= distance_range * ?", [$salon_location['lat'], $salon_location['lng'], $one_km]);
        $query_without_stylist->orderBy('id', 'desc');
        // $offer_without_stylist = $query_without_stylist->get();

        $results = $query_with_stylist->union($query_without_stylist)->get();
        return response($results);

        /* [SQL memo]
        **************
        1. User has to be a stylist.
        2. Offer has to be within the range of user decided.
        3. 1km = 0.0089831601679492°
        ---
        1. users.salon_location != null
        2. users.salon_location - offers.user_location <= offers.distance_range * 0.0089831601679492°
        */
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function edit(Offers $offers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function update(OffersUpdateFormRequest $request, Offers $offer)
    {
        if ($request->input('is_closed')) {
            $offer->is_closed = $request->input('is_closed');
        }

        $offer->save();
        return response($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offers $offers)
    {
        //
    }
}
