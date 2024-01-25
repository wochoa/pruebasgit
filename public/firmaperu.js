/* Requiere jQuery v3.6.0
 * https://code.jquery.com/jquery-3.6.0.min.js
 * */
var inter;
function startSignature(e, a) {

        signatureInit(),
            (host = "http://localhost:" + e + "/firmaperu/sign"),
            (count = 0),
            (maximumTry = 60),
            inter && clearInterval(inter),
            (inter = setInterval(function () 
                {
                    jqFirmaPeru
                        .ajax({ method: "GET", url: host, data: {}, timeout: 500 })
                        .done(function (e) {
                            "ok" === e.status && (clearInterval(inter), processSignature(host, a));
                        })
                        .fail(function () {
                            console.log("El tiempo de espera m\xe1ximo para la ejecuci\xf3n del servicio es de 1 minuto, pasado ese tiempo si el servicio no se ejecut\xf3, la operaci\xf3n de firma digital se cancelar\xe1.")
                            signatureCancel()
                        });
                }, 1e3)
            );
            
            // console.log(inter)
}
function processSignature(e, a) {
    console.log("Firma Per\xfa Cliente Web instalado en la PC."),
        console.log("Iniciando operaci\xf3n de firma digital."),
        jqFirmaPeru
            .ajax({ method: "POST", url: e, data: { param: a }, timeout: 0 })
            .done(function (e) {
                "ok" === e.status
                    ? (console.log("Operaci\xf3n de firma digital terminada."), signatureOk())
                    : (console.log("Firma Per\xfa Cliente Web: " + e.message),
                      console.log("Firma Per\xfa Cliente Web: Para m\xe1s informaci\xf3n revise el log de ejecuci\xf3n en USER_HOME/PCM/FirmadorClienteWeb/FirmadorClienteWeb.log"),
                      "La operaci\xf3n de firma digital fue cancelada." !== e.message && alert("Firma Per\xfa Cliente Web\n\n" + e.message),
                      signatureCancel());
            })
            .fail(function () {
                console.log("Firma Per\xfa Cliente Web: No se pudo hacer POST a " + e), alert("Firma Per\xfa Cliente Web\n\nNo se pudo hacer POST a " + e);
                // console.log("Firma Per\xfa Cliente Web: No se pudo hacer POST a " + e)
            });
}


