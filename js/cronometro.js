class Cronometro{
    constructor(){
        this.tiempo = 0;
    }

    arrancar(){     
        if(this.tiempo == 0){
            try{
                this.inicio = Temporal.Now.Instant();
            }catch(err){
                this.inicio = Date.now();
            } 
        }
        this.corriendo = setInterval(this.actualizar.bind(this), 100);
    }

    actualizar(){
        try{
            this.tiempo = Temporal.Now.Instant().epochMilliseconds - this.inicio.epochMilliseconds;  
        }catch(err){
            this.tiempo = Date.now() - this.inicio;
        } 
        this.mostrar();
    }

    mostrar(){
        var tiempoActual;
        try{
            const minutos = parseInt(this.tiempo /60000);
            const segundos = parseInt((this.tiempo % 60000) /1000);
            const decimas = parseInt((this.tiempo % 1000)/100);

            var minutosConvertidos = minutos.toString().padStart(2,"0");
            var segundosConvertidos = segundos.toString().padStart(2,"0");
            var decimasConvertidas = decimas.toString().padStart(1,"0");

            tiempoActual = minutosConvertidos + ":" + segundosConvertidos + ":" + decimasConvertidas;

        }catch(err){
            var minutos = parseInt(this.tiempo.getMinutes()).toString().padStart(2,"0");
            var segundos = parseInt(this.tiempo.getSeconds()).toString().padStart(2,"0");
            var decimas = parseInt(this.tiempo.getMilliseconds()).toString().padStart(1,"0");

            tiempoActual = minutos + ":" + segundos + ":" + decimas;
        }
        document.querySelector("main p").textContent = tiempoActual;
    }

    parar(){
        clearInterval(this.corriendo);
    }

    reiniciar(){
        this.parar();
        this.tiempo = 0;
        this.mostrar();
    }
}