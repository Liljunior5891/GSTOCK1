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


$('#fournisseur2').on('change',function ( ) {
    $.ajax({
        url: '/recupererproduit2-' + $('#fournisseur2').val(),
        type: "get",
        success: function (data) {
            $('#produit2').empty();
            $('#modele2').empty();
            $('#prix').empty();
            $('#quantite').empty();
            $('#produit2').append('<option value=""></option>')

            for (var i = 0; i < data.length; i++) {

                $('#produit2').append('<option value="'+data[i].id+'">'+data[i].produit+'</option>')
            }

        },
        error: function (data) {
            console.log("erreur")
        },
    })
})


$('#produit2').on('change',function ( ) {
    $.ajax({
        url: '/recuperermodele-' + $('#produit2').val(),
        type: "get",
        success: function (data) {
            $('#modele2').empty();
            $('#modele2').append('<option value=""></option>')

            for (var i = 0; i < data.length; i++) {

                $('#modele2').append('<option value="'+data[i].id+'">'+data[i].libelle+'</option>')
            }

        },
        error: function (data) {
            console.log("erreur")
        },
    })
})

$('#modele2').on('change',function ( ) {
    $.ajax({
        url: '/recupefournisseur-' + $('#modele2').val(),
        type: "get",
        success: function (data) {
                $('#prix').val(null);
                for (var i = 0; i < data.length; i++) {
                    $('#prix').val(data[i].prix);
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
    if($('#fournisseur2').val()  ==''  ||  $('#produit2').val() ==null ||  $('#modele2').val() ==null   ||  $('#quanite').val() <= 0 || $('#quanite').val()  ==''  ||  $('#prix').val() <= 0 || $('#prix').val()  =='' ){
    message='Veuillez remplir tous les champs svp...'
        sweetToast('warning',message);

    }else{

        var dEmporte , position
        let trouveEmporte = false;
        for(let i = 0; i <  $table2.data().length; i++){
            let  data = $table2.data()[i]
            if (data.id == $('#modele2').val()) {
                trouveEmporte = true;
                position = i;
            }
        }

        if ( trouveEmporte === false) {
            var d=document.getElementById('produit2')
            var b=document.getElementById('modele2')
            var produit=d.options[d.selectedIndex].text;
            var modele=b.options[b.selectedIndex].text;
            $table2.row.add({
                "id":$('#modele2').val(),
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


        url = '/storecommande'


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

