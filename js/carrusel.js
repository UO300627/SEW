class Carrusel{

    #busqueda;
    #actual;
    #maximo;
    #fotografias;
    #intervaloActivado;

    constructor(){
        this.#busqueda = "MotoGP";
        this.#actual = 0;
        this.#maximo = 4;
        this.#intervaloActivado = false;
    }

    getFotografias(){
        const url = "https://www.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
        return $.getJSON(url,
            {
                tags: this.#busqueda,
                tagmode:"any",
                format: "json"
            }
        ).done(data =>{
            this.#procesarJSONFotografias(data.items);
        })
    }

    #procesarJSONFotografias(items){
        const listaFotografias = [];
        $.each(items, (i, item) => {
            const urlTamaño640 = item.media.m.replace("_m.jpg", "_z.jpg");
            listaFotografias.push(urlTamaño640);
            if(i == this.#maximo){
                return false;
            }
        });
        this.#fotografias = listaFotografias; 
        this.#mostrarFotografias();
    }

    #mostrarFotografias(){ 
        let $main = $("main");
        if($main.length == 0){
            $main = $("<main></main>");
            $("body").append($main);
        }
        const $articulo = $main.find("article");
        if($articulo.length == 0){
            const $articuloNuevo = $("<article></article>");
            const $encabezado = $("<h2></h2>").text("Imágenes del circuito de Petronas Sepang International Circuit");
            const $imagen = $("<img />").attr("src",this.#fotografias[this.#actual]);
            $imagen.attr("alt","Carrusel con imagenes sobre MotoGP");
            $articuloNuevo.append($encabezado);
            $articuloNuevo.append($imagen);
            $("main").prepend($articuloNuevo);
        }else{
            let $img = $articulo.find("img");
            $img.attr("src",this.#fotografias[this.#actual]);
        }
        
        if(!this.#intervaloActivado){
            this.#intervaloActivado = true;
            setInterval(this.#cambiarFotografia.bind(this),3000);

            let noticia = new Noticias();
            noticia.buscar();
        }
    }

    #cambiarFotografia(){
        if(this.#actual == this.#maximo){
            this.#actual = 0;
        }else{
            this.#actual += 1;
        }
        this.#mostrarFotografias();
    }
}

let carrusel = new Carrusel();
carrusel.getFotografias();
