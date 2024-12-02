<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow-lg">
            <div class="card-header text-center bg-success text-white">
              <h2>Register</h2>
            </div>
            <div class="card-body">
              <form @submit.prevent="register">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    v-model="name"
                    type="text"
                    id="name"
                    class="form-control"
                    placeholder="Enter your full name"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    v-model="email"
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="Enter your email"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    v-model="password"
                    type="password"
                    id="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirm Password</label>
                  <input
                    v-model="password_confirmation"
                    type="password"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Confirm your password"
                    required
                  />
                </div>
                <div class="d-flex justify-content-center">
                <button  class="btn btn-success w-30" >Register</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center">
              <small class="text-muted">Already have an account?
                <router-link class="text-success" to="/login">Login</router-link>
                 .</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";

  export default {
    name: "Register",
    data() {
      return {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      };
    },
    methods: {
      async register() {
        try {
          await axios.post("http://127.0.0.1:8000/api/register", {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
          alert("Registration successful!");
          this.name = '';
          this.email='';
          this.password='';
          this.password_confirmation='';

          this.$router.push("/");

        } catch (error) {
          console.error(error.response.data);
        }
      },
    },
  };
  </script>
