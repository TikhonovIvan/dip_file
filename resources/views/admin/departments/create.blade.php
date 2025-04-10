@extends('layouts.default')

@section('title', 'Создать отдел')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-6">
                <h3>Создать новую Отдел</h3>
                <form class="row g-3" method="post" action="{{ route('departments.store') }}" >
                    @csrf
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Название</label>
                        <input name="name" type="text" class="form-control" id="inputEmail4">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

