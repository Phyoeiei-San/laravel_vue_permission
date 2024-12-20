import { createStore } from 'vuex';
import axios from "axios";

export const store = createStore({
    state:{
        users: [],
        roles: [],
        rolefeatures: [],
        features: [],
        selectedPermissions: [],
    },
    mutations :{
        fetchUsers(state, users) {
            state.users = users;
          },
          searchUser(state,users){
            state.users = users;
          },
          fetchRoles(state,roles){
            state.roles = roles;
          },
          fetchModules(state, rolefeatures){
            state.rolefeatures = rolefeatures;
          },
          SET_SELECTED_PERMISSIONS(state, permissions) {
            state.selectedPermissions = permissions;
          },
          getFeatures(state, features) {
            state.features = features;
          },

    },
    getters: {
        allUsers: (state) => state.users,
        selectedPermissions: (state) => state.selectedPermissions,

    },

    actions: {
        async fetchUsers({commit}) {
            try {
            const token = localStorage.getItem('auth_token');
            const response = await axios.get("http://127.0.0.1:8000/api/users",

            {headers: { Authorization: `Bearer ${token}` },
        });
            commit('fetchUsers', response.data.users);
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        },
        Search({commit},search){
            axios.post("http://127.0.0.1:8000/api/users/search",{
                key : search
            }).then(res=>{
                commit('searchUser',res.data.users);

            })

        },
        async fetchRoles({commit}) {
            try {
              const response = await axios.get("http://127.0.0.1:8000/api/roles");
            //   console.log('Response',response);
              commit('fetchRoles', response.data.roles);
            //   this.roles = response.data.roles;
            } catch (error) {
              console.error("Error fetching roles:", error);
            }
          },

          async fetchModules({commit}) {
              try {
                const response = await axios.get("http://127.0.0.1:8000/api/rolefeatures");
                // this.rolefeatures = response.data.rolefeatures;
                commit('fetchModules',response.data.rolefeatures);
              } catch (error) {
                console.error("Error fetching modules:", error);
              }
            },

            async fetchRolePermissions({ commit }, roleId) {
                if (!roleId) return;

                try {
                  const response = await axios.get(
                    `http://127.0.0.1:8000/api/roles/${roleId}/permissions`
                  );

                  const permissions = response.data.permissions.map((permission) => permission.id);
                //   console.log('Permission',permissions);

                  commit("SET_SELECTED_PERMISSIONS", permissions);
                } catch (error) {
                  console.error("Error fetching role permissions:", error);
                }
              },

              async getFeatures({commit}) {
                try {
                    const response = await axios.get("http://127.0.0.1:8000/api/features");
                    console.log("Fetched features:", response.data);
                    // this.features = response.data.features;
                    commit('getFeatures',response.data.features);
                } catch (error) {
                    console.error("Error fetching features:", error);
                }
                },

    },

});

export default store;


