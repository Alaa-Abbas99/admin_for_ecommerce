<template>
   <div>
       <div class="d-flex justify-content-between flew-wrap lfex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <div class="btn-tollbar mb-2 mb-md-0">
              <a href="javascript:void(0)" class="btn btn-sm btn-primary" @click="exportFile"> Export</a>
           </div>
       </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>email</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <td>{{order.id}}</td>
                <td>{{order.first_name}} {{order.last_name}}</td>
                <td>{{order.email}}</td>
                <td>{{order.total}}</td>
                <td>
                    <div class="btn-group mr-2">
                        <router-link :to="'/orders/'+ order.id" class="btn btn-outline-secondary"> View </router-link>
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
import { ref, onMounted } from "vue";
import axios from 'axios';
 // eslint-disable-next-line no-unused-vars
import { Entity } from "../../interfaces/entity";
import Paginator from '../../components/Paginator.vue';


export default {
  components: { Paginator },
    name: "Orders",
    setup() {
       const orders = ref([]);
       const lastPage = ref(null);

    
        const load = async (page) => {
          const res = await axios.get('/orders?page='+page);
          orders.value = res.data.data;
          lastPage.value = res.data.meta.last_page;
        }

        const exportFile = async () => {
            const res = await axios.get('/export', {responseType: 'blob'});
             // eslint-disable-next-line no-unused-vars
            const blob = new Blob( [res.data], {type: 'text/csv'});
            const downloadUrl = window.URL.createObjectURL(res.data);
            const link = document.createElement('a');
            link.href= downloadUrl;
            link.download = 'orders.csv';
            link.click();
        }


       onMounted(load);
       
        

       return{
           lastPage,
           load,
           orders,
           exportFile,
           
       }
       
    }
}
</script>