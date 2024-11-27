import { createRouter, createWebHistory } from 'vue-router'; // Use Vue 3's router API
// import Home from './components/Home.vue';
import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import UserList from './components/UserList.vue';
import RoleList from './components/RoleList.vue';
import CreateRole from './components/CreateRole.vue';
import CreateUser from './components/CreateUser.vue';
import EditUser from './components/EditUser.vue';
import ViewUser from './components/ViewUser.vue';
import CreateFeature from './components/CreateFeature.vue';
import ModulePermission from './components/ModulePermission.vue';

// Define your routes
const routes = [
//   { path: '/', component: Home },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', component: Register },
  { path: '/userlist', name: 'userlist', component: UserList },
  { path: '/rolelist', name: 'rolelist', component: RoleList },
  { path: '/createrole', name: 'createrole', component: CreateRole },
  { path: '/createuser', name: 'createuser', component: CreateUser },
  {
    path: "/users/edit/:userId",
    name: "EditUser",
    component: EditUser,
    props: true, // Enable route params as props
  },
  {
    path: "/users/view/:userId",
    name: "ViewUser",
    component: ViewUser,
    props: true, // Enable route params as props
  },
  {
    path: "/createfeature",
    name: "CreateFeature",
    component: CreateFeature,

  },
  {
    path: "/modulepermission",
    name: "ModulePermission",
    component: ModulePermission,

  },


];

// Create the router instance
const router = createRouter({
  history: createWebHistory(), // Use history mode for clean URLs
  routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("auth_token");

    if (to.meta.requiresAuth && !token) {
        next("/login"); // Redirect to login if not authenticated
    } else {
        next(); // Allow navigation
    }
});


export default router;

// Navigation guard for authentication
// router.beforeEach((to, from, next) => {
//   const isAuthenticated = !!localStorage.getItem('auth_token');
//   if (to.meta.requiresAuth && !isAuthenticated) {
//     next('/login');
//   } else {
//     next();
//   }
// });


