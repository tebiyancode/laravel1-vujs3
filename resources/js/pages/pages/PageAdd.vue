<script setup>
import { ref } from "vue";
import { toast } from "vue3-toastify";
import { watchEffect } from "@vue/runtime-core";
const emit = defineEmits(["goBack"]);
const props = defineProps(["page", "Pages"]);
const Pages = ref([]);
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
const createPage = () => {
  if (item.value.page === "") {
    alert("Please fill all fields");
  } else {
    axios
      .post("/create-page", item.value)
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
  if (props.page) {
    item.value = props.page;
  } else {
    item.value = {
      page: "",
      path: "#",
      icon: "fa-file-text-o",
      page_id: 0,
      order: 0,
    };
  }
  if (props.Pages) {
    Pages.value = props.Pages;
    Pages.value.push({ id: 0, page: "no page" });
  }
});
</script>
<template>
  <v-card class="mx-auto p-2" prepend-icon="mdi-home">
    <template v-slot:title>
      {{ props.user ? $t("update") : $t("create") }}
    </template>

    <v-card-text>
      <v-form validate-on="submit lazy" @submit.prevent="createPage()">
        <div class="row g-3 mt-5">
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.page"
              :rules="[(v) => !!v || 'page is required']"
              variant="solo"
              :label="$t('page')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.path"
              :rules="[(v) => !!v || 'path is required']"
              variant="solo"
              :label="$t('path')"
            ></v-text-field>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.icon"
              :rules="[(v) => !!v || 'icon is required']"
              variant="solo"
              :label="$t('icon')"
            ></v-text-field>
          </v-sheet>

          <v-sheet max-width="350" class="col-md-6 m-auto">
            <v-select
              v-model="item.page_id"
              :label="$t('page')"
              variant="solo"
              :items="Pages"
              item-value="id"
              item-title="page"
            >
            </v-select>
          </v-sheet>
          <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-text-field
              v-model="item.order"
              :rules="[(v) => !!v || 'order is required']"
              variant="solo"
              :label="$t('order')"
            ></v-text-field>
          </v-sheet>
        </div>
        <v-sheet max-width="300" class="col-md-6 m-auto">
            <v-btn
              type="submit"
              block
              class="mt-2"
              :color="props.page ?'primary':'success' "
              :text="props.page ? $t('update') : $t('create')"
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
