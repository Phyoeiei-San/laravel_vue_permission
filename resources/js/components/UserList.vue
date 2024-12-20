<template>

    <div class="d-flex flex-column flex-md-row h-100" style="width: 1400px;">
      <!-- Sidebar -->
      <SideBar />

      <!-- Main Content -->
      <div class="flex-grow-1 p-4 bg-light">
        <div class="d-flex col-12 justify-content-end mb-1">
          <div class="col-3">
            <input
              type="text"
              class="form-control mb-3"
              v-model="searchKey"
              v-on:keyup.enter="search"
              placeholder="Search staffs..."
            />
          </div>
          <button class="btn btn-dark text-white btn-sm mx-3 mb-3" @click="search">Search</button>
        </div>
        <div class="card shadow ">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center">Staff List</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive ">
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
                <tbody v-if="users && users.length > 0">
                <!-- <tbody v-if="users.length > 0"> -->
                  <tr v-for="(user,index) in users" :key="index">
                    <td>{{ index+1 }}</td>
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
                      <button
                        @click="goToView(user.id)"
                        class="btn btn-primary btn-sm me-2"
                    >
                        View
                    </button>
                    </td>
                  </tr>
                </tbody>
                <div v-else
                    class="d-flex justify-content-center align-items-center bg-light mx-5 mt-3"
                    style="height: 100px; width: 500%;"
                >
                    <h2 class="text-center text-danger ">No Staff List Found !...</h2>
                </div>
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
  import { mapState, mapActions, mapGetters } from "vuex/dist/vuex.cjs.js";

  export default {
    name: "UserList",
    components: {
      SideBar,
    },
    data() {
      return {
        searchKey: "",
      };
    },
    computed: {
      ...mapGetters(["StoresearchUser"]),
        ...mapState(["users"])

    },

    methods: {
        ...mapActions(["fetchUsers"]),

        goToEdit(userId) {
            this.$router.push({
                name: "EditUser",
                params: { userId },
                query: { fromButton: true },
            });
            },
        goToView(userId) {
            this.$router.push({
                name: "ViewUser",
                params: { userId },
                query: { fromButton: true },
            });
            },

      async deleteUser(userId) {

            if (confirm("Are you sure you want to delete this user?")) {
            try {
                const response = await axios.delete(
                `http://127.0.0.1:8000/api/users/${userId}`
                );
                alert("User deleted successfully!");
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
        search() {

            this.$store.dispatch("Search",this.searchKey);
      },


    },
    mounted() {
        this.fetchUsers();
        },

        watch: {
        searchKey(newSearchKey) {
            if (!newSearchKey.trim()) {
            this.fetchUsers();
            }
        },
        },

    };
  </script>

