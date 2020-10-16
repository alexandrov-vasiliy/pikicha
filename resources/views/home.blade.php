@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col">

            <div class="card">
                <div class="card-header">Фотоальбомы </div>




                        <albom-table userid="{{ Auth::user()->id }}"></albom-table>

            </div>
        </div>
    </div>
</div>


@endsection

