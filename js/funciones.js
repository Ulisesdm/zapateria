$(document).ready(  
      
    function(){         
        $('#txtnom').keyup(
            function(){
                var nombre=$('#txtnom').val();
                if (nombre.length>=3){
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

        $('#txtape').keyup(
            function(){
                var apellido=$('#txtape').val();
                if (apellido.length>=3){
                    $('#txtape').removeClass('is-invalid');
                    $('#txtape').addClass('is-valid');                    
                    return false;
                }
                else{                  
                    $('#txtape').removeClass('is-valid');
                    $('#txtape').addClass('is-invalid');  
                    return true;
                }
            }   
        );
        $('#txtus').keyup(
            function(){
                var apellido=$('#txtus').val();
                if (apellido.length>=3){
                    $('#txtus').removeClass('is-invalid');
                    $('#txtus').addClass('is-valid');                    
                    return false;
                }
                else{                  
                    $('#txtus').removeClass('is-valid');
                    $('#txtus').addClass('is-invalid');  
                    return true;
                }
            }   
        );
        $('#txtcon').keyup(function(){
            cadena =  $('#txtcon').val();
            if (!tieneNumeros(cadena) || !tieneMinusculas(cadena) || !tieneMinusculas(cadena) || !tieneCarEsp(cadena) || cadena.length<8){
                $('#txtcon').removeClass('is-valid');
                $('#txtcon').addClass('is-invalid');
                return false;
            }else{
                $('#txtcon').addClass('is-valid');
                $('#txtcon').removeClass('is-invalid');
                return true;
            }
        });
        $('#txtcor').keyup(function(){
            cadena =  $('#txtcor').val();
            if (!tieneFormato(cadena)){
                $('#txtcor').removeClass('is-valid');
                $('#txtcor').addClass('is-invalid');
                return false;
            }else{
                $('#txtcor').addClass('is-valid');
                $('#txtcor').removeClass('is-invalid');
                return true;
            }
        });
        $("#frmRegistro").submit(function( event ) {
             //evita se recargue la pagina
            nom = $("#txtnom").val();
            ape = $("#txtape").val(); 
            cor = $("#txtcor").val();
            con = $("#txtcon").val();
            con = $("#txtus").val();         
            if (validaNombre(nom)){
                var datosUsuario = new FormData($("#frmRegistro")[0]);
                $.ajax(
                    {            
                    url: "RegistrarUsuario.php",
                    data: datosUsuario,
                    type: "POST",
                    contentType:false,
                    processData:false,
                    success: function(respuestaServidor){
                        window.alert(respuestaServidor); 
                           //Remover clase                
                             $('#txtnom').removeClass('is-valid'); 
                             $('#txtape').removeClass('is-valid');
                             $('#txtcor').removeClass('is-valid'); 
                             $('#txtcon').removeClass('is-valid');
                             
                             //Vaciar cajas
                             $('#txtnom').val("");
                            $('#txtape').val("");
                            $('#txtcor').val("");
                            $('#txtcon').val("");
                            $('#txtadmin').val("");


                            $('#txtnom').focus();
                           
                            
                        }
                    });   
            }
            
        });
        $('#txtpasUsu').keyup(function(){
            var  nom=false , pas= false, pas2=false; 
            var cadena =  $('#txtpasUsu').val();
            if (cadena.length>=8){
                $('#txtpasUsu').removeClass('is-invalid');
                $('#txtpasUsu').addClass('is-valid');                    
            }
            else{                  
                $('#txtpasUsu').removeClass('is-valid');
                $('#txtpasUsu').addClass('is-invalid');  
            }
            if (!tieneNumeros(cadena) || !tieneMinusculas(cadena) || !tieneMayusculas(cadena)){
                $('#txtpasUsu').removeClass('is-valid');
                $('#txtpasUsu').addClass('is-invalid');
                pas= false;
            }else{
                $('#txtpasUsu').addClass('is-valid');
                $('#txtpasUsu').removeClass('is-invalid');
                pas= true;
            }
        });
        $('#txtpas2').keyup(function(){
            var  nom=false , pas= false, pas2=false; 
            cadena =  $('#txtpasUsu').val();
            cadena2 =  $('#txtpas2').val();
            if (cadena==cadena2){
                $('#txtpas2').addClass('is-valid');
                $('#txtpas2').removeClass('is-invalid');
                pas2= true;
            }
            else{
                $('#txtpas2').removeClass('is-valid');
                $('#txtpas2').addClass('is-invalid');
                pas2= false;
            }
        });
        $('#txtfoto').change(function () { 
            var  nom=false , pas= false, pas2=false;        
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
        
    }
);
//------------------------------------------------------------------------------------//

function validaNombre(){
    var nombre = document.getElementById('txtnom');
    if (nombre.value.length>=4){
        
        return true;
    }
    else{
        
        return false;
    }
}

//------------------------------------------------------------------------------------//

function validaApellido(){
    var nombre = document.getElementById('txtape');
    if (nombre.value.length>=3){
        
        return true;
    }
    else{
        
        return false;
    }
}
//------------------------------------------------------------------------------------//

function tieneNumeros(cadena){
    numeros="0123456789";
    minusculas="abcdefghijklmnñopqrstuvwxyz";
    for(var i=0;i<cadena.length;i++){
        c=cadena.charAt(i);
        if(numeros.indexOf(c)!=-1){
            return true;
        }
    }
    return false;
}
//------------------------------------------------------------------------------------//

function tieneMinusculas(cadena){
    minusculas="abcdefghijklmnñopqrstuvwxyz";
    for(var i=0;i<cadena.length;i++){
        c=cadena.charAt(i);
        if(minusculas.indexOf(c)!=-1){
            return true;
        }
    }
    return false;
}
//------------------------------------------------------------------------------------//

function tieneFormato(cadena){
    minusculas="@";
    for(var i=0;i<cadena.length;i++){
        c=cadena.charAt(i);
        if(minusculas.indexOf(c)!=-1){
            return true;
        }
    }
    return false;
}
//------------------------------------------------------------------------------------//

function tieneMayusculas(cadena){
    minusculas="ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    for(var i=0;i<cadena.length;i++){
        c=cadena.charAt(i);
        if(minusculas.indexOf(c)!=-1){
            return true;
        }
    }
    return false;
}
//------------------------------------------------------------------------------------//

function tieneCarEsp(cadena){
    minusculas=",;.:-_{}[]´+¨*'¿?¡°!#$%&/()=@^`~";
    for(var i=0;i<cadena.length;i++){
        c=cadena.charAt(i);
        if(minusculas.indexOf(c)!=-1){
            return true;
        }
    }
    return false;
}
//------------------------------------------------------------------------------------//

function validaFrm(){
    if (validaNombre() && validaContraseña() && validaApellido ){
        var f = document.getElementById('frmRegistro');
        f.submit();
    }
    
}
//------------------------------------------------------------------------------------//
function valpas(pas){
    if (pas){
        $('#txtcon').removeClass('is-invalid');
        $('#txtcon').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtcon').removeClass('is-valid');
        $('#txtcon').addClass('is-invalid');  
        $('#txtcon').focus();
        return false;
    }
}
function valnom(nom){
    if (nom){
        $('#txtnom').removeClass('is-invalid');
        $('#txtnom').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtnom').removeClass('is-valid');
        $('#txtnom').addClass('is-invalid');  
        $('#txtnom').focus();
        return false;
    }
}
//------------------------------------------------------------------------------------//

function valpas2(pas2){
    if (pas2){
        $('#txtpas2').removeClass('is-invalid');
        $('#txtpas2').addClass('is-valid');
        return true;  
    }
    else{                  
        $('#txtpas2').removeClass('is-valid');
        $('#txtpas2').addClass('is-invalid');  
        $('#txtpas2').focus();
        return false;
    }
}




  



  

//------------------------------------------------------------------------------------//
