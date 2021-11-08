

async function marcarMensajeVisto(elemento,id){

    let respuesta = await fetch(`/Controllers/request.php?peticion=mensajevisto&id=${id}`)
    let respuesta_json = await respuesta.json();
    
    if(parseInt(respuesta_json) == 1){
      elemento.style.display = 'none';
      elemento.parentNode.innerHTML = 'Mensaje visto';
     
    }
}  

window.onload = function () {
    var mensajes_sinleer = 0;
    var mensajes_leidos = 0;
    var modal_mensajes = document.getElementById("mensajes_modal");
    var cruz_cierre_modal = document.getElementById("cruz");

    /* 
    * Realiza un request HTTP GET a request.php para recibir el estado de los mensajes.
     */
    async function requestEstadoMensajes() {
        let respuesta = await fetch('/Controllers/request.php?peticion=getpendientes')
        let respuesta_json = await respuesta.json();

        document.getElementById('cajon_pendientes').innerHTML = respuesta_json.pendientes;
        document.getElementById('cajon_confirmados').innerHTML = respuesta_json.confirmados;
        document.getElementById('cajon_rechazados').innerHTML = respuesta_json.rechazados;
        

        /* Si los mensajes pendientes son mas de 10 mostraremos el numero en rojo. */
        if(respuesta_json.pendientes > 10){
            document.getElementById('cajon_pendientes').style.color='Red'
        }
    }
    requestEstadoMensajes();

    /* 
    *   Realiza un request HTTP GET a request.php para traer todos los mensajes al front
    */
    async function requestMensajes() {

        let respuesta = await fetch('/Controllers/request.php?peticion=getmensajes')
        let all_mensajes_json = await respuesta.json();

        mensajesSinVer(all_mensajes_json)
        if (mensajes_sinleer > 0) {
            setInterval(() => {
                document.getElementById('mensaje_div').classList.toggle('mensaje_img_frame_alert');

            }, 2000)


        }
        /* Al recibirlo en JSON recorremos la array de mensajes  y por cada mensaje crearemos un div nuevo */
        all_mensajes_json.forEach( mensaje => {
            if(mensaje.visto == '0'){
                let mensaje_div = document.createElement("div");

                mensaje_div.classList.add('contenedor_mensajes')
                mensaje_div.classList.add('mensajes')
                mensaje_div.innerHTML = `
                <p>
                ${mensaje.contenido}

                <button onclick=marcarMensajeVisto(this,${mensaje.mensajeid}) class="button check_mensaje_button" > Marcar como visto</button>
                
                </p>`
    
                document.getElementById("mensajes_modal").append(mensaje_div);
    
            }
            
        })
    }

    requestMensajes();


    function mensajesSinVer(mensajes) {
        mensajes.forEach(mensaje => {
            if (mensaje.visto == 0) {
                mensajes_sinleer += 1;
            } else {
                mensajes_leidos += 1;
            }
        })
    }


    /* Se le añade funcionalidad al boton de mensajes para mostrar o no el Modal de mensajes */
    document.getElementById('mensaje_button').addEventListener('click', () => {

        modal_mensajes.style.display = "block";

        cruz_cierre_modal.addEventListener('click', () => {
            modal_mensajes.style.display = "none";

        })

    })


 

}
