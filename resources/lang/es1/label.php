<?php

return [

    "create_new" => "Añadir",
    'name' => 'nombre',
    'excel' => 'fichero de importación',

    'locations.fa_icon' => 'fa fa-home',
    'users.fa_icon' => 'fa fa-key',
    'groups.fa_icon' => 'fa fa-address-book',
    'rightholders.fa_icon' => 'fa fa-id-card-o',
    'photos.fa_icon' => 'fa fa-image',
    'persons.fa_icon' => 'fa fa-users',
    'historic.fa_icon' => 'fa fa-history',
    'historic.persons.fa_icon' => 'fa fa-users',
    'historic.rightholders.fa_icon' => 'fa fa-id-card-o',
    'historic.photos.fa_icon' => 'fa fa-camera-retro',
    'consents.fa_icon' => 'fa fa-legal',
    'finalidad_text'=>"La publicación de la imagen en las siguientes plataformas web",

    //PROFILES
    'profiles.super'=> 'Super usuario',
    'profiles.admin'=> 'Administrador/Director',
    'profiles.owner'=> 'Responsable de grupo',
    'profiles.user'=>'Usuario',

    // LOCATIONS
    'locations' => "Colegio",
    'title.locations' => "Lista de Colegios",
    'locations.icon'=> "Escudo del colegio",
    "locations.name" => "Nombre del colegio",
    'locations.description' => 'Descripción',
    'locations.logo' => 'Logo',
    'locations.show' => 'Mostrar',
    'locations.excel' => 'Importaciones',
    'locations.delete' => 'Borrar',
    'locations.accountable' => 'Responsable',
    'locations.CIF' => 'CIF',
    'locations.email' => 'Email',
    'locations.address' => 'Dirección',
    'locations.city' => 'Ciudad',
    'locations.CP' => 'Código Postal',

    //CONSENTS
    'consents' => 'Ambito legal',
    'title.consents' => "Lista de ámbitos legales",
    'consents.description' => 'Titulo',
    'consents.legitimacion' => 'Legitimación',
    'consents.destinatarios' => 'Destinatarios',
    'consents.derechos' => 'Derechos',

    // USERS
    'users' => 'usuario',
    'title.users' => "Lista de Usuarios",
    'users.type'=>'Perfil',
    'users.name'=>'Nombre',
    'users.email'=>'Email',
    'users.location'=>'Colegio',
    'users.show' => 'Perfil',
    'users.phone' => 'Teléfono',
    'users.password' => 'Introduzca su password',
    'users.password_confirmation' => 'Confirme su password',

    //PROFILES
    'profiles' => 'Perfil',
    'profiles.avatar' => 'Foto',
    'profiles.phone' => 'Teléfono',
    'profiles.type' => 'Permisos',


    // GROUPS
    'groups' => 'Grupo',
    'title.groups' => "Lista de Grupos",
    'groups.name' => 'Curso',
    'groups.count' => 'Nº de alumnos',
    'groups.show' => 'Alumnos',
    'groups.user_id' => 'Profesor encargado',
    'groups.sites' => 'Lugares de publicación',

    // PUBLICATIONSITES
    'publicationsites' => 'nueva',
    'title.publicationsites' => "Areas de Difusión",
    'publicationsites.name' => 'Nombre',
    'publicationsites.url' => 'Dirección web',

    // PERSONS
    'persons' => 'Alumno',
    'title.persons' => "Lista de alumnos",
    'persons.name' => 'Nombre',
    'persons.minor' => 'Menor de 16 años',
    'persons.email' => 'DNI/NIE/Pasaporte',
    'persons.documentId' => 'Email',
    'persons.group_id' => 'Clase',
    'persons.photo' => 'Foto',
    'persons.phone' => 'Teléfono',
    'persons.show' => 'Responsables',
    'persons.rightholders' => 'Responsables',
    'persons.FaceId'=> 'Face Id',


    // RIGHTHOLDERS
    'rightholders' => 'Responsables',
    'title.rightholders' => "Lista de responsables",
    'rightholders.name' => 'Nombre del responsable',
    'rightholders.person' => 'Nombre del alumno',
    'rightholders.title' => 'Relación',
    'rightholders.mother' => 'Madre',
    'rightholders.father' => 'Padre',
    'rightholders.tutor' => 'Tutor',
    'rightholders.email' => 'Email',
    'rightholders.phone' => 'Teléfono',
    'rightholders.person_id'=>'Nombre del alumno',
    'rightholders.relation' =>'Relación',
    'rightholders.request' => 'Solicitar consentimientos',
    'rightholders.consents' => 'Consentimientos',
    'rightholders.documentId' => 'DNI/NIE/Pasaporte',
    'rightholders.template' => 'Solicito su consentimiento para publicar y bla,bla,bla. <br> Por favor pulse el botón y siga las instrucciones.',


    // PHOTOS
    'photos' => 'Foto',
    'title.photos' => "Lista de imagenes",
    'photos.group_id' => 'Curso',
    'photos.name' => 'Etiqueta',
    'photos.photo' => 'Foto',
    'photos.show' => 'Contratos',
    'photos.faces' => 'Iniciar reconocimiento',
    'photos.detected' => 'Personas detectadas',
    'photos.findings' => 'Personas reconocidas',
    'photos.requests' => 'Solicitar aprobación',
    'photos.date' => 'Fecha',
    'photos.requests_received' => 'Aprobaciones',
    'photos.recognition' => 'Reconocimiento facial',
    'photos.sharing' => 'Publicar',
    'photos.name-person'=>'Nombre',
    'photos.name-rightholder'=>'Responsable',
    'photos.link'=>'Enlace',
    'photos.request'=>'Solicitar consentimientos',
    'photos.label' => 'Etiqueta identificativa',
    'photos.origen' => 'Imagen',
    'photos.name-email'=>'Email',
    'photos.consent_id'=>'Ámbito legal',
    'photos.send'=> 'Solicitar consentimientos para la imagen ',
    'photos.warning' => "AVISO",
    'photos.error' => "ERROR",



    //CONTRACTS s
    'contracts' => 'Contrato',
    'contracts.person' => 'Alumno reconocido',
    'contracts.group' => 'Clase del Alumno',
    'contracts.show' => 'Firmas',
    'contracts.photo'=> 'Foto',
    'contracts.rightholders'=>'Tutores',

    //Acks
    'acks' => 'Consentimiento',
    'Acks.show' => 'Ver',
    'acks.status' => 'Acepto....',
    'acks.status_short' => 'Estado',
    'acks.photo'  => 'Foto',
    'acks.rightholder'=> 'Firmantes',
    'acks.status_signed' =>'Firmado',
    'acks.status_pending' => 'Pendiente',

    //Response
    'response.dni'=>'Introduzca su DNI',

    //HISTORIC
    'title.historic.photos' => "Historial de imagenes",
    'title.historic.persons' => "Historial de personas",
    'title.historic.rightholders' => "Historial de responsables",
    'historic.photos.photo' => 'Imagen',
    'historic.photos.name' => 'Etiqueta',
    'historic.photos.date' => 'Fecha de captura',
    'historic.photos.people' => 'Personas identificadas',
    'historic.persons.group_id' => 'Clase',
    'historic.persons.name' => 'Nombre',
    'historic.persons.photo' => 'Foto',
    'historic.rightholders' => 'Historial de responsables',
    'historic.photos' => 'Historial de fotografías',
    'historic.persons' => 'Historial de alumnos',
    'historic.persons.download' => 'Descargar informe',
    'historic.photos.download' => 'Descargar informe',
    'historic.rightholders.download' => 'Descargar informe',
    'historic.rightholders.name' => 'Nombre',
    'historic.rightholders.email' => 'Email',
    'historic.rightholders.phone' => 'Teléfono',
    'historic.rightholders.relation' => 'Relación',
    'historic.rightholders.consents' => 'Consentimientos',
    'historic.person.show.data' => "Historial del alumno",
    'historic.rightholders.show.data' => "Historial del responsable",
    'historic.photo.show.data' => "Historial de la imagen",
    'historic.person.show' => 'Historial del alumno',


    'historic.photo.show.to'=>'Enviar a',
    'historic.photo.show.title'=>'Titulo',
    'historic.photo.show.request'=>'Enviar informe',
    'historic.person.show.to'=>'Enviar a',
    'historic.person.show.title'=>'Titulo',
    'historic.person.show.request'=>'Enviar informe',
    'historic.rightholders.show.to'=>'Enviar a',
    'historic.rightholders.show.title'=>'Titulo',
    'historic.rightholders.show.request'=>'Enviar informe',

    //EXCEL
    'excel.id'=>'#',
    'excel.user_id'=>'Usuario',
    'excel.created_at'=>'Fecha de creación',
    'excel.site_code' => '#',
    'excel.site_group' => 'Grupo',
    'excel.site_name' => 'Nombre',
    'excel.site_url' => 'Dirección web',
    'excel.status'=> 'Estado',
    'excel.person_code'=> 'Código de persona',
    'excel.person_group'=> 'Grupo',
    'excel.person_name'=>'Nombre',
    'excel.person_minor'=>'Menor de 16 años',
    'excel.person_dni'=>'Documento',
    'excel.person_phone'=>'Teléfono',
    'excel.person_email'=>'Email',
    'excel.person_photo_name'=>'Nombre de la foto',
    'excel.person_photo_path'=>'Foto',

    'excel.rightholder_code'=>'#',
    'excel.rightholder_person_code'=>'Código de persona',
    'excel.rightholder_name'=>'Nombre',
    'excel.rightholder_relation'=>'Relación',
    'excel.rightholder_email'=>'Email',
    'excel.rightholder_phone'=>'Teléfono',
    'excel.rightholder_documentId'=>'Documento',

    // TAREAS
    'tasks' => 'tarea',
    'title.tasks' => 'Lista de tareas',
    'tasks.description' => 'Descripción',
    'tasks.priority_short' => 'Prioridad',
    'tasks.priority' => 'Prioridad (Alta 1-10 | Media 10-20 | Baja > 20)',
    'tasks.group_id' => 'Grupo',
    'tasks.done_short' => 'Completada',
    'tasks.done' => 'Tarea realizada',
    'tasks.arco' => 'Relacionada con derechos ARCO',
    'tasks.priority_high' => 'Alta',
    'tasks.priority_medium' => 'Media',
    'tasks.priority_low' => 'Baja',


];