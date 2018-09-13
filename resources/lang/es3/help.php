<?php

return [

    "locations.title1"=>"1. Información del Colegio",
    "locations.text1"=>"Aquí guardaremos toda la información relativa al colegio.
    Como por ejemplo su descripción , el responsable o la dirección donde se encuentra localizado.
    ",

    "locations.title2"=>"2. Modificación de los datos",
    "locations.text2"=>"Esta información no puede ser modificada directamente pues forma parte del acuerdo suscrito con Allowapp. Si desea modificar alguno de estos datos
    debe escribir un correo a clientes@allowapp.com.",

    "locations.title3"=>"3. Importación de datos <span><i class='glyphicon glyphicon-save'></i></span>",
    "locations.text3"=>"Pulsando en este icono <span><i class='glyphicon glyphicon-save'></i></span> puede realizar
    una importación de todos los datos relativos a su colegio, como son clases, alumnos y los responsables de cada alumno.
    Para más información, pulse el botón <span><i class='glyphicon glyphicon-save'></i></span> y el botón de ayuda para recibir indicaciones
    detalladas de cómo importar datos.",

    "locations.question1"=>"¿Puedo realizar importaciones en cualquier momento?",
    "locations.answer1" => "Se pueden importar datos en cualquier momento pues si existe ese dato en el sistema no se
    a ver afectados. Sólo se insertarían los nuevos datos. ",

    "excel.title1"=>"Proceso de importación:",
    "excel.text1"=>"El proceso de importación es delicado y se deben seguir los pasos cuidadosamente. Es importante destacar que
se realiza en varias etapas pues primero se cargan los datos en una tablas intermedias que se muestran en pantalla pero que aún no se han volcado
en el sistema. De esta forma podemos comprobar y validar los datos antes de que sean volcados en la base de datos real.
    A continuación vamos a enumerar los 4 pasos que deben seguirse para realizar con éxito una importación:<br>
    ",

    "excel.title2"=>"1. Seleccionar el fichero a importar (xlsx)",
    "excel.text2"=>"Se AÑADE un FICHERO de IMPORTACIÓN: este fichero está en formato excel y debe seguir un formato determinado. Puede
        descargar un fichero de ejemplo <a href='".asset('otros/ejemplo.xlsx')."'>aquí</a>. El fichero trae instrucciones precisas para rellenar
        todos los campos.<br> Tras importarlo verás que se rellenan las 3 tablas : Lugares de Publicación, Personas y Responsables.Compruebe
        los valores de las 3 Tablas. Si toda la información es correcta estarán todas las filas en verde. Si hay algún error
        en cualquiera de las tablas aparecerá en esa celda en rojo y si nos ponemos sobre el error nos dirá cúal es el problema.",
    "excel.title3"=>"2. Importar primera tabla (Lugares de Publicación)",
    "excel.text3"=>"Pulse el botón Importar tabla de la primera tabla (Lugares de Publicación), y espere el resultado . Si todo es correcto aparecerá un ok en la
        columna estado de cada una de las filas de la primera tabla.<br>",

    "excel.title4"=>"3. Importar segunda tabla (Personas)",
    "excel.text4"=>"Se realiza en dos pasos: primero se importan las fotografías de las personas y después la tabla.
        Para importar las fotos pulse el botón Asignar fotos
        <label  style='color:white;background-color: rgb(0, 192, 239); border: 1px solid rgb(0, 172, 214); padding-right: 4px; padding-left: 4px;'><i class='fa fa-photo'></i> Asignar fotos</label>.
        A continuación seleccione todos los ficheros de las caras de las personas. En caso de tener muchas imágenes podemos hacerlo varias veces.<br>
        Una vez importadas aparecerán las caras en las columnas de las personas. A continuación pulse el boton Importar tabla y espere
        hasta que se carguen todas las personas. Este proceso puede durar de uno a varios minutos, dependiendo del volumen de personas
        a importar. ",

    "excel.title5"=>"4. Importar tercera tabla (Responsables)",
    "excel.text5"=>"Pulse el botón de Importar Tabla. Espere el resultado y con esto hemos finalizado
        el proceso de importación <br><br>
        Hemos intentado simplificar lo máximo posible el proceso pero como ve es complejo y para que sea satisfactorio se deben seguir estas instrucciones cuidadosamente.
    ",

    "excel.question1"=>"¿Puedo realizar importaciones en cualquier momento?",
    "excel.answer1" => "Se pueden importar datos en cualquier momento pues si existe ese dato en el sistema no se
    a ver afectados. Sólo se insertarían los nuevos datos. ",
];