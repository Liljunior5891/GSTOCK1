@extends('layout')
@section('contenu')
    <div class="inner-wrapper">
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Tableau de bord</h2>
            </header>
            <div class="row">
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">SERVICES</h4>
                                                <div class="info">
                                                    <strong class="amount">{{$garages}}</strong>
                                                    <span class="text"> au total</span>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <a class="text-primary-muted text-uppercase" href="{{route('detail_garage')}}">Voir la liste</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <section class="panel panel-featured-left panel-featured-secondary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-secondary">
                                                <i class="fa fa-gears (alias)"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">PRESTATIONS</h4>
                                                <div class="info">
                                                    <strong class="amount">{{$prestations}}</strong>
                                                    <span class="text"> au total</span>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <a class="text-primary-muted text-uppercase" href="{{route('prestation')}}">Voir la liste</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-success">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">EMPLOYES</h4>
                                                <div class="info">
                                                    <strong class="amount">{{$employes}}</strong>
                                                    <span class="text"> au total</span>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <a class="text-primary-muted text-uppercase" href="{{route('employer.index')}}">Voir la liste</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <section class="panel panel-featured-left panel-featured-info">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-info">
                                                <i class="fa fa-money"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">CHIFFRE D'AFFAIRE</h4>
                                                <div class="info">
                                                    <strong class="amount">{{$total}}</strong>
                                                    <span class="text"> FCFA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">STATISTIQUE DES PRESTATIONS </h2>
                                    </header>
                                    <div class="panel-body">

                                        <!-- Morris: Bar -->
                                        <div class="chart chart-md" id="morrisBar"></div>

                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
        </section>
    </div>
@endsection
