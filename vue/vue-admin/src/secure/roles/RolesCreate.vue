<template>

  
    <div >
        <form  @submit.prevent="submit">
            <label for="name" class="visually-hidden">Role Name</label>
            <input type="text" id="name" class="form-control" placeholder="Role Name" required v-model="name" >

            <div class="form-check form-check-inline col-3" v-for="permission in permissions" :key="permission.id">
                <input type="checkbox" class="form-check-input" value="permission.id" @change="select(permission.id, $event.target.checked)" />
                <label class="form-check-label"> {{permission.name}}</label>
            </div>
                

            <button class="btn btn-primary" type="submit"> Save </button>
        </form>
    </div>

  

</template>

<script lang="ts">
import {ref, onMounted} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";



export default {
    name: "RolesCreate",
  
    setup(){
        const name = ref('');
        const permissions = ref([]);
        const selected = ref([] as number [])
        

        const router = useRouter();

        onMounted(async () => {
            
                const response = await axios.get('/permissions');
                permissions.value = response.data.data;
               
            
        });

        const select = ( id: number, checked: boolean) => {
            if(checked){
                selected.value = [...selected.value, id];
                return;
            }

            // selected.value = selected.value.filter(s => s !== id);
        }


        const submit = async () => {
              await axios.post('roles', {
               name: name.value,
               permissions: selected.value,

            });

    

            await router.push('/roles');
        }

        return{
            name,
            select,
            permissions,
            submit,   
        };
  }
}
</script>