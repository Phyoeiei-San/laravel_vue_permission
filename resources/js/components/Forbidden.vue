<template>
    <div class="d-flex align-items-center justify-content-center vh-300 bg-light">
  <div
    class="text-center mx-5 mb-3 "
    style="width: 1200px; "
  >
    <h1 class="display-1 text-danger fw-bold">403</h1>
    <h2 class="h4 text-secondary">Access Denied</h2>
    <p class="text-muted">You are not allowed to access this page.</p>
    <router-link to="/">
      <button class="btn btn-primary btn-lg mt-3">Go Back to Dashboard</button>
    </router-link>
  </div>
</div>

  </template>

  <script>
  export default {
    name: "Forbidden",
  };
  </script>

  <style scoped>

  .bg-light {
    background-color: #f8f9fa !important;
  }



  .expanded-width {
  width: 600px;
}

  </style>
