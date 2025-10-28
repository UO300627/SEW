import xml.etree.ElementTree as ET

class Html(object):

    def __init__(self):
        self.raiz = ET.Element('html', attrib={'lang': 'es'})
        self.head = ET.SubElement(self.raiz, 'head')
        self.body = ET.SubElement(self.raiz, 'body')

        ET.SubElement(self.head, 'meta', charset='UTF-8')
        ET.SubElement(self.head, 'title').text = "Circuito de MotoGP"
        ET.SubElement(self.head, 'link',rel="stylesheet", href="../estilo/estilo.css")

    def añadirEtiquetaP(self,texto):
        ET.SubElement(self.body, 'p').text = texto

    def añadirEtiquetaH2(self,texto):
        ET.SubElement(self.body, 'h2').text = texto

    def añadirEtiquetaH3(self,texto):
        ET.SubElement(self.body, 'h3').text = texto

    def añadirEtiquetaImg(self,src,alt):
        ET.SubElement(self.body,'img', attrib={'src':src,'alt':alt})

    def añadirEtiquetaVideo(self,src, modo = None):
        atributos = {'src': src}
        if modo:
            atributos[modo] = modo
        ET.SubElement(self.body,'video',attrib=atributos)

    def añadirEtiquetaOl(self,elementosLista):
        lista_ol = ET.SubElement(self.body,'ol')
        for elemento in elementosLista:
            ET.SubElement(lista_ol,'li').text = elemento

    def añadirEtiquetaUlConEnlaces(self,elementosLista):
        lista_ul = ET.SubElement(self.body,'ul')
        for elemento in elementosLista:
            elemento_li = ET.SubElement(lista_ul,'li')
            ET.SubElement(elemento_li,'a',href = elemento[0]).text = elemento[1]

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

    nameSpace = {'xs': 'http://www.uniovi.es'}
    arbol = ET.parse("circuitoEsquema.xml")
    raiz = arbol.getroot()

    nuevoHtml.añadirEtiquetaH2("Gran Premio de Malasia")
    nuevoHtml.añadirEtiquetaH3("Información general acerca del circuito:")
    nuevoHtml.añadirEtiquetaP("Nombre: " + raiz.find(".//xs:nombre",
                                 nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Logitud: " + raiz.find(".//xs:longitud",
                                 nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Anchura media: " + raiz.find(".//xs:anchuraMedia",
                                    nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Fecha del Gran Premio en 2025: " + raiz.find(".//xs:fecha",
                                    nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Hora de comienzo del Gran Premio: " + raiz.find(".//xs:hora",
                                     nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Numero de vueltas: " + raiz.find(".//xs:numeroVueltas",
                                        nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Localidad más próxima al circuito: " + raiz.find(
                                ".//xs:localidadMasProxima", nameSpace).text)
    nuevoHtml.añadirEtiquetaP("País: " + raiz.find(".//xs:pais", nameSpace).text)
    nuevoHtml.añadirEtiquetaP("Patrocinador del Gran Premio: " + raiz.find(
                                ".//xs:nombrePatrocinador", nameSpace).text)

    nuevoHtml.añadirEtiquetaH3("Enlaces, fotos y videos relacionados con el Gran Premio: ")
    enlaces = []
    enlaces.append((raiz.find(".//xs:referencias/xs:referencia[1]",nameSpace).text,
                            "Página oficial del Gran Premio de Malasia"))
    enlaces.append((raiz.find(".//xs:referencias/xs:referencia[2]",nameSpace).text,
                            "Página oficial de MotoGp"))
    enlaces.append((raiz.find(".//xs:referencias/xs:referencia[3]",nameSpace).text,
                            "Página con información acerca del Gran Premio"))
    nuevoHtml.añadirEtiquetaUlConEnlaces(enlaces)
    nuevoHtml.añadirEtiquetaImg(raiz.find(".//xs:fotos/xs:foto[1]", nameSpace).text,
                                    "Trazado del circuito")
    nuevoHtml.añadirEtiquetaImg(raiz.find(".//xs:fotos/xs:foto[2]", nameSpace).text,
                                    "Panorámica del circuito")
    nuevoHtml.añadirEtiquetaImg(raiz.find(".//xs:fotos/xs:foto[3]", nameSpace).text,
                                    "Recta de salida del circuito")

    nuevoHtml.añadirEtiquetaVideo(raiz.find(".//xs:videos/xs:video[1]", nameSpace).text,
                                'controls')
    nuevoHtml.añadirEtiquetaP("Vencedor: " + raiz.find(".//xs:vencedor",
                                nameSpace).text)
    nuevoHtml.añadirEtiquetaH3("Clasificación general tras el Gran Premio:")
    clasificacionGeneral = []
    clasificacionGeneral.append(raiz.find(".//xs:clasificacionGeneral/xs:primero",
                                nameSpace).text)
    clasificacionGeneral.append(raiz.find(".//xs:clasificacionGeneral/xs:segundo",
                                nameSpace).text)
    clasificacionGeneral.append(raiz.find(".//xs:clasificacionGeneral/xs:tercero",
                                nameSpace).text)
    nuevoHtml.añadirEtiquetaOl(clasificacionGeneral)

    nuevoHtml.escribir(nombreHtml)


if __name__ == '__main__':
    main()