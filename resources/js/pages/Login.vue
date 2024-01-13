<script setup>
import { ref } from "vue";
const email = ref("");
const password = ref("");
const ruleEmail=ref([
        v => !!v || 'Email is required',

      ]);
const rulePassword=ref([
        v => !!v || 'password is required',
        v => (v && v.length <= 8) || 'Name must be less than 8 characters',
      ]);
const Login = () => {
  if (email.value === "" || password.value === "") {
    alert("Please fill all fields");
  } else {
    axios
      .post("/login", {
        email: email.value,
        password: password.value,
      })
      .then((res) => {
        if (res.data.status === 200) {
          localStorage.setItem("token", res.data.access_token);
          window.location.href = "/admin";
        } else {
          alert(res.data.message);
        }
      })
      .catch((err) => {
        alert(err.response.data.message);
      });
  }
};
</script>
<template>
    <!-- Outer Row -->
    <v-card
    class="mx-auto"
    width="400"
    prepend-icon="mdi-home"
  >
    <template v-slot:title>
        {{ $t('Login In') }}
    </template>

    <v-card-text>
        <v-sheet max-width="300" class="mx-auto">
    <v-form validate-on="submit lazy" @submit.prevent="Login()">
      <v-text-field
      variant="solo"
        v-model="email"
        :rules="ruleEmail"
        :label="$t('email')"
        type="email"
      ></v-text-field>
      <v-text-field
      variant="solo"
        v-model="password"
        :rules="rulePassword"
        :label="$t('password')"
        type="password"
      ></v-text-field>
      <v-btn type="submit" block class="mt-2">{{ $t('Login In') }}</v-btn>
    </v-form>
    <div class="d-flex flex-column">
        <router-link  to="/forgot-password">
        <v-btn type="submit" block class="mt-2"  color="warning" >{{ $t('Forgot Password') }}</v-btn>
    </router-link>
      <router-link  to="/register">
      <v-btn type="submit" block class="mt-2  " color="success" >{{ $t('Create an Account') }}</v-btn>
                     </router-link>





      </div>


  </v-sheet>
    </v-card-text>
  </v-card>
    
</template>
