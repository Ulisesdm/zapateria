$(document).ready(function(){
    
    llenaTablaUsuarios();    
    $( "#btnActAut" ).prop( "disabled",  true);  
    $('#txtnom').keyup(function(){
        var nombre = $('#txtnom').val();        
        if (nombre.length>=3){
            $('#txtnom').removeClass('is-invalid');
            $('#txtnom').addClass('is-valid');
        }
        else{                  
            $('#txtnom').removeClass('is-valid');
            $('#txtnom').addClass('is-invalid');            
        }
    });

      $('#txtape').keyup(function(){
        var ape = $('#txtape').val();        
        if (ape.length>=3){
            $('#txtape').removeClass('is-invalid');
            $('#txtape').addClass('is-valid');
        }
        else{                  
            $('#txtape').removeClass('is-valid');
            $('#txtape').addClass('is-invalid');            
        }
    });

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){  
    $('#txtnom').removeClass('is-valid'); 
    $('#txtcon').removeClass('is-valid');
    
    $('#txtcor').removeClass('is-valid');
    $('#txtnom').removeClass('is-invalid'); 
    $('#txtcon').removeClass('is-invalid');
    
    $('#txtcor').removeClass('is-invalid');
    $('#txtnom').val("");
    $('#txtId').val("");
    $('#txtape').val("");
    $('#txtcor').val("");
    $('#txtcon').val("");
    
    $('#txtfoto').val("");
    $('#foto_usuario').attr("src","");
        id_user=$(this).attr("id_user");
        var respuesta = confirm("¿Está seguro de eliminar el registro: "+id_user+"?");
        if(respuesta==true){
            $("#btnCancelar").click();
            $.ajax({
                url: "eliminaUsuario.php",           
                type: "POST",
                data: {id:id_user},
                success: function(msg){   
                    
                    alert(msg); 
                    $('#txtnom').removeClass('is-invalid');
                    $('#txtnom').focus();
                    tblUsuarios.api().ajax.reload();
                           
                }
            });
        }   
      });
      $(document).on("click", ".btnEditar", function(){
        $( "#btnGuaAut" ).prop( "disabled", true );
        $( "#btnActAut" ).prop( "disabled", false );
        id_user=$(this).attr("id_user");           
        $.ajax({
            url: "verificaUsuarioId.php",           
            type: "POST",          
            data: {id:id_user},
            dataType: "json",
            success: function(usuario){  
                console.log(usuario);                         
                $('#txtId').val(usuario.id_user);
                $('#txtnom').val(usuario.nombre_usuario); 
                $('#txtape').val(usuario.apellidos_usuario);
                $('#txtcor').val(usuario.correo_usuario);
                $('#txtcon').val(usuario.contraseña_usuario); 
                $('#txtadmin').val(usuario.administrador); 
                $('#foto').attr("src",usuario.foto_usuario);
                




                $('#txtnom').removeClass('is-invalid');           
                                   
                $('#txtape').removeClass('is-invalid');
                $('#txtnom').addClass('is-valid'); 
                $('#txtape').addClass('is-valid');  
                                 
            }                
        });
        
    });
    
      $(document).on("click", "#btnCancelar", function(){     
        $('#txtnom').removeClass('is-valid'); 
        $('#txtape').removeClass('is-valid'); 
        $('#txtnom').removeClass('is-invalid'); 
        $('#txtape').removeClass('is-invalid');                                                 
        $('#txtId').val("");
        $('#txtnom').val("");
        $('#txtape').val("");
        $('#txtcon').val("");
        $('#txtcor').val("");
        $('#txtadmin').val("");
        $('#txtfoto').val("");
        $('#foto').attr("src","");
        $('#txtnom').focus();
        $( "#btnGuaAut" ).prop( "disabled", false );
        $( "#btnActAut" ).prop( "disabled",  true); 
      });
      





      $(document).on("click", "#btnActAut", function(){
        nom = $("#txtnom").val();
        ape = $("#txtape").val();
        cor = $("#txtcor").val();
        con = $("#txtcon").val();
        admin = $("#txtadmin").val();
          
        if (valnomAut(nom)&&valapeAut(ape)){
            var datosUsuarios = new FormData($("#frmUsuarios")[0]);
            $.ajax(
                {            
                url: "actualizaUsuario.php",
                data: datosUsuarios,
                type: "POST",
                contentType:false,
                processData:false,
                success: function(respuestaServidor){
                        window.alert(respuestaServidor);                       
                         $('#txtnom').removeClass('is-valid'); 
                         $('#txtape').removeClass('is-valid');                                                 
                         $('#txtId').val("");
                         $('#txtnom').val("");
                         $('#txtape').val("");
                         $('#txtcon').val("");
                         $('#txtcor').val("");
                         $('#txtadmin').val("");
                         $('#txtfoto').val("");
                         $('#foto').attr("src","");
                        
                        $('#txtnom').focus();
                        $( "#btnGuaAut" ).prop( "disabled", false );
                        $( "#btnActAut" ).prop( "disabled",  true);                       
                        tblUsuarios.api().ajax.reload();
                    }
                });  
        }
      });
    
      $("#frmUsuarios").submit(function( event ) {
        event.preventDefault(); //evita se recargue la pagina
        nom = $("#txtnom").val();
        ape = $("#txtape").val();
        cor = $("#txtcor").val();
        con = $("#txtcon").val();
        admin = $("#txtadmin").val();      
        if (valnomAut(nom)&&valapeAut(ape)){
            var datosUsuarios = new FormData($("#frmUsuarios")[0]);
            $.ajax(
                {            
                url: "AgregarUsuario.php",
                data: datosUsuarios,
                type: "POST",
                contentType:false,
                processData:false,
                success: function(respuestaServidor){
                       window.alert(respuestaServidor);                       
                         $('#txtnom').removeClass('is-valid'); 
                         $('#txtape').removeClass('is-valid');                        
                         $('#txtId').val("");
                         $('#txtnom').val("");
                         $('#txtape').val("");
                         $('#txtcon').val("");
                         $('#txtcor').val("");
                         $('#txtadmin').val("");
                         $('#txtfoto').val("");
                         $('#foto').attr("src","");
                        $('#txtnom').focus();
                       
                        tblUsuarios.api().ajax.reload();
                    }
                });   
        }
        
    });
    





    $("#frmUsuarios").submit(function( event ) {
        event.preventDefault(); //evita se recargue la pagina
        nom = $("#txtnom").val();
        ape = $("#txtape").val();
        cor = $("#txtcor").val();
        con = $("#txtcon").val();
        admin = $("#txtadmin").val();      
        if (valnomAut(nom)&&valapeAut(ape)){
            var datosUsuarios = new FormData($("#frmUsuarios")[0]);
            $.ajax(
                {            
                url: "AgregarUsuario.php",
                data: datosUsuarios,
                type: "POST",
                contentType:false,
                processData:false,
                success: function(respuestaServidor){
                       window.alert(respuestaServidor);                       
                         $('#txtnom').removeClass('is-valid'); 
                         $('#txtape').removeClass('is-valid');                        
                         $('#txtId').val("");
                         $('#txtnom').val("");
                         $('#txtape').val("");
                         $('#txtcon').val("");
                         $('#txtcor').val("");
                         $('#txtadmin').val("");
                         $('#txtfoto').val("");
                         $('#foto').attr("src","");
                        $('#txtnom').focus();
                       
                        tblUsuarios.api().ajax.reload();
                    }
                });   
        }
        
    });
});
//
function valnomAut(nom){
    if (nom.length>=3){
        $('#txtnom').removeClass('is-invalid');
        $('#txtnom').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtnom').removeClass('is-valid');
        $('#txtnom').addClass('is-invalid');  
        
        return false;
    }
}

