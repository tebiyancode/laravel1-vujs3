<script setup>
import { ref } from 'vue';
import AppFontAdd from "./AppFontAdd.vue";
import { onMounted } from "@vue/runtime-core";
import axios from "axios";
import { toast } from "vue3-toastify";
const isEdit = ref(false);
const appFont = ref({});
const AppFonts = ref([]);
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
const appFontEdit = (appFontSelect) => {
  isEdit.value = true;
  appFont.value = appFontSelect;
};
const addAppFont = () => {
  isEdit.value = true;
  appFont.value = false;
};
const getAppFonts= () =>{
    axios.get(`get-app-fonts`).then((res) => {
        AppFonts.value = res.data.appFonts;

    });
}
const goBack = (event) => {
  isEdit.value = event;
  appFont.value = false;
  getAppFonts(appFont);
};
onMounted(() => {
    getAppFonts();
});
const perUser = ref(JSON.parse(localStorage.getItem("perUser")));
const chickPermission=(page,per)=>{
    let permission = perUser.value.find(
        permission => permission.page.page === page
        && permission[per] === 1
        );
        if(permission){
            return true;
        }else{
            return false;
        }
}
</script>
<template>
  <div>
    <AppFontAdd v-if="isEdit"  @goBack="goBack($event)" :appFont="appFont" />
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-header">
        <h4 class="card-title" >{{ $t('table') }} {{ $t('appFonts') }} </h4>
        <v-btn
        v-if="chickPermission('appFonts','create')"
        @click="addAppFont"
        class="ma-2"
        color="indigo"
        icon="mdi-plus"
      ></v-btn>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered text-center" width="100%">
            <thead>
              <tr>
                <th
                v-if="chickPermission('appFonts','edit')"
                >{{ $t('actions') }}</th>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('name') }}</th>
                <th v-if="chickPermission('appFonts','delete') ">{{ $t('delete') }}</th>
              </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
              <tr v-for="appFont in AppFonts" :key="appFont.id">
                <td  v-if="chickPermission('appFonts','delete') || chickPermission('appFonts','edit')" >

                  <v-btn
                  v-if="chickPermission('appFonts','edit')"
                   @click="appFontEdit(appFont)"
                    class="ma-2"
                    color="orange-darken-2"
                    icon="mdi-pencil"
                ></v-btn>

                </td>
                <td>
                    {{ appFont.id }}
                </td>
                <td>
                    {{ appFont.name_font }} <br />
                    {{ appFont.path }}
                </td>
                <td v-if="chickPermission('appFonts','delete') " >
                    <button

                   class="btn btn-danger btn-circle btn-sm m-1">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
