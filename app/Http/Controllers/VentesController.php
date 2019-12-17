<?php

namespace App\Http\Controllers;

use App\Client;
use App\Facture;
use App\Historique;
use App\Modele;
use App\Prevente;
use App\Produit;
use App\Reglement;
use App\vente;
use DB;
use App\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vente = vente::all();
        return datatables()->of($vente)
            ->addColumn('action', function ($clt) {
                return  '<a class="btn btn-info " onclick="show(' . $clt->id . ')" ><i class="fa  fa-info"></i></a>
                                    <a class="btn btn-danger" onclick="deletepro(' . $clt->id . ')"><i class="fa fa-trash-o"></i></a> ';
            })
            ->make(true);
    }


    public function liste()
    {
        $vente=vente::all();
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
        $historique->cible = "Ventes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        return view('vente',compact('vente','modele2','mod','clients','credit','cre'));
    }
    public function reglement()
    {
        $id=DB::table('ventes')->max('id');
        $vente = DB::table('ventes')
        ->join('preventes', function ($join) {
            $join->on('preventes.vente_id', '=', 'ventes.id');
        })
        ->join('modele_fournisseurs', function ($join) {
            $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
        })
        ->join('modeles', function ($join) {
            $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
        })
        ->join('produits', function ($join) {
            $join->on('produits.id', '=', 'modeles.produit_id');
        })
        ->where('ventes.id','=',$id)
        ->select('ventes.numero as numero',
            'ventes.date_vente as date',
            'modeles.libelle as modele',
            'produits.nom as produit',
            'preventes.quantite as quantite',
            'preventes.prix as prix',
            'preventes.prixtotal as prixtotal',
            'ventes.created_at as create',
            'ventes.updated_at as update')
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
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$id)
            ->SUM('preventes.prixtotal');
        return view('reglement',compact('vente','modele2','mod','total','clients','cre','credit'));
    }
    public function reglementcredit()
    {
        $id=DB::table('ventes')->max('id');
        $vente = DB::table('ventes')
        ->join('preventes', function ($join) {
            $join->on('preventes.vente_id', '=', 'ventes.id');
        })
        ->join('modele_fournisseurs', function ($join) {
            $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
        })
        ->join('modeles', function ($join) {
            $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
        })
        ->join('produits', function ($join) {
            $join->on('produits.id', '=', 'modeles.produit_id');
        })
        ->where('ventes.id','=',$id)
        ->select('ventes.numero as numero',
            'ventes.date_vente as date',
            'modeles.libelle as modele',
            'produits.nom as produit',
            'preventes.quantite as quantite',
            'preventes.prix as prix',
            'preventes.prixtotal as prixtotal',
            'ventes.created_at as create',
            'ventes.updated_at as update')
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
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$id)
            ->SUM('preventes.prixtotal');
        return view('reglementcredit',compact('vente','modele2','mod','total','clients','credit','cre'));
    }

    public function facturecredit(Request $request)
    {
        $id=DB::table('ventes')->max('id');
        $vente = DB::table('ventes')
        ->join('preventes', function ($join) {
            $join->on('preventes.vente_id', '=', 'ventes.id');
        })
        ->join('modele_fournisseurs', function ($join) {
            $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
        })
        ->join('modeles', function ($join) {
            $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
        })
        ->join('produits', function ($join) {
            $join->on('produits.id', '=', 'modeles.produit_id');
        })
            ->join('clients', function ($join) {
            $join->on('clients.id', '=', 'ventes.client_id');
        })
            ->join('reglements', function ($join) {
            $join->on('ventes.id', '=', 'reglements.vente_id');
        })
        ->where('ventes.id','=',$id)
        ->select('ventes.numero as numero',
            'ventes.date_vente as date',
            'modeles.libelle as modele',
            'produits.nom as produit',
            'preventes.quantite as quantite',
            'preventes.prix as prix',
            'preventes.prixtotal as prixtotal',
            'clients.nom as nom',
            'clients.prenom as prenom',
            'clients.contact as contact',
            'reglements.montant_donne as donne',
            'reglements.montant_restant as restant',
            'ventes.created_at as create',
            'ventes.updated_at as update')
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
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$id)
            ->SUM('preventes.prixtotal');

        return view('facturecredit',compact('vente','modele2','mod','total','clients','credit','cre'));
    }

    public function facturesimple()
    {
        $id=DB::table('ventes')->max('id');
        $vente = DB::table('ventes')
        ->join('preventes', function ($join) {
            $join->on('preventes.vente_id', '=', 'ventes.id');
        })
        ->join('modele_fournisseurs', function ($join) {
            $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
        })
        ->join('modeles', function ($join) {
            $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
        })
        ->join('produits', function ($join) {
            $join->on('produits.id', '=', 'modeles.produit_id');
        })
        ->where('ventes.id','=',$id)
        ->select('ventes.numero as numero',
            'ventes.date_vente as date',
            'modeles.libelle as modele',
            'produits.nom as produit',
            'preventes.quantite as quantite',
            'preventes.prix as prix',
            'preventes.prixtotal as prixtotal',
            'ventes.created_at as create',
            'ventes.updated_at as update')
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
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$id)
            ->SUM('preventes.prixtotal');
        return view('facturesimple',compact('vente','modele2','mod','total','clients','credit','cre'));
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
        return view('ventesimple',compact('categorie','modele2','mod'));
    }
    public function create2()
    { $categorie=Categorie::all();
    $client=Client::all();
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

        return view('ventecredit',compact('categorie','client','modele2','mod','clients','credit','cre'));
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
        $ed=1+$id;
        $vente = new vente();
        $vente ->numero="VENT".now()->format('Y')."-".$ed;
        $vente ->date_vente= now();
        $vente ->user_id= Auth::user()->id;
        $vente->save();
        $allcommande= explode( ',', $request->input('venTable') );
        for ($i =0 ;$i<count($allcommande);$i+=3) {
            $prevente = new Prevente();
            $prevente ->modele_fournisseur_id=$allcommande[$i];
            $prevente ->prix=$allcommande[$i+1];
            $prevente -> quantite= $allcommande[$i+2];
            $prevente ->prixtotal =$allcommande[$i+2]*$allcommande[$i+1] ;
            $prevente ->vente_id=$vente->id;
            $prevente->save();
            $modele_id = DB::table('modeles')
                ->join('modele_fournisseurs', function ($join) {
                    $join->on('modele_fournisseurs.modele_id', '=', 'modeles.id');
                })
                ->join('preventes', function ($join) {
                    $join->on('preventes.modele_fournisseur_id', '=', 'modele_fournisseurs.id');
                })
                ->where('preventes.id','=',$prevente->id)
                ->select('modeles.id as id')
                ->get();
            $modele= Modele::findOrFail($modele_id[0]->id);
            $modele->quantite=$modele->quantite -$prevente ->quantite;
            $modele->update();
        }
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
        $historique->cible = "Ventes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$vente->id)
            ->SUM('preventes.prixtotal');
        $id=DB::table('factures')->max('id');
        $ed=1+$id;
        $facture=new Facture();
        $facture->prixapayer =$total;
        $facture->vente_id =$vente->id;
        $facture ->numero="FACT".now()->format('Y')."-".$ed;
        $facture->save();
        if ($mod>0){
         Alert::warning('Attention quantité inferieure au seuil','Veuillez vous approvisionner');
        }
        return view('vente',compact('modele2','mod','clients','credit','cre'));
    }

    public function store2(Request $request)
    {
        $allcommande= explode( ',', $request->input('venTable') );
        $id=DB::table('ventes')->max('id');
        $ed=1+$id;
        $vente = new vente();
        $vente ->numero="VENT".now()->format('Y')."-".$ed;
        $vente ->date_vente= now();
        $vente ->client_id= $allcommande[1];
        $vente ->user_id= Auth::user()->id;
        $vente->save();
        for ($i =0 ;$i<count($allcommande);$i+=4) {
            $prevente = new Prevente();
            $prevente ->modele_fournisseur_id=$allcommande[$i];
            $prevente ->prix =$allcommande[$i+2];
            $prevente ->quantite= $allcommande[$i+3];
            $prevente ->prixtotal =$prevente ->prix *$prevente ->quantite;
            $prevente ->vente_id=$vente->id;
            $prevente->save();
            $modele_id = DB::table('modeles')
                ->join('modele_fournisseurs', function ($join) {
                    $join->on('modele_fournisseurs.modele_id', '=', 'modeles.id');
                })
                ->join('preventes', function ($join) {
                    $join->on('preventes.modele_fournisseur_id', '=', 'modele_fournisseurs.id');
                })
                ->where('preventes.id','=',$prevente->id)
                ->select('modeles.id as id')
                ->get();
            $modele= Modele::findOrFail($modele_id[0]->id);
            $modele->quantite=$modele->quantite -$prevente ->quantite;
            $modele->update();
        }
        $modele2=DB::table('modeles')
            ->join('produits', function ($join) {
                $join->on('modeles.produit_id', '=', 'produits.id');
            })
            ->whereColumn('modeles.seuil','>=','modeles.quantite')
            ->get();
        $mod=count($modele2);
        $historique=new Historique();
        $historique->actions = "Creer";
        $historique->cible = "Ventes";
        $historique->user_id =Auth::user()->id;
        $historique->save();
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$vente->id)
            ->SUM('preventes.prixtotal');
        $id=DB::table('factures')->max('id');
        $ed=1+$id;
        $facture=new Facture();
        $facture->prixapayer =$total;
        $facture->vente_id =$vente->id;
        $facture ->numero="FACT".now()->format('Y')."-".$ed;
        $facture->save();
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
        return view('vente',compact('modele2','mod','clients','credit','cre'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type= vente::find($id);
        if ($type->client_id==null)
        {
        $vente = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->join('modele_fournisseurs', function ($join) {
                $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
            })
            ->join('modeles', function ($join) {
                $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
            })
            ->join('produits', function ($join) {
                $join->on('produits.id', '=', 'modeles.produit_id');
            })
            ->where('ventes.id','=',$id)
            ->select('ventes.numero as numero',
                'ventes.date_vente as date',
                'modeles.libelle as modele',
                'produits.nom as produit',
                'preventes.quantite as quantite',
                'preventes.prix as prix',
                'preventes.prixtotal as prixtotal',
                'ventes.created_at as create',
                'ventes.updated_at as update')
            ->get();
        $total = DB::table('ventes')
            ->join('preventes', function ($join) {
                $join->on('preventes.vente_id', '=', 'ventes.id');
            })
            ->where('ventes.id','=',$id)
            ->SUM('preventes.prixtotal');

            return view('detailvente2',compact('vente','total'));
        }
        else{
            $vente = DB::table('ventes')
                ->join('preventes', function ($join) {
                    $join->on('preventes.vente_id', '=', 'ventes.id');
                })
                ->join('modele_fournisseurs', function ($join) {
                    $join->on('modele_fournisseurs.id', '=', 'preventes.modele_fournisseur_id');
                })
                ->join('modeles', function ($join) {
                    $join->on('modeles.id', '=', 'modele_fournisseurs.modele_id');
                })
                ->join('produits', function ($join) {
                    $join->on('produits.id', '=', 'modeles.produit_id');
                })
                ->join('clients', function ($join) {
                    $join->on('clients.id', '=', 'ventes.client_id');
                })
                ->where('ventes.id','=',$id)
                ->select('ventes.numero as numero',
                    'ventes.date_vente as date',
                    'modeles.libelle as modele',
                    'produits.nom as produit',
                    'preventes.quantite as quantite',
                    'preventes.prix as prix',
                    'preventes.prixtotal as prixtotal',
                    'clients.nom as Nclient',
                    'clients.prenom as Pclient',
                    'ventes.created_at as create',
                    'ventes.updated_at as update')
                ->get();
            $total = DB::table('ventes')
                ->join('preventes', function ($join) {
                    $join->on('preventes.vente_id', '=', 'ventes.id');
                })
                ->where('ventes.id','=',$id)
                ->SUM('preventes.prixtotal');
            $historique=new Historique();
            $historique->actions = "Detail";
            $historique->cible = "Ventes";
            $historique->user_id =Auth::user()->id;
            $historique->save();
            return view('detailvente',compact('vente','total'));
        }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $modele=DB::table('modeles')
            ->join('produits', function ($join) {
                $join->on('modeles.produit_id', '=', 'produits.id');
            })
            ->whereColumn('modeles.seuil','>=','modeles.quantite')
            ->get();
        $mod=count($modele);
        return $modele;
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
        return [];
    }
}
