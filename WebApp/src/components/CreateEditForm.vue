<template>
    <div class="formulario">
        <form @submit="submit">
          <fieldset>
            <label for="title" >Tarefa</label>
            <input v-model='title' id='title' type="text" maxlength="255" placeholder="digite aqui" autofocus>
            <label for="description">Descrição</label>
            <textarea v-model='description' id='description' type="text" placeholder="descreva a tarefa..."></textarea>
            <label for="done"><input  v-model="done" id='done' type="checkbox"> Finalizada</label> 
            <label for="due_date">Data para o término</label>
            <input v-model="due_date" id='due_date' type="text" placeholder="dd-mm-aaaa" autocomplete="off">
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
        color: var(--color-quaternary);
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
        background-color: var(--color-quaternary);
        border-radius: 5px;
        font-size: 1.8rem;
        line-height: 1.4;
        padding: 0.8rem;
        outline: none;
        transition: all 0.5s ease-in-out;
        text-transform: capitalize;
    }

    input:focus,
    textarea:focus {
        box-shadow: inset 0 0 10px 1px var(--font-color-light);
    }

    textarea {
        height: 9rem;
        resize: none;
    }

    input::placeholder,
    textarea::placeholder {
        font-size: 1.6rem;
        color: var(--font-color-light);
    }

    #done {
        vertical-align: middle;
        margin-bottom: 0.2rem;
        margin-right: 0.5rem;
    }

    #due_date {
        text-transform: none;
    }

    button {
        background-color: var(--color-secondary);
        border-radius: 5px;
        color: var(--color-quaternary);
        cursor: pointer;
        margin-top: 2rem;
        height: 5.5rem;
        font-size: 1.8rem;
        font-weight: 700;
        transition: all 0.5s linear;
    }

    button:hover {
        opacity: 0.9;
        color: white;
    }

    @media screen and (min-width: 660px) and (max-width: 1399px) {
        .formulario {
            padding-inline: 20%; 
        }
    }
</style>