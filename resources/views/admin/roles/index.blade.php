@extends('layouts.app')

@section('title', 'Список ролей ')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-5">
                <h4 class="text-center pb-2 border-bottom">Список ролей </h4>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white table-striped ">
                        <thead class="bg-light">
                        <tr>
                            <th class="text-center">№</th>
                            <th class="text-center">Название</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">
                                    <p class="fw-normal mb-1">{{ $role->id }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="fw-normal mb-1">{{ $role->name }}</p>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection
