class Ciudad{
    constructor(nombre,pais,gentilicio){
        this.nombre = nombre;
        this.pais = pais;
        this.gentilicio = gentilicio;
    }
    setPoblacionYCoordenadas(poblacion,coordenadas){
        this.poblacion = poblacion;
        this.coordenadas = coordenadas;
    }

    getCiudad(){
        return "Nombre de la ciudad: " + this.nombre;
    }

    getPais(){
        return "Pais: " + this.pais;
    }

    getInformacionSecundaria(){
        return "<ul> \n" +
                    "\t<li>Gentilicio: " +  this.gentilicio + "</li>" +
                    "\t<li>Población: " + this.poblacion + "</li>\n" + 
                "</ul>"
    }

    escribirCoordenadas(){
        document.write("<p>Coordenadas de las ciudad: " + this.coordenadas + "</p>");
    }
}




