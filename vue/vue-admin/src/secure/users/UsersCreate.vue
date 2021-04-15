
<template>

  
    <div >
        <form  @submit.prevent="submit">
            <label for="first_name" class="visually-hidden">First Name</label>
            <input type="text" id="first_name" class="form-control" placeholder="First Name" required v-model="firstName" >

            <label for="last_name" class="visually-hidden">Last Name</label>
            <input type="text" id="last_name" class="form-control" placeholder="Last Name" required v-model="lastName"> 

            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required v-model="email">

            <label>Role</label>
            <select name="role_id" class="form-control" v-model="roleId">
                <option value="0">Select Role </option>
                <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{role.name}}
                </option>
            </select>

            <button class="btn btn-primary" type="submit"> Save </button>
        </form>
    </div>

  

</template>

<script lang="ts">
import {ref} from "vue";
import { onMounted } from "vue";
import axios from "axios";
import {useRouter} from "vue-router";


export default {
    name: "UsersCreate",
  
    setup(){
        const firstName = ref('');
        const lastName = ref('');
        const email = ref('');
        const roleId = ref(0); 
        const roles = ref([]);

        const router = useRouter();

        onMounted(async () => {
            
                const response = await axios.get('/roles');
                roles.value = response.data.data;
            
        });

        const submit = async () => {
             const res = await axios.post('users', {
                first_name: firstName.value,
                last_name: lastName.value,
                email: email.value,
                password: "password",
                role_id: roleId.value
            });

            console.log(res);

            await router.push('/');
        }

        return{
            firstName,
            lastName,
            email,
            roleId,
            roles,
            submit, 
        
        };
  }
}
</script>