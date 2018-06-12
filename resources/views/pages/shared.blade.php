
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
    <meta property="og:url"                content="{{$photo->url}}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="When Great Minds Don’t Think Alike" />
    <meta property="og:description"        content="How much does culture influence creative thinking?" />
    <meta property="og:image"              content="{{$photo->url}}?v={{\Carbon\Carbon::now()}}" />
</head>
<body>
<img class="img-responsive center" src="{{$photo->url}}">
<p>bla bla bla</p>
</body>
</html>
