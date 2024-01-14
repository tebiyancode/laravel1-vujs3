<script setup>
import { ref } from "vue";
import { toast } from "vue3-toastify";
import {onMounted, watchEffect } from "@vue/runtime-core";
const emit = defineEmits(["goBack"]);
const props = defineProps(["generalSetting"]);
const AppFonts =ref([]);
onMounted(() => {
    getAppFonts();
});

const getAppFonts= () =>{
    axios.get(`get-app-fonts`).then((res) => {
        AppFonts.value = res.data.appFonts;

    });
}
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
const createGeneralSetting = () => {
  if (item.value.name === "") {
    alert("Please fill all fields");
  } else {
    axios
      .post("/create-general_setting", item.value, {
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
  item.value.file_image = file;


};
watchEffect(() => {
  if (props.generalSetting) {
    item.value = props.generalSetting;
  }
});
</script>
<template>
  <v-card class="mx-auto p-2" prepend-icon="mdi-home">
    <template v-slot:title>
      {{ props.generalSetting ? $t("update") : $t("create") }}
    </template>
    <v-card-text>
      <v-form validate-on="submit lazy" @submit.prevent="createGeneralSetting()">
        <div class="row g-3 mt-5">
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.name"
              :rules="[(v) => !!v || 'generalSetting is required']"
              variant="solo"
              :label="$t('name')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.email"
              :rules="[(v) => !!v || 'email is required']"
              variant="solo"
             type="email"
              :label="$t('email')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.facebook"
              :rules="[(v) => !!v || 'facebook is required']"
              variant="solo"

              :label="$t('facebook')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.youtube"
              :rules="[(v) => !!v || 'youtube is required']"
              variant="solo"
              :label="$t('youtube')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <!-- <label v-if="props.generalSetting" > {{ item.logo }}</label> -->
            <img :src="'/'+item.logo" width="150">
            <input
            type="file"
            class="form-control"
            placeholder="اختر الخط"
            @change="uploadFile"
            ref="file"
            />
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-select
              v-model="item.font_id"
              :label="$t('font')"
              variant="solo"
              :items="AppFonts"
              item-value="id"
              item-title="name_font"
            >
            </v-select>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.font_size"
              :rules="[(v) => !!v || 'font_size is required']"
              variant="solo"
              type="number"
              step="0.1"
              :label="$t('font_size')"
            ></v-text-field>
          </v-sheet>
        </div>
        <v-sheet max-width="300" class="col-md-6 m-auto">
          <v-btn
            type="submit"
            block
            class="mt-2"
            :color="props.generalSetting ? 'primary' : 'success'"
            :text="props.generalSetting ? $t('update') : $t('create')"
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
