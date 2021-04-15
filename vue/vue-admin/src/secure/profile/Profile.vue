<template>

  
    <div >
        <h2>Account Information</h2>
        <form  @submit.prevent="submitInfo" class="mb-4">
            <label for="first_name" class="visually-hidden">First Name</label>
            <input type="text" id="first_name" class="form-control" placeholder="First Name" required v-model="firstName" >

            <label for="last_name" class="visually-hidden">Last Name</label>
            <input type="text" id="last_name" class="form-control" placeholder="Last Name" required v-model="lastName"> 

            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required v-model="email">

            <button class="btn btn-primary mt-2" type="submit"> Update Info </button>
        </form>

         <h2>Change Password</h2>
         <form  @submit.prevent="submitPass">
            <label for="first_name" class="visually-hidden">Password</label>
            <input type="text" id="password" class="form-control" placeholder="password" required v-model="password" >

            <label for="password_confirm" class="visually-hidden">Password Confirm</label>
            <input type="text" id="password_confirm" class="form-control" placeholder="password_confirm" required v-model="password_confirm"> 
            
            <button class="btn btn-primary mt-2" type="submit"> Update Password </button>
        </form>
    </div>

  

</template>

<script lang="ts">
import {ref} from "vue";
import { onMounted , computed } from "vue";
import axios from "axios";
import {useStore} from "vuex";


// eslint-disable-next-line no-unused-vars
import {User} from "../../classes/user";


export default {
    name: "Profile",
   
    setup(){
        const firstName = ref('');
        const lastName = ref('');
        const email = ref('');
        const password = ref('');
        const password_confirm = ref('');
        const store = useStore();

        onMounted(async () => {

               
                const userCall = computed( () => store.state.User.user);
                const user = userCall.value;
                console.log(user);
                firstName.value = user.first_name;
                lastName.value = user.last_name;
                email.value = user.email;
            
        });

        const submitInfo = async () => {
              const res = await axios.put('/users/info', {
                first_name: firstName.value,
                last_name: lastName.value,
                email: email.value,
            });

            const u: User = res.data;

           await  store.dispatch('User/setUser', new User(
              u.id,
              u.first_name,
              u.last_name,
              u.email,
              u.role,
              u.permissions
            ));

    
        }


            const submitPass = async () => {
              await axios.put('/users/password', {
                password: password.value,
                password_confirm: password_confirm.value,
            });

            password.value = '';
            password_confirm.value = '';

        }

        return{
            firstName,
            lastName,
            email,
            password,
            password_confirm,
            submitInfo, 
            submitPass,
        
        };
  }
}
</script>