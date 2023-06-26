<template>
    <!--testar ou apagar ########### mais tarde-->
    <!-- <p v-if="todos.length === 0">Você não possui tarefas agendadas</p> -->
    
    <nav class="navbar">
        <button class="openSideBar" @click="toogleSideBar()">&#9776;</button>
        <h1 class="navbar__titulo">task <span class="plus">+</span></h1>
    </nav>
    <div v-bind:class="['sidebar', { 'collapsed': isCollapsed }]">
        <h1 class="sidebar__titulo">task <span class="plus">+</span></h1>
        <a class="closeSideBar" href="javascript:void(0)" @click="toogleSideBar()"><span class="material-symbols-outlined">close</span></a>
        <CreateEditForm 
        v-bind:todo="toBeUpdated"
        @save="onSave"
        @update="onUpdate"
        />
    </div>
    <div class="tarefas container">
        <div
            v-for="todo in todos"
            v-bind:key="todo.id"
            class="tarefa__card"
        >
            <div>
                <div class="tarefa__card-conteudo">
                    <div>
                        <h3 class="tarefa__card-titulo">{{ todo.title }}</h3>
                        <p class="tarefa__card-descricao">{{ todo.description }}</p>
                    </div>
                    <div>
                        <a
                            href="javascript:void(0)"
                            @click.stop.prevent="toogleStatus(todo)"
                            class="tarefa__card-conteudo-toogle"
                        >
                            <p
                            v-if="todo.done"
                            class="tarefa__card-conteudo-toogle--done"
                            >Finalizada
                            </p>
                            <p
                            v-else
                            class="tarefa__card-conteudo-toogle--not-done"
                            >Em&nbsp;progresso
                            </p>
                        </a>
                    </div>
                </div>
                <div class="tarefa__card-base">
                    <p class="tarefa_card-base-data">Prazo: {{ todo.due_date }}</p>
                    <div class="tarefa_card-conteudo-acoes">
                        <a class="tarefa__card-acao tarefa__card-acao--deleta"
                            href="javascript:void(0)"
                            @click="deleteTodo(todo.id)"
                        >
                            Deletar
                        </a>
                        <a class="tarefa__card-acao tarefa__card-acao--update"
                            href="javascript:void(0)"
                            @click.stop.prevent="toBeUpdated = todo"
                        >
                            Update
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CreateEditForm from '@/components/CreateEditForm.vue';

export default {
    name: 'HomeView',

    components: {
    CreateEditForm,
},

    data() {
        return {
            todos: [],
            toBeUpdated: [],
            isCollapsed: true,
        };
    },

    mounted() {
        fetch('http://127.0.0.1:8000/todos')
            .then(response => response.json())
            .then(res => this.todos = res.data);
    },

    methods: {
        onSave(todo) {
            this.todos.push(todo);
        },

        onUpdate(todo) {
            const todos = this.todos;
            const index = todos.findIndex(e => e.id === todo.id);
            todos.splice(index, 1, todo);
        },

        toogleStatus(todo) {
            let changedStatus = todo.done ? false : true;
            todo.done = changedStatus;    
            fetch(`http://127.0.0.1:8000/todos/${todo.id}`,
                    {
                        method: 'PUT',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(todo)
                })
                    .then(response => response.json())
                    .then(res => console.log(res.data));
          
        },

        deleteTodo(todoId) {
            fetch(`http://127.0.0.1:8000/todos/${todoId}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                }
            })
                .then(() => {  
                    const todos = this.todos;
                    const index = todos.findIndex(e => e.id === todoId);
                    todos.splice(index, 1);
                })},

        toogleSideBar() {
            this.isCollapsed = !this.isCollapsed;
        },
    }
}
</script>

<style scoped>
    .navbar {
        background-color: blue;
        text-align: center;
        position: relative;
    }
    .navbar__titulo {
        color: whitesmoke;
        font-size: 5rem;
    }
    .sidebar {
        background-color: blue;
        height: 100%;
        width: 100vw;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        overflow-x: hidden;
        transition: .3s ease-in-out;
    }
    .sidebar__titulo {
        color: whitesmoke;
        text-align: center;
        font-size: 5rem;
        padding: 2rem 0;
    }
    .openSideBar {
        border: none;
        background-color: blue;
        cursor: pointer;
        color: white;
        font-size: 3rem;
        margin-left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        position: absolute;
    }
    .closeSideBar {
        color: white;
        right: 2.5rem;
        font-size: 3.6rem;
        margin-left: 5rem;
        position: absolute;
        top: 0;
    }
    .plus {
        font-size: 8rem;
    }
    .collapsed {
        width: 0;
    }
    .container {
        padding-inline: 6%;
    }

    .tarefas {
        column-gap: 2rem;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
        row-gap: 2rem;
    }
   
    .tarefa__card {
        background-color: white;
        border: 1px solid grey;
        border-left: 6px solid blue;
        border-radius: 5px;
        width: min(100%, 45rem);
        padding: 2rem;
        position: relative;
        font-size: 1.6rem;
        box-shadow: 2px 4px 20px lightgray;
    }
    .tarefa__card-conteudo {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .tarefa__card-conteudo-toogle {
        color: black;
        text-decoration: none;
    }
    .tarefa__card-conteudo-toogle--done {
        border-bottom: 5px solid blue;
        padding-bottom: 0.2rem;
        transition: all 0.5s ease-in-out;
    }
    .tarefa__card-conteudo-toogle--not-done {
        border-bottom: 5px solid red;
        padding-bottom: 0.2rem;
        transition: all 0.5s ease-in-out;
    }
    .tarefa__card-titulo {
        margin-top: 3rem;
        margin-bottom: 1.5rem;
    }
    .tarefa__card-descricao {
        line-height: 1.4;
        margin-bottom: 1rem;
    }
    .tarefa__card-base {
        border-top: 1px solid grey;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
    }
    .tarefa_card-base-data {
        color: grey;
        font-size: 1.4rem;
    }
    .tarefa__card-acao {
        color: black;
        padding: 0.2rem;
        text-decoration: none;
        transition: border 0.2s linear;
    }
    .tarefa__card-acao--deleta:hover {
        border-bottom: 5px solid red;
    }
    .tarefa__card-acao--update:hover {
        border-bottom: 5px solid green;
    }

    @media screen and (min-width: 1000px) {
        .navbar {
            display: none;
        }
        .sidebar {
            width: 40rem;
        }
        .closeSideBar {
            display: none;
        }
        .container {
            padding-inline: 0;
            width: calc(100% - 40rem);
            margin-left: 40rem;
            padding: 4%;
        }
        .tarefas {
            justify-content: flex-start;
        }
        .tarefa__card {
            width: 100%;
            max-width: calc(50% - 1rem);   
            min-width: 30rem;
        }
    }

    @media screen and (min-width: 1600px) {
        .sidebar {
            width: 50rem;
        }
        .container {
            width: calc(100% - 50rem);
            margin-left: 50rem;
        }
    }

</style>