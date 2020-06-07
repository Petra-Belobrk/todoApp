<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                            type="text"
                            name="email"
                            placeholder="Enter your e-mail"
                            class="form-control"
                            v-model="email"
                            :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <div class="invalid-feedback" v-for="error in this.errorFor('email')" :key="error.id">{{ error }}</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            class="form-control"
                            v-model="password"
                            :class="[{'is-invalid': errorFor('password')}]"
                    />
                    <div class="invalid-feedback" v-for="error in this.errorFor('password')" :key="error.id">{{ error }}</div>
                </div>

                <button
                        type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        :disabled="loading"
                        @click.prevent="login"
                >
                    <div v-if="loading">Loading...</div>
                    <div v-if="!loading">Login</div>

                </button>
                <div class="form-group">
                    <div class="is-invalid none"></div>
                    <div class="invalid-feedback" v-for="error in this.errorFor('invalid_credentials')" :key="error.id">{{ error }}</div>
                </div>

                <hr />

                <div>
                    No account yet?
                    <router-link :to="{name: 'register'}" class="font-weight-bold">Register</router-link>
                </div>

                <div>
                    Forgotten password?
                    <router-link :to="{name: 'home'}" class="font-weight-bold">Reset password</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'login',

        data() {
            return {
                email: null,
                password: null,
                loading: false,
                errors: {}

            }
        },
        methods: {
            errorFor(field) {
                return this.errors[field] ? this.errors[field] : null;
            },
            login() {
                this.loading = true
                this.errors = {};
                this.$store.dispatch('getToken', {
                    email: this.email,
                    password: this.password,
                })
                    .then(response => {
                        this.loading = false
                        this.$router.push({ name: 'home' })
                    })
                    .catch(error => {
                        if(error.response.data.errors){
                            this.errors = error.response.data.errors;            console.log(this.errors);
                            console.log(this.errorFor('name'));
                        } else {
                            this.errors.invalid_credentials = [error.response.data.message];
                            console.log(this.errorFor('invalid_credentials'));
                        }
                    }).finally(() =>{
                        this.loading = false;
                })
            }
        }
    }
</script>
