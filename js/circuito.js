class Circuito{
    constructor(){
        this.#comprobarApiFile();
    }
    #comprobarApiFile(){
        if(window.File && window.FileReader && window.FileList && window.Blob){
            return true;
        }else{
            const mensajeError = document.createElement("p");
            mensajeError.textContent = "Este navegador NO soporta el API File y este programa puede no funcionar correctamente";
            const main = document.querySelector("main");
            main.appendChild(mensajeError);
            return false;
        }
    }

    leerArchivoHTML(){
        const main = document.querySelector("main");
        const articulo = document.createElement("article");
        const tituloArticulo = document.createElement("h3");
        tituloArticulo.textContent = "Carga del archivo html";
        const input = document.createElement("input");
        input.type = "file";
        input.id = "input-html";
        const mensajeError = document.createElement("p");
        mensajeError.textContent="";
        const label = document.createElement("label");
        label.htmlFor = "input-html";
        label.textContent = "Selecciona el archivo HTML a cargar: ";

        articulo.appendChild(tituloArticulo);
        articulo.appendChild(label);
        articulo.appendChild(input);
        articulo.appendChild(mensajeError);
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            const tipoTexto = /text.*/;
            articulo.innerHTML = "";
            articulo.appendChild(tituloArticulo);
            articulo.appendChild(label);
            articulo.appendChild(input);
            articulo.appendChild(mensajeError);
            mensajeError.textContent="";
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    const contenidoHTML = lector.result;
                    this.#procesarHTML(contenidoHTML,articulo);
                }
                lector.readAsText(archivo);
            } else {
                mensajeError.textContent = "Error: El archivo seleccionado no es válido";
            }
        });    
        main.appendChild(articulo);
    }

    #procesarHTML(contenidoHTML,articulo){
        const parser = new DOMParser();
        var documentoHTML = parser.parseFromString(contenidoHTML,"text/html");
        const titulosH2 = documentoHTML.querySelectorAll("h2");
        for(let titulo of titulosH2){
            const h4 = document.createElement("h4");
            h4.innerHTML = titulo.innerHTML;
            titulo.replaceWith(h4);
        }
        const imagenes = documentoHTML.getElementsByTagName("img");
        for(let imagen of imagenes){
            imagen.setAttribute("src",imagen.getAttribute("src").substring(3));
        }
        const videos = documentoHTML.getElementsByTagName("video");
        for(let video of videos){
            video.setAttribute("src",video.getAttribute("src").substring(3));
        }       
        Array.from(documentoHTML.body.children).forEach(elemento => {
            articulo.appendChild(elemento);
        });
    }
}

class CargadorSVG{
    leerArchivoSVG(){
        const main = document.querySelector("main");
        const articulo = document.createElement("article");
        const tituloArticulo = document.createElement("h3");
        tituloArticulo.textContent = "Carga del archivo svg";
        articulo.appendChild(tituloArticulo);
        const input = document.createElement("input");
        input.type = "file";
        input.id = "input-svg";
        const label = document.createElement("label");
        label.htmlFor = "input-svg";
        label.textContent = "Selecciona el archivo SVG a cargar: ";
        const figure = document.createElement("figure");

        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            const tipoTexto = /image.*/;
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    figure.innerHTML = "";
                    figure.appendChild(this.#insertarSVG(lector.result));
                }
                lector.readAsText(archivo);
            } else {
                figure.innerText = "Error: El archivo seleccionado no es válido";
            }
        });
        articulo.appendChild(label);
        articulo.appendChild(input);
        articulo.appendChild(figure);
        main.appendChild(articulo);
    }

    #insertarSVG(contenidoSVG){
        const parser = new DOMParser();
        var documentoSVG = parser.parseFromString(contenidoSVG,"image/svg+xml");
        documentoSVG.documentElement.setAttribute("version", "1.1");   
        return documentoSVG.querySelector("svg");
    }
}

class CargadorKML{
    leerArchivoKML(){
        const main = document.querySelector("main");
        const articulo = document.createElement("article");
        const tituloArticulo = document.createElement("h3");
        tituloArticulo.textContent = "Carga del archivo kml";
        articulo.appendChild(tituloArticulo);
        const input = document.createElement("input");
        input.type = "file";
        input.id = "input-kml";
        const label = document.createElement("label");
        label.htmlFor = "input-kml";
        label.textContent = "Selecciona el archivo KML a cargar: ";
        const divMapa = document.createElement("div");
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            const tipoTexto = /kml.*/;
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    const mapa = new google.maps.Map(divMapa,{
                        zoom:15,
                        center: {lat: 2.7605323046860426, lng: 101.73770823971508}
                    });
                    this.#insertarCapaKML(lector.result,mapa);
                }
                lector.readAsText(archivo);
            } else {
                divMapa.innerText = "Error: El archivo seleccionado no es válido";
            }
        });
        articulo.appendChild(label);
        articulo.appendChild(input);
        articulo.appendChild(divMapa);
        main.appendChild(articulo);
    }

    #insertarCapaKML(contenidoKML,mapa){
        const parser = new DOMParser();
        var documentoKML = parser.parseFromString(contenidoKML,"text/xml");
        const coordenadas = documentoKML.getElementsByTagName("coordinates");

        const arrayCoordenadas = [];
        for(let coordenada of coordenadas){
            if(coordenada.parentNode.tagName !== "LineString"){
                const coordenadaLatLng = coordenada.textContent.trim().split(',');
                arrayCoordenadas.push({
                    lat: parseFloat(coordenadaLatLng[1]),
                    lng: parseFloat(coordenadaLatLng[0])
                });
            }
            
        }
        const marcadorOrigen = new google.maps.Marker({
            position: arrayCoordenadas[0],
            map: mapa,
            title: 'Origen del circuito'
        });
        const polyline = new google.maps.Polyline({
            path: arrayCoordenadas,
            geodesic:true,
            strokeColor: "#ff0000",
            strokeOpacity: 0.8,
            strokeWeight: 4,
        });
        polyline.setMap(mapa);
    }
}

$(document).ready(function(){
    const circuito = new Circuito();
    circuito.leerArchivoHTML();
    const cargadorSVG = new CargadorSVG();
    cargadorSVG.leerArchivoSVG();
    const cargadorKML = new CargadorKML();
    cargadorKML.leerArchivoKML();
});
