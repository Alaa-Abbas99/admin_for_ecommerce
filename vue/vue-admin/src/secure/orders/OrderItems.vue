<template>
   <div>
       
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Product Title</th>
                <th>Price</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="orderItem in orderItems" :key="orderItem.id">
                <td>{{orderItem.id}}</td>
                <td>{{orderItem.product_title}}</td>
                <td>{{orderItem.price}}</td>
                <td>{{orderItem.quantity}}</td>
              </tr>
              
            </tbody>
          </table>
        </div>



   </div>

</template>

<script lang="ts">
import { ref, onMounted } from "vue";
import axios from 'axios';
 // eslint-disable-next-line no-unused-vars
import { Entity } from "../../interfaces/entity";
import { useRoute } from 'vue-router';



export default {
  
    name: "OrderItems",
    setup() {
       const orderItems = ref([]);
       const {params} = useRoute();



       onMounted( async () => {
           const res = await axios.get('/orders/'+params.id);
           orderItems.value = res.data.data.order_items;
          
       });
       
        

       return{
           orderItems,
           
       }
       
    }
}
</script>