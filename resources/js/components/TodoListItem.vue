<template>
    <div class="row">
        <div class="col-md-1">
            <input type="checkbox" @click="markDone" v-model="item.isDone" true-value="true" false-value="false">
        </div>
        <div class="col-md-9 inline-edit-text list-item">
            <input type="text" v-bind:class="{ 'is-done': item.isDone }" v-model="item.name" title="Click to edit" @focus="isEditing = true">
        </div>
        <div class="col-md-2" v-bind:class="{ 'is-editing': isEditing }">
            <button type="button" class="button remove" @click="deleteItem" title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></button>
            <button type="button" class="button primary inline-button-save save" @click="updateName" title="Save"><i class="fa fa-check-square" aria-hidden="true"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
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
                const url = '/todoListItems/' + this.item.id
                            + (!this.item.isDone ? '/markDone' : '/undoMarkDone');
                axios.post(url, {

                }).then((response) => {
                    this.item.isDone = response.data.is_done == 1 ? true : false;
                });
            },
            deleteItem() {
                if (confirm('Are you sure you want to delete this item?')) {
                    axios.delete('todoListItems/' + this.item.id, {}).then((response) => {
                        this.$emit('itemDeleted', {
                            itemId: this.item.id,
                            todoListId: this.item.todoListId
                        })
                    });
                }
            }
        }
    }
</script>