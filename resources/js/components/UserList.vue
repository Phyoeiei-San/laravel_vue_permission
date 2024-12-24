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
        <button class="btn btn-secondary text-white btn-sm mx-3 mb-3" @click="search">Search</button>
        <button class="btn btn-danger text-white btn-sm mb-3" @click="toggleFilter">Filter</button>
      </div>

      <div v-if="showFilter" class="card mb-3 p-3">
        <div class="row">
         <div class="col-md-6">
        <label for="nameFilter">Name</label>
        <select
            id="nameFilter"
            class="form-control"
            v-model="filterName"
        >
            <option value="">Select Name</option>
            <option v-for="user in users" :key="user.id" :value="user.name">
            {{ user.name }}
            </option>
        </select>
        </div>

          <div class="col-md-6">
            <label for="roleFilter">Role</label>
            <select
              id="roleFilter"
              class="form-control"
              v-model="filterRole"
            >
              <option value="">Select Role</option>
              <option v-for="role in roles" :key="role.id" :value="role.name">
                {{ role.name }}
              </option>
            </select>
          </div>
        </div>
      </div>

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
             <tbody v-if="paginatedUsers && paginatedUsers.length > 0">
                <tr v-for="(user, index) in paginatedUsers" :key="index">
                  <td>{{ index + 1 }}</td>
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
                    <button @click="goToEdit(user.id)" class="btn btn-success btn-sm me-2">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm me-2" @click="deleteUser(user.id)">
                      <i class="fas fa-trash-alt"></i> Delete
                    </button>
                    <button @click="goToView(user.id)" class="btn btn-primary btn-sm me-2">
                      View
                    </button>
                  </td>
                </tr>
              </tbody>
              <div v-else class="d-flex justify-content-center align-items-center bg-light mx-5 mt-3" style="height: 100px; width: 500%;">
                <h2 class="text-center text-danger">No Staff List Found !...</h2>
              </div>
            </table>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation">
            <ul class="pagination">
            <li
                class="page-item"
                :class="{ disabled: currentPage === 1 }"
                @click="changePage(currentPage - 1)"
            >
                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
            </li>
            <li
                class="page-item"
                v-for="page in totalPages"
                :key="page"
                :class="{ active: currentPage === page }"
                @click="changePage(page)"
            >
                <a class="page-link" href="#">{{ page }}</a>
            </li>
            <li
                class="page-item"
                :class="{ disabled: currentPage === totalPages }"
                @click="changePage(currentPage + 1)"
            >
                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
            </li>
            </ul>
        </nav>
        </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import SideBar from "../SideBar.vue";
import { mapState, mapActions } from "vuex/dist/vuex.cjs.js";

export default {
  name: "UserList",
  components: {
    SideBar,
  },
  data() {
    return {
      searchKey: "",
      showFilter: false,
      filterName: "",
      filterRole: "",
      currentPage: 1,
     itemsPerPage: 5,

    };
  },
  computed: {
    ...mapState(["users", "roles"]),
   filteredUsers() {
    return this.users.filter(user => {
      const matchesName = this.filterName ? user.name === this.filterName : true;
      const matchesRole = this.filterRole ? (user.roles && user.roles.name === this.filterRole) : true;
      return matchesName && matchesRole;
    });
  },
  paginatedUsers() {
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    return this.filteredUsers.slice(startIndex, endIndex);
  },
  totalPages() {
    return Math.ceil(this.filteredUsers.length / this.itemsPerPage);
  },
  },
  methods: {
    ...mapActions(["fetchUsers", "fetchRoles"]),

    toggleFilter() {
      this.showFilter = !this.showFilter;
    },
     changePage(page) {
    if (page >= 1 && page <= this.totalPages) {
      this.currentPage = page;
    }
  },

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
          await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);
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
      this.$store.dispatch("Search", this.searchKey);
    },
  },
  mounted() {
    this.fetchUsers();
    this.fetchRoles();
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
