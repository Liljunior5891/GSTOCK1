<?php

namespace App\Http\Controllers;
use App\Caisse;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $client=DB::table('Clients')->count ();
        $fournisseur=DB::table('Fournisseurs')->count ();
        $employe=DB::table('Users')->count ();
        $categorie=DB::table('Categories')->count ();
        $produit=DB::table('modeles')->count ();
        $commande=DB::table('commandes')->count ();
        $livraison=DB::table('livraisons')->count ();
        $caisse=DB::table('caisses')->count ();
        $role =DB::table('model_has_Roles')
            ->join('roles', function ($join) {
                $join->on('roles.id', '=', 'model_has_Roles.role_id');
            })
            ->where('model_has_Roles.model_id','=',Auth::user()->id)
            ->select('roles.name')
            ->get();
        $modele2=DB::table('modeles')
            ->join('produits', function ($join) {
                $join->on('modeles.produit_id', '=', 'produits.id');
            })
            ->whereColumn('modeles.seuil','>=','modeles.quantite')
            ->get();
        $mod=count($modele2);
        $clients=DB::table('clients')
            ->join('ventes', function ($join) {
                $join->on('ventes.client_id', '=', 'clients.id');
            })
            ->select('clients.nom as nom','clients.prenom as prenom','clients.id as id')
            ->groupBy('id')
            ->get();
        $credit=array();
        for ($i =0 ;$i<count($clients);$i++) {
            $total = DB::table('reglements')
                ->join('ventes', function ($join) {
                    $join->on('reglements.vente_id', '=', 'ventes.id');
                })
                ->where('ventes.client_id', '=', $clients[$i]->id)
                ->SUM('reglements.montant_restant');
            $credit[$i] = $total;
        }
        $cre=count($clients);

        return view('bord.index',compact('client','caisse','fournisseur', 'employe','mod','modele2','categorie','produit','commande','livraison','role','cre','clients','credit'));
    }


    public function magasin()
    {
        if (Auth::user()->flag_etat==true){
            Alert::warning('Attention.....Compte bloqué','Veuillez vous référer a votre administrateur');
            return view('connexion');
        }
        $fournisseur=DB::table('Fournisseurs')->count ();
        $categorie=DB::table('Categories')->count ();
        $produit=DB::table('modeles')->count ();
        $commande=DB::table('commandes')->count ();
        $livraison=DB::table('livraisons')->count ();
        $modele2=DB::table('modeles')
            ->join('produits', function ($join) {
                $join->on('modeles.produit_id', '=', 'produits.id');
            })
            ->whereColumn('modeles.seuil','>=','modeles.quantite')
            ->get();
        $mod=count($modele2);
        return view('bord.magasin',compact('caisse','fournisseur','categorie','produit','commande','livraison','mod','modele2'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function caisse()
    {
        if (Auth::user()->flag_etat==true){
            Alert::warning('Attention.....Compte bloqué','Veuillez vous référer a votre administrateur');
            return view('connexion');
        }
        $client=DB::table('Clients')->count ();
        $modele2=DB::table('modeles')
            ->join('produits', function ($join) {
                $join->on('modeles.produit_id', '=', 'produits.id');
            })
            ->whereColumn('modeles.seuil','>=','modeles.quantite')
            ->get();
        $mod=count($modele2);
        return view('bord.caisse',compact('client','mod','modele2'));
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
