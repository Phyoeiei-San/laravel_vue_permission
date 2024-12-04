<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
              <h2>Login</h2>
            </div>
            <div class="card-body">
              <div v-if="message.text" :class="message.type === 'success' ? 'alert alert-success' : 'alert alert-danger'" role="alert">
                {{ message.text }}
              </div>
              <form @submit.prevent="login">
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
                  <small class="text-danger" v-if="validation.emailStatus">Email is required</small>
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
                  <small class="text-danger" v-if="validation.passwordStatus">Password is required</small>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary w-30">Login</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center">
              <small class="text-muted">
                Don't have an account?
                <router-link class="text-primary" to="/register">Register</router-link>.
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";

  export default {
    name: "Login",
    data() {
      return {
        email: "",
        password: "",
        message: {
          text: "",
          type: "",
        },
        validation: {
          emailStatus: false,
          passwordStatus: false,
        },
      };
    },
    methods: {
      async login() {
        // Validate input fields
        this.validation.emailStatus = !this.email;
        this.validation.passwordStatus = !this.password;
        if (this.validation.emailStatus || this.validation.passwordStatus) {
          return;
        }

        try {
          const response = await axios.post("http://127.0.0.1:8000/api/login", {
            email: this.email,
            password: this.password,
          });

          // Save the authentication token to localStorage
          const token = response.data.token;
          localStorage.setItem("auth_token", token);

          // Extract the user's ID
          const userId = response.data.user.id;

          // Display success message
          this.message.text = "Login successful!";
          this.message.type = "success";

          // Clear the fields
          this.email = "";
          this.password = "";

          // Redirect based on user ID
          setTimeout(() => {
            if (userId === 1) {
              this.$router.push("/userlist");
            } else {
              this.$router.push("/modulepermission");
            }
          }, 1500);
        } catch (error) {
          console.error("Login failed:", error);


          this.message.text = "Login failed. Please check your credentials.";
          this.message.type = "error";
        }
      },
    },
  };
  </script>
