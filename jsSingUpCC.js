let sendbtn1 = document.getElementById("formulario")
let inputs = document.querySelectorAll('#formulario input') 

let expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, 
	number: /^.{4,12}$/, 
	password: /^.{4,12}$/, 
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ 
}
                
let validarCampo = (expresion, input, campo) => {
    if(expresion.test(input)){  
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
    }
}

let validarFormulario = (e) => {
    switch (e.target.name) {  
        case "email":
            validarCampo(expresiones.email, e.target.value , e.target.name);
        break;
       
    }
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario)
    input.addEventListener('blur', validarFormulario)  
    
})


let envioCondiciones = () => {
    if(expresiones.email.test(inputs[0].value)){
        return true;
    } else {
        return false;
    }
    
}

sendbtn1.addEventListener('mouseover', envioCondiciones)
sendbtn1.addEventListener('keyup', envioCondiciones)

sendbtn1.addEventListener('submit', (e) => {
    if(!envioCondiciones()) {
        return e.preventDefault();
    }
});


let modal_container4 = document.getElementById('modal_container4');
let close4 = document.getElementById('close4');

if(close4){
    close4.addEventListener('click', () => {
      modal_container4.classList.remove('show4');
      setTimeout(()=> {window.location="index.php"}, 0)
    });
}



