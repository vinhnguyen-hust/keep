@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Oops!</strong> There were some problems with your form submission<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif