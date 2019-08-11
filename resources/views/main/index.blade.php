@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <new-todo-box></new-todo-box>
                    <br>
                    <div class="card">
                        <div class="card-header">Your todo lists</div>

                        <div class="card-body clearfix">
                            <div class="col-md-6 float-left" v-for="list in todoLists" style="margin-bottom: 30px">
                                <todo-list v-bind:list="list"></todo-list>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.inline-edit-text {
    border: none;
    background: #F7F7F7;
    margin-bottom: 5px;
    padding: 5px;
    width: 100%;
}
.inline-edit-text.is-done {
    text-decoration: line-through;
}
.inline-edit-text:hover {
    border-bottom: 1px solid #bcbcbc;
}
.list-item {
    background: #FFF !important;
}
.inline-button-save {
}
[type=checkbox] {
    margin-top: 10px;
}
</style>