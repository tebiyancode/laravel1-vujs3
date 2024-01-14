<template>
  <div>
    <div class="demo-inline-spacing p-2">
      <button
        v-if="chickPermission('translates', 'create')"
        @click="addShow"
        class="btn btn-primary btn-relief-primary"
      >
        {{ isAdd ? $t("back") : $t("add") }}
      </button>
    </div>
    <div v-if="isAdd">
      <v-card max-width="400" class="mx-auto p-2" prepend-icon="mdi-home">
        <template
          v-if="
            chickPermission('translates', 'create') ||
            chickPermission('translates', 'edit')
          "
          v-slot:title
        >
          {{ isEdit ? $t("update") : $t("create") }}
        </template>
        <v-card-text>
          <v-form validate-on="submit lazy" @submit.prevent="addLang()">
            <div class="m-auto center">
              <v-sheet max-width="300">
                <v-text-field
                  v-model="keyValue"
                  :rules="[(v) => !!v || 'keyValue is required']"
                  variant="solo"
                  :label="$t('key')"
                ></v-text-field>
              </v-sheet>
              <v-sheet max-width="300" v-for="(lang, index) in refForm" :key="index">
                <v-text-field
                  v-model="lang.value"
                  :rules="[(v) => !!v || `${lang.value} is required`]"
                  variant="solo"
                  :label="$t(lang.lang)"
                ></v-text-field>
              </v-sheet>
            </div>
            <v-sheet max-width="300" class="col-md-6 m-auto">
              <v-btn
                v-if="
                  chickPermission('translates', 'create') ||
                  chickPermission('translates', 'update')
                "
                type="submit"
                block
                class="mt-2"
                :color="isEdit ? 'primary' : 'success'"
                :text="isEdit ? $t('update') : $t('create')"
              ></v-btn>
            </v-sheet>
          </v-form>
        </v-card-text>
        <hr />
      </v-card>
    </div>
    <div v-if="!isAdd" class="row" id="table-head">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $t("Table langs") }}</h4>
            <h4 class="card-title">
              <input
                class="form-control"
                v-model="search"
                @input="getLangs(page)"
                placeholder="search"
              />
            </h4>
          </div>
          <div class="table-responsive">
            <table class="table m-1">
              <thead class="table-dark">
                <tr>
                  <th>{{ $t("language") }}</th>
                  <th>{{ $t("key") }}</th>
                  <th>{{ $t("value") }}</th>
                  <th v-if="chickPermission('translates', 'edit')">
                    {{ $t("Actions") }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(lang, index) in langs" :key="index">
                  <td>
                    {{ lang.lang }}
                  </td>
                  <td>
                    {{ lang.key }}
                  </td>
                  <td>
                    {{ lang.value }}
                  </td>
                  <td v-if="chickPermission('translates', 'edit')">
                    <div class="d-flex">

                      <v-btn
                    @click="editLang(lang.key)"

                    class="ma-2"
                    color="orange-darken-2"
                    icon="mdi-pencil"
                ></v-btn>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <Paginate
              v-model="page"
              @click="getLangs(page)"
              :page-count="length"
              :page-range="max"
              :prev-text="$t('previous')"
              :next-text="$t('next')"
              :container-class="'pagination'"
            >
            </Paginate>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "@vue/reactivity";
import { onMounted, inject } from "@vue/runtime-core";
import { toast } from "vue3-toastify";
import Paginate from "vuejs-paginate-next";
import axios from "axios";
const errors = ref([]);
const fields = ref({
  lang: "lang",
  key: "key",
  value: "value",
});
const notify = (message) => {
  toast.success(message, {
    autoClose: 1000,
    position: toast.POSITION.TOP_CENTER,
  });
};
const perUser = ref(JSON.parse(localStorage.getItem("perUser")));
const chickPermission = (page, per) => {
  let permission = perUser.value.find(
    (permission) => permission.page.page === page && permission[per] === 1
  );
  if (permission) {
    return true;
  } else {
    return false;
  }
};
const langs = ref([]);
const isAdd = ref(false);
const isEdit = ref(false);
const keyValue = ref("");
const search = ref("");
const page = ref(1);
const length = ref(1);
const max = ref(3);

const refForm = ref([
  {
    lang: "ar",
    value: "",
  },
  {
    lang: "en",
    value: "",
  },
  {
    lang: "fr",
    value: "",
  },
  {
    lang: "tr",
    value: "",
  },
]);
const getLangForm = () => {
  keyValue.value = "";
  refForm.value = [
    {
      lang: "ar",
      value: "",
    },
    {
      lang: "en",
      value: "",
    },
    {
      lang: "fr",
      value: "",
    },
    {
      lang: "tr",
      value: "",
    },
  ];
};
const addShow = () => {
  isAdd.value = !isAdd.value;
  isEdit.value = false;
  getLangForm();
};
const addLang = async () => {
  await axios
    .post(`add-langs`, {
      refForm: refForm.value,
      keyValue: keyValue.value,
      isEdit: isEdit.value,
    })
    .then((r) => {
      console.log(r.data);
      let meassge = r.data.message;
      isAdd.value = false;
      isEdit.value = false;
      getLangForm();
      getLangs();
      localStorage.setItem("messages", "");
      axios.get("/get-i18n").then((res) => {
        localStorage.setItem("messages", JSON.stringify(res.data));
      });
      notify(meassge);
    })
    .catch((error) => {
      console.log(error);
      errors.value = error;
    });
};
const editLang = (key) => {
  isAdd.value = true;
  isEdit.value = true;
  console.log(key);
  axios.get(`langs/${key}`).then((r) => {
    refForm.value = r.data.langs;
    keyValue.value = key;
  });
};
const getLangs = async (page = 1) => {
  await axios.get(`langs?page=${page} && search=${search.value}`).then((r) => {
    langs.value = r.data.langs.data;
    length.value = r.data.langs.last_page;
  });
};
onMounted(async () => {
  await getLangs(page.value);
});
</script>
