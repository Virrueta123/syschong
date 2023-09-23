<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class user_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /* ******** aixos  ************* */
    public function search_mecanico(Request $req)
    {
        if ($req->all()['search'] == '') {

            $search_mecanico = User::select(DB::raw('id AS id'), DB::raw('CONCAT(name, " ", last_name) as name'))
                ->where('roles_id', '2') 
                ->get();

        } else {
             
            $search_mecanico = User::select(DB::raw('id AS id'), DB::raw('CONCAT(name, " ", last_name) as name')) 
            ->where(function($query) use ($req) {
                $query->where('name', 'like', '%' . $req->all()['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $req->all()['search'] . '%');
            })
            ->where('roles_id', '2')   
            ->get();
        }

        echo json_encode($search_mecanico);
    }
    /* *********************** */
}
