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
  <!-- Dropdown Menu for User Lists -->
            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#userListsNav"
            data-bs-toggle="collapse"
            to="#"
            >
            <i class="bi bi-grid me-2" style="color: white;"></i>
            <span class="text-white">Staff Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>

  <!-- Collapsed Menu for User Lists -->
        <ul id="userListsNav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
        <router-link class="nav-link" to="/userlist">
        <i class="bi bi-person-plus-fill me-2" style="color: white;"></i><span class="text-white">View Staff Lists</span>
        </router-link>
        </li>
        <li>
        <router-link class="nav-link" to="/createuser">
        <i class="bi bi-person-plus-fill me-2" style="color: white;"></i><span class="text-white">Create Staff</span>
        </router-link>
        </li>
    <!-- Add more user-related items here -->
        </ul>
    </li>

    <li class="nav-item">
  <!-- Dropdown Menu for User Lists -->
            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#roleListNav"
            data-bs-toggle="collapse"
            to=""
            >
            <i class="bi bi-menu-button-wide me-2"  style="color: white;"></i>
            <span class="text-white">Role Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>

  <!-- Collapsed Menu for User Lists -->
        <ul id="roleListNav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
        <router-link class="nav-link" to="/rolelist">
        <i class="bi bi-person-plus-fill me-2" style="color: white;"></i><span class="text-white">View Role List</span>
        </router-link>
        </li>
        <li>
        <router-link class="nav-link" to="/createrole">
        <i class="bi bi-person-plus-fill me-2" style="color: white;"></i><span class="text-white">Create Role</span>
        </router-link>
        </li>
    <!-- Add more user-related items here -->
        </ul>
    </li>

    <li class="nav-item">
  <!-- Dropdown Menu for Module Lists -->
            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#moduleList"
            data-bs-toggle="collapse"
            to=""
            >
            <i class="bi bi-menu-button-wide me-2"  style="color: white;"></i>
            <span class="text-white">Module Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>

  <!-- Collapsed Menu for User Lists -->
        <ul id="moduleList" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <!-- <li>
        <router-link class="nav-link" to="#">
        <i class="bi bi-person-plus-fill me-2" style="color: white;"></i><span class="text-white">View Module List</span>
        </router-link>
        </li> -->
        <li>
        <router-link class="nav-link" to="/createfeature">
        <i class="bi bi-grid me-2" style="color: white;"></i><span class="text-white">Create Module</span>
        </router-link>
        </li>
    <!-- Add more user-related items here -->
        </ul>
    </li>



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

  .nav-link {
    font-size: 16px;
    display: flex;
    align-items: center;
  }

  .nav-content .nav-link {
    font-size: 14px;
  }

  .dropdown-menu {
    border-radius: 0.375rem; /* Rounded corners for dropdown */
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
  }


</style>
