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
        articulo.appendChild(tituloArticulo);
        const input = document.createElement("input");
        input.type = "file";
        const section = document.createElement("section");
        const tituloSeccion = document.createElement("h4");
        tituloSeccion.textContent = "Petronas Senpang Circuit International";
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            const tipoTexto = /text.*/;
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = function(evento) {
                    const contenidoHTML = lector.result;
                    const parser = new DOMParser();
                    var documentoHTML = parser.parseFromString(contenidoHTML,"text/html");
                    const titulosH2 = documentoHTML.querySelectorAll("h2");
                    for(let titulo of titulosH2){
                        const h5 = document.createElement("h5");
                        h5.innerHTML = titulo.innerHTML;
                        titulo.replaceWith(h5);
                    }
                    const imagenes = documentoHTML.getElementsByTagName("img");
                    for(let imagen of imagenes){
                        imagen.setAttribute("src",imagen.getAttribute("src").substring(3));
                    }
                    const videos = documentoHTML.getElementsByTagName("video");
                    for(let video of videos){
                        video.setAttribute("src",video.getAttribute("src").substring(3));
                    }
                    section.innerHTML = "";
                    section.appendChild(tituloSeccion);
                    section.append(...documentoHTML.body.children);
                }
                lector.readAsText(archivo);
            } else {
                section.innerText = "Error: El archivo seleccionado no es válido";
            }
        });
        
        articulo.appendChild(input);
        articulo.appendChild(section);
        main.appendChild(articulo);
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
        input.type = "file"
        const figure = document.createElement("figure");

        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            const tipoTexto = /image.*/;
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    figure.innerHTML = "";
                    figure.append(this.#insertarSVG(lector.result));                    
                }
                lector.readAsText(archivo);
            } else {
                figure.innerText = "Error: El archivo seleccionado no es válido";
            }
        });
        articulo.appendChild(input);
        articulo.appendChild(figure);
        main.appendChild(articulo);
    }

    #insertarSVG(contenidoSVG){
        const parser = new DOMParser();
        var documentoSVG = parser.parseFromString(contenidoSVG,"image/svg+xml");   
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
