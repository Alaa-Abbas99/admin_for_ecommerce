<template>
   <div>
       <div class="d-flex justify-content-between flew-wrap lfex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <div class="btn-tollbar mb-2 mb-md-0" v-if="myuser.role.name === 'admin'">
               <router-link to="/users/create" class="btn btn-outline-secondary">Add</router-link>
           </div>
       </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>email</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{user.id}}</td>
                <td>{{user.first_name}} {{user.last_name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.role.name}}</td>
                <td>
                    <div class="btn-group mr-2" v-if="myuser.role.name === 'admin'" >
                        <router-link :to="'/users/'+ user.id +'/edit'" class="btn btn-outline-secondary"> Edit </router-link>
                        
                        <a href="javascript:void(0)" class="btn btn-danger" @click="del(user.id)"> Delete </a>
                    </div>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>

      
      <Paginator :lastPage="lastPage" @page-changed="load($event)"/>
   </div>

</template>

<script>
import { ref, onMounted, computed } from "vue";
import axios from 'axios';


import Paginator from '../../components/Paginator.vue';
import { useStore } from 'vuex';


export default {
  components: { Paginator },
    name: "Users",
    setup() {
       const users = ref([]);
       const lastPage = ref(null);

       const store = useStore();
       const myuser = computed(()=> store.state.User.user);
       

       
        const load = async (page) => {
          const res = await axios.get('/users?page='+page);
          users.value = res.data.data;
          lastPage.value = res.data.meta.last_page;
          
        }

      

         const del =  async (id) =>{
              
              if(confirm('Are you sure you want to delete?')){
                  await axios.delete('/users/'+id);

                  users.value = users.value.filter((e) => e.id !==id)
              }
        }

       onMounted(load);       


      return{
          lastPage,
          load,
          users,
          myuser,
          del,           
      }
       
    }
}
</script>