@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <p>Por favor corrige los siguientes errores para poder continuar:</p>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif