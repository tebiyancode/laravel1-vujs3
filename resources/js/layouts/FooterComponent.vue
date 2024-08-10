<script setup>
import { ref } from "vue";
const setting = JSON.parse(localStorage.getItem("setting"));
</script>
<template>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div v-if="setting" class="copyright text-center my-auto">
                <span>Copyright &copy; {{ setting.name }} 2024</span>
            </div>
        </div>
    </footer>
</template>
