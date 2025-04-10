@extends('layouts.default')

@section('title', 'Редактирование отдела')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-6">
                <h3>редактирование отдела</h3>
                <form class="row g-3" method="post" action="{{ route('departments.update', $department->id) }}" >
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Название</label>
                        <input name="name" type="text" class="form-control" id="inputEmail4" value="{{$department->name}}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Редактировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

