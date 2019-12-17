@extends('layout')
@extends('layoutCaisse')
@section('css')
    <link rel="stylesheet" href="octopus/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
@endsection
@section('contenu')
    <div class="inner-wrapper">
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Vente</h2>
            </header>

            <div class="row">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>

                        <h1 class="panel-title">LISTES DES  VENTES</h1>
                    </header>

                    <div class="panel-body">
                        <a class="btn btn-default mb-xs mt-xs mr-xs btn btn-default" href="{{route('ventesimple')}}"><i class="fa fa-plus"></i>Ajouter une vente simple</a>
                        <a class="btn btn-default mb-xs mt-xs mr-xs btn btn-primary" href="{{route('ventecredit')}}"><i class="fa fa-plus"></i>Ajouter une vente a  credit</a>
                        <table class="table table-bordered table-striped mb-none" id="venteTable" >
                            <thead>
                            <tr>
                                <th class="center hidden-phone">Numero</th>
                                <th class="center hidden-phone">Date de vente</th>
                                <th class="center hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody class="center hidden-phone">


                            </tbody>
                        </table>
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
    <script src="js/vente.js"></script>
    <script src="js/categorie.js"></script>

@endsection
