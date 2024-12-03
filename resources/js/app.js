// import './bootstrap';



  import { createApp } from 'vue';
  import "bootstrap/dist/css/bootstrap.min.css";
  import 'bootstrap-icons/font/bootstrap-icons.css';
  import 'bootstrap/dist/js/bootstrap.bundle.js';


  import App from './App.vue';
  import router from './router'; // Import the router

  // Create the Vue app and use the router
  createApp(App).use(router).mount('#app');
