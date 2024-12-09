$(document).ready(function(){
    
    llenaTablaTemas();   
});


//botón BORRAR
$(document).on("click", ".btnBorrar", function(){  
    
        $('#txtnom').removeClass('is-invalid');
        $('#txtdes').removeClass('is-invalid');
        $('#txtfoto').removeClass('is-invalid');
        $('#txtnom').removeClass('is-valid');
        $('#txtdes').removeClass('is-valid');
        $('#txtfoto').removeClass('is-valid');
        $('#txtnom').val("");
        $('#txtId').val("");
        $('#txtdes').val("");
        $('#txtfoto').val("");
        $('#foto_usuario').attr("src","");
        id_tipo=$(this).attr("id_tipo");
        $("#btnCancelar").click();
        $('#txtnom').removeClass('is-invalid');
        Swal.fire({
            title: '¿Estás seguro de eliminar el tema?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: "Cancelar",
            focusConfirm: false,
        }).then((result) => {
            $('#txtnom').removeClass('is-invalid');
            if (result.isConfirmed) {
                $('#txtnom').removeClass('is-invalid');
                $.ajax({
                    url: "../administrar/eliminaTema.php",           
                    type: "POST",
                    data: {id_tipo:id_tipo},
                    success: function(msg){
                        $('#txtnom').removeClass('is-invalid');
                        Swal.fire({
                            title:msg,
                            icon:'success',
                            toast: true,
                            showConfirmButton: false,
                            padding:'1rem',
                            position: 'bottom-end',
                            timer: '3000',
                            timerProgressBar:true,

                        });
                        tblTemasTotal.api().ajax.reload();
                    }
                });
            }
        })
    });
    $( "#btnGuaTem" ).prop( "disabled", false );
    $( "#btnActTem" ).prop( "disabled", true );
    $(document).on("click", ".btnEditar", function(){
        $( "#btnGuaTem" ).prop( "disabled", true );
        $( "#btnActTem" ).prop( "disabled", false );
        id_tipo=$(this).attr("id_tipo");           
        $.ajax({
            url: "../administrar/verificaTemaId.php",           
            type: "POST",          
            data: {id_tipo:id_tipo},
            dataType: "json",
            success: function(tema){                      
                $('#txtId').val(tema.id_tipo);
                $('#txtnom').val(tema.nombre_tema);
                $('#txtdes').val(tema.descripcion_tema);
                $('#img').attr("src",tema.foto_tema);
                $('#txtnom').removeClass('is-invalid');
                $('#txtdes').removeClass('is-invalid');
                $('#txtfoto').removeClass('is-invalid');
                $('#txtnom').addClass('is-valid');
                $('#txtdes').addClass('is-valid');
                $('#txtfoto').addClass('is-valid');
            }                
        });
        
    });
    
    $(document).on("click", "#btnCancelar", function(){     
        $('#txtnom').removeClass('is-invalid');
        $('#txtdes').removeClass('is-invalid');
        $('#txtfoto').removeClass('is-invalid');
        $('#txtnom').removeClass('is-valid');
        $('#txtdes').removeClass('is-valid');
        $('#txtfoto').removeClass('is-valid');                                                 
        $('#txtId').val("");
        $('#txtnom').val("");
        $('#txtdes').val("");
        $('#txtfoto').val("");
        $('#img').attr("src","");
        $('#txtnom').focus();
        $( "#btnGuaTem" ).prop( "disabled", false );
        $( "#btnActTem" ).prop( "disabled",  true); 
    });

    $(document).on("click", "#btnActTem", function(){
        nom = $("#txtnom").val();
        des = $("#txtdes").val();

        if (valnomTem(nom) && valdesTem(des) ){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                })
                Swal.fire({
                    title: '¿Realmente quieres guardar los cambios?',
                    text: 'Verifica que hayas ingresado los datos correctos',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Guardar',
                    confirmButtonColor: '#0d6efd',
                    denyButtonText: `No guardar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var datosTemas = new FormData($("#frmTemasTotal")[0]);
                        $.ajax(
                            {            
                            url: "../administrar/actualizarTema.php",
                            data: datosTemas,
                            type: "POST",
                            contentType:false,
                            processData:false,
                            success: function(respuestaServidor){
                                    swalWithBootstrapButtons.fire(respuestaServidor, '', 'success')
                                    $('#txtnom').removeClass('is-invalid');
                                    $('#txtdes').removeClass('is-invalid');
                                    $('#txtfoto').removeClass('is-invalid');
                                    $('#txtnom').removeClass('is-valid');
                                    $('#txtdes').removeClass('is-valid');
                                    $('#txtfoto').removeClass('is-valid'); 
                                    $('#txtId').val("");
                                    $('#txtnom').val("");
                                    $('#txtdes').val("");
                                    $('#txtfoto').val("");
                                    $('#img').attr("src","");
                                    $('#txtnom').focus();
                                    $( "#btnGuaTem" ).prop( "disabled", false );
                                    $( "#btnActTem" ).prop( "disabled",  true);
                                    tblTemasTotal.api().ajax.reload();
                                }
                            }); 
                    } else if (result.isDenied) {
                        swalWithBootstrapButtons.fire('Cambios no guardados', 'Recuerda que no hay forma de recuperar estos datos', 'info')
                    }
                }) 
        }
        else{
            return Swal.fire({title:"Error en los datos ingresados",text:"Verifica los campos",icon:"warning",confirmButtonColor:"#0d6efd",confirmButtonText:"Aceptar"});
        }
    });


    $(document).on("click", "#btnGuaTem", function(){
        event.preventDefault(); //evita se recargue la pagina
        $('#txtnom').keyup(
            function(){
                var nombre=$('#txtnom').val();
                if (valnomAut(nombre)){
                    $('#txtnom').removeClass('is-invalid');
                    $('#txtnom').addClass('is-valid');                    
                    return false;
                }
                else{                  
                    $('#txtnom').removeClass('is-valid');
                    $('#txtnom').addClass('is-invalid');  
                    return true;
                }
            }   
        );
        $('#txtdes').keyup(
            function(){
                var descripcion=$('#txtdes').val();
                if (valapeAut(descripcion)){
                    $('#txtdes').removeClass('is-invalid');
                    $('#txtdes').addClass('is-valid');                    
                    return false;
                }
                else{                  
                    $('#txtdes').removeClass('is-valid');
                    $('#txtdes').addClass('is-invalid');  
                    return true;
                }
            }   
        );
        
        var des = $("#txtdes").val();
        var nom = $("#txtnom").val();
        
        if(des.length==0 && nom.length==0){
            return Swal.fire({title:"Error en los datos ingresados",text:"Llene los campos vacíos",icon:"warning",confirmButtonColor:"#0d6efd",confirmButtonText:"Aceptar"});
        }
        if(!valnomTem(nom)){
            $('#txtnom').addClass('is-invalid');
            $('#txtnom').removeClass('is-valid');
            return Swal.fire({title:"Error en el nombre",text:"Escribe un nombre válido",icon:"warning",confirmButtonColor:"#0d6efd",confirmButtonText:"Aceptar"});
        }
        if(!valdesTem(des)){
            $('#txtdes').addClass('is-invalid');
            $('#txtdes').removeClass('is-valid');
            return Swal.fire({title:"Error en la descripcion",text:"Escribe la descripción",icon:"warning",confirmButtonColor:"#0d6efd",confirmButtonText:"Aceptar"});
        }
        if (valnomTem(nom) && valdesTem(des)){
            var datosTemas = new FormData($("#frmTemasTotal")[0]);
            $.ajax(
                {            
                url: "../administrar/AgregarTema.php",
                data: datosTemas,
                type: "POST",
                contentType:false,
                processData:false,
                success: function(respuestaServidor){
                        
                        var data = $.parseJSON(respuestaServidor);
                        Swal.fire({
                            title:data.title,
                            text:data.mensaje,
                            icon:data.tipo,
                            confirmButtonColor: "#0d6efd",
                            confirmButtonText: "Aceptar"
                        });                        
                        $('#txtnom').removeClass('is-valid'); 
                        $('#txtdes').removeClass('is-valid'); 
                        $('#txtnom').val("");
                        $('#txtdes').val("");
                        $('#txtfoto').val("");
                        $('#img').attr("src","");
                        $('#txtnom').focus();
                        tblTemasTotal.api().ajax.reload();
                    }
                });   
        }
        
    });

function cancelar(){
    $('#txtnom').removeClass('is-invalid');
    $('#txtdes').removeClass('is-invalid');
    $('#txtbus').removeClass('is-invalid');
    $('#txtfoto').removeClass('is-invalid');
    $('#txtnom').removeClass('is-valid');
    $('#txtdes').removeClass('is-valid');
    $('#txtfoto').removeClass('is-valid');
    $('#txtnom').val("");
    $('#txtdes').val("");
    $('#txtbus').val("");
    $('#txtfoto').val("");
    $('#img').attr("src","");
    $('#txtnom').focus();
    $('#txtbus').focus();
};

function valnomTem(nom){
    nombre= /^[a-zA-ZÀ-ÿ\s]{1,20}$/; // Letras y espacios, pueden llevar acentos.
    if (nombre.test(nom)){
        $('#txtnom').removeClass('is-invalid');
        $('#txtnom').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtnom').removeClass('is-valid');
        $('#txtnom').addClass('is-invalid');  
        
        return false;
    }
};

function valdesTem(des){
    descripcion= /^[a-zA-ZÀ-ÿ\s]{1,20}$/; // Letras y espacios, pueden llevar acentos.
    if (descripcion.test(des)){
        $('#txtdes').removeClass('is-invalid');
        $('#txtdes').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtdes').removeClass('is-valid');
        $('#txtdes').addClass('is-invalid');  
        $('#txtdes').focus();
        return true;
    }
};

// Llenar datatable temas
function llenaTablaTemas() {
    tblTemasTotal= $('#tblTemasTotal').dataTable({
        responsive: true,  
        destroy:true, 
        ajax:{
            url: '../administrar/listarTemasTodo.php',
            type: 'POST',
        },
        columns:[
            {"data":"id_tipo"},
            {"data":"nombre_tema"},
            {"data":"descripcion_tema"},
            {"data":"foto_tema",
            "render":function(data,type,row){               
            return '<div class="d-flex align-items-center justify-content-center"><img src="'+ data +'" width="35" class="rounded-3" height="35" /></div>';
        }
        },      
            {
            "data": null,
            render:function(data, type, row)
            {
                return '<div class="text-center"><button title="Editar" id_tipo="'+data.id_tipo+'" class="btn btn-warning btnEditar" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-pen-to-square"></i></button>&nbsp; <button title="Eliminar" id_tipo="'+data.id_tipo+'"  class="btn btn-danger btnBorrar"><i class="fa-solid fa-trash"></button></div>';
            },
            "targets": -1
        },
        
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
    });
}

