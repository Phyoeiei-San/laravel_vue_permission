<template>
    <div class="d-flex">
         <!-- Sidebar -->
      <aside
        id="sidebar"
        class="sidebar bg-primary text-light vh-100 shadow-sm d-none d-lg-block"
        style="min-width: 250px;"
      >
        <ul class="nav flex-column pt-3" id="sidebar-nav">
          <!-- Dashboard -->
          <li class="nav-item">
            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#userListsNav"
            data-bs-toggle="collapse"
            to="#"
            >
            <i class="bi bi-grid me-2" style="color: white;"></i>
            <span class="text-white">Staff Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>
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
        </ul>
    </li>

    <li class="nav-item">

            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#roleListNav"
            data-bs-toggle="collapse"
            to=""
            >
            <i class="bi bi-menu-button-wide me-2"  style="color: white;"></i>
            <span class="text-white">Role Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>

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
        </ul>
    </li>

    <li class="nav-item">
            <router-link
            class="nav-link collapsed d-flex align-items-center"
            data-bs-target="#moduleList"
            data-bs-toggle="collapse"
            to=""
            >
            <i class="bi bi-menu-button-wide me-2"  style="color: white;"></i>
            <span class="text-white">Module Lists</span><i class="bi bi-chevron-down ms-auto" style="color: white;"></i>
            </router-link>

        <ul id="moduleList" class="nav-content collapse" data-bs-parent="#sidebar-nav">

        <li>
        <router-link class="nav-link" to="/createfeature">
        <i class="bi bi-grid me-2" style="color: white;"></i><span class="text-white">Create Module</span>
        </router-link>
        </li>
        </ul>
    </li>

          <li class="nav-item" >

           <button type="submit" class="nav-link text-light" @click="logout">
           <i class="bi bi-box-arrow-in-right me-2"></i> Logout
           </button>
          </li>
        </ul>
      </aside>

      <div
        class="offcanvas offcanvas-start bg-primary text-light"
        tabindex="-1"
        id="mobileSidebar"
      >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title text-white">Menu</h5>
          <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>
        <div class="offcanvas-body">
          <ul class="nav flex-column" id="sidebar-nav">
            <!-- Same sidebar content as the desktop version -->
            <li class="nav-item">
              <router-link class="nav-link" to="/userlist">
                <i class="bi bi-person-plus-fill me-2" style="color: white;"></i
                ><span class="text-white">View Staff Lists</span>
              </router-link>
            </li>
            <li>
                <router-link class="nav-link" to="/createuser">
                  <i class="bi bi-person-plus-fill me-2" style="color: white;"></i
                  ><span class="text-white">Create Staff</span>
                </router-link>
              </li>
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
            <li>
            <router-link class="nav-link" to="/createfeature">
            <i class="bi bi-grid me-2" style="color: white;"></i><span class="text-white">Create Module</span>
            </router-link>
            </li>
            <li class="nav-item" >

            <button type="submit" class="nav-link text-light" @click="logout">
            <i class="bi bi-box-arrow-in-right me-2"></i> Logout
            </button>
            </li>
          </ul>
        </div>
      </div>

      <!-- Main Content -->
      <main class="flex-grow-1 p-3">
        <button
          class="btn btn-primary d-lg-none mb-3"
          data-bs-toggle="offcanvas"
          data-bs-target="#mobileSidebar"
        >
          <i class="bi bi-list"></i> Menu
        </button>
        <slot></slot>
      </main>
    </div>
  </template>

<script>
    import axios from 'axios';
    export default {
        name:'SideBar',
        methods: {
            async logout() {
                try {
                    const token = localStorage.getItem('auth_token');
                    await axios.post('http://127.0.0.1:8000/api/logout', {}, {
                        headers: { Authorization: `Bearer ${token}` },
                    });

                    localStorage.removeItem('auth_token');
                    this.$router.push('/');
                } catch (error) {
                    console.error('Logout failed:', error);
                }
        }

        },
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
