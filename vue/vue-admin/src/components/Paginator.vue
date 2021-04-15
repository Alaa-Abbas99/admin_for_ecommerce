<template>
   <div>

        <nav>
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" @click="previous">Previous</a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" @click="next">Next</a>
                </li>
            </ul>
        </nav>

   </div>

</template>

<script>
import { ref } from "vue";




export default {
    name: "Paginator",
    emits: ['page-changed'],
    props: {
        lastPage: Number
    },
    setup(props, {emit}) {
       const page = ref(1);
        const next = async () =>{
            if(page.value === props.lastPage) return;

            page.value++;
            emit('page-changed', page.value);
            
        }

        const previous = async () =>{
            if(page.value === 1) return;

            page.value--;
            emit('page-changed', page.value);
    
        }
       
        

       return{
         
           next,
           previous,
           
       }
       
    }
}
</script>