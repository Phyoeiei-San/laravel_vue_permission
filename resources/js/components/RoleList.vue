
<template>
    <div class="d-flex">
      <!-- Sidebar -->
      <SideBar />

      <!-- Main Content -->
      <div class="flex-grow-1 p-4 w-100">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h3>Assign Role and Permissions</h3>
          </div>
          <div class="card-body">

            <div class="container-fluid" style="width:600px; margin:0px auto">
              <!-- Role Dropdown -->
              <form>
                <div class="form-group mb-4">
                  <label for="roleSelect" class="form-label">Select Role</label>
                  <select
                    id="roleSelect"
                    class="form-select"
                    v-model="selectedRoleId"
                    @change="fetchRolePermissions"
                  >
                    <option value="" disabled>Select a role</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                      {{ role.name }}
                    </option>
                  </select>
                </div>

                <!-- Permissions Table -->
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
                            @change="togglePermission(module.create)"
                          />
                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(module.view)"
                            @change="togglePermission(module.view)"
                          />
                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(module.update)"
                            @change="togglePermission(module.update)"
                          />
                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(module.delete)"
                            @change="togglePermission(module.delete)"
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Action Buttons -->
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-success btn-lg mx-2" @click.prevent="savePermissions">
                    Save
                  </button>
                  <button type="reset" class="btn btn-secondary btn-lg mx-2" @click="resetForm">
                    Cancel
                  </button>
                </div>
              </form>
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
    name: "RoleList",
    components: {
      SideBar,
    },
    data() {
      return {
        roles: [], // Roles fetched from the database
        selectedRoleId: "",
        selectedPermissions: [], // Permissions for the selected role
        modules: [

          {
            name: "User",
            create: 1,
            view: 2,
            update: 3,
            delete: 4,
          },
          {
            name: "Product",
            create: 5,
            view: 6,
            update: 7,
            delete: 8,
          },
        ],
      };
    },
    methods: {

    async fetchRoles() {
    try {
      const response = await axios.get("http://127.0.0.1:8000/api/roles");
      this.roles = response.data.roles; // Ensure roles data matches API response

    } catch (error) {
      console.error("Error fetching roles:", error);
    }
  },

      // Fetch permissions for the selected role
      async fetchRolePermissions() {
        if (!this.selectedRoleId) return;

        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/roles/${this.selectedRoleId}/permissions`
          );
          this.selectedPermissions = response.data.permissions.map(
            (permission) => permission.id
          );
        } catch (error) {
          console.error("Error fetching role permissions:", error);
        }
      },

      // Check if a permission is selected
      hasPermission(permissionId) {
        return this.selectedPermissions.includes(permissionId);
      },

      // Toggle permission selection
      togglePermission(permissionId) {
        const index = this.selectedPermissions.indexOf(permissionId);
        if (index === -1) {
          this.selectedPermissions.push(permissionId);
        } else {
          this.selectedPermissions.splice(index, 1);
        }
      },

      // Save updated permissions for the selected role
      async savePermissions() {
        if (!this.selectedRoleId) {
          alert("Please select a role!");
          return;
        }

        try {
          await axios.post(
            `http://127.0.0.1:8000/api/roles/${this.selectedRoleId}/permissions`,
            { permissions: this.selectedPermissions }
          );
          alert("Permissions updated successfully!");
        } catch (error) {
          console.error("Error saving permissions:", error);
        }
      },

      // Reset form
      resetForm() {
        this.selectedRoleId = null;
        this.selectedPermissions = [];
      },
    },
    mounted() {
      this.fetchRoles(); // Fetch roles on component mount
    },
  };
  </script>


<style lang="scss" scoped>

</style>
