<template>
    <div class="container mt-5">
      <!-- Card for Modules and Permissions -->
      <div class="card shadow-lg">
        <!-- Header Section -->
        <div class="card-header bg-primary text-white text-center d-flex justify-content-between align-items-center py-3">
          <div class="">
            <h5 class="mb-1">Modules and Permissions</h5>
            <p class="mb-0">
              Hello, <span class="fw-bold">{{ userName }}</span>! Your Role:
              <span class="badge bg-light text-dark">{{ userRole }}</span>
            </p>
          </div>
          <button type="button" class="btn btn-outline-light btn-sm" @click="logout">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
          </button>
        </div>

        <!-- Body Section -->
        <div class="card-body">
          <!-- Table of Modules and Permissions -->
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-primary text-center">
                <tr>
                  <th scope="col">Module Name</th>
                  <th scope="col">Permissions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(module, index) in modules" :key="index">
                  <td class="text-center fw-bold text-capitalize">
                    {{ module.module_name }}
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                      <span v-for="(permission, i) in module.permissions" :key="i">
                        <button class="btn btn-sm btn-outline-primary" disabled>
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
      async logout() {
        try {
          const token = localStorage.getItem("auth_token");
          await axios.post(
            "http://127.0.0.1:8000/api/logout",
            {},
            {
              headers: { Authorization: `Bearer ${token}` },
            }
          );

          localStorage.removeItem("auth_token");
          this.$router.push("/login");
        } catch (error) {
          console.error("Logout failed:", error);
        }
      },
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
  .table td,
  .table th {
    vertical-align: middle;
  }

  .card-header {
    border-bottom: none;
  }

  .badge {
    font-size: 0.9rem;
  }

  .table td button {
    padding: 0.3rem 0.8rem;
  }

  .table th {
    text-transform: uppercase;
  }

  .card {
    border-radius: 0.5rem;
  }

  .card-body {
    padding: 1.5rem;
  }
  </style>
