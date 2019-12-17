<?php

namespace App\Http\Controllers;

use App\Historique;
use Illuminate\Http\Request;
use DB;

class HistoriquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historique = DB::table('historiques')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'historiques.user_id');
})
            ->get();
        return datatables()->of($historique)
            ->addColumn('action', function ($clt){

                return ' <a class="btn btn-danger" onclick="deletecategorie('.$clt->id.')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true) ;
    }

    public function liste()
    {
        $historique = DB::table('historiques')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'historiques.user_id');
                    })
                    ->get();
                return view('historique',compact('historique'));

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
}
