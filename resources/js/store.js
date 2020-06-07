import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default {
    state: {
        token: localStorage.getItem('access_token') || false,
        tasks: [],
    },
    getters: {
        loggedIn(state) {
            return state.token !== false
        },
        tasks(state) {
            return state.tasks;
        },

    },
    mutations: {
        getToken(state, token) {
            state.token = token
        },
        destroyToken(state) {
            state.token = false
        },
        getTasks(state, tasks) {
            state.tasks = tasks
        },
        addTask(state, task) {
            state.tasks.data.push({
                id: task.id,
                description: task.description,
                best_before: task.best_before,
                completed: false,
            })
        },
        editTask(state, task) {
            state.task = {
                'id': task.id,
                'description': task.description,
                'completed': task.completed,
                'best_before': task.best_before
            }
        }
    },
    actions: {
        getToken(context, credentials) {

            return new Promise((resolve, reject) => {
                axios.post('/api/login', {
                    email: credentials.email,
                    password: credentials.password,
                })
                    .then(response => {
                        const token = response.data.access_token
                        localStorage.setItem('access_token', token)
                        context.commit('getToken', token)
                        resolve(response)
                    })
                    .catch((error) => {
                        console.log( error.response )
                        reject(error);
                    } );
            })
        },
        logout(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                return new Promise((resolve, reject) => {
                    axios.post('/api/logout')
                        .then(response => {
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            delete axios.defaults.headers.common['Authorization'];
                            resolve(response)
                        })
                        .catch(error => {
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            reject(error)
                        })
                })

        },

        getTasks(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            axios.get('/api/tasks')
                .then(response => {
                    context.commit('getTasks', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },

        deleteTask(context, id) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.delete('/api/tasks/' + id)
                .then(response => {
                    context.commit('getTasks', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        addTask(context, task) {
            return new Promise((resolve, reject) => {

                    axios.post('/api/tasks', {
                description: task.description,
                best_before: task.best_before,
                completed: false,
            })
                .then(response => {
                    context.commit('addTask', response.data)
                    resolve(response)

                })
                .catch(error => {
                    console.log(error)
                    reject(error);

                })
            })
        },
        editTask(context, task ) {
            axios.patch('/api/tasks/' + task.id, {
                description: task.description,
                completed: task.completed,
                best_before: task.best_before

            })
                .then(response => {
                    if(task.global){
                        context.dispatch('getTasks', response.data)
                    } else {
                        context.commit('editTask', response.data)
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
}
