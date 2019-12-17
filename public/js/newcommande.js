$('#info').on('click', function(){

    $('.modal-title-user').text('LISTE DES PRODUITS A APPROVISIONNER');
    $('#infoproduit').modal('show');
});
$('#credit').on('click', function(){

    $('.modal-title-user').text('LISTE DES CREANCIERS');
    $('#infocredit').modal('show');
});


var $table2


function sweetToast(type,text){
    return  Swal.fire({
        position: 'top-end',
        type: type,
        title: text,
        showConfirmButton: false,
        timer: 1500,
        animation : true,
    });
}



$('#categorie').on('change',function ( ) {
    $.ajax({
        url: '/recupererproduit-' + $('#categorie').val(),
        type: "get",
        success: function (data) {
            $('#produit').empty();
            $('#modele').empty();
            $('#produit').append('<option value=""></option>')

            for (var i = 0; i < data.length; i++) {

                $('#produit').append('<option value="'+data[i].id+'">'+data[i].nom+'</option>')
            }

        },
        error: function (data) {
            console.log("erreur")
        },
    })
})



$('#produit').on('change',function ( ) {
    $.ajax({
        url: '/recuperermodele-' + $('#produit').val(),
        type: "get",
        success: function (data) {
            $('#modele').empty();
            $('#modele').append('<option value=""></option>')

            for (var i = 0; i < data.length; i++) {

                $('#modele').append('<option value="'+data[i].id+'">'+data[i].libelle+'</option>')
            }

        },
        error: function (data) {
            console.log("erreur")
        },
    })
})

$('#modele').on('change',function ( ) {
    $.ajax({
        url: '/recupefournisseur-' + $('#modele').val(),
        type: "get",
        success: function (data) {
            if (data == ""){
                $('#fournisseur').empty();
                $('#prix').val(null);
                $('#fournisseur').append('<option value="">Pas de fournisseur</option>')

            }
            else {
                document.getElementById('four').style.display='block';
                $('#fournisseur').empty();
                $('#prix').val(null);

                for (var i = 0; i < data.length; i++) {

                    $('#fournisseur').append('<option value="'+data[i].id+'">'+data[i].fournisseur+'</option>')
                    $('#prix').val(data[i].prix);
                    $('#mod').val(data[i].modele);
                }
            }


        },
        error: function (data) {
            console.log("erreur")
        },
    })
})




