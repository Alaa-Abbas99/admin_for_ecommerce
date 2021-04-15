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
import {useRouter, useRoute} from "vue-router";
// eslint-disable-next-line no-unused-vars
import {User} from "../../classes/user";


export default {
    name: "UserUpdate",
   
    setup(){
        const firstName = ref('');
        const lastName = ref('');
        const email = ref('');
        const roleId = ref(0); 
        const roles = ref([]);
        const {params} = useRoute();
        const router = useRouter();

        onMounted(async () => {
                const response = await axios.get('/roles');
                roles.value = response.data.data;

                const userCall = await axios.get('/users/'+params.id);
                const user: User = userCall.data.data;
                console.log(user);
                firstName.value = user.first_name;
                lastName.value = user.last_name;
                email.value = user.email;
                roleId.value = user.role.id;
            
        });

        const submit = async () => {
             const res = await axios.put('/users/'+params.id, {
                first_name: firstName.value,
                last_name: lastName.value,
                email: email.value,
                password: "password",
                role_id: roleId.value,
            });

            console.log(res);

            await router.push('/users');
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