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
                            <div v-if="todoLists.length == 0">You have not got any todo list yet</div>
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

@section('script')
    <script src="{{ asset('js/todos.js') }}" defer></script>
@endsection

<style>
.inline-edit-text input[type=text], input.inline-edit-text {
    border: none;
    background: #F7F7F7;
    margin-bottom: 5px;
    padding: 5px;
    width: 100%;
}
.inline-edit-text .is-done {
    text-decoration: line-through;
}
.inline-edit-text input[type=text]:hover, input.inline-edit-text[type=text]:hover {
    /* box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    border-bottom: 1px solid #bcbcbc; */
    background-color: #f4f4f4 !important;
}
.list-item input[type=text] {
    background: #FFF !important;
}
.inline-button-save {
}
[type=checkbox] {
    margin-top: 10px;
}
.save {
    background: none;
    border:none;
    color: #227DC7;
    display: none;
    /* padding: 8px; */
    float: right;
    margin: 8px 0 0 0;
}
.remove {
    background: none;
    border:none;
    color: #227DC7;
    float: right;
    margin: 8px 0 0 0;
    /* padding: 8px; */
}
.is-editing .save {
    display: inline !important;
}
.has-error {
    border: 1px solid red;
}
</style>