/* Requiere jQuery v3.6.0
 * https://code.jquery.com/jquery-3.6.0.min.js
 * */
var app,
    inter,
    port,
    clickonce = "https://resources.firmaperu.gob.pe/app/clickonce/clienteweb/FirmaPeruWeb.application",
    jws = "jnlps://apps.firmaperu.gob.pe/web/jwslauncher.jsp";
function startSignature(e, a) {
    if ("undefined" == typeof jqFirmaPeru)
        (msg1 = "Variable jqFirmaPeru no definida en la aplicaci\xf3n web que integra al servicio, la versi\xf3n de JQuery para Firma Per\xfa al momento de su puesta en producci\xf3n es 3.6.0."),
            (msg2 = "Para el funcionamiento del servicio es necesario el integrador establezca la variable var jqFirmaPeru = jQuery.noConflict(true)."),
            console.log("Firma Per\xfa: " + msg1),
            console.log("Firma Per\xfa: " + msg2),
            alert("Firma Per\xfa\n\n" + msg1 + ". " + msg2);
    else {
        if (
            (console.log("Firma Per\xfa: La versi\xf3n de JQuery para Firma Per\xfa al momento de su puesta en producci\xf3n es 3.6.0, si usa una versi\xf3n superior y no presenta inconvenientes no ser\xeda necesario bajar la versi\xf3n."),
            console.log("Firma Per\xfa: Versi\xf3n de JQuery configurado por el integrador de Firma Per\xfa: " + jqFirmaPeru.fn.jquery),
            (userAgent = window.navigator.userAgent),
            "Windows" === (OSName = getOSName()))
        )
            (app = clickonce), console.log("Firma Per\xfa: Sistema Operativo Windows, se realizar\xe1 la ejecuci\xf3n con ClickOnce.");
        else if ("macOS" === OSName) (app = jws), console.log("Firma Per\xfa: Sistema Operativo macOS, se realizar\xe1 la ejecuci\xf3n con OpenWebStart.");
        else if ("Linux" === OSName) {
            if (/Firefox/.test(userAgent)) (app = jws), console.log("Firma Per\xfa: Sistema Operativo Linux, se realizar\xe1 la ejecuci\xf3n con OpenWebStart.");
            else {
                alert("Firma Per\xfa\n\nNavegador no soportado, solo disponible con Mozilla Firefox.");
                return;
            }
        } else {
            alert("Firma Per\xfa\n\nSistema operativo '" + OSName + "' no soportado");
            return;
        }
        signatureInit(),
            (host = "http://localhost:" + e + "/firmaperu/sign"),
            (count = 0),
            (maximumTry = 60),
            inter && clearInterval(inter),
            (inter = setInterval(function () {
                jqFirmaPeru
                    .ajax({ method: "GET", url: host, data: {}, timeout: 500 })
                    .done(function (e) {
                        "ok" === e.status && (clearInterval(inter), processSignature(host, a));
                    })
                    .fail(function () {
                        0 === count &&
                            (printInfo(host, e),
                            runService(e),
                            console.log("El tiempo de espera m\xe1ximo para la ejecuci\xf3n del servicio es de 1 minuto, pasado ese tiempo si el servicio no se ejecut\xf3, la operaci\xf3n de firma digital se cancelar\xe1.")),
                            count++,
                            console.log("Verificando el servicio se haya instalado, intento " + count + " de " + maximumTry),
                            count == maximumTry &&
                                (clearInterval(inter),
                                console.log("Tiempo de espera de ejecuci\xf3n superado. Si la instalaci\xf3n est\xe1 en progreso, espere a que esta termine y luego vuelva a intentar firmar nuevamente."),
                                alert("Firma Per\xfa\n\nTiempo de espera de ejecuci\xf3n superado.\n\nSi la instalaci\xf3n est\xe1 en progreso, espere a que esta termine y luego vuelva a intentar firmar nuevamente."),
                                signatureCancel());
                    });
            }, 1e3));
    }
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
            });
}
function printInfo(e, a) {
    "Windows" === (OSName = getOSName())
        ? (console.log("***CONFIGURACI\xd3N PARA SISTEMA OPERATIVO WINDOWS***"),
          console.log("Revisar instalaciones y configuraciones a realizar para que el componentre web funcione: https://apps.firmaperu.gob.pe/web/firmador.xhtml"),
          console.log("***PLUGIN DE CLICKONCE***"),
          console.log(
              "Para que la aplicaci\xf3n de Firma Per\xfa en aplicaciones web funcione desde la integraci\xf3n realizada por los desarrolladores de las entidades, es importante tener instalado en el navegador el plugin de ClickOnce."
          ),
          console.log("Si un plugin de ClickOnce correspondiente al navegador est\xe1 instalado se iniciar\xe1 autom\xe1ticamente el servicio, caso contrario instale un Plugin de las opciones a continuaci\xf3n:"),
          console.log("Plugin para Firefox (Instalar solo uno de los listados)"),
          console.log(" - https://addons.mozilla.org/es/firefox/addon/logalty-clickonce/"),
          console.log(" - https://addons.mozilla.org/es/firefox/addon/breez-clickonce/"),
          console.log("Plugin para Google Chrome (Instalar solo uno de los listados)"),
          console.log(" - https://chrome.google.com/webstore/detail/windows-remix-clickonce-h/dgpgholdldjjbcmpeckiephjigdpikan"),
          console.log(" - https://chrome.google.com/webstore/detail/clickonce-for-google-chro/kekahkplibinaibelipdcikofmedafmb"),
          console.log(
              "Para Microsoft Edge basado en Chromium, las ultima versiones trabajan de manera nativa, en caso no se realice la ejecuci\xf3n, puede instalar uno de los plugin de Google Chrome, Para esto tendr\xe1 que aceptar el mensaje de instalaci\xf3n de componentes desde tiendas de terceros que apare al momento de la instalaci\xf3n."
          ),
          console.log(
              "Al instalar un plugin se descargar\xe1 un archivo exe, es importante que este archivo exe se ejecute para que la instalaci\xf3n del plugin sea correcta. En caso sea necesario, habilitar la ejecuci\xf3n de este exe en caso el antivirus muestre un mensaje."
          ),
          console.log(
              "Si luego de tener un plugin instalado y no se ejecuta el servicio, aseg\xfarese que la PC tiene acceso al puerto " +
                  a +
                  " que el desarrollador estableci\xf3 para la ejecuci\xf3n del servicio local y que la URL " +
                  e +
                  " no est\xe9 bloqueada por alg\xfan programa local como antivirus o firewall."
          ),
          console.log("Puede revisar el log de ejecuci\xf3n en USER_HOME/PCM/FirmadorClienteWeb/log/FirmadorClienteWeb.log"),
          console.log("\n"))
        : "macOS" === OSName
        ? (console.log("***CONFIGURACI\xd3N PARA SISTEMA OPERATIVO MACOS***"),
          console.log("Revisar instalaciones y configuraciones a realizar para que el componente web funcione: https://apps.firmaperu.gob.pe/web/firmador.xhtml"),
          console.log(
              "Si luego de realizar las instalaciones y configuraciones el comoponente web no carga, aseg\xfarese que la PC tiene acceso al puerto " +
                  a +
                  " que el desarrollador estableci\xf3 para la ejecuci\xf3n del servicio local y que la URL " +
                  e +
                  " no est\xe9 bloqueada por alg\xfan programa local."
          ),
          console.log("Puede revisar el log de ejecuci\xf3n en USER_HOME/PCM/FirmadorClienteWeb/log/FirmadorClienteWeb.log"))
        : "Linux" === OSName &&
          (console.log("***CONFIGURACI\xd3N PARA SISTEMA OPERATIVO LINUX***"),
          console.log("Revisar instalaciones y configuraciones a realizar para que el componente web funcione: https://apps.firmaperu.gob.pe/web/firmador.xhtml"),
          console.log(
              "Si luego de realizar las instalaciones y configuraciones el comoponente web no carga, aseg\xfarese que la PC tiene acceso al puerto " +
                  a +
                  " que el desarrollador estableci\xf3 para la ejecuci\xf3n del servicio local y que la URL " +
                  e +
                  " no est\xe9 bloqueada por alg\xfan programa local."
          ),
          console.log("Puede revisar el log de ejecuci\xf3n en USER_HOME/PCM/FirmadorClienteWeb/log/FirmadorClienteWeb.log"));
}
function runService(e) {
    console.log("Ejecutando la aplicaci\xf3n Firma Per\xfa Cliente Web."),
        (objFrame = document.getElementById("componentFirmaPeru")) ||
            (((div = document.createElement("div")).innerHTML = '<iframe id="firmaPeru" style="height:0%;width:0%; border:none;display:none;" src="' + app + "?port=" + e + '"></iframe>'),
            document.getElementById("addComponent").appendChild(div)),
        setTimeout(function () {
            (padre = (objFrame = document.getElementById("firmaPeru")).parentNode).removeChild(objFrame);
        }, 2e3);
}
function getOSName() {
    return (
        (userAgent = window.navigator.userAgent),
        (platform = window.navigator.platform),
        (windowsPlatforms = ["Win32", "Win64", "Windows", "WinCE"]),
        (iosPlatforms = ["iPhone", "iPad", "iPod"]),
        (OSName = null),
        (OSName =
            -1 !== (macosPlatforms = ["Macintosh", "MacIntel", "MacPPC", "Mac68K"]).indexOf(platform)
                ? "macOS"
                : -1 !== iosPlatforms.indexOf(platform)
                ? "iOS"
                : -1 !== windowsPlatforms.indexOf(platform)
                ? "Windows"
                : /Android/.test(userAgent)
                ? "Android"
                : !OSName && /Linux/.test(platform)
                ? "Linux"
                : platform)
    );
}
