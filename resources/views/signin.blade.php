@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="form-wrap d-flex align-items-center justify-content-center">
                <form method="POST" action="{{ route('signin') }}" class="form p-5 shadow-lg rounded">
                    @csrf
                    <a class="text-decoration-none fs-4 d-block text-center mb-3 text-dark" href="{{ route('home') }}">НА
                        ГЛАВНУЮ</a>
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" required aria-describedby="nameHelp">
                        <div class="text-danger mt-2">
                            Пожалуйста, введите корректный логин.
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="text-danger mt-2">
                            Неверные данные входа.
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        <div class="text-danger mt-2">
                            Пожалуйста, введите пароль.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
            </div>
        </div>
@endsection