function valapeAut(ape){
    if (ape.length>=3){
        $('#txtape').removeClass('is-invalid');
        $('#txtape').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtape').removeClass('is-valid');
        $('#txtape').addClass('is-invalid');  
        $('#txtape').focus();
        return false;
    }
}
$('#txtfoto').change(function () {        
    var archivo = this.files[0];
    if (archivo.size > 5242880) {
      alert('El tamaño maximo es de 5Mb');
      $('#txtfoto').val("");
      return;
    }
    else if (archivo.type!="image/png" && archivo.type!="image/jpeg"){
        alert('Se aceptan imagenes png o jpg');
        $('#txtfoto').val("");
        return;
    }    

    console.log($('#txtfoto').val());
          
      $('#txtfoto').attr('src', $('#txtfoto').val());
    

  });

// Llenar datatable autores
function llenaTablaUsuarios() {
    tblUsuarios= $('#tblUsuarios').dataTable(
    {
      responsive: true,  
      destroy:true, 
      ajax:{
          url: 'listarUsuariosTodo.php',
          type: 'POST',
      },
      columns:[
          {"data":"id_user"},
          {"data":"nombre_usuario"},
          {"data":"apellidos_usuario"},
          {"data":"correo_usuario"},
          {"data":"contraseña_usuario"},
          {"data":"administrador"},
          {"data":"foto_usuario",
          "render":function(data,type,row){               
            return '<img src="'+ data +'" width="60" height="60" />';
        }
        },      
          {
            "data": null,
            render:function(data, type, row)
            {
              return '<div class="text-center"><button title="Editar" id_user="'+data.id_user+'" class="btn btn-warning btnEditar">Editar</button>&nbsp; <button title="Eliminar" id_user="'+data.id_user+'"  class="btn btn-danger btnBorrar">Eliminar</button></div>';
            },
            "targets": -1
        }
        ],
  
    //Para cambiar el lenguaje a español
    "language": {
      "lengthMenu": "Mostrar _MENU_ registros",
      "zeroRecords": "No se encontraron resultados",
      "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sSearch": "Buscar:",
      "oPaginate": {
          "sFirst": "Primero",
          "sLast":"Último",
          "sNext":"Siguiente",
          "sPrevious": "Anterior"
       },
       "sProcessing":"Procesando...",
  }
  
  
      }    
    );
  }