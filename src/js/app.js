let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
   id: '',
   nombre: '',
   fecha: '',
   hora: '',
   servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
   iniciarApp();
});

function iniciarApp() {
   mostrarSeccion();
   tabs(); // cambia la seccion cuando se presionan los tabs
   botonesPaginador();
   paginaAnterior();
   paginaSiguiente();
   consultarAPI();

   idCliente();
   nombreCliente();
   seleccionarFecha();
   seleccionarHora();
   mostrarResumen();
}

function mostrarSeccion() {
   const seccionAnterior = document.querySelector('.mostrar');
   if (seccionAnterior) {
      seccionAnterior.classList.remove('mostrar')
   }

   const seccion = document.querySelector(`#paso-${paso}`);
   seccion.classList.add('mostrar');

   const tabAnterior = document.querySelector('.actual');
   if (tabAnterior) {
      tabAnterior.classList.remove('actual');
   }

   const tab = document.querySelector(`[data-paso="${paso}"]`);
   tab.classList.add('actual');
}

function tabs() {
   const botones = document.querySelectorAll('.tabs button');

   botones.forEach(boton => {
      boton.addEventListener('click', function (e) {
         e.preventDefault(e);
         paso = parseInt(e.target.dataset.paso);

         mostrarSeccion();
         botonesPaginador();
      });
   });
}

function botonesPaginador() {
   const paginaAnterior = document.querySelector('#anterior');
   const paginaSiguiente = document.querySelector('#siguiente');

   if (paso === 1) {
      paginaAnterior.classList.add('ocultar');
      paginaSiguiente.classList.remove('ocultar');
   } else if (paso === 3) {
      paginaAnterior.classList.remove('ocultar');
      paginaSiguiente.classList.add('ocultar');

      mostrarResumen();
   } else {
      paginaAnterior.classList.remove('ocultar');
      paginaSiguiente.classList.remove('ocultar');
   }

   mostrarSeccion();
}

function paginaAnterior() {
   const paginaAnterior = document.querySelector('#anterior');
   paginaAnterior.addEventListener('click', function () {
      if (paso <= pasoInicial) return;
      paso--;

      botonesPaginador();
   });
}

function paginaSiguiente() {
   const paginaSiguiente = document.querySelector('#siguiente');
   paginaSiguiente.addEventListener('click', function () {
      if (paso >= pasoFinal) return;
      paso++;

      botonesPaginador();
   });
}

async function consultarAPI() {
   try {
      const url = `${location.origin}/api/servicios`;
      const resultado = await fetch(url);
      const servicios = await resultado.json();

      mostrarServicios(servicios);
   } catch (error) {
      console.log(error);
   }
}

function mostrarServicios(servicios) {
   servicios.forEach(servicio => {
      const { id, nombre, precio } = servicio;

      const nombreServicio = document.createElement('P');
      nombreServicio.classList.add('nombre-servicio');
      nombreServicio.textContent = nombre;

      const precioServicio = document.createElement('P');
      precioServicio.classList.add('precio-servicio');
      precioServicio.textContent = `$${precio}`;

      const servicioDiv = document.createElement('P');
      servicioDiv.classList.add('servicio');
      servicioDiv.dataset.idServicio = id;
      servicioDiv.onclick = function () {
         seleccionarservicio(servicio);
      };

      servicioDiv.appendChild(nombreServicio);
      servicioDiv.appendChild(precioServicio);

      document.querySelector('#servicios').appendChild(servicioDiv);
   });
}


function seleccionarservicio(servicio) {
   const { id } = servicio;
   const { servicios } = cita;

   //IDENTIFICAR AL ELEMENTO QUE SE LE DA CLICK
   const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

   //comprobar si el servico ya fue agregado o quitarlo
   if (servicios.some(agregado => agregado.id === id)) {
      //ELIMINARLO
      cita.servicios = servicios.filter(agregado => agregado.id !== id);
      divServicio.classList.remove('seleccionado');;
   } else {
      //AGREGARLO
      cita.servicios = [...servicios, servicio]; // los tres puntos es para hacer una copia del objeto existente  
      divServicio.classList.add('seleccionado');
   }

}

function idCliente() {
   const idCliente = document.querySelector('#id').value;
   cita.id = idCliente;
}

function nombreCliente() {
   //console.log(cita);
   const nombre = document.querySelector('#nombre').value; //OBTENIENDO EL VALOR DEL INPUT NOMBRE
   cita.nombre = nombre; //AGREGANDO EL VALOR AL OBJETO DE NOMBRE
}

