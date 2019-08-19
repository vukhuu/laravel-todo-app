<template>
    <div>
        I would like to add a 
        <input type="text" placeholder="new task" v-model="newNote"
            :class="{ 'has-error': errors.has('todo_list_items.0.name') }"
            :title="errors.get('todo_list_items.0.name')"> 
        under 
        <input type="text" placeholder="list name" v-model="newList"
            :class="{ 'has-error': errors.has('title') }"
            :title="errors.get('title')">
        <button type="button" class="btn btn-primary" @click="createNewList">Go</button>
    </div>
</template>

<script>
    import TodoList from '../models/TodoList';
    import TodoListItem from '../models/TodoListItem';
    import Errors from '../core/Errors';

    export default {
        data: function() {
            return {
                newNote: '',
                newList: '',
                errors: new Errors()
            };
        },
        methods: {
            reset() {
                this.newNote = '';
                this.newList = '';
                this.errors.clear();
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
                    let todoItem = new TodoListItem(item.id, item.name, item.isDone, item.todo_list_id);
                    let todoList = new TodoList(response.data.id, response.data.title, [todoItem]);
                    Event.fire('newListAdded', todoList);
                }).catch((error) => {
                    let response = error.response.data;
                    console.log(response);
                    this.errors.record(response.errors);
                });
            }
        }
    }
</script>