$('#credit').on('click', function(){

    $('.modal-title-user').text('LISTE DES CREANCIERS');
    $('#infocredit').modal('show');
});

var venteTable;

$(function () {

    venteTable =   $('#venteTable').DataTable({
        processing: true,
        serverSide: true,
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
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

        ajax: '/allvente',
        "columns": [

            {data: "numero",name : 'numero'},
            {data: "date_vente",name : 'date_vente'},
            {data: "action", name : 'action' , orderable: false, searchable: false}


        ]

    });
});
$('#info').on('click', function(){

    $('.modal-title-user').text('LISTE DES PRODUITS A APPROVISIONNER');
    $('#infoproduit').modal('show');
});



//post des données

function show(id){

    $.ajax({
        url: '/showvente-'+id,
        type: "get",
        success : function(data) {
         window.location='/detailvente-'+id



        },
        error : function(data){
            window.location='/detailvente2-'+id
        }
    })
}


function deletepro(id){
    Swal.fire({
        position: 'center',
        title: 'Vous etes sûr',
        text:"Les produits enregistrés sur la vente seront supprimé aussi",
        type: 'warning',
        showCancelButton: true,
        confirmButton:'#3085d6',
        cancelButton:'#d33',
        confirmButtonText:'Oui effacer'
    }).then ((result)=>{
        if (result.value){
            $.ajax({
                url : '/deletevente-'+id,
                type : "get",

                contentType: false,
                processData: false,
                success : function(data) {
                    Swal.fire('Effacé',
                        'Fichier bien effacé',
                        'success')
                    provisionTable.ajax.reload();
                },
                error : function(data){
                    Swal.fire('Impossible',
                        'Cette vente a été deja éffectuée',
                        'info')
                }
            });

        }
    });
}

