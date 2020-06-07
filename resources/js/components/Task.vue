<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <div class="row">
                            <div v-if="!edit" class="col-10">
                                <h2>{{ task.description }}</h2>
                                <p>Complete by: {{ task.best_before }}</p>
                            </div>
                            <div v-else class="col-10 edit form-group">
                                <input key="description" class="form-control input-lg" type="text" v-model="task.description">
                                <input key="date" class="form-control input-lg" type="datetime-local" v-model="task.best_before">
                            </div>
                            <div class="col-2 text-center">
                                <input type="checkbox" @change="editSubmit(task)" v-model="task.completed">
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                                <div class="form-group col-9 text-left">
                                    <button @click="deleteTask(task.id)" class="btn btn-danger">Delete</button>
                                </div>
                                <div v-if="!edit" @click="editTask(task.id)" class="form-group col-3 text-right">
                                    <button key="editButton" class="btn btn-info">Edit</button>
                                </div>
                                <template v-if="edit">
                                    <div @click="clear" class="form-group col-1 text-right">
                                        <button key="cancelButton" class="btn btn-info">Cancel</button>
                                    </div>
                                    <div @click="editSubmit" class="form-group col-2 text-right">
                                        <button key="doneButton" class="btn btn-info">Done</button>
                                    </div>
                                </template>
                        </div>


                        <hr>
                    </div>
                    <div v-else>Loading...</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                task: {
                    description: '',
                    completed: '',
                    best_before: '',
                    id: ''
                },
                loading: false,
                edit:false,
                beforeEditCache:'',
                beforeEditDateCache:'',
            };
        },
        methods: {
            deleteTask(id) {
                let ok = confirm("Are you sure you want to delete this task?");
                if (ok) {
                    this.$store.dispatch('deleteTask', id)
                    this.$router.push({ name: 'home' })
                }
            },
            editTask() {
                this.edit=true
                this.beforeEditCache = this.task.description
                this.beforeEditDateCache = this.task.best_before
            },
            editSubmit() {
                this.$store.dispatch('editTask', this.task);
                this.edit=false;
            },
            clear(){
                this.task.description = this.beforeEditCache
                this.task.best_before = this.beforeEditDateCache
                this.edit=false;
            },
            refreshState(){
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token')
                axios.get(`/api/tasks/${this.$route.params.id}`).then(response => {
                    this.task = response.data.data;
                    this.loading = false;
                });
            }
        },
        created() {
            this.loading = true;
            this.refreshState();
        }
    }
</script>
