<?php
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Alert::success('Success Title', 'Success Message');
    return view('welcome');
});
Route::get('/bord', 'BordsController@index')->name('bord');
Route::get('/bordcaisse', 'BordsController@caisse')->name('caissebord');
Route::get('/bordmagasin', 'BordsController@magasin')->name('magasinbord');
//Route::resource('Users','UserController');

Route::get('/clients', 'ClientsController@liste')->name('clients');
Route::get('/allclient', 'ClientsController@index');
Route::get('/deleteclient-{id}', 'ClientsController@destroy');
Route::post('/ajoutclient', 'ClientsController@store');
Route::post('/updateclient', 'ClientsController@update');
Route::get('/showclient-{id}', 'ClientsController@show');


Route::get('/fournisseurs', 'FournisseursController@liste')->name('fournisseurs');
Route::get('/allfournisseur', 'FournisseursController@index');
Route::get('/deletefournisseur-{id}', 'FournisseursController@destroy');
Route::post('/ajoutfournisseur', 'FournisseursController@store');
Route::post('/updatefournisseur', 'FournisseursController@update');
Route::get('/showfournisseur-{id}', 'FournisseursController@show');

Route::get('/allfourni', 'FournisseursController@index2');
Route::get('/recupererproduit-{id}', 'FournisseursController@produit');
Route::get('/recupererproduit2-{id}', 'FournisseursController@produit2');
Route::get('/recuperermodele-{id}', 'FournisseursController@modele');
Route::get('/recupefournisseur-{id}', 'FournisseursController@fournisseur');
Route::get('/deletefourni-{id}', 'FournisseursController@destroy2');
Route::post('/ajoutfourni', 'FournisseursController@store2');
Route::post('/updatefourni', 'FournisseursController@update2');
Route::get('/showfourni-{id}', 'FournisseursController@show2');


Route::get('/employes', 'EmployesController@liste')->name('employes');
Route::get('/allemploye', 'EmployesController@index');
Route::get('/deleteemploye-{id}', 'EmployesController@destroy');
Route::post('/ajoutemploye', 'EmployesController@store');
Route::post('/updateemploye', 'EmployesController@update');
Route::get('/showemploye-{id}', 'EmployesController@show');


Route::get('/utilisateurs', 'UserController@liste')->name('utilisateurs');
Route::get('/allUser', 'UserController@index');
Route::get('/deleteUser-{id}', 'UserController@destroy');
Route::post('/ajoutUser', 'UserController@store');
Route::post('/updateUser', 'UserController@update');
Route::post('/updateUser2', 'UserController@update2');
Route::get('/showUser-{id}', 'UserController@show');
Route::get('/show', 'UserController@create');
Route::get('/compte', 'UserController@compte')->name('compte');
Route::get('/changeUserState-{id}', 'UserController@changeState');



Route::get('/categories', 'CategoriesController@liste')->name('categories');
Route::get('/allcategorie', 'CategoriesController@index');
Route::get('/deletecategorie-{id}', 'CategoriesController@destroy');
Route::post('/ajoutcategorie', 'CategoriesController@store');
Route::post('/updatecategorie', 'CategoriesController@update');
Route::get('/showcategorie-{id}', 'CategoriesController@show');



Route::get('/allmodele', 'ModelesController@index');
Route::get('/deletemodele-{id}', 'ModelesController@destroy');
Route::post('/ajoutmodele', 'ModelesController@store');
Route::post('/updatemodele', 'ModelesController@update');
Route::get('/showmodele-{id}', 'ModelesController@show');


Route::get('/modeles', 'ModelesController@liste')->name('modeles');
Route::get('/allmodele', 'ModelesController@index');
Route::get('/deletemodele-{id}', 'ModelesController@destroy');
Route::post('/ajoutmodele', 'ModelesController@store');
Route::post('/updatemodele', 'ModelesController@update');
Route::get('/showmodele-{id}', 'ModelesController@show');



Route::get('/allproduit', 'ProduitsController@index');
Route::get('/deleteproduit-{id}', 'ProduitsController@destroy');
Route::post('/ajoutproduit', 'ProduitsController@store');
Route::post('/updateproduit', 'ProduitsController@update');
Route::get('/showproduit-{id}', 'ProduitsController@show');



Route::get('/livraisons', 'LivraisonsController@liste')->name('livraisons');
Route::get('/newlivraison', 'LivraisonsController@create')->name('newlivraison');
Route::get('/alllivraison', 'LivraisonsController@index');
Route::get('/deletelivraison-{id}', 'LivraisonsController@destroy');
Route::post('/storelivraison', 'LivraisonsController@store');
Route::post('/updatelivraison', 'LivraisonsController@update');
Route::get('/showlivraison-{id}', 'LivraisonsController@show');
Route::get('/ex', 'LivraisonsController@edit');
Route::get('/detaillivraison-{id}', 'LivraisonsController@show')->name('detaillivraison');


Route::get('/recupererfournisseur-{id}', 'ProvisionsController@fournisseur');
Route::get('/recupererprovision-{id}-{ed}', 'ProvisionsController@provision');
Route::get('/provisions', 'ProvisionsController@liste')->name('provisions');
Route::get('/newcommande', 'CommandesController@create')->name('newcommande');
Route::get('/newcommande2', 'CommandesController@create2')->name('newcommande2');
Route::post('/storecommande', 'CommandesController@store');
Route::post('/storecommande2', 'CommandesController@store2');
Route::get('/allcommande', 'CommandesController@index');
Route::get('/deletecommande-{id}', 'CommandesController@destroy');
Route::post('/updatecommande', 'CommandesController@update');
Route::get('/showcommande-{id}', 'CommandesController@show');
Route::get('/detailcommande-{id}', 'CommandesController@show')->name('detailcommande');
Route::get('/recuperercommandemodele-{id}', 'CommandesController@commande');



Route::get('/ventesimple', 'VentesController@create')->name('ventesimple');
Route::get('/ventecredit', 'VentesController@create2')->name('ventecredit');
Route::get('/ventes', 'VentesController@liste')->name('ventes');
Route::get('/reglements', 'VentesController@reglement')->name('reglements');
Route::get('/reglementcredit', 'VentesController@reglementcredit')->name('reglementcredit');
Route::get('/facturesimple', 'VentesController@facturesimple')->name('facturesimple');
Route::get('/facturecredit', 'VentesController@facturecredit')->name('facturecredit');
Route::post('/regler', 'ReglementsController@store');
Route::get('/expl', 'ReglementsController@create');

Route::post('/storevente', 'VentesController@store');
Route::post('/storevente2', 'VentesController@store2');
Route::get('/allvente', 'VentesController@index');
Route::get('/deletevente-{id}', 'VentesController@destroy');
Route::post('/updatevente', 'VentesController@update');
Route::get('/edit', 'VentesController@edit');
Route::get('/showvente-{id}', 'VentesController@show');
Route::get('/detailvente-{id}', 'VentesController@show')->name('detailvente');
Route::get('/detailvente2-{id}', 'VentesController@show')->name('detailvente2');

Route::get('/historiques', 'HistoriquesController@liste')->name('historiques');
Route::get('/allhistorique', 'HistoriquesController@index');

Route::get('/connexion', function () {return view('connexion');})->name('connexion');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
