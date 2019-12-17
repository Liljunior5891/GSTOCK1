<?php

namespace App\Http\Controllers;

use App\Client;
use App\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client=Client::all();
        return datatables()->of($client)
            ->addColumn('action', function ($clt){

                    return ' <a class="btn btn-info " onclick="showclt('.$clt->id.')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-success" onclick="editclt('.$clt->id.')"> <i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" onclick="deleteclt('.$clt->id.')"><i class="fa fa-trash-o"></i></a> ';
                })
            ->make(true) ;
    }

    public function liste()
    {
        $historique=new Historique();
        $historique->actions = "liste";
        $historique->cible = "Clients";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('client');
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
        $client = new Client;
        $client->nom = $request->input('nom');
        $client->prenom = $request->input('prenoms');
        $client->sexe = $request->input('sexe');
        $client->email = $request->input('email');
        $client->contact = $request->input('contact');
        $client->save();
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Clients";
        $historique->user_id =Auth::user()->id;
        $historique->save();
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
        $historique=new Historique();
        $historique->actions = "Detail";
        $historique->cible = "Clients";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        $client= Client::findOrFail($id);
        return $client;
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
    public function update(Request $request)
    {
       $client= Client::findOrFail($request->input('idclient'));
        $client->nom = $request->input('nom');
        $client->prenom = $request->input('prenoms');
        $client->sexe = $request->input('sexe');
        $client->email = $request->input('email');
        $client->contact = $request->input('contact');
        $client->update();
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Clients";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client= Client::findOrFail($id);
        $client ->delete();
        $historique=new Historique();
        $historique->actions = "Supprimer";
        $historique->cible = "Clients";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
}
