@extends('layoutimprimer')
@section('contenu')
    <body onload="window.print(); fermer()">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fa fa-home"></i> <strong style="color: red;">MAWUPEASSI</strong>
                        <small class="float-right">{{$vente[0]->date}}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">

                    <address>
                        <b> ETS: MAWUPEASSI</b><br>
                        Telephone: (00228) 92 65 87 97<br>
                        Telephone: (00228) 99 30 03 77<br>
                        Fixe: (00228) 22 25 33 11<br>
                        Site Web : www.mawupeassi.tg
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                    <address>
                        <strong></strong><br>

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>45 Rue Accablant</b><br>
                    <b>Lomé - </b> Assigamé<br>
                    <b>05 BP:816 Lomé-Togo</b><br>
                    <b>Email:</b> Mawupeassi@gmail.com<br>
                    <b>Lomé-Togo</b>
                </div>

                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="col-sm-4 invoice-col">
                <h6 align="center"><strong>INFORMATIONS DU CLIENT</strong></h6>
                <br>
                <address>
                    <b class="list-group-item"> Nom: <span class="text-danger" ></span> </b>
                    <b class="list-group-item">Prenom : <span class="text-danger" ></span> </b>
                    <b class="list-group-item">Contact : <span class="text-danger" ></span> </b>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">

                <address>
                    <strong></strong><br>

                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h6 align="center"><strong>INFORMATIONS DE LA VENTE</strong></h6>
                <br>
                <address>
                    <b class="list-group-item">Vente N*: <span class="text-danger" >{{$vente[0]->numero}}</span> </b>
                    <b class="list-group-item">Date de vente : <span class="text-danger" >{{$vente[0]->date}}</span> </b>
                    <b class="list-group-item">Montant total : <span class="text-danger" >{{$total}} fcfa</span> </b>
                </address>
            </div>


            <h5 align="center"><strong>LISTE DES PRODUITS</strong></h5>
            <br>
            <!-- Table row -->

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped mb-none" id="afficheTable" data-swf-path="octopus/assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf" >
                        <thead>
                        <tr>
                            <th class="center hidden-phone">Produit</th>
                            <th class="center hidden-phone">Prix </th>
                            <th class="center hidden-phone">Quantité </th>
                            <th class="center hidden-phone">Prix total </th>
                        </tr>
                        </thead>
                        <tbody class="center hidden-phone">

                        @foreach($vente as $ven)

                            <tr class="gradeA">
                                <td class="center hidden-phone">{{$ven->produit}} - {{$ven->modele}}  </td>
                                <td class="center hidden-phone">{{$ven->prix}} fcfa</td>
                                <td class="center hidden-phone">{{$ven->quantite}}</td>
                                <td class="center hidden-phone">{{$ven->prixtotal}} fcfa</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <li class="list-group-item center hidden-phone" >Montant total :<b> <span class="text-danger "  >{{$total}} fcfa</span></b></li>
                </div>
            </div>
    </body>
@endsection
@section('js')


    </script>
    <script src="octopus/assets/vendor/jquery/jquery.js"></script>
    <script src="octopus/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="octopus/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="octopus/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
    <script src="js/facture.js"></script>

@endsection
