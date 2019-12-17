<?php

namespace App\Http\Controllers;

use App\Commande;
use App\commandeModele;
use App\Historique;
use App\Livraison;
use App\livraisonCommande;
use App\Modele;
use App\modeleFournisseur;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class LivraisonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livraison=Livraison::all();
        return datatables()->of($livraison)
            ->addColumn('action', function ($clt){

                return '
                                    <a class="btn btn-info" onclick="show('.$clt->id.')"> <i class="fa fa-info"></i></a> ';
            })
            ->make(true) ;
    }
    public function liste()
    {
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
        $historique=new Historique();
        $historique->actions = "Liste";
        $historique->cible = "Livraisons";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('livraison',compact('mod','modele2','clients','credit','cre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commande = DB::table('commandes')
            ->join('commande_modeles', function ($join) {
                $join->on('commande_modeles.commande_id', '=', 'commandes.id');
            })
            ->where ('commande_modeles.modele_fournisseur_id', '!=', null)
            ->where ('commande_modeles.etat', '=', false)
            ->select('commandes.id as id','commandes.numero as numero')
            ->groupBy('commandes.id')
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
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Livraisons";
        $historique->user_id =Auth::user()->id;
        $historique->save();
       return  view('newlivraison',compact('commande','mod','modele2','clients','credit','cre'));
    }
    /**

     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id=DB::table('livraisons')->max('id');
        $ed=1+$id;
        $livraison = new Livraison();
        $livraison ->numero="LIV".now()->format('Y')."-".$ed;
        $livraison ->date_livraison= now();
        $livraison->save();
        $alllivraison= explode( ',', $request->input('livTable') );
        for ($i =0 ;$i<count($alllivraison);$i+=2) {
        $commande = DB::table('commandes')
            ->join('commande_modeles', function ($join) {
                $join->on('commande_modeles.commande_id', '=', 'commandes.id');
            })
            ->join('modele_fournisseurs', function ($join) {
                $join->on('modele_fournisseurs.id', '=', 'commande_modeles.modele_fournisseur_id');
            })
            ->join('modeles', function ($join) {
                $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
            })
            ->join('produits', function ($join) {
                $join->on('produits.id', '=', 'modeles.produit_id');
            })
            ->join('fournisseurs', function ($join) {
                $join->on('fournisseurs.id', '=', 'modele_fournisseurs.fournisseur_id');
            })
            ->where('commande_modeles.id','=',$alllivraison[$i])
            ->select('commande_modeles.quantite as quantite','commande_modeles.id as idC','modeles.id as id','modeles.quantite as quant','commandes.id as commande')
            ->get();

        $quantite= DB::table('livraison_commandes')
            ->where('commande_modele_id',$alllivraison[$i] )
            ->sum('quantite_livre');
if ($quantite + $quantite-$alllivraison[$i+1] <=$commande[0]->quantite){
    $livraisoncommande = new livraisonCommande();
    $livraisoncommande ->livraison_id=$livraison ->id;
    $livraisoncommande  ->commande_modele_id=$alllivraison[$i];
    $livraisoncommande ->quantite_livre =$alllivraison[$i+1];
    $livraisoncommande->quantite_restante =$commande[0]->quantite - $quantite-$alllivraison[$i+1];
    $livraisoncommande->save();
    $modele_id = DB::table('modeles')
        ->join('modele_fournisseurs', function ($join) {
            $join->on('modele_fournisseurs.modele_id', '=', 'modeles.id');
        })
        ->join('commande_modeles', function ($join) {
            $join->on('commande_modeles.modele_fournisseur_id', '=', 'modele_fournisseurs.id');
        })

        ->join('livraison_commandes', function ($join) {
            $join->on('livraison_commandes.commande_modele_id', '=', 'commande_modeles.id');
        })
        ->where('livraison_commandes.id','=',$livraisoncommande->id)
        ->select('modeles.id as id')
        ->get();
    $modele= Modele::findOrFail($modele_id[0]->id);
    $modele->quantite=$modele->quantite+  $livraisoncommande ->quantite_livre;
    $modele->update();

    $liv= DB::table('livraison_commandes')
        ->where('commande_modele_id',$commande[0]->idC )
        ->latest('created_at')
        ->get();

    if ($liv[0]->quantite_restante==0){
        DB::table('commande_modeles')
            ->where('id',$commande[0]->idC)
            ->update(['etat' => true]);

    }
}
else {
    Alert::warning('Attention.....Livraison non effectuée','La quantite livré est superieur a celle commandé');
}


        }
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Livraisons";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return $commande;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
                */
    public function show($id)
    {
        $livraison =DB::table('livraisons')
            ->join('livraison_commandes', function ($join) {
                $join->on('livraisons.id', '=', 'livraison_commandes.livraison_id');
            })
            ->join('commande_modeles', function ($join) {
                $join->on('commande_modeles.id', '=', 'livraison_commandes.commande_modele_id');
            })
            ->join('modele_fournisseurs', function ($join) {
                $join->on('modele_fournisseurs.id', '=', 'commande_modeles.modele_fournisseur_id');
            })
            ->join('modeles', function ($join) {
                $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
            })
            ->join('fournisseurs', function ($join) {
                $join->on('fournisseurs.id', '=', 'modele_fournisseurs.fournisseur_id');
            })
            ->join('produits', function ($join) {
                $join->on('produits.id', '=', 'modeles.produit_id');
            })
            ->join('commandes', function ($join) {
                $join->on('commandes.id', '=', 'commande_modeles.commande_id');
            })
            ->where('livraisons.id','=',$id)
            ->select('commandes.numero as numero',
                'commandes.date_commande as dateC',
                'livraisons.date_livraison as dateL',
                'livraisons.numero as num',
                'modeles.libelle as modele',
                'produits.nom as produit',
                'livraison_commandes.quantite_livre as quantiteL',
                'fournisseurs.nom as fournisseur',
                'commande_modeles.etat as etat',
                'commande_modeles.quantite as quantiteC',
                'livraison_commandes.quantite_restante as quantiteR'
                )
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
        $historique=new Historique();
        $historique->actions = "Detail";
        $historique->cible = "Livraisons";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('detaillivraison',compact('livraison','mod','modele2','cre','credit','clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        $liv= DB::table('livraison_commandes')
            ->where('commande_modele_id',1 )
            ->latest('created_at')
            ->get();

        if ($liv[0]->quantite_restante==0){
            DB::table('commande_modeles')
                ->where('id',1 )
            ->update(['etat' => true]);

        }
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Livraisons";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return $liv[0]->quantite_restante;
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