function seleccionarFecha() {
   const inputFecha = document.querySelector('#fecha');
   inputFecha.addEventListener('input', function (e) {
      const dia = new Date(e.target.value).getUTCDay();

      if ([6, 0].includes(dia)) {
         e.target.value = '';
         mostrarAlerta('Fines de semana no permitido', 'error', '.formulario');
      } else {
         cita.fecha = e.target.value;
      }
   });
}

function seleccionarHora() {
   const inputHora = document.querySelector('#hora');
   inputHora.addEventListener('input', function (e) {
      const horaCita = e.target.value;
      const hora = horaCita.split(":")[0];

      if (hora < 10 || hora > 18) {
         e.target.value = '';
         mostrarAlerta('Hora no valida', 'error', '.formulario');
      } else {
         cita.hora = e.target.value;
      }
   });
}

function mostrarAlerta(mensaje, tipo, elemento, desparece = true) {
   //PREVIENE QUE SE GENERE UNA NUEVA ALERTA
   const alertaPrevia = document.querySelector('.alerta');
   if (alertaPrevia) {
      alertaPrevia.remove();
   };

   //GENERA UNA NUEVA ALERTA
   const alerta = document.createElement('DIV');
   alerta.textContent = mensaje;
   alerta.classList.add('alerta');
   alerta.classList.add(tipo);

   const referencia = document.querySelector(elemento);
   referencia.appendChild(alerta);

   if (desparece) {
      //ELIMINAR LA ALERTA
      setTimeout(() => {
         alerta.remove();
      }, 3000);
   }
}

function mostrarResumen() {
   const resumen = document.querySelector('.contenido-resumen');

   while (resumen.firstChild) {
      resumen.removeChild(resumen.firstChild)
   }

   if (Object.values(cita).includes('') || cita.servicios.length === 0) {
      mostrarAlerta('Hacen falta datos o servicios', 'error', '.contenido-resumen', false);
      return;
   }

   const { nombre, fecha, hora, servicios } = cita;

   const headingServicios = document.createElement('H3');
   headingServicios.textContent = 'Resumen de servicios';
   resumen.appendChild(headingServicios);

   //ITERANDO Y MOSTRANDO LOS SERVICIOS
   servicios.forEach(servicio => {
      const { id, precio, nombre } = servicio;

      const contenedorServicio = document.createElement('DIV');
      contenedorServicio.classList.add('contenedor-servicio');

      const textoServicio = document.createElement('P');
      textoServicio.textContent = nombre;

      const precioServicio = document.createElement('P');
      precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

      contenedorServicio.appendChild(textoServicio);
      contenedorServicio.appendChild(precioServicio);

      resumen.appendChild(contenedorServicio);
   });

   const headingCita = document.createElement('H3');
   headingCita.textContent = 'Resumen de cita';
   resumen.appendChild(headingCita);

   const nombreCliente = document.createElement('P');
   nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`

   const fechaObj = new Date(fecha);
   const mes = fechaObj.getMonth();
   const dia = fechaObj.getDate() + 2;
   const year = fechaObj.getFullYear();

   const fechaUTC = new Date(Date.UTC(year, mes, dia));

   const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
   const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

   const fechaCita = document.createElement('P');
   fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`

   const horaCita = document.createElement('P');
   horaCita.innerHTML = `<span>Hora:</span> ${hora}`

   const botonReservar = document.createElement('BUTTON');
   botonReservar.classList.add('boton');
   botonReservar.textContent = 'Reservar';
   botonReservar.onclick = reservarCita;

   resumen.appendChild(nombreCliente);
   resumen.appendChild(fechaCita);
   resumen.appendChild(horaCita);
   resumen.appendChild(botonReservar);
}

async function reservarCita() {
   const { nombre, fecha, hora, servicios, id } = cita;
   const idServicio = servicios.map(servicio => servicio.id);
   //return;

   const datos = new FormData();
   datos.append('fecha', fecha);
   datos.append('hora', hora);
   datos.append('usuarioId', id);
   datos.append('servicios', idServicio);

   try {
      const url = `${location.origin}/api/citas`;
      const respuesta = await fetch(url, {
         method: 'POST',
         body: datos
      });
   
      const resultado = await respuesta.json();
      if (resultado.resultado) {
         Swal.fire({
            icon: "success",
            title: "Cita creada",
            text: "Cita creada correctamente",
            button: 'Ok'
         }).then(() => {
            window.location.reload();      
         });
      }  
   } catch (error) {
      Swal.fire({
         icon: "error",
         title: "Error",
         text: "Hubo un error al guardar la cita",
         button: 'Ok'
      });
   }
}