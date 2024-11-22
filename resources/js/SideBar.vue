<template>
    <div>
         <!-- Sidebar -->
      <aside
        id="sidebar"
        class="sidebar bg-primary text-light vh-100 shadow-sm"
        style="min-width: 250px;"
      >
        <ul class="nav flex-column pt-3" id="sidebar-nav">
          <!-- Dashboard -->
          <li class="nav-item">
            <router-link class="nav-link text-light" to="/dashboard">
              <i class="bi bi-grid me-2"></i> Dashboard
            </router-link>
          </li>

          <!-- Components -->
          <li class="nav-item">
            <a
              class="nav-link text-light collapsed"
              data-bs-toggle="collapse"
              href="#components-nav"
              role="button"
              aria-expanded="false"
              aria-controls="components-nav"
            >
              <i class="bi bi-menu-button-wide me-2"></i> Components
              <i class="bi bi-chevron-down float-end"></i>
            </a>
            <!-- <div class="collapse" id="components-nav">
              <ul class="nav flex-column ms-3">
                <li>
                  <a class="nav-link text-light" href="components-alerts.html">
                    <i class="bi bi-circle me-2"></i>Alerts
                  </a>
                </li>
                <li>
                  <a class="nav-link text-light" href="components-accordion.html">
                    <i class="bi bi-circle me-2"></i>Accordion
                  </a>
                </li>
                <li>
                  <a class="nav-link text-light" href="components-badges.html">
                    <i class="bi bi-circle me-2"></i>Badges
                  </a>
                </li>
              </ul>
            </div> -->
          </li>

          <!-- More sections here... -->

          <!-- Pages -->
          <li class="nav-heading mt-3 px-3 text-light fw-bold">Pages</li>
          <!-- <li class="nav-item">


            <router-link class="nav-link text-light" to="/register">
              <i class="bi bi-person me-2"></i> Register
            </router-link>

          </li> -->
          <li class="nav-item">
            <router-link class="nav-link text-light" to="/">
                <i class="bi bi-box-arrow-in-right me-2"></i> Logout
            </router-link>



          </li>
        </ul>
      </aside>

      <!-- Main Content -->
    </div>
</template>

<script>
    export default {
        name:'SideBar',
    }
</script>

<style >
     body {
    margin: 0;
    font-family: Arial, sans-serif;
  }
  .sidebar {
    position: sticky;
    top: 0;
    overflow-y: auto;
  }
  .sidebar .nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
  }
</style>
