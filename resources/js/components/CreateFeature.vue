<template>
    <div class="d-flex" style="height: 100vh;">
      <!-- Sidebar -->
      <SideBar />

      <div class="flex-grow-1 p-4">
        <div class="card shadow-lg h-100">
          <div class="card-header bg-primary text-white text-center">
            <h3>Create Module</h3>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="container-fluid" style="width:600px; margin:0px auto">
              <form @submit.prevent="saveModule">
                <!-- Name Input -->
                <div class="mb-3">
                  <label for="name" class="form-label">Module Name</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="feature.name"
                    placeholder="Enter Module Name"
                  />
                  <small class="text-danger" v-if="validation.nameStatus">Module Name Is Required</small>
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
        name: 'CreateFeature',
        components: {
        SideBar,
    },
    data() {
        return {
            feature : {
                name: "",

            },
            validation: {
          nameStatus: false,

        },
        }
    },
    methods: {
        async saveModule() {

        this.validation.nameStatus = !this.feature.name;


        if (this.validation.nameStatus)
         {
          return;
        }

        try {
          const response = await axios.post("http://127.0.0.1:8000/api/features", this.feature);
          alert("Module created successfully!");


            this.feature.name= "";

          this.validation.nameStatus = false;

        } catch (error) {
        console.error(error.response.data);
        alert('Failed');

      }
      },
    },
    }
</script>

<style lang="scss" scoped>

</style>
