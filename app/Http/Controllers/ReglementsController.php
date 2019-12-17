<?php

namespace App\Http\Controllers;

use App\credit;
use App\Reglement;
use Illuminate\Http\Request;
use DB;

class ReglementsController extends Controller
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
        $client=DB::table('clients')
            ->join('ventes', function ($join) {
                $join->on('ventes.client_id', '=', 'clients.id');
            })
            ->select('clients.nom as nom','clients.prenom as prenom','clients.id as id')
            ->groupBy('id')
            ->get();
        $credit=array();
        for ($i =0 ;$i<count($client);$i++) {
            $total = DB::table('reglements')
                ->join('ventes', function ($join) {
                    $join->on('reglements.vente_id', '=', 'ventes.id');
                })
                ->join('clients', function ($join) {
                    $join->on('ventes.client_id', '=', 'clients.id');
                })
                ->where('ventes.client_id', '=', $client[$i]->id)
                ->SUM('reglements.montant_restant');
           $credit[$i] = $total;
        }
        return  $client;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=DB::table('ventes')->max('id');
        $reglement=new Reglement();
        $reglement->montant_donne = $request->input('donne');
        $reglement->montant_restant = $request->input('restant');
        $reglement->vente_id =$id;
        $reglement->save();
        return $request ->input();

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
