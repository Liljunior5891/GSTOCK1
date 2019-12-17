@extends('layout')
@extends('layoutCaisse')
@section('css')
    <link rel="stylesheet" href="octopus/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
@endsection
@section('contenu')
    <div class="inner-wrapper">
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Commande indirecte</h2>
            </header>

            <div class="row">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>

                        <h1 class="panel-title">ENREGISTREMENT DE LA COMMANDE INDIRECTE</h1>
                    </header>

                    <div class="panel-body">


                        <div class="row" " >

                                <div class="col-md-4 form-group">
                                                <label class="col-md-4 control-label">Fournisseur</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="fournisseur2" id="fournisseur2"   class="form-control populate">
                                                        <optgroup label="Choisir le fournisseur">
                                                            <option value=""></option>
                                                            @foreach($fournisseur as $four)
                                                                <option value="{{$four->id}}">{{$four->nom}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-4 control-label">Produit</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="produit2" id="produit2"  class="form-control populate">
                                                        <optgroup label="Choisir un produit">

                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-4 control-label">Modele</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="modele2" id="modele2"   class="form-control populate">
                                                        <optgroup label="Choisir le modele">
                                                            <option value=""></option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="col-md-4 form-group">
                                                  <label class="col-sm-3 control-label">Prix</label>
                                                   <div class="col-sm-9">
                                                         <input type="integer" name="prix"  id="prix" class="form-control" placeholder="15000" required/>

                                                     </div>
                                           </div>
                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-3 control-label">Quantité</label>
                                                <div class="col-sm-9">
                                                    <input type="integer" name="quantite"  id="quantite" class="form-control" placeholder="100" required/>
                                                </div>
                                            </div>
                                        </div>
                                                <div class="col-md-12 text-right">
                                                    <button type="button" class="btn btn-primary" id="ajout"><i class="fa fa-check"></i> Ajouter</button>
                                                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-default  "  id="annuler"><i class="fa fa-times"></i> Annuler</button>
                                                </div>

                    <div id="comform">
                        <form  method="POST" class="	form-validate form-horizontal mb-lg" >
                            {{csrf_field()}}
                        <input type="hidden"  name="comTable" id="comTable">
                        </form>
                    </div>
                    <table class="table table-bordered table-striped mb-none" id="commandeTable" data-swf-path="octopus/assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
                        <thead>
                        <tr>
                            <th class="center hidden-phone">Numero</th>
                            <th class="center hidden-phone">Produit</th>
                            <th class="center hidden-phone">Modele</th>
                            <th class="center hidden-phone">Quantité </th>
                            <th class="center hidden-phone">Prix </th>
                            <th class="center hidden-phone">Total </th>
                            <th class="center hidden-phone">Action</th>
                        </tr>
                        </thead>
                        <tbody class="center hidden-phone">
                        </tbody>
                    </table>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" id="valider"><i class="fa fa-check"></i> Valider</button>
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-default  "  id="annuler"><i class="fa fa-times"></i> Annuler</button>
                    </div>

                    </div>
            </div>
        </section>
    </div>
    </section>
    </div>

@endsection
@section('js')

    <script src="octopus/assets/vendor/jquery/jquery.js"></script>
    <script src="octopus/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="octopus/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
    <script src="js/newcommande2.js"></script>

@endsection
