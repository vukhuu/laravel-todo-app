/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('new-todo-box', {
    template: `
        <div>
        I would like to add a <input type="text" placeholder="new note" v-model="newNote"> 
        under 
        <select>
        <option>a new list called</option>
        </select>
        <input type="text" placeholder="list name" v-model="newList">
        <button type="button" class="btn btn-primary" @click="createNewList">Go</button>
        </div>
        `,
    data: function() {
        return {
            newNote: '',
            newList: ''
        };
    },
    methods: {
        reset() {
            this.newNote = '';
            this.newList = '';
        },
        createNewList() {
            axios.post('/todoLists', {
                title: this.newList,
                todo_list_items: [
                    { name: this.newNote }
                ]
            }).then((response) => {
                console.log(response);
                this.reset();
            });
        }
    }
});

Vue.component('todo-list', {
    template: `
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" v-model="dataList.title" class="inline-edit-text" title="Click to edit">
                </div>
                <div class="col-md-2">
                    <button type="button" class="button primary" @click="updateTitle(dataList)">Save</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-for="item in dataList.todo_list_items" class="row">
                <div class="col-md-1"><input type="checkbox"></div>
                <div class="col-md-9">
                    <input type="text" class="inline-edit-text list-item" v-model="item.name" title="Click to edit">
                </div>
                <div class="col-md-2">
                    <button type="button" class="button primary inline-button-save" @click="updateName(item)">Save</button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-10">
                    <input type="text" class="inline-edit-text" placeholder="New item" v-model="newItemValue">
                </div>
                <div class="col-md-2">
                    <button type="button" class="button primary inline-button-save" @click="createNewItem">Save</button>
                </div>
            </div>
        </div>
    </div>
    `,
    props: {
        list: Object
    },
    data() {
        return {
            newItemValue: '',
            dataList: this.list,
        };
    },
    
    methods: {
        resetAddNewForm() {
            this.newItemValue = '';
        },
        updateTitle(list) {
            axios.put('/todoLists/' + list.id, {
                title: list.title
            }).then((response) => {
                list.isEditing = false;
            });
        },
        updateName(listItem) {
            axios.put('/todoListItems/' + listItem.id, {
                name: listItem.name
            }).then((response) => {
                listItem.isEditing = false;
            });
        },
        createNewItem: function() {
            let me = this;
            axios.post('/todoListItems/', {
                name: this.newItemValue,
                todo_list_id: this.list.id
            }).then(function(response) {
                me.dataList.todo_list_items.push({ name: response.data.name} );
                me.resetAddNewForm();
            });
        }
    }
});

class TodoListItem
{
    constructor(id, name, isDone) {
        this.id = id;
        this.name = name;
        this.isDone = isDone;
    }
}

class TodoList
{
    constructor(id, title, items) {
        this.id = id;
        this.title = title;
        this.todo_list_items = items;
    }
}

let todoLists = [];

const app = new Vue({
    el: '#app',
    data: {
        newNote: '',
        newListName: '',
        todoLists: todoLists
    },
    methods: {
        loadTodoLists() {
            axios.get('/todoLists').then((response) => {
                let data = response.data;
                this.todoLists = [];
                data.forEach((row) => {
                    let items = [];
                    row.todo_list_items.forEach((item) => {
                        let todoListItem = new TodoListItem(item.id, item.name, item.is_done);
                        items.push(todoListItem);
                    });
                    let todoList = new TodoList(row.id, row.title, items);
                    this.todoLists.push(todoList);
                })
            });
        }
    },
    mounted() {
        this.loadTodoLists();
    }
});
