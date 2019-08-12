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

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import TodoList from './models/TodoList';
import TodoListItem from './models/TodoListItem';

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
                        let todoListItem = new TodoListItem(item.id, item.name, item.is_done, item.todo_list_id);
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
