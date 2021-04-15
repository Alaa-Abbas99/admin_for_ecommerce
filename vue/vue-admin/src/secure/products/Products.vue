<template>
   <div>
      
        <div class="d-flex justify-content-between flew-wrap lfex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <div class="btn-tollbar mb-2 mb-md-0" v-if="user.canEdit('users')">
               <router-link to="/products/create" class="btn btn-outline-secondary">Add</router-link>
           </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>{{product.id}}</td>
                <td> <img :src="product.image" height="50" ></td>
                <td>{{product.title}}</td>
                <td>{{product.description}}</td>
                <td>{{product.price}}</td>
                <td v-if="user.canEdit('users')">
                        <router-link :to="'/products/'+ product.id +'/edit'" class="btn btn-outline-secondary"> Edit </router-link>    
                        <a href="javascript:void(0)" class="btn btn-danger" @click="del(product.id)"> Delete </a>

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
import Paginator from '../../components/Paginator.vue';
import { useStore } from 'vuex';
import { computed } from "vue";

export default {
  components: { Paginator },
    name: "Products",
    setup() {
       const products = ref([]);
       const lastPage = ref(null);

       const store = useStore();
       const user = computed(()=> store.state.User.user);


        const load = async (page) => {
          const res = await axios.get('/products?page='+page);
          products.value = res.data.data;
          lastPage.value = res.data.meta.last_page;
        }

         const del =  async (id) =>{
              
              if(confirm('Are you sure you want to delete?')){
                  await axios.delete('/products/'+id);

                  products.value = products.value.filter((e) => e.id !==id)
              }
        }

       onMounted(load);
       
        

       return{
           load,
           products,
           lastPage,
           del, 
            user
       }
       
    }
}
</script>