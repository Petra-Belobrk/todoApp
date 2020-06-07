import VueRouter from "vue-router";
import Tasks from "./components/Tasks";
import Task from "./components/Task";
import Logout from "././auth/Logout";

const routes = [
    {
        path: "/",
        component: Tasks,
        name: "home",
    },
    {
        path: "/login",
        component: require("./auth/Login").default,
        name: "login"
    },
    {
        path: "/register",
        component: require("./auth/Register").default,
        name: "register"
    },
    {
        path: "/task/:id",
        component: Task,
        name: "task",
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout
    }



];

const router = new VueRouter({
    routes,
    mode: "history",
});

export default router;
