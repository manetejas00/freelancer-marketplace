<script setup>
import { ref, onMounted } from "vue";
import api from "../api";

const jobs = ref([]);
const showModal = ref(false);
const newJob = ref({ title: "", description: "", budget: "", category: "" });

const fetchJobs = async () => {
  const response = await api.get("/jobs");
  jobs.value = response.data;
};

const postJob = async () => {
  await api.post("/jobs", newJob.value);
  fetchJobs();
  showModal.value = false;
};

onMounted(fetchJobs);
</script>

<template>
  <div>
    <button @click="showModal = true">Add Job</button>

    <div v-if="showModal" class="modal">
      <input v-model="newJob.title" placeholder="Title" />
      <input v-model="newJob.description" placeholder="Description" />
      <input v-model="newJob.budget" type="number" placeholder="Budget" />
      <input v-model="newJob.category" placeholder="Category" />
      <button @click="postJob">Post Job</button>
      <button @click="showModal = false">Close</button>
    </div>

    <ul>
      <li v-for="job in jobs" :key="job.id">
        <h3>{{ job.title }}</h3>
        <p>{{ job.description }}</p>
        <p>Budget: ${{ job.budget }}</p>
        <p>Category: {{ job.category }}</p>
      </li>
    </ul>
  </div>
</template>

<style>
.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  padding: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}
</style>
