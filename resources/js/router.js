import { createRouter, createWebHistory } from 'vue-router';
// import Home from './components/Home.vue';
// import Dashboard from './components/Dashboard.vue';
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
import Forbidden from './components/Forbidden.vue';
import axios from 'axios';


// Define your routes
const routes = [
    //   { path: '/', component: Home },
    // {
    //     path: '/dashboard',
    //     component: Dashboard,
    //     meta: { requiresAuth: true }
    // },
    {
        path: '/',
         name: 'login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/register',
        component: Register,
        meta: { requiresAuth: false }
    },
    {
        path: '/userlist',
        name: 'userlist',
        component: UserList,
        meta: { requiresAuth: true },

    },

    {
        path: '/rolelist',
        name: 'rolelist', component: RoleList,
        meta: { requiresAuth: true }
    },
    {
        path: '/createrole',
        name: 'createrole',
        component: CreateRole,
        meta: { requiresAuth: true }
    },
    {
        path: '/createuser',
        name: 'createuser',
        component: CreateUser, meta:
            { requiresAuth: true }
    },

    {
        path: "/users/edit/:userId",
        name: "EditUser",
        component: EditUser,
        props: true,
        meta: { requiresAuth: true },
        beforeEnter: (to, from, next) => {

          if (to.query.fromButton) {
            next();
          } else {
            next({ name: "Forbidden" });
          }
        },
      },


    {
        path: "/users/view/:userId",
        name: "ViewUser",
        component: ViewUser,
        props: true,
        meta: { requiresAuth: true },
        beforeEnter: (to, from, next) => {

          if (to.query.fromButton) {
            next();
          } else {
            next({ name: "Forbidden" });
          }
        },
      },
    {
        path: "/createfeature",
        name: "CreateFeature",
        component: CreateFeature,
        meta: { requiresAuth: true }

    },



    {
        path: "/modulepermission",
        name: "ModulePermission",
        component: ModulePermission,
        meta: { requiresAuth: true },

    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Forbidden',
        component: Forbidden,
    },




];


const router = createRouter({
    history: createWebHistory(),
    routes,
});


async function fetchUser() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
        console.warn('No token found.');
        return null;
    }

    try {
        const response = await axios.get('http://127.0.0.1:8000/api/user', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        // console.log('User fetched successfully:', response.data);
        return response.data;
    } catch (error) {
        console.error('Failed to fetch user:', error.response?.data || error.message);
        return null;
    }
}


router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('auth_token'); // Check for token
    let user = null;

    if (token) {
        console.log('Token:', token);
        try {
            user = await fetchUser(); // Fetch user details if token exists
            // console.log('User:', user);
        } catch (error) {
            console.error("Error fetching user:", error);
            // Handle token expiry or fetch failure here, e.g., clearing token
            localStorage.removeItem('auth_token');
        }
    }

    // Redirect to login if authentication is required but user is not authenticated
    if (to.meta.requiresAuth && !user) {
        return next('/');
    }

    if (user) {
        if (
            (to.path === '/' || to.path === '/register' ||
            to.path === '/userlist' || to.path === '/rolelist' ||
            to.path === '/createuser' || to.path === '/createrole' ||
            to.path === '/createfeature' ) && user.id !== 1
        ) {

            return next('/modulepermission');
        } else if (
            (to.path === '/' || to.path === '/register' || to.path === '/modulepermission') &&
            user.id === 1
        ) {

            return next('/userlist');
        }
    }


    next();
});


export default router;






