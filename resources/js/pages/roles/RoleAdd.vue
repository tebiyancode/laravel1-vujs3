<script setup>
import { ref } from "vue";
import { toast } from "vue3-toastify";
import { watchEffect } from "@vue/runtime-core";
const emit = defineEmits(["goBack"]);
const props = defineProps(["role"]);
const notify = (message) => {
  toast.success(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};
const notifyError = (message) => {
  toast.error(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};
const item = ref({});
const goBack = () => {
  item.value = {};
  emit("goBack", false);
};
const createRole = () => {
  if (item.value.role === "") {
    alert("Please fill all fields");
  } else {
    axios
      .post("/create-role", item.value)
      .then((res) => {
        notify(res.data.message);
        emit("goBack", false);
        item.value = {};
      })
      .catch((err) => {
        notifyError(err.response.data.message);
      });
  }
};
watchEffect(() => {
  if (props.role) {
    item.value = props.role;
  }
});
</script>
<template>
  <v-card class="mx-auto p-2" prepend-icon="mdi-home">
    <template v-slot:title>
      {{ props.role ? $t("update") : $t("create") }}
    </template>
    <v-card-text>
      <v-form validate-on="submit lazy" @submit.prevent="createRole()">
        <div class="row g-3 mt-5">
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.name_role"
              :rules="[(v) => !!v || 'role is required']"
              variant="solo"
              :label="$t('role')"
            ></v-text-field>
          </v-sheet>
        </div>
        <v-sheet max-width="300" class="col-md-6 m-auto">
          <v-btn
            type="submit"
            block
            class="mt-2"
            :color="props.role ? 'primary' : 'success'"
            :text="props.role ? $t('update') : $t('create')"
          ></v-btn>
          <v-btn
            color="warning"
            @click="goBack()"
            block
            class="mt-2"
            :text="$t('back')"
          ></v-btn>
        </v-sheet>
      </v-form>
    </v-card-text>
    <hr />
  </v-card>
</template>
