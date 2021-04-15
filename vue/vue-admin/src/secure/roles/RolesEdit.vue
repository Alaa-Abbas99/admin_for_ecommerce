<template>

  
    <div >
        <form  @submit.prevent="submit">
            <label for="name" class="visually-hidden">Role Name</label>
            <input type="text" id="name" class="form-control" placeholder="Role Name" required v-model="name" >

            <div class="form-check form-check-inline col-3" v-for="permission in permissions" :key="permission.id" >
                <input type="checkbox" class="form-check-input" value="permission.id" @change="select(permission.id, $event.target.checked)" :checked="checked(permission.id)" />
                <label class="form-check-label"> {{permission.name}}</label>
            </div>
                

            <button class="btn btn-primary" type="submit"> Save </button>
        </form>
    </div>

  

</template>

<script lang="ts">
import {ref, onMounted} from "vue";
import axios from "axios";
import {useRouter, useRoute} from "vue-router";
// eslint-disable-next-line no-unused-vars
import { Role } from '../../classes/role';



export default {
    name: "RolesEdit",
  
    setup(){
        const name = ref('');
        const permissions = ref([]);
        const selected = ref([] as number [])
        const {params} = useRoute();

        const router = useRouter();

        onMounted(async () => {
            
                const response = await axios.get('/permissions');
                permissions.value = response.data.data;
                
                const roleCall = await axios.get('/roles/'+params.id);
                const role: Role = roleCall.data.data;
                

                name.value = role.name;
                selected.value = role.permissions.map(p => p.id);
            
        });

        const select = ( id: number, checked: boolean) => {
            if(checked){
                selected.value = [...selected.value, id];
                return;
            }

            selected.value = selected.value.filter(s => s !== id);
        }

        const checked = (id: number) => selected.value.some(s => s ===id );

        const submit = async () => {
              await axios.put('roles/'+params.id, {
               name: name.value,
               permissions: selected.value,

            });

    

            await router.push('/roles');
        }

        return{
            name,
          
            permissions,
           
            checked,
            select,
            submit,   
        };
  }
}
</script>