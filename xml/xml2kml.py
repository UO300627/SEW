import xml.etree.ElementTree as ET


class Kml(object):

    def __init__(self):
        self.raiz =  ET.Element('kml', xmlns="http://www.opengis.net/kml/2.2")
        self.doc = ET.SubElement(self.raiz,'Document')

    def obtenerTramos(self,nameSpace,raiz):
        tramos = []
        longitudOrigen = raiz.find(".//xs:puntoOrigen/xs:coordenada/xs:longitudPunto",nameSpace).text
        latitudOrigen = raiz.find(".//xs:puntoOrigen/xs:coordenada/xs:latitudPunto",nameSpace).text
        self.addPlacemark(longitudOrigen,latitudOrigen,'relativeToGround')
        tramos.append(f"{longitudOrigen},{latitudOrigen}")

        for tramo in raiz.findall(".//xs:tramo/xs:coordenada",nameSpace):
            longitud = tramo.find("xs:longitudPunto",nameSpace).text
            latitud = tramo.find("xs:latitudPunto",nameSpace).text
            self.addPlacemark(longitud,latitud,'relativeToGround')
            tramos.append(f"{longitud},{latitud}")
        return "\n".join(tramos)

    def addPlacemark(self,long,lat, modoAltitud):
        pm = ET.SubElement(self.doc,'Placemark')
        punto = ET.SubElement(pm,'Point')
        ET.SubElement(punto,'coordinates').text = '{},{}'.format(long,lat)
        ET.SubElement(punto,'altitudeMode').text = modoAltitud

    def addLineString(self,nombre,extrude,tesela, listaCoordenadas,
                modoAltitud, color, ancho):
        ET.SubElement(self.doc,'name').text = nombre
        pm = ET.SubElement(self.doc,'Placemark')
        ls = ET.SubElement(pm, 'LineString')
        ET.SubElement(ls,'extrude').text = extrude
        ET.SubElement(ls,'tessellation').text = tesela
        ET.SubElement(ls,'coordinates').text = listaCoordenadas
        ET.SubElement(ls,'altitudeMode').text = modoAltitud
        estilo = ET.SubElement(pm, 'Style')
        linea = ET.SubElement(estilo, 'LineStyle')
        ET.SubElement (linea, 'color').text = color
        ET.SubElement (linea, 'width').text = ancho

    def escribir(self,nombreArchivoKML):
        arbol = ET.ElementTree(self.raiz)
        ET.indent(arbol)
        arbol.write(nombreArchivoKML, encoding='utf-8', xml_declaration=True)


def main():

    nombreKML = "circuito.kml"

    nuevoKML = Kml()

    nameSpace = {'xs': 'http://www.uniovi.es'}
    arbol = ET.parse("circuitoEsquema.xml")
    raiz = arbol.getroot()

    tramos = nuevoKML.obtenerTramos(nameSpace,raiz)

    nuevoKML.addLineString("Recorrido circuito","1","1",tramos,
            'relativeToGround','#ff0000ff',"5")
    nuevoKML.escribir(nombreKML)

if __name__ == '__main__':
    main()
