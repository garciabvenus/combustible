/**
 * Created by venusgb on 28/02/2020.
 */

function actualizabd() {
    var cCelda = ''
    nNumLiq=document.getElementById('txtliq').value
    cKilom=document.getElementById('txtKilom').value
    for (var i=1;i<document.getElementById('TblDetPro').rows.length;i++) {
        cCelda=document.getElementById('TblDetPro').rows[i].cells[0].innerHTML
        if (cCelda=='Carga') {nIdTipC=1}
        if (cCelda=='Recarga') {nIdTipC=2}
        nIdProd=document.getElementById('TblDetPro').rows[i].cells[1].innerHTML
        nCanti=document.getElementById('TblDetPro').rows[i].cells[3].innerHTML
        nPcio=document.getElementById('TblDetPro').rows[i].cells[4].innerHTML
        nDevVac=document.getElementById('TblDetPro').rows[i].cells[5].children[0].value
        nDevLle=document.getElementById('TblDetPro').rows[i].cells[6].children[0].value
        nRacDev=document.getElementById('TblDetPro').rows[i].cells[7].children[0].value
        nNvaCga=document.getElementById('TblDetPro').rows[i].cells[8].children[0].value
        nNvoRac=document.getElementById('TblDetPro').rows[i].cells[9].children[0].value
        actualizaDato(nDevVac,nDevLle,nRacDev,nNumLiq,nIdProd,nIdTipC,nCanti,nPcio,nNvaCga,nNvoRac)
    }
    actualizaDetLiq(nNumLiq,cKilom)
    alert('Actualizacion completada')
}

function objetoAjax(){
    var xmlhttp=false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function actualizaDato(nDevVac,nDevLle,nRacDev,nNumLiq,nIdProd,nIdTipC,nCanti,nPcio,nNvaCga,nNvoRac) {
    divResultado = document.getElementById('resultado')
    ajax=objetoAjax()
    ajax.open("POST", "actualizaygraba.php");
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            //mostrar resultados en esta capa
            //divResultado.innerHTML = ajax.responseText
        }
    }

    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
    ajax.send("&nDevVac="+nDevVac+"&nDevLle="+nDevLle+"&nRacDev="+nRacDev+"&nNumLiq="+nNumLiq+"&nIdProd="+nIdProd+"&nIdTipC="+nIdTipC+"&nCanti="+nCanti+"&nPcio="+nPcio+"&nNvaCga="+nNvaCga+"&nNvoRac="+nNvoRac,true)
}

function actualizaDetLiq(nNumLiq,cKilom) {
    divResultado = document.getElementById('resultado')
    ajax=objetoAjax()
    ajax.open("POST", "ActualizayGenera.php")
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            //mostrar resultados en esta capa
            //divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
    ajax.send("nNumLiq="+nNumLiq+"cKilom="+cKilom,true)
}

function presionarInsert(){
    $.ajax({
        type: "POST",
        url: "insertarRegistro.php",
        data: {
            cbotipcga :$('#cbotipcga').val().trim(),
            txtliq:$('#txtliq').val().trim(),
            txtCant:$('#txtCant').val().trim(),
            TxtRack:$('#TxtRack').val().trim(),
            cboprod : $('#cboprod').val()
        },
        success: function(data){
            alert("Se inserto el Registro");
        }
    });
}


function myFunction(x) {
    nfila=x.rowIndex;
}

function btnguardar(){
    var i=nfila;

    dFecha=document.getElementById('fechacga').value
    cPlacas=document.getElementById('TblDetgas').rows[i].cells[1].innerHTML;
    nKilom=document.getElementById('TblDetgas').rows[i].cells[5].children[0].value
    nLitros=document.getElementById('TblDetgas').rows[i].cells[6].children[0].value
    nImpte=document.getElementById('TblDetgas').rows[i].cells[7].children[0].value
    nPrecio=nImpte/nLitros

    divResultado = document.getElementById('resultado')
    ajax=objetoAjax()
    ajax.open("POST", "actcombust.php"),
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                //mostrar resultados en esta capa
                divResultado.innerHTML = ajax.responseText
            }
        }

    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("&dFecha="+dFecha+"&cPlacas="+cPlacas+"&nKilom="+nKilom+"&nLitros="+nLitros+"&nImpte="+nImpte+"&nPrecio="+nPrecio,true);

}
