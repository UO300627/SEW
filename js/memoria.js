class Memoria{
    constructor(){
        this.tablero_bloqueado = true;
        this.primera_carta = null;
        this.segunda_carta = null;
        this.barajarCartas();
        this.tablero_bloqueado = false;
        this.cronometro = new Cronometro();
        this.cronometro.arrancar();
    }

    voltearCarta(carta){
        if(carta.dataset.estado != "revelada" && carta.dataset.estado != "volteada" && !this.tablero_bloqueado){
            carta.dataset.estado = "volteada";
            if(this.primera_carta == null){
                this.primera_carta = carta;
                return;
            }else{
                this.segunda_carta = carta;
                this.comprobarPareja();
            }
        }
    }

    barajarCartas(){
        const main = document.querySelector("main")
        const cartas = Array.from(document.querySelectorAll("main article")); // aqui preguntar si se puede usar esto o hay que usar lo de children

        for (let i = cartas.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            
            const aux = cartas[i];
            cartas[i] = cartas[j];
            cartas[j] = aux;
        }

        for (let i = 0; i < cartas.length; i++) {
            main.appendChild(cartas[i]);
        }
    }

    reiniciarAtributos(){
        this.tablero_bloqueado = false;
        this.primera_carta = null;
        this.segunda_carta = null;
    }

    deshabilitarCartas(){
        this.primera_carta.dataset.estado = "revelada";
        this.segunda_carta.dataset.estado = "revelada";
        this.comprobarJuego();
        this.reiniciarAtributos();
    }

    comprobarJuego(){
        const cartas = document.querySelectorAll("main article");
        for(let carta of cartas){
            if(carta.dataset.estado != "revelada"){
                return;
            }
        }
        this.cronometro.parar();
    }

    cubrirCartas(){
        this.tablero_bloqueado = true;
        setTimeout(() => {
            this.primera_carta.dataset.estado = "";
            this.segunda_carta.dataset.estado = "";
            this.reiniciarAtributos();
        },1500);
    }

    comprobarPareja(){
        const altPrimeraCarta = this.primera_carta.querySelector("img").getAttribute("alt"); // mirar si aqui hay que usar children
        const altSegundaCarta = this.segunda_carta.querySelector("img").getAttribute("alt");
        (altPrimeraCarta == altSegundaCarta) ? this.deshabilitarCartas() : this.cubrirCartas();  
    }
}