<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Fournisseur;
use App\Historique;
use App\modeleFournisseur;
use App\Produit;
use App\Provision;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseur=Fournisseur::all();
        return datatables()->of($fournisseur)
            ->addColumn('action', function ($clt){

                return ' <a class="btn btn-info " onclick="showfournisseur('.$clt->id.')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-success" onclick="editfournisseur('.$clt->id.')"> <i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" onclick="deletefournisseur('.$clt->id.')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true) ;
    }
    public function index2()
    {
        $fournisseurP = DB::table('modele_fournisseurs')
            ->join('fournisseurs', function ($join) {
                $join->on('fournisseurs.id', '=', 'modele_fournisseurs.fournisseur_id');
            })
            ->join('modeles', function ($join) {
                $join->on('modele_fournisseurs.modele_id', '=', 'modeles.id');
            })
            ->join('produits', function ($join) {
                $join->on('produits.id', '=', 'modeles.produit_id');
            })
            ->select ('modele_fournisseurs.id as id','modele_fournisseurs.prix as prix','fournisseurs.nom as fournisseur','modeles.libelle as modele','produits.nom as produit','produits.id as idproduit')
            ->get();
        return datatables()->of($fournisseurP)
            ->addColumn('action', function ($fourni){

                return ' <a class="btn btn-info " onclick="showfourni('.$fourni->id.')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-success" onclick="editfourni('.$fourni->id.')"> <i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" onclick="deletefourni('.$fourni->id.')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true) ;
    }

    public function liste()
    {
        $fournisseur=Fournisseur::all();
        $categorie=Categorie::all();
        $historique=new Historique();
        $historique->actions = "Liste";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('fournisseur',compact('fournisseur','categorie'));
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
        $fournisseur = new Fournisseur;
        $fournisseur->nom = $request->input('nom');
        $fournisseur->adresse = $request->input('adresse');
        $fournisseur->description = $request->input('description');
        $fournisseur->email = $request->input('email');
        $fournisseur->contact = $request->input('contact');
        $fournisseur->save();
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return $request ->input();
    }
    public function store2(Request $request)
    {
        $fournisseurP = new modeleFournisseur();
        $fournisseurP->fournisseur_id = $request->input('fournisseurP');
        $fournisseurP->modele_id = $request->input('modele');
        $fournisseurP->prix = $request->input('prix');
        $fournisseurP->save();
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Fournisseurs";
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
        $fournisseur= Fournisseur::findOrFail($id);
        $historique=new Historique();
        $historique->actions = "Detail";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return $fournisseur;
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
        $fournisseur= Fournisseur::findOrFail($request->input('idfournisseur'));
        $fournisseur->nom = $request->input('nom');
        $fournisseur->adresse = $request->input('adresse');
        $fournisseur->description = $request->input('description');
        $fournisseur->email = $request->input('email');
        $fournisseur->contact = $request->input('contact');
        $fournisseur->update();
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
    public function update2(Request $request)
    {
        $provision= Provision::with('fournisseur','produit')->findOrFail($request->input('idfournisseur_produit'));
        $provision->fournisseur_id = $request->input('fournisseurP');
        $provision->produit_id = $request->input('produit');
        $provision->update();
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Fournisseurs";
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
        $fournisseur= Fournisseur::findOrFail($id);
        $fournisseur ->delete();
        $historique=new Historique();
        $historique->actions = "Supprimer";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
    public function destroy2($id)
    {
        $fournisseurP= modeleFournisseur::findOrFail($id);
        $fournisseurP ->delete();
        $historique=new Historique();
        $historique->actions = "Supprimer";
        $historique->cible = "Fournisseurs";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
    public function produit($id)
    {
        $produit=DB::table('produits')
            ->where ('categorie_id', '=', $id)
            ->get();
        return $produit;
    }
    public function modele($id)
    {
        $modele=DB::table('modeles')
            ->where ('produit_id', '=', $id)
            ->where ('quantite', '>',  0)
            ->get();
        return $modele;
    }
    public function fournisseur($id)
    {
        $fournisseur = DB::table('modele_fournisseurs')
            ->join('fournisseurs', function ($join) {
                $join->on('fournisseurs.id', '=', 'modele_fournisseurs.fournisseur_id');
            })
            ->join('modeles', function ($join) {
                $join->on('modele_fournisseurs.modele_id', '=', 'modeles.id');
            })
            ->where ('modele_fournisseurs.modele_id', '=', $id)
            ->select ('fournisseurs.nom as fournisseur',
                'fournisseurs.id as id',
                'modele_fournisseurs.prix as prix',
                'modeles.quantite as stock',
                'modele_fournisseurs.id as modele')
            ->get();
        return $fournisseur;
    }
    public function produit2($id)
    {
        $produit = DB::table('modele_fournisseurs')
            ->join('modeles', function ($join) {
                $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
            })
            ->join('produits', function ($join) {
                $join->on('produits.id', '=', 'modeles.produit_id');
            })
            ->where('modele_fournisseurs.fournisseur_id', '=', $id)
            ->select('produits.nom as produit', 'produits.id as id')
            ->groupBy('produits.id')
            ->get();
        return $produit;
    }
}
