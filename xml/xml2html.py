import xml.etree.ElementTree as ET

class Html(object):

    def __init__(self):
        self.raiz = ET.Element('html', attrib={'lang': 'es'})
        self.head = ET.SubElement(self.raiz, 'head')
        self.body = ET.SubElement(self.raiz, 'body')

        self.contenedor_actual = self.body
        ET.SubElement(self.head, 'meta', charset='UTF-8')
        ET.SubElement(self.head, 'title').text = "Circuito de MotoGP"
        ET.SubElement(self.head, 'link',rel="stylesheet", href="../estilo/estilo.css")

    def crearSeccion(self):
        nueva_seccion = ET.SubElement(self.body, 'section')
        self.contenedor_actual = nueva_seccion

    def añadirEtiquetaP(self,texto):
        ET.SubElement(self.contenedor_actual, 'p').text = texto

    def añadirEtiquetaH2(self,texto):
        ET.SubElement(self.contenedor_actual, 'h2').text = texto

    def añadirEtiquetaImg(self,src,alt):
        ET.SubElement(self.contenedor_actual,'img', attrib={'src':src, 'alt':alt})

    def añadirEtiquetaVideo(self,src,alt, modo = None):
        atributos = {'src': src,'alt': alt}
        if modo:
            atributos[modo] = modo
        ET.SubElement(self.contenedor_actual,'video',attrib=atributos)

    def añadirEtiquetaOl(self,elementosLista):
        lista_ol = ET.SubElement(self.contenedor_actual,'ol')
        for elemento in elementosLista:
            ET.SubElement(lista_ol,'li').text = elemento

    def añadirEtiquetaUlConEnlaces(self,enlaces):
        lista_ul = ET.SubElement(self.contenedor_actual,'ul')
        for enlace in enlaces:
            elemento_li = ET.SubElement(lista_ul,'li')
            ET.SubElement(elemento_li,'a',href = enlace[0]).text = enlace[1]
    
    def formatearTiempo(self, tiempoEmpleado):
        tiempo = tiempoEmpleado.replace("PT", "")  

        partes_horas = tiempo.split('H')
        horas = int(partes_horas[0])           
        partes_minutos = partes_horas[1].split('M')
        minutos = int(partes_minutos[0])          
        segundos = partes_minutos[1].replace('S', '')

        resultado = f"{horas}:{minutos}:{segundos}"

        return resultado.strip()

    def escribir(self,nombreArchivoHtml):
        arbol = ET.ElementTree(self.raiz)

        ET.indent(arbol)

        arbol.write(nombreArchivoHtml,
                    encoding='utf-8',
                    xml_declaration=False,method="html"
                    )

def main():
    nombreHtml = "InfoCircuito.html"

    nuevoHtml = Html()

    nameSpace = '{http://www.uniovi.es}'
    arbol = ET.parse("circuitoEsquema.xml")
    raiz = arbol.getroot()
    nuevoHtml.crearSeccion()
    nuevoHtml.añadirEtiquetaH2("Información general acerca del circuito:")
    nuevoHtml.añadirEtiquetaP("Nombre: " + raiz.find(f'.//{nameSpace}nombre').text)
    nuevoHtml.añadirEtiquetaP("Logitud: " + raiz.find(f'.//{nameSpace}longitud').text)
    nuevoHtml.añadirEtiquetaP("Anchura media: " + raiz.find(f'.//{nameSpace}anchuraMedia').text)
    nuevoHtml.añadirEtiquetaP("Fecha del Gran Premio en 2025: " + raiz.find(f'.//{nameSpace}fecha').text)
    nuevoHtml.añadirEtiquetaP("Hora de comienzo del Gran Premio: " + raiz.find(f'.//{nameSpace}hora').text)
    nuevoHtml.añadirEtiquetaP("Numero de vueltas: " + raiz.find(f'.//{nameSpace}numeroVueltas').text)
    nuevoHtml.añadirEtiquetaP("Localidad más próxima al circuito: " + raiz.find(
                                f'.//{nameSpace}localidadMasProxima').text)
    nuevoHtml.añadirEtiquetaP("País: " + raiz.find(f'.//{nameSpace}pais').text)
    nuevoHtml.añadirEtiquetaP("Patrocinador del Gran Premio: " + raiz.find(
                                f'.//{nameSpace}nombrePatrocinador').text)

    nuevoHtml.crearSeccion()
    nuevoHtml.añadirEtiquetaH2("Enlaces de interés:")
    enlaces_xml = raiz.findall(f'.//{nameSpace}referencias/{nameSpace}referencia[@texto]')
    enlaces = []
    for enlece in enlaces_xml:
        enlaces.append((enlece.text, enlece.get("texto")))
    nuevoHtml.añadirEtiquetaUlConEnlaces(enlaces)

    nuevoHtml.crearSeccion()
    nuevoHtml.añadirEtiquetaH2("Imágenes sobre el circuito:")
    imagenes = raiz.findall(f'.//{nameSpace}fotos/{nameSpace}foto[@descripcion]')
    for imagen in imagenes:
        alt = imagen.get("descripcion")
        nuevoHtml.añadirEtiquetaImg(imagen.text,alt)
    
    nuevoHtml.crearSeccion()
    nuevoHtml.añadirEtiquetaH2("Videos sobre el circuito:")
    videos = raiz.findall(f'.//{nameSpace}videos/{nameSpace}video[@descripcion]')
    for video in videos:
        alt = video.get("descripcion")
        nuevoHtml.añadirEtiquetaVideo(video.text,alt,'controls')  

    nuevoHtml.crearSeccion()
    nuevoHtml.añadirEtiquetaH2("Información sobre la clasificación:")
    vencedor = raiz.find(f'.//{nameSpace}vencedor[@tiempoEmpleado]')
    nuevoHtml.añadirEtiquetaP("Vencedor: " + vencedor.text + " - tiempo empleado: " + 
                              nuevoHtml.formatearTiempo(vencedor.get("tiempoEmpleado")))
    nuevoHtml.añadirEtiquetaP("Clasificación general después de la carrera:")
    clasificacionGeneral = []
    clasificacionGeneral.append(raiz.find(f'.//{nameSpace}clasificacionGeneral/{nameSpace}primero').text)
    clasificacionGeneral.append(raiz.find(f'.//{nameSpace}clasificacionGeneral/{nameSpace}segundo').text)
    clasificacionGeneral.append(raiz.find(f'.//{nameSpace}clasificacionGeneral/{nameSpace}tercero').text)
    nuevoHtml.añadirEtiquetaOl(clasificacionGeneral)

    nuevoHtml.escribir(nombreHtml)


if __name__ == '__main__':
    main()