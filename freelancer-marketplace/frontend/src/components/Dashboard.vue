<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const logout = () => {
  localStorage.removeItem("token");
  router.push("/login");
};
</script>

<template>
  <div>
    <h2>Dashboard</h2>
    <button @click="logout">Logout</button>
  </div>
</template>
