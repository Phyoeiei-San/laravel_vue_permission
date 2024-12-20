<template>

 <div class="d-flex flex-column flex-md-row" style="height: 130vh;">
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
                <small class="text-danger" v-if="validation.roleNameStatus"> Role Name is Required !</small>
            </div>

            <!-- Permissions Table -->
            <div class="form-group mb-4">
                <h5>Permissions</h5>
                <small class="text-danger" v-if="validation.permissionsStatus">At least one permission is required!</small>
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
                <tr v-for="feature in features" :key="feature.id">
                    <td class="text-center">{{ feature.name }}</td>
                    <td class="text-center">
                    <input
                        type="checkbox"
                        :checked="role.permissions.includes(feature.id * 4 - 3)"
                        @change="togglePermission(feature.id * 4 - 3)"
                    />
                    </td>
                    <td class="text-center">
                    <input
                        type="checkbox"
                        :checked="role.permissions.includes(feature.id * 4 - 2)"
                        @change="togglePermission(feature.id * 4 - 2)"
                    />
                    </td>
                    <td class="text-center">
                    <input
                        type="checkbox"
                        :checked="role.permissions.includes(feature.id * 4 - 1)"
                        @change="togglePermission(feature.id * 4 - 1)"
                    />
                    </td>
                    <td class="text-center">
                    <input
                        type="checkbox"
                        :checked="role.permissions.includes(feature.id * 4)"
                        @change="togglePermission(feature.id * 4)"
                    />
                    </td>
                </tr>
                </tbody>


            </table>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-success btn-lg mx-2">Save</button>
                <button type="reset"  @click="resetForm" class="btn btn-secondary btn-lg mx-2">Cancel</button>
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
        import { mapActions, mapState } from "vuex/dist/vuex.cjs.js";

        export default {
            name: 'CreateRole',
                components: {
                SideBar
            },
        data() {
            return {
            role: {
                name: "",
                permissions: [],

            },
            validation : {
                roleNameStatus: false,
                permissionsStatus: false,
            }
            };
        },
        computed:{
        ...mapState(["features"]),
        },

        methods: {
            ...mapActions(["getFeatures"]),

            togglePermission(permissionId) {
            const index = this.role.permissions.indexOf(permissionId);
            if (index === -1) {
                this.role.permissions.push(permissionId);
            } else {
                this.role.permissions.splice(index, 1);
            }

            },

        async createRole() {
        this.validation.roleNameStatus = !this.role.name;
        this.validation.permissionsStatus = this.role.permissions.length === 0;

       if (this.validation.roleNameStatus || this.validation.permissionsStatus) {
        return;
    }

    try {
        const response = await axios.post("http://127.0.0.1:8000/api/roles", this.role);
        alert(response.data.message);
        this.resetForm();
    } catch (error) {
        console.error(error.response.data);
        alert("This role already exists.");
    }
},

            resetForm() {
            this.role.name = "";
            this.role.permissions = [];
            }
        },
        mounted () {
            this.getFeatures();
        },
        };
        </script>


        <style lang="scss" scoped>

        </style>
