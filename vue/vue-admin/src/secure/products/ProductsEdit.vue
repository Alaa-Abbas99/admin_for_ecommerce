<template>

  
    <div >
        <form  @submit.prevent="submit">
            <div class="form-group">
                <label for="title" class="visually-hidden">Name</label>
                <input type="text" name="title" class="form-control"  required v-model="title" >
            </div>
            
            <div class="form-group">
                <label for="title" class="visually-hidden">Description</label>
                <textarea name="description" class="form-control"  required v-model="description" ></textarea>
            </div>

             <div class="form-group">
                <label for="title" class="visually-hidden">Image</label>
                <input type="text" name="Image" class="form-control"  required v-model="image" >
                <ImageUpload @file-uploaded="image = $event" />
            </div>
                    
            <div class="form-group">
                <label for="title" class="visually-hidden">Price</label>
                <input type="number" name="price" class="form-control"  required v-model="price" >
            </div>
           

            <button class="btn btn-primary" type="submit"> Save </button>
        </form>
    </div>

  

</template>

<script lang="ts">
import {ref, onMounted} from "vue";
import axios from "axios";
import {useRouter, useRoute} from "vue-router";
import ImageUpload from '../../components/ImageUpload.vue';
 // eslint-disable-next-line no-unused-vars
import { Product } from '../../classes/product';



export default {
    name: "ProductsEdit",
    components: { ImageUpload },
    setup(){
        const title = ref('');
        const description = ref('');
        const image = ref('')
        const price = ref(0);
        

        const router = useRouter();
        const {params} =useRoute();

         onMounted( async () => {
            const response = await axios.get('/products/'+ params.id);
            const product: Product = response.data.data;

            title.value = product.title;
            description.value = product.description;
            image.value = product.image;
            price.value = product.price;

        });


        const submit = async () => {
              await axios.post('/products', {
               title: title.value,
               description: description.value,
               image: image.value,
               price: price.value,

            });

       

            await router.push('/products');
        }

        return{
            title,
            description,
            image,
            price, 
            submit,   
        };
  }
}
</script>