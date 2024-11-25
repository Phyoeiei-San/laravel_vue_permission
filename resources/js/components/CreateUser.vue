<template>
    <div class="d-flex" style="height: 130vh;">
      <!-- Sidebar -->
      <SideBar />

      <div class="flex-grow-1 p-4">
        <div class="card shadow-lg h-100">
          <div class="card-header bg-primary text-white text-center">
            <h3>Add Staff</h3>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="container-fluid" style="width:600px; margin:0px auto">
              <form @submit.prevent="saveUser">
                <!-- Name Input -->
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="user.name"
                    placeholder="Enter staff's full name"
                  />
                  <small class="text-danger" v-if="validation.nameStatus">Name Is Required</small>
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input
                    type="email"
                    id="email"
                    class="form-control"
                    v-model="user.email"
                    placeholder="Enter staff's email"
                  />
                  <small class="text-danger" v-if="validation.emailStatus">Email Is Required</small>
                </div>

                <!-- Address Input -->
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input
                    type="text"
                    id="address"
                    class="form-control"
                    v-model="user.address"
                    placeholder="Enter staff's address"
                  />
                  <small class="text-danger" v-if="validation.addressStatus">Address Is Required</small>
                </div>

                <!-- Mobile Number Input -->
                <div class="mb-3">
                  <label for="mobile" class="form-label">Mobile Number</label>
                  <input
                    type="tel"
                    id="mobile"
                    class="form-control"
                    v-model="user.phone_no"
                    placeholder="Enter mobile number"
                  />
                  <small class="text-danger" v-if="validation.mobileStatus">Phone_no Is Required</small>
                </div>

                <!-- Role Dropdown -->
                <div class="mb-3">
                  <label for="roleid" class="form-label">Staff Role</label>
                  <select
                    class="form-control"
                    id="roleid"
                    v-model="user.role_id"
                    @change="validateRole"
                  >

                    <option value="" disabled>Select a role</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                      {{ role.name }}
                    </option>

                  </select>
                  <small class="text-danger" v-if="validation.roleStatus">Role Is Required</small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3 mt-auto">
                  <button type="submit" class="btn btn-success btn-lg">
                    Save
                  </button>
                  <button type="reset" class="btn btn-secondary btn-lg">
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
    name: "CreateUser",
    components: {
      SideBar,
    },
    data() {
      return {
        user: {
          name: "",
          email: "",
          address: "",
         phone_no: "",
          role_id: "",
        },
        roles: [],
        validation: {
          nameStatus: false,
          emailStatus: false,
          addressStatus: false,
          mobileStatus: false,
          roleStatus: false,
        },
      };
    },
    mounted() {
      this.fetchRoles();
    },
    methods: {
      async fetchRoles() {
        try {
          const response = await axios.get("http://127.0.0.1:8000/api/roles");
          this.roles = response.data.roles;
        } catch (error) {
          console.error("Error fetching roles:", error);
        }
      },
      validateRole() {
      // Check if a role is selected
      this.validation.roleStatus = this.user.role_id === "";
    },
      async saveUser() {
        this.validateRole();
        this.validation.nameStatus = !this.user.name;
        this.validation.emailStatus = !this.user.email;
        this.validation.addressStatus = !this.user.address;
        this.validation.mobileStatus = !this.user.phone_no;
        // this.validation.roleStatus = !this.user.role_id;

        if (this.validation.nameStatus || this.validation.emailStatus || this.validation.addressStatus ||
            this.validation.mobileStatus || this.validation.roleStatus)
         {
          return;
        }

        try {
          const response = await axios.post("http://127.0.0.1:8000/api/users", this.user);
          alert("User created successfully!");
          // Reset form
          this.user = {
            name: "",
            email: "",
            address: "",
            phone_no: "",
            role_id: "",
          };
          this.validation.nameStatus = false;
          this.validation.emailStatus = false;
          this.validation.addressStatus = false;
          this.validation.mobileStatus = false;
          this.validation.roleStatus = false;
        } catch (error) {
        console.error(error.response.data);

      }
      },
    },
  };
  </script>
