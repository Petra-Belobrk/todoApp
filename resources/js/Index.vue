<template>
    <div>
        <nav class="navbar d-flex flex-row bg-white border-bottom navbar-light">
            <router-link class="navbar-brand mr-auto" :to="{name:'home'}">ToDo</router-link>
            <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item m-2" v-if="!loggedIn"><router-link class="nav-link" :to="{ name: 'login' }">Login</router-link></li>
            <li class="nav-item m-2" v-if="!loggedIn"><router-link class="nav-link" :to="{ name: 'register' }">Register</router-link></li>
            <li class="nav-item m-2" v-if="loggedIn"><router-link class="nav-link" :to="{ name: 'logout' }">Logout</router-link></li>
            </ul>

        </nav>
        <div class="container mt-4 mb-4 pl-4 pr-4">
            <router-view></router-view>
        </div>

        <footer class="fixed-bottom card-footer bg-white border-top d-flex flex-row">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 footer-bottom">
                        <p>&copy; 5Ra 2020</p>
                    </div>

                    <div class="col-md-6 offset-md-1">
                        <a href="https://www.facebook.com/petra.belobrk/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.linkedin.com/in/petra-mlinarevic/"><i class="fab fa-linkedin"></i></a>
                        <a href="https://github.com/Petra-Belobrk"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
    computed: {
        ...mapGetters([
            'loggedIn'
        ])
    },

}


</script>
