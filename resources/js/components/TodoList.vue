<template>
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
            <div v-if="list.todo_list_items.length == 0">There is no task in this list</div>
            <div v-for="item in list.todo_list_items">
                <todo-list-item v-bind:item="item" v-on:itemDeleted="deleteItem"></todo-list-item>
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
</template>

<script>
    import TodoListItem from '../models/TodoListItem';

    export default {
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
                    let todoListItem = new TodoListItem(response.data.id, response.data.name, response.data.is_done, response.data.todo_list_id);
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
            },
            deleteItem(data) {
                console.log(data);
                let itemId = data.itemId;
                
                for(let i=0; i<this.list.todo_list_items.length; i++) { // should use "index" instead?
                    if (this.list.todo_list_items[i].id == itemId) {
                        this.list.todo_list_items.splice(i, 1);
                        break;
                    }
                }
            }
        }
    }
</script>