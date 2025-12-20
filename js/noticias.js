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
        const titulo = $("<h2></h2>").text("Noticias");
        main.append(titulo);
        datos.data.forEach(noticia =>{
            const articulo = $("<article></article>");
            articulo.append($("<h3></h3>").text(noticia.title));
            articulo.append($("<h4></h4>").text(noticia.description));
            articulo.append($("<p></p>").text("Fuente de la noticia: " + noticia.source));
            articulo.append($("<a></a>").attr("href",noticia.url).text("Leer más..."));
            main.append(articulo);
        }); 
    }
}

