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

window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
}

Vue.component('new-todo-box', {
    template: `
        <div>
        I would like to add a <input type="text" placeholder="new task" v-model="newNote"> 
        under 
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
            if (this.newNote.trim() == '' || this.newList.trim() == '') {
                alert('Task and list cannot be blank');
                return;
            }
            axios.post('/todoLists', {
                title: this.newList,
                todo_list_items: [
                    { name: this.newNote }
                ]
            }).then((response) => {
                this.reset();
                let item = response.data.todo_list_items[0];
                let todoItem = new TodoListItem(item.id, item.name, item.isDone);
                let todoList = new TodoList(response.data.id, response.data.title, [todoItem]);
                Event.fire('newListAdded', todoList);
            });
        }
    }
});

Vue.component('todo-list', {
    template: `
    <div class="card clearfix">
        <div class="card-header">
            <div class="row" v-bind:class="{ 'is-editing': isEditing }">
                <div class="col-md-9">
                    <input type="text" v-model="list.title" class="inline-edit-text" title="Click to edit" @focus="isEditing = true">
                </div>
                <div class="col-md-3">
                    <button type="button" class="button remove" @click="deleteList" title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></button>
                    <button type="button" class="button primary save" @click="updateTitle(list)" title="Save"><i class="fa fa-check-square" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-for="item in list.todo_list_items">
                <todo-list-item v-bind:item="item"></todo-list-item>
            </div>
            <hr>
            <div class="row" v-bind:class="{ 'is-editing': isAddingNewTask }">
                <div class="col-md-9">
                    <input type="text" class="inline-edit-text" placeholder="New task" v-model="newItemValue" title="Click to add new task" @focus="isAddingNewTask = true">
                </div>
                <div class="col-md-3">
                    <button type="button" class="button primary inline-button-save save" @click="createNewItem" title="Save"><i class="fa fa-check-square" aria-hidden="true"></i></button>
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
            isEditing: false,
            isAddingNewTask: false,
            isDeleted: false
        };
    },
    
    methods: {
        resetAddNewForm() {
            this.newItemValue = '';
            this.isAddingNewTask = false;
        },
        updateTitle(list) {
            if (list.title.trim() == '') {
                alert('List title cannot be blank');
                return;
            }
            axios.put('/todoLists/' + list.id, {
                title: list.title
            }).then((response) => {
                this.isEditing = false;
            });
        },
        createNewItem: function() {
            if (this.newItemValue.trim() == '') {
                alert('Task cannot be blank');
                return;
            }
            axios.post('/todoListItems/', {
                name: this.newItemValue,
                todo_list_id: this.list.id
            }).then((response) => {
                let todoListItem = new TodoListItem(response.data.id, response.data.name, response.data.is_done);
                this.list.todo_list_items.push(todoListItem);
                this.resetAddNewForm();
            });
        },
        deleteList: function() {
            if (confirm('Are you sure you want to delete this list?')) {
                axios.delete('/todoLists/' + this.list.id).then((response) => {
                    this.isDeleted = true;
                    Event.fire('listDeleted', this.list);
                });
            }
        }
    }
});

Vue.component('todo-list-item', {
    template: `
        <div class="row">
            <div class="col-md-1">
                <input type="checkbox" @click="markDone" v-model="item.isDone" true-value="true" false-value="false">
            </div>
            <div class="col-md-9 inline-edit-text list-item">
                <input type="text" v-bind:class="{ 'is-done': item.isDone }" v-model="item.name" title="Click to edit" @focus="isEditing = true">
            </div>
            <div class="col-md-2" v-bind:class="{ 'is-editing': isEditing }">
                <button type="button" class="button primary inline-button-save save" @click="updateName" title="Save"><i class="fa fa-check-square" aria-hidden="true"></i></button>
            </div>
        </div>
    `,
    props: {
        item: Object
    },
    data() {
        return {
            newItem: '',
            isEditing: false
        };
    },
    methods: {
        updateName() {
            if (this.item.name.trim() == '') {
                alert('Task name cannot be blank');
                return;
            }
            axios.put('/todoListItems/' + this.item.id, {
                name: this.item.name
            }).then((response) => {
                this.isEditing = false;
            });
        },
        markDone() {
            console.log(this.item);
            console.log(this.item.isDone);
            const url = '/todoListItems/' + this.item.id
                        + (!this.item.isDone ? '/markDone' : '/undoMarkDone');
            axios.post(url, {

            }).then((response) => {
                this.item.isDone = response.data.is_done == 1 ? true : false;
            });
        }
    }
});

class TodoListItem
{
    constructor(id, name, isDone) {
        this.id = id;
        this.name = name;
        this.isDone = isDone == 1 ? true : false;
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

const app = new Vue({
    el: '#app',
    data: {
        newNote: '',
        newListName: '',
        todoLists: []
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
    created() {
        Event.listen('newListAdded', (newItem) => {
            this.todoLists.unshift(newItem);
        });
        Event.listen('listDeleted', (deletedList) => {
            for(let i=0; i<this.todoLists.length; i++) {
                let list = this.todoLists[i];
                if (list['id'] == deletedList['id']) {
                    this.todoLists.splice(i, 1);
                    break;
                }
            }
        });
    },
    mounted() {
        this.loadTodoLists();
    }
});
