<template>
    <div class="d-flex" style="height: 100vh;">
      <SideBar />
      <div class="flex-grow-1 p-4">
        <div class="card shadow-lg h-100">
          <div class="card-header bg-primary text-white text-center">
            <h3>View Staff Details</h3>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="container-fluid" style="width:600px; margin:0 auto;">
                <div v-if="loading" class="text-center">
                <p>Loading user data...</p>
                </div>
                <div v-else>
              <form>
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="user.name" readonly
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input
                    type="email"
                    id="email"
                    class="form-control"
                    v-model="user.email" readonly
                  />
                </div>
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input
                    type="text"
                    id="address"
                    class="form-control"
                    v-model="user.address" readonly
                  />
                </div>
                <div class="mb-3">
                  <label for="phone_no" class="form-label">Mobile Number</label>
                  <input
                    type="text"
                    id="phone_no"
                    class="form-control"
                    v-model="user.phone_no" readonly
                  />
                </div>
                <div class="mb-3">
                  <label for="role_id" class="form-label">Role</label>
                  <select
                    class="form-control"
                    id="role_id"
                    v-model="user.role_id"
                    disabled
                    >
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{ role.name }}
                    </option>
                    </select>

                </div>

                <div class="form-group mb-4">
                  <h5>Permissions</h5>
                  <table class="table table-bordered table-hover table-fluid w-100">
                    <thead>
                      <tr>
                        <th class="text-center">Module</th>
                        <th class="text-center">Create</th>
                        <th class="text-center">View</th>
                        <th class="text-center">Update</th>
                        <th class="text-center">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
  <tr v-for="module in modules" :key="module.name">
    <td class="text-center">{{ module.name }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        :checked="hasPermission(module.create)"
        disabled
      />
    </td>
    <td class="text-center">
      <input
        type="checkbox"
        :checked="hasPermission(module.view)"
        disabled
      />
    </td>
    <td class="text-center">
      <input
        type="checkbox"
        :checked="hasPermission(module.update)"
        disabled
      />
    </td>
    <td class="text-center">
      <input
        type="checkbox"
        :checked="hasPermission(module.delete)"
        disabled
      />
    </td>
  </tr>
</tbody>

                  </table>
                </div>

              </form>
              </div>
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
  name: "ViewUser",
  components: {
    SideBar,
  },
  props: ["userId"],
  data() {
    return {
      user: this.defaultUser(),
      roles: [],
      loading: true,
      modules: [], // Modules fetched dynamically
      selectedPermissions: [], // Permissions for the selected role
    };
  },
  methods: {
    defaultUser() {
      return {
        name: "",
        email: "",
        selectedRoleId: "",
        address: "",
        phone_no: "",
        role_id: null,
      };
    },
    async fetchUser() {
      try {
        console.log("Fetching user for ID:", this.userId);
        const response = await axios.get(
          `http://127.0.0.1:8000/api/users/${this.userId}`
        );
        console.log("Fetched user:", response.data);
        this.user = response.data.user || this.defaultUser();
      } catch (error) {
        console.error("Error fetching user:", error);
      } finally {
        this.loading = false;
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/roles");
        this.roles = response.data.roles;
      } catch (error) {
        console.error("Error fetching roles:", error);
      }
    },
    async fetchModules() {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/modules");
    this.modules = response.data.modules;
  } catch (error) {
    console.error("Error fetching modules:", error);
  }
},
async fetchRolePermissions() {
    try {
      const response = await axios.get(
        `http://127.0.0.1:8000/api/users/${this.user.role_id}/permissions`
      );
      console.log("Fetched Permissions for Role:", response.data.permissions);

      // Update selectedPermissions with permissions for the role
      this.selectedPermissions = response.data.permissions;

      console.log("Selected Permissions:", this.selectedPermissions);
    } catch (error) {
      console.error("Error fetching role permissions:", error);
    }
  },
  hasPermission(permissionId) {
    // Check if a permission exists in the selectedPermissions array
    return this.selectedPermissions.includes(permissionId);
  },


    // Toggle the permission for add/remove
    togglePermission(permissionId) {
      const index = this.selectedPermissions.indexOf(permissionId);
      if (index === -1) {
        this.selectedPermissions.push(permissionId);
      } else {
        this.selectedPermissions.splice(index, 1);
      }
      console.log("Updated Permissions:", this.selectedPermissions);
    },



  },
  mounted() {
    // console.log("User ID:", this.userId);
    this.fetchUser();
    this.fetchRoles();
    this.fetchModules();

    this.$watch(
    () => this.user.role_id,
    (newRoleId) => {
      if (newRoleId) {
        this.fetchRolePermissions();
      }
    });
  },
}


  </script>
  <style>
  input[type="checkbox"]:checked {
  background-color: blue; /* Blue background for checked state */
  border-color: blue;     /* Blue border for consistency */
}



</style>
