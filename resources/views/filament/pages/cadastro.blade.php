
@extends('filament::page')

@section('content')
    <h1>Cadastro</h1>
    <form>
        <div>
            <label for="name">Nome</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
@endsection
