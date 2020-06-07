<template>
    <div v-if="!loggedIn" class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Welcome to ToDo App</h1>
            <p class="lead font-weight-normal">Experience great work ethics with this simple app</p>
        </div>

    </div>
    <div v-else="loggedIn">
        <div v-if="loading">Data is loading...</div>
        <div v-else>
            <div class="mb-4 form-group row">
                <div class="col-md-6">
                    <input type="text"
                           name="description"
                           class="input-group input-group-lg"
                           :class="[{'is-invalid': errorFor('description')}]"
                           placeholder="What needs to be done"
                           v-model="newTask.description"
                           @keyup.enter="addTask">
                    <div class="invalid-feedback" v-for="error in this.errorFor('description')" :key="error.id">{{ error }}</div>

                </div>

                <div class="form-group col-md-4">
                    <label for="deadline">Deadline:</label>
                    <input type="datetime-local"
                           @keyup.enter="addTask"
                           v-model="newTask.best_before"
                           name="deadline"
                           :class="[{'is-invalid': errorFor('best_before')}]"
                           placeholder="Deadline">
                    <div class="invalid-feedback" v-for="error in this.errorFor('best_before')" :key="error.id">{{ error }}</div>

                </div>
                <div @click.prevent="addTask" class="form-group col-2 text-right">
                    <button key="doneButton" class="btn btn-info"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div v-if="tasks" class="row">
                <div class="col-md-4"> <h1>List of your todos</h1></div>

                <div class="col-md-4">
                    <button class="btn btn-filter" :class="{ active: filter == 'all' }" @click="changeFilter('all')">All</button>
                    <button class="btn btn-filter" :class="{ active: filter == 'active' }" @click="changeFilter('active')">Active</button>
                    <button class="btn btn-filter" :class="{ active: filter == 'completed' }" @click="changeFilter('completed')">Completed</button>
                </div>
                <div v-if="showClearCompletedButton" class="col-md-4 text-right">
                    <button class="btn btn-link" @click="clearCompleted">Clear Completed Tasks</button>
                </div>



            </div>
            <div v-if="tasks" class="col d-flex align-items-stretch" ref="tasks-list" v-for="task in tasksFiltered" :key="task.id">
                <TaskItem :task="task" />
            </div>
            <hr>
            <div v-if="remaining">
                {{ remaining }} Items left
            </div>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import TaskItem from './TaskItem';
    export default {
        components: {TaskItem},
        data () {
            return {
                newTask: {
                    description:null,
                    best_before:null
                },
                loading: false,
                filter: 'all',
                errors: {}

            }
        },
        computed: {
            ...mapGetters([
                'loggedIn', 'tasks'
            ]),
            remaining() {
                return this.tasks.data ? this.tasks.data.filter(task => !task.completed).length : null;
            },

            tasksFiltered() {
                if(this.filter == 'all') {
                    return this.orderByDate(this.tasks.data)
                } else if(this.filter == 'active') {
                    return this.tasks.data.filter(task => !task.completed);
                } else if(this.filter == 'completed') {
                    return this.tasks.data.filter(task => task.completed);
                }
            },
            showClearCompletedButton() {
                return this.tasks.data ? this.tasks.data.filter(task => task.completed).length > 0 : false;
            }
        },
        methods: {
            addTask(){

                if (this.newTask !== null) {
                    this.$store.dispatch('addTask', {
                        description: this.newTask.description,
                        best_before: this.newTask.best_before
                    }) .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                }

            this.newTask = {
                    description: '',
                    best_before: ''
            };

            },
            errorFor(field) {
                return this.errors[field] ? this.errors[field] : null;
            },
            changeFilter(filterBy) {
                this.filter = filterBy
            },
            clearCompleted() {
                this.tasks.data = this.tasks.data.filter(task => !task.completed)
            },
            orderByDate(data) {
                return _.orderBy(data, 'best_before')
            },
        },
        created () {
            this.loading = true;
            if(this.loggedIn){
                this.$store.dispatch('getTasks');
                this.loading=false;
            }
        },

    }
</script>
<style>
    .btn-filter {
        color: #212529;
        border-color: #6cb2eb;
    }
    .btn-filter:hover, .active {
        color: white;
        background-color: #6cb2eb;
        border-color: #6cb2eb;
    }
</style>
