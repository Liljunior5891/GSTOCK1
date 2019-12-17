<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Commande;
use App\commandeModele;
use App\Fournisseur;
use App\Historique;
use App\Modele;
use App\Produit;
use App\produitProvision;
use App\Provision;
use DB;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fournisseur($id)
    {
        $fournisseur=Provision::with('fournisseur','produit')->where ('produit_id', '=', $id)->get();
        return $fournisseur;
    }
    public function provision($id,$ed)
    {
        $provision=DB::table('provisions')
            ->where ('fournisseur_id', '=', $id)
            ->where ('produit_id', '=', $ed)

            ->get();
        return $provision;
    }
    public function commande($id)
    {
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
            ->where('commandes.id','=',$id)
            ->select(
                'modeles.libelle as modele',
                'commande_modeles.etat as etat',
                'produits.nom as produit',
                'commande_modeles.id as id')
            ->get();
        return $commande;
    }


    public function index()
    {
        $commande = Commande::all();
        return datatables()->of($commande)
            ->addColumn('action', function ($clt) {
                return  '<a class="btn btn-info " onclick="show(' . $clt->id . ')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-danger" onclick="deletepro(' . $clt->id . ')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true);
    }


    public function liste($id)
    {
        $categorie=Categorie::all();
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
            ->where('commandes.id','=',$id)
            ->select('commandes.numero as numero',
                'commandes.date_commande as date',
                'fournisseurs.nom as fournisseur',
                'modeles.libelle as modele',
                'produits.nom as produit',
                'commande_modeles.quantite as quantite',
                'commande_modeles.prix as prix',
                'commandes.created_at as create',
                'commandes.updated_at as update')
            ->get();
        $historique=new Historique();
        $historique->actions = "Liste";
        $historique->cible = "Commandes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('provision',compact('categorie','commande'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { $categorie=Categorie::all();
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
        return view('newcommande',compact('categorie','mod','modele2','clients','credit','cre'));
    }
  public function create2()
    { $fournisseur=Fournisseur::all();
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
        return view('newcommande2',compact('fournisseur','mod','modele2','clients','credit','cre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=DB::table('commandes')->max('id');
        $ed=1+$id;
        $commande = new Commande();
        $commande ->numero="COM".now()->format('Y')."-".$ed;
        $commande ->date_commande= now();
        $commande->save();
        $allcommande= explode( ',', $request->input('comTable') );
        for ($i =0 ;$i<count($allcommande);$i+=3) {
            $commandemodele = new commandeModele();
            $commandemodele ->commande_id=$commande ->id;
            $commandemodele ->modele_fournisseur_id=$allcommande[$i];
            $commandemodele ->prix =$allcommande[$i+1];
            $commandemodele -> quantite= $allcommande[$i+2];
            $commandemodele->save();
            $modele_id = DB::table('modeles')
                ->where('modeles.id','=',$allcommande[$i])
                ->select('modeles.id as id')
                ->get();
            $modele= Modele::findOrFail($modele_id[0]->id);
            $modele->quantite=$modele->quantite+  $allcommande[$i+2];
            $modele->update();
        }

        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Commandes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
    return view('provision');
    }
    public function store2(Request $request)
    {
        $id=DB::table('commandes')->max('id');
        $ed=1+$id;
        $commande = new Commande();
        $commande ->numero="COM".now()->format('Y')."-".$ed;
        $commande ->date_commande= now();
        $commande->save();
        $allcommande= explode( ',', $request->input('comTable') );
        for ($i =0 ;$i<count($allcommande);$i+=3) {
            $commandemodele = new commandeModele();
            $commandemodele ->commande_id=$commande ->id;
            $commandemodele ->prix =$allcommande[$i+1];
            $commandemodele -> quantite= $allcommande[$i+2];
            $commandemodele->save();
        }
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Commandes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
    return view('provision');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
            ->where('commandes.id','=',$id)
                 ->select('commandes.numero as numero',
                     'commandes.date_commande as date',
                     'fournisseurs.nom as fournisseur',
                     'modeles.libelle as modele',
                     'produits.nom as produit',
                     'commande_modeles.quantite as quantite',
                     'commande_modeles.prix as prix',
                     'commandes.created_at as create',
                     'commandes.updated_at as update')
            ->get();
        $historique=new Historique();
        $historique->actions = "Detail";
        $historique->cible = "Commandes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('detailcommande',compact('commande'));

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
        $provision= produitProvision::findOrFail($request->input('idprovision'));
        $provision->quantite = $request->input('quantite');
        $provision->prix_achat = $request->input('prix');
        $provision->date_provision = $request->input('dateprovision');
        $provision->provision_id = $request->input('provision');
        $provision->update();
        $historique=new Historique();
        $historique->actions = "Modifier";
        $historique->cible = "Commandes";
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
        $commande=Commande::findOrFail($id);
        DB::table('commande_modeles')->where('commande_id', '=', $commande->id)->delete();
        $commande ->delete();
        $historique=new Historique();
        $historique->actions = "Supprimer";
        $historique->cible = "Commandes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return [];
    }
}
