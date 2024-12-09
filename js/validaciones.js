$(document).ready(function(){
    $("#div3").slideDown("slow");
});

(function () {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if(!form.checkValidity()){
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    })
  })();



//------------------------------------------------------------------------------------//
function RegistrarUsuario(){
  $('#txtnom').keyup(
    function(){
        var nombre = $('#txtnom').val();        
        if (validaNombre(nombre)){
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
        if (validaApellido(apellido)){
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
  $('#txtcon').keyup(function(){
      cadena =  $('#txtcon').val();
      if (!tieneNumeros(cadena) || !tieneMinusculas(cadena) || !tieneMayusculas(cadena) || !tieneCarEsp(cadena) || cadena.length<8){
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
  
  var cor = $("#txtcor").val();
  var con = $("#txtcon").val();
  var ape = $("#txtape").val();
  var nom = $("#txtnom").val();

  if(cor.length==0 || con.length==0 || ape.length==0 || nom.length==0 || mat.length==0){
    if(cor.length==0){
      $('#txtcor').addClass('is-invalid');
      $('#txtcor').removeClass('is-valid');
    }
    if(con.length==0){
      $('#txtcon').addClass('is-invalid');
      $('#txtcon').removeClass('is-valid');
    }
    if(ape.length==0){
      $('#txtape').addClass('is-invalid');
      $('#txtape').removeClass('is-valid');
    }
    if(nom.length==0){
      $('#txtnom').addClass('is-invalid');
      $('#txtnom').removeClass('is-valid');
    }
    return Swal.fire({title:"Error en los datos ingresados",text:"Llene los campos vacíos",icon:"warning",confirmButtonColor:"#0d6efd",confirmButtonText:"Aceptar"});
  }
  if (validaNombre(nom) && validaApellido(ape) && tieneFormato(cor) && valpas(con) && tieneNumeros(mat)){
        $.ajax({
        url: 'procesarRegistro',
        type: 'POST',
        data:{nom:nom,ape:ape,cor:cor,con:con},
        beforeSend: function(){
          Swal.fire({
              title:'Registrando usuario...',
              showConfirmButton: false,
              customClass: {title:"text-primary fw-bolder",footer: "fw-bolder"},
              html: '<div id="body"><div id="loader" class="m-5"></div></div>',
              footer: 'Evite recargar la página',
              allowOutsideClick: false,
              allowEscapeClick: false,
              allowEnterClick: false,
              stopKeydownPropagation: true,
          });
        },
          success:function(respuesta){
            $('#txtnom').val(''),
            $('#txtape').val(''),
            $('#txtcor').val(''),
            $('#txtcon').val(''),
            $('#txtadmin').val(''),
            $('#txtnom').removeClass('is-valid'); 
            $('#txtape').removeClass('is-valid');
            $('#txtcor').removeClass('is-valid'); 
            $('#txtcon').removeClass('is-valid');
            var data = $.parseJSON(respuesta);
            Swal.fire({
                icon: data.tipo,
                title: data.title,
                text: data.mensaje,
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Aceptar',
                showConfirmButton: true
            });
        }
    });
  }
}
$(document).ready(  
      
  function(){         
    $('#txtnom').keyup(
      function(){
          var nom=$('#txtnom').val();
          if (validaNombre(nom)){
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
          var ape=$('#txtape').val();
          if (validaNombre(ape)){
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
    $('#txtcon').keyup(function(){
        cadena =  $('#txtcon').val();
        if (!tieneNumeros(cadena) || !tieneMinusculas(cadena) || !tieneMayusculas(cadena) || !tieneCarEsp(cadena) || cadena.length<8){
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
  }
);

//------------------------------------------------------------------------------------//

function validaNombre(nom){
  nombre= /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Letras y espacios, pueden llevar acentos.
  if (nombre.test(nom)){
      
      return true;
  }
  else{
      
      return false;
  }
}

//------------------------------------------------------------------------------------//

function validaApellido(ape){
  apellidos= /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Letras y espacios, pueden llevar acentos.
  if (apellidos.test(ape)){
      
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
      
  emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
  
  if (emailRegex.test(cadena)) {
    return true;
  } else {
    return false;
  }
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
  if (!tieneNumeros(pas) || !tieneMinusculas(pas) || !tieneMayusculas(pas) || !tieneCarEsp(pas) || pas.length<8){
      $('#txtcon').removeClass('is-valid');
      $('#txtcon').addClass('is-invalid');
      return false;
  }else{
      $('#txtcon').addClass('is-valid');
      $('#txtcon').removeClass('is-invalid');
      return true;
  }
}
