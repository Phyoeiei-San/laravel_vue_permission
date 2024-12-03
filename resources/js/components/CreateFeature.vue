<template>
    <div class="d-flex flex-column flex-md-row h-100" style="width: 1200px;">
      <!-- Sidebar -->
      <SideBar />

      <!-- Main Content -->
      <div class="container-fluid p-6 flex-grow-1 ">
        <div class="row g-4 mt-3">
          <!-- Create/Edit Module Card -->
          <div class="col-md-5">
            <div class="card shadow-lg  ">
              <div class="card-header bg-primary text-white text-center">
                <h3>{{ editMode ? "Edit Module" : "Create Module" }}</h3>
              </div>
              <div class="card-body">
                <form @submit.prevent="editMode ? updateModule() : saveModule()">
                  <!-- Module Name Input -->
                  <div class="mb-3 ">
                    <label for="name" class="form-label">Module Name</label>
                    <input
                      type="text"
                      id="name"
                      class="form-control"
                      v-model="feature.name"
                      placeholder="Enter Module Name"
                    />
                    <small class="text-danger" v-if="validation.nameStatus">
                      Module Name is required
                    </small>
                  </div>

                  <!-- Action Buttons -->
                  <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-success px-4">
                      {{ editMode ? "Update" : "Save" }}
                    </button>
                    <button type="reset" class="btn btn-secondary px-4" @click="resetForm">
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Module List Table -->
          <div class="col-md-7">
            <div class="card shadow-lg h-100">
              <div class="card-header bg-primary text-white text-center">
                <h3>Module List</h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-secondary">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Module Name</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
                </thead>
            <tbody>
            <tr v-for="(feature, index) in features" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ feature.name }}</td>
                <td class="text-center">
                <button class="btn btn-sm btn-success me-2" @click="editModule(feature)">
                    Edit
                </button>
                <button class="btn btn-sm btn-danger" @click="deleteModule(feature.id)">
                    Delete
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
      </div>
    </div>
  </template>
<script>
import axios from "axios";
import SideBar from "../SideBar.vue";

export default {
  name: "CreateFeature",
  components: {
    SideBar,
  },
  data() {
    return {
      feature: {
        id: null,
        name: "",
      },
      features: [],
      editMode: false,
      validation: {
        nameStatus: false,
      },
    };
  },
  methods: {
    async saveModule() {
      this.validation.nameStatus = !this.feature.name;

      if (this.validation.nameStatus) {
        return;
      }

      try {
        await axios.post("http://127.0.0.1:8000/api/features", this.feature);
        alert("Module created successfully!");
        this.resetForm();
        this.getModules();
      } catch (error) {
        console.error(error.response.data);
        alert("Failed to create module.");
      }
    },
    async updateModule() {
      this.validation.nameStatus = !this.feature.name;

      if (this.validation.nameStatus) {
        return;
      }

      try {
        await axios.put(`http://127.0.0.1:8000/api/features/${this.feature.id}`, this.feature);
        alert("Module updated successfully!");
        this.resetForm();
        this.getModules();
      } catch (error) {
        console.error(error.response.data);
        alert("Failed to update module.");
      }
    },
    async deleteModule(id) {
      if (confirm("Are you sure you want to delete this module?")) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/features/${id}`);
          alert("Module deleted successfully!");
          this.getModules();
        } catch (error) {
          console.error(error.response.data);
          alert("Failed to delete module.");
        }
      }
    },
    editModule(feature) {
      this.editMode = true;
      this.feature = { ...feature };
    },
    resetForm() {
      this.editMode = false;
      this.feature = { id: null, name: "" };
      this.validation.nameStatus = false;
    },
    async getModules() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/features");
        this.features = response.data.features;
      } catch (error) {
        console.error("Error fetching features:", error);
      }
    },
  },
  mounted() {
    this.getModules();
  },
};
</script>
