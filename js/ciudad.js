class Ciudad{
    
    #nombre;
    #pais;
    #gentilicio;
    #poblacion;
    #coordenadas;

    constructor(nombre,pais,gentilicio){
        this.#nombre = nombre;
        this.#pais = pais;
        this.#gentilicio = gentilicio;
    }
    setPoblacionYCoordenadas(poblacion,coordenadas){
        this.#poblacion = poblacion;
        this.#coordenadas = coordenadas;
    }

    getCiudad(){
        const ciudad = document.createElement("p");
        ciudad.textContent = "Nombre de la ciudad: " + this.#nombre;
        const main = document.querySelector("main");
        main.appendChild(ciudad);
    }

    getPais(){
        const pais = document.createElement("p");
        pais.textContent = "Pais: " + this.#pais;
        const main = document.querySelector("main");
        main.appendChild(pais);
    }

    getInformacionSecundaria(){
        const lista = document.createElement("ul");
        const gentilicio = document.createElement("li");
        gentilicio.textContent = "Gentilicio: " +  this.#gentilicio;
        const poblacion = document.createElement("li");
        poblacion.textContent = "Población: " + this.#poblacion

        lista.appendChild(gentilicio);
        lista.appendChild(poblacion);
        const main = document.querySelector("main");
        main.appendChild(lista);
    }

    escribirCoordenadas(){
        const coordenadas = document.createElement("p");
        coordenadas.textContent = "Coordenadas de las ciudad: " + this.#coordenadas;
        const main = document.querySelector("main");
        main.appendChild(coordenadas);
    }

    getMeteorologiaCarrera(){
        const url = "https://archive-api.open-meteo.com/v1/era5?latitude=2.760767&longitude=101.738373" +
                            "&timezone=Asia%2FSingapore&start_date=2025-10-26&end_date=2025-10-26&hourly=temperature_2m,relative_humidity_2m" +
                                    ",apparent_temperature,rain,wind_speed_10m,wind_direction_10m&daily=sunrise,sunset#hourly_weather_variables";
        return $.getJSON(url
        ).done(data =>{
            this.#procesarJSONCarrera(data);
        })
    }

    #procesarJSONCarrera(data){
        const articulo = $("<article></article>");
        articulo.append($("<h2></h2>").text("Datos del tiempo el día de la carrera"))

        const datosDiarios = data.daily;
        const datosHorarios = data.hourly;

        const diaCarrera = datosDiarios.time[0];
        articulo.append($("<h3></h3>").text("Fecha: " + diaCarrera));

        const temperatura = datosHorarios.temperature_2m[15];
        const sensacion = datosHorarios.apparent_temperature[15];
        const lluvia = datosHorarios.rain[15];
        const humedad = datosHorarios.relative_humidity_2m[15];
        const velocidadViento = datosHorarios.wind_speed_10m[15];
        const direccionViento = datosHorarios.wind_direction_10m[15];

        const numHoras = datosHorarios.time.length;
        articulo.append($("<p></p>").text("Temperatura: " +  temperatura + " ºC"));
        articulo.append($("<p></p>").text("Sensación térmica: " + sensacion + " ºC"));
        articulo.append($("<p></p>").text("Lluvia: " + lluvia + " mm"));
        articulo.append($("<p></p>").text("Humedad relativa: " + humedad + " %"));
        articulo.append($("<p></p>").text("Velocidad del viento: " + velocidadViento + " km/h"));
        articulo.append($("<p></p>").text("Dirección del viento: " + direccionViento + " º"));

        const salidaSol = new Date(datosDiarios.sunrise[0]).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        const puestaSol = new Date(datosDiarios.sunset[0]).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        articulo.append($("<p></p>").text("Salida del sol: " + salidaSol));
        articulo.append($("<p></p>").text("Puesta del sol: " + puestaSol));
        $("main").append(articulo);

        this.getMeteorologiaEntrenos();
    }

    getMeteorologiaEntrenos(){
        const url = "https://archive-api.open-meteo.com/v1/era5?latitude=2.760767&longitude=101.738373" +
                            "&timezone=Asia%2FSingapore&start_date=2025-10-24&end_date=2025-10-25&hourly=temperature_2m,relative_humidity_2m" +
                                    ",rain,wind_speed_10m&daily=sunrise,sunset";
        return $.getJSON(url
        ).done(data =>{
            this.#procesarJSONEntrenos(data);
        })
    }

    #procesarJSONEntrenos(data){
        const articulo = $("<article></article>");
        articulo.append($("<h2></h2>").text("Datos medios de tiempo en los entrenamientos"))

        const datosDiarios = data.daily;
        const datosHorarios = data.hourly

        let diaEntrenaiento1 = datosDiarios.time[0];
        articulo.append($("<h3></h3>").text("Fecha: " + diaEntrenaiento1));

        let temperaturaMediaDia1 = 0.0;
        let lluviaMediaDia1 = 0.0;
        let humedadMediaDia1 = 0.0;
        let velocidadVientoMediaDia1 = 0.0;
        let numDatosDia1 = 0;
        for(let i = 0; i < 24;i++){
            temperaturaMediaDia1 += datosHorarios.temperature_2m[i];
            lluviaMediaDia1 += datosHorarios.rain[i];
            velocidadVientoMediaDia1 += datosHorarios.wind_speed_10m[i];
            humedadMediaDia1 += datosHorarios.relative_humidity_2m[i];
            numDatosDia1++;
        }
        articulo.append($("<p></p>").text("Temperatura media: " +  (temperaturaMediaDia1/numDatosDia1).toFixed(2) + " ºC"));
        articulo.append($("<p></p>").text("Lluvia media: " + (lluviaMediaDia1/numDatosDia1).toFixed(2) + " mm"));
        articulo.append($("<p></p>").text("Velocidad media del viento: " + (velocidadVientoMediaDia1/numDatosDia1).toFixed(2) + " km/h"));
        articulo.append($("<p></p>").text("Humedad relativa media: " + (humedadMediaDia1/numDatosDia1).toFixed(2) + " %"));

        let diaEntrenaiento2 = datosDiarios.time[1];
        articulo.append($("<h3></h3>").text("Fecha: " + diaEntrenaiento2));

        let temperaturaMediaDia2 = 0.0;
        let lluviaMediaDia2 = 0.0;
        let humedadMediaDia2 = 0.0;
        let velocidadVientoMediaDia2 = 0.0;
        let numDatosDia2 = 0
        for(let i = 24; i < 48;i++){
            temperaturaMediaDia2 += datosHorarios.temperature_2m[i];
            lluviaMediaDia2 += datosHorarios.rain[i];
            velocidadVientoMediaDia2 += datosHorarios.wind_speed_10m[i];
            humedadMediaDia2 += datosHorarios.relative_humidity_2m[i];
            numDatosDia2++;
        }
        articulo.append($("<p></p>").text("Temperatura media: " +  (temperaturaMediaDia2/numDatosDia2).toFixed(2) + " ºC"));
        articulo.append($("<p></p>").text("Lluvia media: " + (lluviaMediaDia2/numDatosDia2).toFixed(2) + " mm"));
        articulo.append($("<p></p>").text("Velocidad media del viento: " + (velocidadVientoMediaDia2/numDatosDia2).toFixed(2) + " km/h"));
        articulo.append($("<p></p>").text("Humedad relativa media: " + (humedadMediaDia2/numDatosDia2).toFixed(2) + " %"));
        $("main").append(articulo);
    }
}

    
$(document).ready(function(){
    let ciudad = new Ciudad("Kuala lumpur","Malasia","kualalumpurense")
    ciudad.setPoblacionYCoordenadas("2.075.600","3.142866615530959 , 101.68873262503574")
    ciudad.getCiudad()
    ciudad.getPais()
    ciudad.getInformacionSecundaria()
    ciudad.escribirCoordenadas()
    ciudad.getMeteorologiaCarrera()
})




