<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../api";

const router = useRouter();
const name = ref("");
const email = ref("");
const password = ref("");
const message = ref("");

const register = async () => {
  try {
    await api.post("/register", { name: name.value, email: email.value, password: password.value });
    router.push("/login");
  } catch (error) {
    message.value = error.response.data.message;
  }
};
</script>

<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input v-model="name" type="text" placeholder="Name" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>
