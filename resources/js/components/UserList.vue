<template>
    <div class="d-flex">
      <!-- Sidebar -->
      <SideBar />

      <!-- Main Content -->
      <div class="flex-grow-1 p-4 bg-light">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center">Staff List</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="example"
                class="table table-striped table-hover table-bordered text-center align-middle w-100"
              >
                <thead>
                  <tr>
                    <th style="width: 5%;">Id</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 15%;">Phone</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 20%;">Address</th>
                    <th style="width: 10%;">Roles</th>
                    <th style="width: 10%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.phone_no }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.address }}</td>
                    <td>
                      <span v-if="user.roles" class="badge bg-info text-dark">
                        {{ user.roles.name }}
                      </span>
                      <span v-else class="text-muted">No Role</span>
                    </td>
                    <td class="d-flex justify-content-center">

                      <!-- <router-link
                        :to="{ name: 'EditUser', params: { userId: user.id } }"
                        class="btn btn-success btn-sm me-2"
                      >
                        <i class="fas fa-edit"></i> Edit
                      </router-link> -->
                      <button
                        @click="goToEdit(user.id)"
                         class="btn btn-success btn-sm me-2"
                    >
                        Edit
                    </button>
                      <button
                        class="btn btn-danger btn-sm me-2"
                        @click="deleteUser(user.id)">
                        <i class="fas fa-trash-alt"></i> Delete
                        </button>
                        <!-- <router-link
                        :to="{ name: 'ViewUser', params: { userId: user.id } }"
                        class="btn btn-primary btn-sm me-2"
                      >
                      <i class="fas fa-eye"></i> View
                      </router-link> -->
                      <button
                        @click="goToView(user.id)"
                        class="btn btn-primary btn-sm me-2"
                    >
                        View
                    </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";
  import SideBar from "../SideBar.vue";

  export default {
    name: "UserList",
    components: {
      SideBar,
    },
    data() {
      return {
        users: [],
      };
    },
    methods: {
        goToEdit(userId) {
            this.$router.push({
                name: "EditUser",
                params: { userId },
                query: { fromButton: true }, // Pass a query parameter for validation
            });
            },
            goToView(userId) {
            this.$router.push({
                name: "ViewUser",
                params: { userId },
                query: { fromButton: true }, // Pass a query parameter for validation
            });
            },
      async fetchUsers() {
            try {
            const token = localStorage.getItem('auth_token');
            const response = await axios.get("http://127.0.0.1:8000/api/users",

            {headers: { Authorization: `Bearer ${token}` },
        });
            this.users = response.data.users;
            } catch (error) {
            console.error(error);
            }
        },
      async deleteUser(userId) {
            // Confirm deletion
            if (confirm("Are you sure you want to delete this user?")) {
            try {
                // Send DELETE request
                const response = await axios.delete(
                `http://127.0.0.1:8000/api/users/${userId}`
                );
                alert("User deleted successfully!");
                // Refresh the user list
                this.fetchUsers();
            } catch (error) {
                console.error("Error deleting user:", error);
                alert(
                "Failed to delete user: " +
                    (error.response?.data?.message || "An unknown error occurred.")
                );
            }
            }
        },
            },
            mounted() {
            this.fetchUsers();
            },
        };
  </script>
