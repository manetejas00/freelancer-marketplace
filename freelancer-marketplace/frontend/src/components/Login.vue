<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../api";

const router = useRouter();
const email = ref("");
const password = ref("");
const message = ref("");

const login = async () => {
  try {
    const response = await api.post("/login", { email: email.value, password: password.value });
    localStorage.setItem("token", response.data.token);
    router.push("/dashboard");
  } catch (error) {
    message.value = "Invalid credentials";
  }
};
</script>

<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>
