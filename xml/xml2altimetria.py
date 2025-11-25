import xml.etree.ElementTree as ET

class Svg(object):

    def __init__(self):
        self.raiz = ET.Element('svg', xmlns="http://www.w3.org/2000/svg",
                                         version="2.0",
                                         width=str(1000),
                                         height=str(300),
                                         viewBox=f"0 0 1000 300")

    def obtenerDatosPuntos(self, nameSpace, raiz,tramos):
        puntos = []
        altitud_origen = 0.0
        punto_origen = raiz.find(f'.//{nameSpace}puntoOrigen/{nameSpace}coordenada/{nameSpace}altitudPunto')
        altitud_origen = float(punto_origen.text)
            
        puntos.append({'distancia': 0.0,'altitud': altitud_origen,'sector': 1})

        distancia_acumulada = 0.0

        for tramo in tramos:
            distanciaAPunto = tramo.find(f'{nameSpace}distancia').text
            distancia_acumulada += float(distanciaAPunto)
            
            altitud = tramo.find(f'{nameSpace}coordenada/{nameSpace}altitudPunto').text
            altitudPunto = float(altitud)
            
            sector = tramo.find(f'{nameSpace}sector').text
            sectorPunto = int(sector)
            
            puntos.append({'distancia': distancia_acumulada,'altitud': altitudPunto,'sector': sectorPunto})
            
        return puntos

    def addLine(self,x1,y1,x2,y2,stroke,strokeWith):
        ET.SubElement(self.raiz,'line',
                      x1=x1,
                      y1=y1,
                      x2=x2,
                      y2=y2,
                      stroke=stroke,
                      **{"stroke-width": str(strokeWith)})

    def addPolyline(self,points,stroke,strokeWith,fill):
        ET.SubElement(self.raiz,'polyline',
                      points=points,
                      stroke=stroke,
                      **{"stroke-width": str(strokeWith)},
                      fill=fill)

    def addText(self,texto,x,y,fontFamily,fontSize,style):
        ET.SubElement(self.raiz,'text',
                      x=x,
                      y=y,
                      **{
                          "font-family": fontFamily,
                          "font-size": str(fontSize)
                      },
                      style=style).text=texto

    def escribir(self,nombreArchivoSVG):

        arbol = ET.ElementTree(self.raiz)

        ET.indent(arbol)

        arbol.write(nombreArchivoSVG,
                    encoding='utf-8',
                    xml_declaration=True
                    )


def main():
    nombreSVG = "altimetria.svg"
    nombreXML = "circuitoEsquema.xml"
    nameSpace = '{http://www.uniovi.es}'

    arbol = ET.parse(nombreXML)
    raiz = arbol.getroot()


    nuevoSVG = Svg()

    ancho = 1000
    alto = 300
    margen_superior = 50
    margen_inferior = 60
    margen_izquierdo = 50
    margen_derecho = 50

    area_ancho = ancho - margen_izquierdo - margen_derecho
    area_alto = alto - margen_superior - margen_inferior

    tramos = raiz.findall(f'.//{nameSpace}tramo')
    datosPuntos = nuevoSVG.obtenerDatosPuntos(nameSpace,raiz,tramos)

    lista_altitudes = [p['altitud'] for p in datosPuntos]
    distancia_total = datosPuntos[-1]['distancia']
    num_puntos = len(datosPuntos)

    altitud_minima = min(lista_altitudes)
    altitud_maxima = max(lista_altitudes)
    rango_de_altitud = altitud_maxima - altitud_minima

    puntos_escalados = []
    
    for punto in datosPuntos:
        altitud = punto['altitud']
        distancia = punto['distancia']
        sector = punto['sector']

        escala_x = distancia / distancia_total
        coordenada_x = escala_x * area_ancho + margen_izquierdo

        if rango_de_altitud > 0:
            escala_y = (altitud - altitud_minima) / rango_de_altitud
        else:
            escala_y = 0.5

        coordenada_y = area_alto * (1 - escala_y) + margen_superior

        puntos_escalados.append({
            'x': coordenada_x,
            'y': coordenada_y,
            'altitud': altitud,
            'sector': sector
        })

    altitud_minima_y = alto - margen_inferior
    altitud_maxima_y = margen_superior

    nuevoSVG.addLine(str(margen_izquierdo), str(altitud_minima_y), str(ancho - margen_derecho), str(altitud_minima_y), 'black', '1')
    nuevoSVG.addLine(str(margen_izquierdo), str(altitud_maxima_y), str(margen_izquierdo), str(altitud_minima_y), 'black', '1')
    
    nuevoSVG.addText(f'{altitud_minima}m', str(margen_izquierdo - 5), str(altitud_minima_y + 3), 'Arial', '10', 'text-anchor: end; fill: black;')
    nuevoSVG.addText(f'{altitud_maxima}m', str(margen_izquierdo - 5), str(altitud_maxima_y + 3), 'Arial', '10', 'text-anchor: end; fill: black;')

    puntos_svg = " ".join([f"{p['x']},{p['y']}" for p in puntos_escalados])
    nuevoSVG.addPolyline(puntos_svg, 'red', '4', 'none')

    punto_inicio = puntos_escalados[0]
    nuevoSVG.addText('Inicio', str(punto_inicio['x']), str(altitud_minima_y + 20), 'Arial', '12', 'writing-mode: tb; glyph-orientation-vertical: 0;')
    
    punto_final = puntos_escalados[-1]
    nuevoSVG.addText('Final', str(punto_final['x']), str(altitud_minima_y + 20), 'Arial', '12', 'writing-mode: tb; glyph-orientation-vertical: 0;')

    for i in range(1, num_puntos):
        sector_punto_actual = puntos_escalados[i]['sector']
        sector_punto_previo = puntos_escalados[i-1]['sector']

        if sector_punto_actual != sector_punto_previo:
            punto = puntos_escalados[i]
            posicion_x = punto['x']
            
            nuevoSVG.addText(f"S{sector_punto_actual}", str(posicion_x), str(altitud_minima_y + 20), 'Arial', '12', 'writing-mode: tb; glyph-orientation-vertical: 0;')

    nuevoSVG.escribir(nombreSVG)

if __name__ == '__main__':
    main()