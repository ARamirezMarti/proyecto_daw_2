
<!-- Alberga un pequeño dashboard  con la cantidad de pedidos en cada situación y tambien un icono para los mensajes. -->
<div id="contendor_resumen">
        <button id="mensaje_button">
            <div class="mensaje_img_frame" id="mensaje_div">
                <img  src="assets/icons/mensaje.svg" alt="Casa" >
            </div>
        </button>   


    <div class="cajon_resumen">
        <h4>Pedidos pendientes</h4>
        <span class="cajon_numero" id="cajon_pendientes"><?=$pendientes?></span>
    </div>
    <div class="cajon_resumen">
        <h4>Pedidos aceptados</h4>
        <span class="cajon_numero" id="cajon_confirmados">09</span>
    </div>
    <div class="cajon_resumen">
        <h4>pedidos denegados </h4>
        <span class="cajon_numero" id="cajon_rechazados">09</span>
    </div>
</div>

