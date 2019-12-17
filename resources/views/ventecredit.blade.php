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

                        <h1 class="panel-title">ENREGISTREMENT DE LA VENTE A CREDIT</h1>
                    </header>

                    <div class="panel-body">

                        <div class="row">

                                <div class="col-md-4 form-group">
                                                <label class="col-md-4 control-label">Client</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="client" id="client"  class="form-control populate">
                                                        <optgroup label="Choisir le client">
                                                            <option value=""></option>
                                                            @foreach($client as $clt)
                                                                <option value="{{$clt->id}}">{{$clt->nom}} - {{$clt->prenom}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                    <a class="modal-with-form btn btn-default mb-xs mt-xs mr-xs btn btn-primary" id="btnclient"><i class="fa fa-plus"></i></a>
                                </div>
                                             <div class="col-md-4 form-group">
                                                  <label class="col-md-4 control-label">Categorie</label>
                                                    <div class="col-md-9 form-group">
                                                        <select  name="categorie" id="categorie"   class="form-control populate">
                                                                 <optgroup label="Choisir la categorie">
                                                                     <option value=""></option>
                                                                    @foreach($categorie as $cat)
                                                                          <option value="{{$cat->id}}">{{$cat->nom}}</option>
                                                                     @endforeach
                                                                  </optgroup>
                                                         </select>
                                                        </div>
                                             </div>
                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-4 control-label">Produit</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="produit" id="produit"  class="form-control populate">
                                                        <optgroup label="Choisir un produit">

                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-4 control-label">Modele</label>
                                                <div class="col-md-9 form-group">
                                                    <select  name="modele" id="modele"   class="form-control populate">
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
                                                       <input type="hidden" name="mod" id="mod"/>
                                                       <input type="hidden" name="stock" id="stock"/>                                                     </div>
                                           </div>
                                            <div class="col-md-4 form-group">
                                                <label class="col-sm-3 control-label">Quantité</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="quantite"  id="quantite" class="form-control" placeholder="100"  min="1" required/>
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
                        <input type="hidden"  name="venTable" id="venTable">
                        </form>
                    </div>
                    <table class="table table-bordered table-striped mb-none" id="venteTable" data-swf-path="octopus/assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
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

    <div class="modal fade " id="ajout_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header " style="background-color: #0b93d5;border-top-left-radius: inherit;border-top-right-radius: inherit">
                    <h4 class="modal-title-user" id="myModalLabel" style="color: white"></h4>
                </div>
                <div class="modal-body">
                    <form id="form" action="" method="POST" class="	form-validate form-horizontal mb-lg" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group mt-lg">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-9">
                                <input type="text" name="nom"  id="nom" class="form-control" placeholder="LJ" required/>
                                <input type="hidden" name="idclient" id="idclient"/>
                            </div>
                        </div>
                        <div class="form-group mt-lg">
                            <label class="col-sm-3 control-label">Prenoms</label>
                            <div class="col-sm-9">
                                <input type="text" name="prenoms" id="prenoms" class="form-control" placeholder="Kodjo" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email" class="form-control" placeholder="aaaa@aa.com " required/>
                            </div>
                        </div>
                        <div class="form-group mt-lg">
                            <label class="col-sm-3 control-label">Contact</label>
                            <div class="col-sm-9">
                                <input type="integer" name="contact" id="contact" class="form-control" placeholder="92658797" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Sexe</label>
                            <div class="col-md-9">
                                <select  name="sexe" id="sexe" class="form-control populate">
                                    <optgroup label="Choisir un sexe">
                                        <option value="M">Masculin</option>
                                        <option value="F">Feminin</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="btnadd"><i class="fa fa-check"></i> Valider</button>
                                <button type="button" class="mb-xs mt-xs mr-xs btn btn-default  " data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <script src="js/ventecredit.js"></script>

@endsection
