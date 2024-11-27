<template>
    <div class="container mt-5">
      <!-- Card for Modules and Permissions -->
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-1">Modules and Permissions</h5>
          <!-- Greeting with Role -->
          <p class="mb-0">
            Hello, <span class="fw-bold">{{ userName }}</span>! Your Role:
            <span class="badge bg-light text-dark">{{ userRole }}</span>
          </p>
        </div>

        <div class="card-body">
          <!-- Table of Modules and Permissions -->
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th class="text-center">Module Name</th>
                  <th class="text-center">Permissions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(module, index) in modules" :key="index">
                  <td class="text-center fw-bold text-capitalize">
                    {{ module.module_name }}
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center flex-wrap">
                      <span v-for="(permission, i) in module.permissions" :key="i" class="m-1">
                        <button class="btn btn-outline-primary btn-sm">
                          {{ permission }}
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";

  export default {
    name: "ModulePermission",
    data() {
      return {
        modules: [], // Holds modules and permissions
        userName: "", // Holds authenticated user's name
        userRole: "", // Holds authenticated user's role
      };
    },
    methods: {
      async fetchModules() {
        try {
          const token = localStorage.getItem("auth_token"); // Retrieve token from localStorage
          const response = await axios.get("http://127.0.0.1:8000/api/modules", {
            headers: {
              Authorization: `Bearer ${token}`, // Add Authorization header
            },
          });

          this.modules = response.data.modules; // Assign modules to state
          this.userName = response.data.user.name; // Assign authenticated user's name to state
          this.userRole = response.data.role_name; // Assign authenticated user's role name to state
        } catch (error) {
          console.error("Error fetching modules:", error.response?.data || error);
          alert("Failed to fetch modules. Please ensure you are logged in.");
        }
      },
    },
    mounted() {
      this.fetchModules(); // Fetch modules on component mount
    },
  };
  </script>

  <style scoped>
  /* Additional styling for responsive design */
  .table td,
  .table th {
    vertical-align: middle;
  }

  .badge {
    font-size: 1rem;
  }

  .table td button {
    padding: 0.4rem 0.8rem;
  }
  </style>
