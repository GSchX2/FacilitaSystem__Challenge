<template>
    <div class="formulario">
        <form @submit="submit">
          <fieldset>
            <label for="title" >Tarefa</label>
            <input v-model='title' id='title' type="text" maxlength="255" placeholder="digite aqui">
            <label for="description">Descrição</label>
            <textarea v-model='description' id='description' type="text" maxlength="255" placeholder="descreva a tarefa..."></textarea>
            <label for="done"><input  v-model="done" id='done' type="checkbox"> Finalizada</label> 
            <label for="due_date">Data para o término</label>
            <input v-model="due_date" id='due_date' type="text" placeholder="dd-mm-aaaa">
            <button type="submit">Agendar Tarefa</button>
          </fieldset>
        </form>
      </div>
</template>

<script>
    export default {
        name: 'CreateEditForm',

        props: {
            todo: {
                type: Object,
                default: () => ({}),
            },
        },

        data() {
            return {
                id: null,
                title: '',
                description: '',
                done: false,
                due_date: ''
            };
        },

        watch: {
            todo(data) {
                this.id = data.id;
                this.title = data.title;
                this.description = data.description;
                this.done = false;
                this.due_date = data.due_date;
            }
        },

        methods: {
            submit() {
                const submitedValues = {
                    title: this.title,
                    description: this.description,
                    done: this.done,
                    due_date: this.due_date
                };
                
                if (this.id) {
                    console.log(submitedValues);
                    this.updateTodo(submitedValues, this.id);
                } else {
                    this.storeTodo(submitedValues);
                }

                // this.$refs.todoForm.reset();
            },    

            storeTodo(data) {
                    fetch('http://127.0.0.1:8000/todos',
                    {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(res => {
                        this.$emit('save', res.data);
                        console.log(res);

                        this.resetForm();
                });
            },

            updateTodo(data, todoId) {
                    fetch(`http://127.0.0.1:8000/todos/${todoId}`,
                    {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(res => {
                        this.$emit('update', res.data);
                        console.log(res.data);
                        
                        this.resetForm();
                });
            },

            resetForm() {
                this.title = '',
                this.description = '',
                this.done = false,
                this.due_date = ''
            },
        },
    };
</script>

<style scoped>
    .formulario {
        color: whitesmoke;
        font-size: 1.6rem;
        line-height: 2;
        padding-inline: 2rem;
    }

    fieldset {
        display: flex;
        flex-direction: column;
    }

    label {
        font-size: 1.8rem;
        margin-top: 1rem;
    }

    input,
    textarea {
        border-radius: 5px;
        font-size: 1.8rem;
        font-family: Arial, Helvetica, sans-serif;
        line-height: 1.4;
        padding: 0.8rem;
    }

    textarea {
        height: 9rem;
        resize: none;
    }

    input::placeholder,
    textarea::placeholder {
        font-size: 1.6rem;
        color: grey;
    }

    #done {
        vertical-align: middle;
        margin-bottom: 0.2rem;
        margin-right: 0.5rem;
    }

    button {
        background-color: #111;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        margin-top: 2rem;
        height: 5rem;
        font-size: 1.8rem;
        font-weight: 700;
    }
</style>