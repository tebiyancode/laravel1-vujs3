<script setup>
import { ref } from "vue";
import { toast } from "vue3-toastify";
import { watchEffect } from "@vue/runtime-core";
const emit = defineEmits(["goBack"]);
const props = defineProps(["appFont"]);
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
const createAppFont = () => {
  if (item.value.name_font === "") {
    alert("Please fill all fields");
  } else {
    axios
      .post("/create-app-font", item.value, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
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
const uploadFile = (e) => {
  let file = e.target.files[0];
  //this File too big  > 8MB
  if (file.size > 8388608) {
    alert("File too big! > 8MB");
    return false;
  }
  item.value.file_font = file;


};
watchEffect(() => {
  if (props.appFont) {
    item.value = props.appFont;
  }
});
</script>
<template>
  <v-card class="mx-auto p-2" prepend-icon="mdi-home">
    <template v-slot:title>
      {{ props.appFont ? $t("update") : $t("create") }}
    </template>
    <v-card-text>
      <v-form validate-on="submit lazy" @submit.prevent="createAppFont()">
        <div class="row g-3 mt-5">
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.name_font"
              :rules="[(v) => !!v || 'appFont is required']"
              variant="solo"
              :label="$t('appFont')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <label v-if="props.appFont" > {{ item.path }}</label>
            <input
            type="file"
            class="form-control"
            placeholder="اختر الخط"
            @change="uploadFile"
            ref="file"
            />
          </v-sheet>
        </div>
        <v-sheet max-width="300" class="col-md-6 m-auto">
          <v-btn
            type="submit"
            block
            class="mt-2"
            :color="props.appFont ? 'primary' : 'success'"
            :text="props.appFont ? $t('update') : $t('create')"
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
