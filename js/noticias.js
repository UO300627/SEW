class Noticias{

    #busqueda
    #url
    constructor(){
        this.#busqueda = "MotoGP";
        this.#url = "https://api.thenewsapi.com/v1/news/top?"
    }

    async buscar(){
        const url = `${this.#url}search=${encodeURIComponent(this.#busqueda)}&api_token=J7VTKMRnUysO4Td9yF7U2COesexyXc8XwDdWnV5g&language=es&limit=3`;

        try{
            const respuesta = await fetch(url);
            if(!respuesta.ok) throw new Error('No se han encontrado noticias sobre MotoGP');
            const datos = await respuesta.json();
            this.#procesarInformacion(datos);
        }catch (error){
            throw error;
        }
    }

    #procesarInformacion(datos){
        const main = $("main");
        const articulo = $("<article></article>");

        datos.data.forEach(noticia =>{
            articulo.append($("<h2></h2>").text(noticia.title));
            articulo.append($("<h3></h3>").text(noticia.snippet));
            articulo.append($("<p></p>").text("Fuente de la noticia: " + noticia.source));
            articulo.append($("<a></a>").attr("href",noticia.url).text("Leer más..."));
        });
        main.append(articulo);
    }
}

$(document).ready(function(){
    let noticia = new Noticias()
    noticia.buscar()
})