$(function( ) {

    'use strict';

    var datatableInit = function() {

        $table2 = $('#commandeTable').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            language: {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                "select": {
                    "rows": {
                        _: "%d lignes séléctionnées",
                        0: "Aucune ligne séléctionnée",
                        1: "1 ligne séléctionnée"
                    }
                }
            },
            data : [],
            columns: [
                { data: 'id' },
                { data: 'produit' },
                { data: 'modele' },
                { data: 'quantite' },
                { data: 'prix' },
                { data: 'total' },
                {data:'action', orderable: false, searchable: false}
            ]


        });

    };

    $(function() {
        datatableInit();
    });

})
$('#ajout').on('click',function () {
    let message;
    if($('#categorie').val()  ===''  ||  $('#produit').val() ==null ||  $('#modele').val() ==null   ||  $('#quanite').val() <= 0 || $('#quanite').val()  ==''  ||  $('#prix').val() <= 0 || $('#prix').val()  =='' ){
    message='Veuillez remplir tous les champs svp...'
        sweetToast('warning',message);

    }else{

        var dEmporte , position
        let trouveEmporte = false;
        for(let i = 0; i <  $table2.data().length; i++){
            let  data = $table2.data()[i]
            if (data.id == $('#modele').val()) {
                trouveEmporte = true;
                position = i;
            }
        }

        if ( trouveEmporte === false) {
            var d=document.getElementById('produit')
            var b=document.getElementById('modele')
            var produit=d.options[d.selectedIndex].text;
            var modele=b.options[b.selectedIndex].text;
            $table2.row.add({
                "id":$('#modele').val(),
                "produit": produit,
                "modele":modele,
                "prix": $('#prix').val(),
                "quantite": $('#quantite').val(),
                "total": $('#prix').val() * $('#quantite').val(),
                "action": '<a  class="btn btn-primary"><i class="fa fa-pencil"  id="edit"></i></a>' +
                    '  <a class="btn btn-danger" ><i class="fa fa-trash-o" id="sup"></i></a>'
            }).draw()

            $('#prix').val(null);
            $('#quantite').val(null);

        }else{
            $table2.data()[position].quantite = parseInt( $table2.data()[position].quantite) + parseInt( $('#quantite').val()) ;

            $table2.data()[position].total = $table2.data()[position].quantite * $table2.data()[position] .prix;

            $table2 .row().data($table2.data()[position]).draw();

            trouveEmporte = true;
        }

        {

        }
    }
})
$('#annuler').on('click',function (e) {
  let  message='Annuler'
    sweetToast('warning',message);


    $('#prix').val(null);
    $('#quantite').val(null);
})
$('#valider').on('click',function (e) {
    let url;
    if (  $('#fournisseur').val()==""){
        url = '/storecommande2'
    }
    else{
        url = '/storecommande'
    }

    e.preventDefault()

    if ($table2.data().length <= 0 ){
        let message;
        message='Impossible ... Tableau vide!!!'
        sweetToast('warning',message);
    }else{
        let content =''
        for(let i = 0; i <  $table2.data().length; i++){
            if (i!=$table2.data().length-1){
                content +=   $table2.data()[i].id+","+ $table2.data()[i].prix+","+ $table2.data()[i].quantite+","

            }else{
                content +=  $table2.data()[i].id+","+ $table2.data()[i].prix+","+ $table2.data()[i].quantite


            }
        }
        $('#comTable').val(content)
        e.preventDefault();
        if (e.isDefaultPrevented()){
        $.ajax({
            url :url,
            type : "post",
            // data : $('#modal-form-user').serialize(),
            data: new FormData($("#comform form")[0]),
            //data: new FormData($("#modal-form-user")[0]),
            contentType: false,
            processData: false,
            success : function(data) {
let message='Commande enregistré';
                sweetToast('success',message);
                window.location='/provisions'
            },
            error : function(data){
                let message='Erreur ';
                sweetToast('warning',message);
            }
        });
        }
    }

})

$('#btnfournisseur').on('click', function(){

    $('.modal-title-user').text('ENREGISTREMENT DU FOURNISSEUR');
    $('#btnadd').text('Valider');
    $('#btnadd').removeClass('btn-warning');
    $('#btnadd').addClass('btn-primary');
    $('#idfournisseur').val(null);
    $('#nom').val(null);
    $('#adresse').val(null);
    $('#email').val(null);
    $('#contact').val(null);
    $('#description').val(null);
    $('#ajout_fournisseur').modal('show');
});

//post des données
$('#ajout_fournisseur form').on('submit', function (e) {

    let url,message;
    if (!$('#idfournisseur').val()){
        url = '/ajoutfournisseur'
        message = 'Fournisseur enregistré'


    }
    else{
        url = '/updatefournisseur'
        message = 'Fournisseur enregistré'


    }
    e.preventDefault();
    if (e.isDefaultPrevented()){
        $.ajax({
            url : url ,
            type : "post",
            // data : $('#modal-form-user').serialize(),
            data: new FormData($("#ajout_fournisseur form")[0]),
            //data: new FormData($("#modal-form-user")[0]),
            contentType: false,
            processData: false,
            success : function(data) {
                sweetToast('success',message);

                $('#ajout_fournisseur').modal('hide');
           $('#fournisseur').append('<option value="'+$('#idfournisseur').val()+'">'+$('#nom').val()+'</option>')


            },
            error : function(data){
                alert('erreur')
            }
        });
    }

});
