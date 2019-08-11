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
                                <div class="card">
                                    <div class="card-header">
                                        <input type="text" v-model="list.title">
                                        <button type="button" class="button primary" @click="updateTitle(list)">Save</button>
                                    </div>
                                    <div class="card-body">
                                        <div v-for="item in list.items">
                                            <input type="text" v-model="item.name">
                                            <button type="button" class="button primary" @click="updateName(item)">Save</button>
                                        </div>
                                        <hr>
                                        <input type="text" placeholder="New item">
                                        <button type="button" class="button primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection