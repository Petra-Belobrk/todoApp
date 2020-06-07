<template>
    <div class="card w-100">
        <div class="card-body row">
            <div class="col-10">
            <router-link :to="{ name: 'task', params: { id: task.id } }">
                <h5 class="card-title">{{ task.description }}</h5>
            </router-link>
            </div>
            <div class="col-2 text-center">
                <input type="checkbox" :value="task.completed" v-model="checkbox">
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        //props: { description: String, id: Number, completed: [Number, Boolean], best_before: String },
        props: ['task'],
        computed: {
            checkbox: {
                // getter
                get: function() {
                    return this.task.completed;
                },
                // setter
                set: function(newValue) {
                    let object = {
                        ...this.task
                    };
                    object.completed = newValue;
                    object.global = true;
                    this.$store.dispatch('editTask', object);
                }
            }
        },
    };
</script>
