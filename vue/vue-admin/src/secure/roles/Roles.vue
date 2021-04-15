<template>
   <div>
       <div class="d-flex justify-content-between flew-wrap lfex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <div class="btn-tollbar mb-2 mb-md-0"  v-if="user.canEdit('users')">
               <router-link to="/roles/create" class="btn btn-outline-secondary">Add</router-link>
           </div>
       </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="role in roles" :key="role.id">
                <td>{{role.id}}</td>
                <td>{{role.name}}</td>
                <td>
                    <div class="btn-group mr-2"  v-if="user.canEdit('users')">
                        <router-link :to="'/roles/'+ role.id +'/edit'" class="btn btn-outline-secondary"> Edit </router-link>
                        
                        <a href="javascript:void(0)" class="btn btn-danger" @click="del(role.id)"> Delete </a>
                    </div>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>

       <Paginator :lastPage="lastPage" @page-changed="load($event)"/>

   </div>

</template>

<script >
import { ref, onMounted } from "vue";
import axios from 'axios';
 // eslint-disable-next-line no-unused-vars
import { Entity } from "../../interfaces/entity";

import { useStore } from 'vuex';
import { computed } from "vue";

import Paginator from '../../components/Paginator.vue';


export default {
    components: { Paginator },
    name: "Roles",
    setup() {
       const roles = ref([]);
       const lastPage = ref(null);

       const store = useStore();

       const user = computed(()=> store.state.User.user);
      

        const load = async (page) => {
          const res = await axios.get('/roles?page='+page);
          roles.value = res.data.data;
          lastPage.value = res.data.meta.last_page;
        }

      

         const del =  async (id) =>{
              
              if(confirm('Are you sure you want to delete?')){
                  await axios.delete('/roles/'+id);

                  roles.value = roles.value.filter((e) => e.id !==id)
              }
        }

       onMounted(load);
       
        

       return{
           load,
           roles,
           del, user
       }
       
    }
}
</script>