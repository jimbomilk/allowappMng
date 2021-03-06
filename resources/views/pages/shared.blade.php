
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
    <meta property="og:url"                content="{{$photo->url}}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="When Great Minds Don’t Think Alike" />
    <meta property="og:description"        content="How much does culture influence creative thinking?" />
    <meta property="og:image"              content="{{$photo->url}}" />
</head>
<body style="background-image: url('/images/background_allowapp.png')">
<div style="width: 100%;text-align: center">
<img class="img-responsive center" src="{{$photo->url}}">
<p ><small>Imagen compartida por <strong>{{$photo->photo->getData('accountable')}}</strong> como responsable del <strong>{{$photo->photo->location->description}}</strong>.<br> Si desea ejecer sus derechos de acceso, rectificación, cancelación u oposición debe
enviar un correo electrónico a: <br> <strong> {{$photo->photo->getData('accountable_email')}}</strong>.<br> Indicando su nombre y dni, así como esta referencia a la imagen: <strong>{{$photo->photo->group->name}}#{{$photo->photo->getData('name')}}</strong></small></p>
</div>
</body>
</html>
