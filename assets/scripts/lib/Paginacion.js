/**
 * Librería de paginación hecha por Alejandro D.
 * Uso libre
 * Última actualización: 02/03/2020
*/
class Paginacion {
    constructor(contenido, idElementoPadre, elementosPorPagina = 5) {
        this.contenido = contenido; //TODO: convertirlo en un array de objetos literales, con X elementos por pagina
        
        //cada objeto tendrá el siguiente formato
        /**
         {
            titulo : "titulo",
            descripCorta : "descripcion",
            descripLarta :"Descipcion mas larga", // si esta variable es distinta a null, el elemento será desplegable
            enlace : "https://google.es" // enlace que se abrirá en una pestaña nueva al hacer clic en un botón de más información
         }
        */
       
        //idElementoPadre tiene que ser un elemento div que tenga una id. será el padre de todo el conjunto de lista + botonera
        this.idElementoPadre = idElementoPadre;
    }

    //Métodos de desplazamiento
    paginaSiguiente() { }
    paginaAnterior() { }
    primeraPagina() { }
    ultimaPagina() { }
    cambiarAPagina() { }

    //Métodos de mostrar contenido
    renderizarPagina() { } //muestra el contenido de la página actual
    renderizarBotonera() { } //muestra la botonera con la opción seleccionada correspondiente

}