let sendbtn1 = document.getElementById("formulario")
let authUser = document.getElementById("into1")
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
        case "number":  
			validarCampo(expresiones.number, e.target.value , e.target.name);
        break;
    }
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario)
    input.addEventListener('blur', validarFormulario)  
    
})

let caja = document.getElementById("condiciones");

function palomita(){
    if(caja.checked) {
        document.getElementById('grupo__condiciones').classList.remove('formulario__grupo-incorrecto');
        document.getElementById('grupo__condiciones').classList.add('formulario__grupo-correcto');
        document.querySelector('#grupo__condiciones i').classList.add('fa-check-circle');
        document.querySelector('#grupo__condiciones i').classList.remove('fa-times-circle');
        document.querySelector(`#grupo__condiciones .formulario__input-error`).classList.remove('formulario__input-error-activo');

        
    }else{
        document.getElementById('grupo__condiciones').classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__condiciones .formulario__input-error`).classList.add('formulario__input-error-activo');
    }
}

caja.addEventListener('click' ,palomita)

let envioCondiciones = () => {
    if(!expresiones.number.test(inputs[0].value)
    || inputs[0].value == null
    || !caja.checked){
        return false;
    }
    return true;
}

sendbtn1.addEventListener('mouseover', envioCondiciones)
sendbtn1.addEventListener('keyup', envioCondiciones)

sendbtn1.addEventListener('submit', (e) => {
    if(!envioCondiciones()) {
        return e.preventDefault();
    }
});

let conditions = document.getElementById('conditions');
let modal_container = document.getElementById('modal_container');
let close0 = document.getElementById('close');

conditions.addEventListener('click', () => {
  modal_container.classList.add('show');  
});

close0.addEventListener('click', () => {
  modal_container.classList.remove('show');
});

let modal_container2 = document.getElementById('modal_container2');
let close2 = document.getElementById('close2');

if(close2){
close2.addEventListener('click', () => {
  modal_container2.classList.remove('show2')
});
}


let modal_container3 = document.getElementById('modal_container3');
let close3 = document.getElementById('close3');

if(close3){
close3.addEventListener('click', () => {
  modal_container3.classList.remove('show3')
});
}


