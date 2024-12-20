<template>
    <div class="d-flex flex-column flex-md-row" style="height: 130vh;">
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
                    @change="fetchPermissions"
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
                      <tr v-for="rolefeature in rolefeatures" :key="rolefeature.id">
                        <td class="text-center">{{ rolefeature.name }}</td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(rolefeature.create)"
                            @change="togglePermission(rolefeature.create)"
                          />
                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(rolefeature.view)"
                            @change="togglePermission(rolefeature.view)"
                          />
                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(rolefeature.update)"
                            @change="togglePermission(rolefeature.update)"
                          />

                        </td>
                        <td class="text-center">
                          <input
                            type="checkbox"
                            :checked="hasPermission(rolefeature.delete)"
                            @change="togglePermission(rolefeature.delete)"
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
import { mapActions, mapState, mapGetters } from "vuex/dist/vuex.cjs.js";

export default {
  name: "RoleList",
  components: {
    SideBar,
  },
  data() {
  return {
    selectedRoleId: "",

  };
},
    computed:{
        ...mapState(["roles","rolefeatures","selectedPermissions"]),
        ...mapGetters( ["selectedPermissions"]),
        },

  methods: {
    ...mapActions(["fetchRoles", "fetchModules"]),

    fetchPermissions() {
    this.$store.dispatch("fetchRolePermissions", this.selectedRoleId);
  },

    hasPermission(permissionId) {
      return this.selectedPermissions.includes(permissionId);
    },

    togglePermission(permissionId) {
      const index = this.selectedPermissions.indexOf(permissionId);
      if (index === -1) {
        this.selectedPermissions.push(permissionId);
      } else {
        this.selectedPermissions.splice(index, 1);
      }
      console.log("Updated Permissions:", this.selectedPermissions);
    },

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

    resetForm() {
      this.selectedRoleId = null;
      this.selectedPermissions = [];
    },
  },
  mounted() {
    this.fetchRoles();
    this.fetchModules();
  },
};
</script>
