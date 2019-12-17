<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Historique;
use App\Modele;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class ModelesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modele=Modele::with('produit');
        return datatables()->of($modele)
            ->addColumn('action', function ($clt){

                return ' <a class="btn btn-info " onclick="showmodele('.$clt->id.')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-success" onclick="editmodele('.$clt->id.')"> <i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" onclick="deletemodele('.$clt->id.')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true) ;
    }

    public function liste()
    {  $historique=new Historique();
        $historique->actions = "Liste";
        $historique->cible = "Modeles";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        $categorie=Categorie::all();
        return view('produit',compact('categorie'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {$id=DB::table('modeles')->max('id');
        $ed=1+$id;
        $modele = new Modele();
        $modele->libelle = $request->input('modele');
        $modele->quantite = $request->input('quantite');
        $modele->prix = $request->input('prix');
        $modele->seuil = $request->input('seuil');
        $modele->numero ="MOD".now()->format('Y')."-".$ed;
        $modele->produit_id =$request->input('famille');
        $modele->save();
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Modeles";
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
        $historique->cible = "Modeles";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        $modele= Modele::with('produit')->findOrFail($id);
        return $modele;
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
        $modele = Modele::findOrFail($request->input('idmodele'));
        $modele->libelle = $request->input('modele');
        $modele->quantite = $request->input('quantite');
        $modele->prix = $request->input('prix');
        $modele->seuil = $request->input('seuil');
        $modele->produit_id =$request->input('famille');
        $modele->update();
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Modeles";
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
        $modele= Modele::findOrFail($id);
        $modele ->delete();
        $historique=new Historique();
        $historique->actions = "Supprimer";
        $historique->cible = "Modeles";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
}
