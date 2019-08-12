class TodoListItem
{
    constructor(id, name, isDone, todoListId) {
        this.id = id;
        this.name = name;
        this.isDone = isDone == 1 ? true : false;
        this.todoListId = todoListId;
    }
}

export default TodoListItem