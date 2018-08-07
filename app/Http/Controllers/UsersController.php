<?php

namespace App\Http\Controllers;

use App\Users;
use App\Reviews;
use App\Http\Requests\UsersStoreFromRequest;
use App\Http\Requests\UsersUpdateFromRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Users::all());
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
    public function store(UsersStoreFromRequest $request)
    {
        $user = new Users();
        $user->last_name = $request->input('last_name');
        $user->first_name = $request->input('first_name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();
        return response($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Users::find($id));
    }

    /**
     * Display the salon information.
     *
     * @param  \App\Users  $stylist_id
     * @return \Illuminate\Http\Response
     */
    public function salon_info($stylist_id)
    {
        $salon_query = Users::query();
        $salon_query->where('users.id', $stylist_id);
        $salon_query->where('users.is_stylist', true);
        $salon_query->leftJoin('reviews', 'users.id', '=', 'reviews.deal_user_id');
        $salon = $salon_query->first();
        if (empty($salon->deal_user_id)) return response([]);
        $salon = [
            'stylist_id' => $salon->deal_user_id,
            'last_name' => $salon->last_name,
            'first_name' => $salon->first_name,
            'image_url' => $salon->image_url,
            'salon_name' => $salon->salon_name,
            'star_average' => $salon_query->avg('reviews.evaluate_star')
        ];

        return response($salon);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateFromRequest $request, Users $user)
    {
        if ($request->input('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->input('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->input('email')) {
            $user->email = $request->input('email');
        }
        if ($request->input('password')) {
            $user->password = $request->input('password');
        }
        if ($request->input('image_url')) {
            $user->image_url = $request->input('image_url');
        }
        if ($request->input('status_comment')) {
            $user->status_comment = $request->input('status_comment');
        }
        if ($request->input('charity_id')) {
            $user->charity_id = $request->input('charity_id');
        }
        if ($request->input('is_stylist')) {
            $user->is_stylist = $request->input('is_stylist');
        }
        if ($request->input('salon_name')) {
            $user->salon_name = $request->input('salon_name');
        }
        if ($request->input('salon_address')) {
            $user->salon_address = $request->input('salon_address');
        }
        if ($request->input('salon_location')) {
            $user->setLocationAttribute($request->input('salon_location'));
        }

        $user->save();
        return response($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users)
    {
        //
    }
}
