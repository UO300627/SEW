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
        
        const label = document.createElement("label");
        label.htmlFor = "input-html";
        label.textContent = "Selecciona el archivo HTML a cargar: ";
        
        articulo.appendChild(tituloArticulo);
        articulo.appendChild(label);
        articulo.appendChild(input);
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            if (!archivo) {
                return;
            }
            const tipoTexto = /html.*/;
            articulo.innerHTML = "";
            articulo.appendChild(tituloArticulo);
            articulo.appendChild(label);
            articulo.appendChild(input);
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    const contenidoHTML = lector.result;
                    this.#procesarHTML(contenidoHTML,articulo);
                }
                lector.readAsText(archivo);
            } else {
                const mensajeError = document.createElement("p");
                mensajeError.textContent = "Error: El archivo seleccionado no es válido";
                articulo.appendChild(mensajeError);
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
        const input = document.createElement("input");
        input.type = "file";
        input.id = "input-svg";
        const label = document.createElement("label");
        label.htmlFor = "input-svg";
        label.textContent = "Selecciona el archivo SVG a cargar: ";
        
        articulo.appendChild(tituloArticulo);
        articulo.appendChild(label);
        articulo.appendChild(input);
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            if (!archivo) {
                return;
            }
            const tipoTexto = /image.*/;
            articulo.innerHTML = "";
            articulo.appendChild(tituloArticulo);
            articulo.appendChild(label);
            articulo.appendChild(input);
            if (archivo.type.match(tipoTexto)) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    const figure = document.createElement("figure");
                    figure.innerHTML = "";
                    articulo.appendChild(figure);
                    figure.appendChild(this.#insertarSVG(lector.result));
                }
                lector.readAsText(archivo);
            } else {
                const mensajeError = document.createElement("p");
                mensajeError.textContent = "Error: El archivo seleccionado no es válido";
                articulo.appendChild(mensajeError);
            }
        });
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

    constructor() {
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWRyaWFuZ3V0aWVycmV6MjAwNSIsImEiOiJjbWllZWFzODQwMDVtM2VzNzIwdXhnOW96In0.kdZTTD3-knru_ZQoGqASHw'; 
    }

    leerArchivoKML() {
        const main = document.querySelector("main");
        const articulo = document.createElement("article");
        const tituloArticulo = document.createElement("h3");
        tituloArticulo.textContent = "Carga del archivo kml";
        
        const input = document.createElement("input");
        input.type = "file";
        input.id = "input-kml";
        
        const label = document.createElement("label");
        label.htmlFor = "input-kml";
        label.textContent = "Selecciona el archivo KML a cargar: ";
        
        articulo.appendChild(tituloArticulo);
        articulo.appendChild(label);
        articulo.appendChild(input);
        input.addEventListener("change", (evento) => {
            const archivo = evento.target.files[0];
            if (!archivo) {
                return;
            }
            const tipoTexto = /kml.*/;
            
            articulo.innerHTML = "";
            articulo.appendChild(tituloArticulo);
            articulo.appendChild(label);
            articulo.appendChild(input);
            if (archivo.type.match(tipoTexto) || archivo.name.endsWith('.kml')) {              
                const lector = new FileReader();
                lector.onload = (evento) => {
                    const divMapa = document.createElement("div");
                    articulo.appendChild(divMapa);
                    const mapa = new mapboxgl.Map({
                        container: divMapa,
                        center: [101.73770823971508, 2.7605323046860426],
                        style: 'mapbox://styles/mapbox/satellite-streets-v12',
                        zoom: 14
                    });

                    mapa.on('load', () => {
                        this.#insertarCapaKML(lector.result, mapa);
                    });
                }
                lector.readAsText(archivo);
            } else {
                const mensajeError = document.createElement("p");
                mensajeError.textContent = "Error: El archivo seleccionado no es válido";
                articulo.appendChild(mensajeError);
            }
        });
        
        articulo.appendChild(label);
        articulo.appendChild(input);
        main.appendChild(articulo);
    }

    #insertarCapaKML(contenidoKML, mapa) {
        const parser = new DOMParser();
        var documentoKML = parser.parseFromString(contenidoKML, "text/xml");
        const coordenadas = documentoKML.getElementsByTagName("coordinates");

        const arrayCoordenadas = [];
        for (let coordenada of coordenadas) {
            if (coordenada.parentNode.tagName !== "LineString") {
                const coordenadaTexto = coordenada.textContent.trim().split(',');             
                const lng = parseFloat(coordenadaTexto[0]);
                const lat = parseFloat(coordenadaTexto[1]);

                arrayCoordenadas.push([lng, lat]);
            }
        }

        if (arrayCoordenadas.length > 0) {
            new mapboxgl.Marker()
            .setLngLat(arrayCoordenadas[0])
            .addTo(mapa);
        }

        mapa.addSource('ruta-kml', {
            'type': 'geojson',
            'data': {
                'type': 'Feature',
                'geometry': {
                    'type': 'LineString',
                    'coordinates': arrayCoordenadas 
                }
            }
        });

        mapa.addLayer({
            'id': 'ruta-kml-visual',
            'type': 'line',
            'source': 'ruta-kml',
            'paint': {
                'line-color': '#ff0000', 
                'line-width': 4,        
                'line-opacity': 0.8      
            }
        });
    }
}

const circuito = new Circuito();
circuito.leerArchivoHTML();
const cargadorSVG = new CargadorSVG();
cargadorSVG.leerArchivoSVG();
const cargadorKML = new CargadorKML();
cargadorKML.leerArchivoKML();
