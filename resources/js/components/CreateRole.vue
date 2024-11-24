<template>
   <div class="d-flex">
  <!-- Sidebar -->
  <SideBar />
  <!-- Main Content -->
  <div class="flex-grow-1 p-4 w-100">
    <div class="card shadow-lg ">
      <div class="card-header bg-primary text-white text-center">
        <h3>Create Role</h3>
      </div>
      <div class="card-body">

        <div class="container-fluid" style="width:600px; margin:0px auto">
          <!-- Role Input -->
          <form @submit.prevent="createRole">
  <!-- Role Input -->
  <div class="form-group mb-4">
    <label for="name" class="form-label">Role</label>
    <input type="text" v-model="role.name" id="name" class="form-control" placeholder="Enter role name">
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
        <tr>
          <td class="text-center">User</td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(1)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(2)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(3)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(4)"></td>
        </tr>
        <tr>
          <td class="text-center">Product</td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(5)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(6)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(7)"></td>
          <td class="text-center"><input type="checkbox" @change="togglePermission(8)"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Action Buttons -->
  <div class="form-group text-center">
    <button type="submit" class="btn btn-success btn-lg mx-2">Save</button>
    <button type="reset" class="btn btn-secondary btn-lg mx-2">Cancel</button>
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
import SideBar from '../SideBar.vue';
export default {
    name: 'CreateRole',
        components: {
        SideBar
    },
  data() {
    return {
      role: {
        name: "",
        permissions: []
      }
    };
  },
  methods: {
    togglePermission(permissionId) {
      const index = this.role.permissions.indexOf(permissionId);
      if (index === -1) {
        this.role.permissions.push(permissionId);
      } else {
        this.role.permissions.splice(index, 1);
      }
    },
    async createRole() {
      try {
        const response = await axios.post("http://127.0.0.1:8000/api/roles", this.role);
        alert(response.data.message);
        this.resetForm();
      } catch (error) {
        console.error(error.response.data);
        alert("Error creating role.");
      }
    },
    resetForm() {
      this.role.name = "";
      this.role.permissions = [];
    }
  }
};
</script>


<style lang="scss" scoped>

</style>
