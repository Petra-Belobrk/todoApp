<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                            type="text"
                            name="name"
                            placeholder="Enter your name"
                            class="form-control"
                            v-model="user.name"
                            :class="[{'is-invalid': errorFor('name')}]"
                    />
                    <div class="invalid-feedback" v-for="error in this.errorFor('name')" :key="error.id">{{ error }}</div>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                            type="text"
                            name="email"
                            placeholder="Enter your e-mail"
                            class="form-control"
                            v-model="user.email"
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
                            v-model="user.password"
                            :class="[{'is-invalid': errorFor('password')}]"
                    />
                    <div class="invalid-feedback" v-for="error in this.errorFor('password')" :key="error.id">{{ error }}</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Re-type Password</label>
                    <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            class="form-control"
                            v-model="user.password_confirmation"
                            :class="[{'is-invalid': errorFor('password_confirmation')}]"
                    />
                    <div class="invalid-feedback" v-for="error in this.errorFor('password_confirmation')" :key="error.id">{{ error }}</div>

                </div>

                <button
                        type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        :disabled="loading"
                        @click.prevent="register"
                >Register</button>

                <hr />

                <div>
                    Already have an account?
                    <router-link :to="{name: 'login'}" class="font-weight-bold">Log-in</router-link>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

    export default {

        data() {
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                },
                loading: false,
                errors: {}
            };
        },
        methods: {
            errorFor(field) {
                return this.errors[field] ? this.errors[field] : null;
            },
            register() {
                this.loading = true;
                axios.post('/api/register', {
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password,
                    password_confirmation: this.user.password_confirmation
                })
                    .then(response => {
                        this.$router.push({ name: 'login' })
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                    .finally(() =>{
                        this.loading = false;
                })

            }
        },
    };
</script>
