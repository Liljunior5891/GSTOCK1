

var clientTable;



$(function () {

    clientTable =   $('#clientTable').DataTable({
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
            "sPrint": "Imprimer",
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
    
        ajax: '/allclient',
        "columns": [

            {data: "nom",name : 'nom'},
            {data: "prenom",name: 'prenom'},
            {data :  "sexe",name : 'sexe'},
            {data :  "email",name : 'email'},
            {data :  "contact",name : 'contact'},
            {data: "action", name : 'action' , orderable: false, searchable: false}


        ]

    });


});
$('#btnclient').on('click', function(){

    $('.modal-title-user').text('ENREGISTREMENT DU CLIENT');
    $('#idclient').val(null);
    $('#nom').val(null);
    $('#btnadd').text('Valider');
    $('#btnadd').removeClass('btn-warning');
    $('#btnadd').addClass('btn-primary');
    $('#prenoms').val(null);
    $('#email').val(null);
    $('#contact').val(null);
    $('#sexe').val(null);
    $('#ajout_client').modal('show');
});

//post des données
$('#ajout_client  form').on('submit', function (e) {

    let url,message;
    if (!$('#idclient').val()){
        url = '/ajoutclient'
        message = 'Client enregistré'


    }
    else{
        url = '/updateclient'
        message = 'Client modifié'

    }
    e.preventDefault();
    if (e.isDefaultPrevented()){
        $.ajax({
            url : url ,
            type : "post",
            // data : $('#modal-form-user').serialize(),
            data: new FormData($("#ajout_client form")[0]),
            //data: new FormData($("#modal-form-user")[0]),
            contentType: false,
            processData: false,
            success : function(data) {

                $('#ajout_client').modal('hide');
                sweetToast('success',message);

               clientTable.ajax.reload();
            },
            error : function(data){
              alert('erreur')
            }
        });
    }



});


function showclt(id){

    $.ajax({
        url: '/showclient-'+id,
        type: "get",
        success : function(data) {
            $('#modal-user-title').text('CLIENT : '+data.nom+' '+data.prenom);
            $('#sId').text(data.id);
            $('#sNom').text(data.nom);
            $('#sPrenom').text(data.prenom);
            if(data.sexe ===  'M'){
                $('#sSexe').text('Masculin');
            }else if(data.sexe === 'F'){
                $('#sSexe').text('Féminin');
            }

            $('#sEmail').text(data.email);
            $('#sContact').text(data.contact);
            $('#sCreate').text(data.created_at);
            $('#sUpdate').text(data.updated_at);
            $('#detailClient').modal('show');



        },
        error : function(data){
            sweetToast('Une erreur c\'est produite. Veuillez recommancer')
        }
    })
}
function editclt(id){
    $.ajax({
        url : '/showclient-'+id,
        type : "get",
        success : function(data) {

            $('#idclient').val(data.id);
            $('#nom').val(data.nom);
            $('#btnadd').text('Modifier');
            $('#btnadd').removeClass('btn-primary');
            $('#btnadd').addClass('btn-warning');
            $('.modal-title-user').text('Modifier les informations de : '+data.nom+' '+data.prenom);
            $('#prenoms').val(data.prenom);
            $('#email').val(data.email);
            $('#contact').val(data.contact);
            $('#sexe').val(data.sexe);
            $('#ajout_client').modal('show');

        },
        error : function(data){
alert('erreur')
        }
    });
}

function deleteclt(id){

    $.ajax({
        url : '/deleteclient-'+id,
        type : "get",

        contentType: false,
        processData: false,
        success : function(data) {

       console.log(data)

            clientTable.ajax.reload();

        },
        error : function(data){
            console.log(data)
        }
    });
}


