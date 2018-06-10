<?php

return [

    "create_new" => "Añadir",
    'name' => 'nombre',

    //PROFILES
    'profiles.super'=> 'Super usuario',
    'profiles.admin'=> 'Administrador/Director',
    'profiles.owner'=> 'Responsable de grupo',
    'profiles.user'=>'Usuario',

    // LOCATIONS
    'locations' => "Colegio",
    "locations.name" => "Nombre del colegio",
    'locations.description' => 'Descripción',
    'locations.logo' => 'Logo',
    'locations.show' => 'Mostrar',
    'locations.delete' => 'Borrar',

    // USERS
    'users' => 'usuario',
    'users.name'=>'Nombre',
    'users.email'=>'Email',
    'users.show' => 'Perfil',
    'users.phone' => 'Teléfono',
    'users.password' => 'Introduzca su password',
    'users.password2' => 'Vuelva a introducirla',

    //PROFILES
    'profiles' => 'Perfil',
    'profiles.avatar' => 'Foto',
    'profiles.phone' => 'Teléfono',
    'profiles.type' => 'Permisos',


    // GROUPS
    'groups' => 'Grupo',
    'groups.name' => 'Curso',
    'groups.count' => 'Nº de alumnos',
    'groups.show' => 'Alumnos',
    'groups.user_id' => 'Profesor encargado',
    'groups.sites' => 'Lugares de publicación',

    // PUBLICATIONSITES
    'publicationsites' => 'nueva',
    'publicationsites.name' => 'Nombre',
    'publicationsites.url' => 'Dirección web',

    // PERSONS
    'persons' => 'Alumno',
    'persons.name' => 'Nombre',
    'persons.minor' => 'Menor de 16 años',
    'persons.email' => 'DNI/NIE/Pasaporte',
    'persons.documentId' => 'Email',
    'persons.group_id' => 'Clase',
    'persons.photo' => 'Foto',
    'persons.show' => 'Responsables',
    'persons.rightholders' => 'Responsables',
    'persons.FaceId'=> 'Face Id',

    // RIGHTHOLDERS
    'rightholders' => 'Responsables',
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
    'photos.recognition' => 'Buscar coincidencias mediante reconocimiento facial',
    'photos.sharing' => 'Publicar',
    'photos.name-person'=>'Nombre',
    'photos.name-rightholder'=>'Responsable',
    'photos.link'=>'Enlace',
    'photos.request'=>'Solicitar consentimientos',
    'photos.label' => 'Etiqueta identificativa',
    'photos.origen' => 'Imagen',


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

    'historic.photos.name' => 'Etiqueta',
    'historic.photos.date' => 'Fecha',
    'historic.photos.people' => 'Personas identificadas',
    'historic.persons.group_id' => 'Clase',
    'historic.persons.name' => 'Nombre',
    'historic.persons.photo' => 'Foto',
    'historic.rightholders' => 'Mostrar historial de este responsable',
    'historic.photos' => 'Mostrar historial de esta fotografía',
    'historic.persons' => 'Mostrar historial de esta persona',
    'historic.rightholders.name' => 'Nombre',
    'historic.rightholders.email' => 'Email',
    'historic.rightholders.phone' => 'Teléfono',
    'historic.rightholders.relation' => 'Relación',
    'historic.rightholders.consents' => 'Consentimientos',

    'historic.photo.show.to'=>'Enviar a',
    'historic.photo.show.title'=>'Titulo',
    'historic.photo.show.request'=>'Enviar informe',
    'historic.person.show.to'=>'Enviar a',
    'historic.person.show.title'=>'Titulo',
    'historic.person.show.request'=>'Enviar informe',
    'historic.rightholders.show.to'=>'Enviar a',
    'historic.rightholders.show.title'=>'Titulo',
    'historic.rightholders.show.request'=>'Enviar informe',
];