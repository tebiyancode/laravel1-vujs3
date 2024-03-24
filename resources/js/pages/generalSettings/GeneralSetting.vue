<script setup>
import { ref } from 'vue';
import GeneralSettingAdd from "./GeneralSettingAdd.vue";
import { onMounted } from "@vue/runtime-core";
import axios from "axios";
import { toast } from "vue3-toastify";
const isEdit = ref(false);
const generalSetting = ref({});
const GeneralSettings = ref([]);
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
const generalSettingEdit = (generalSettingSelect) => {
  isEdit.value = true;
  generalSetting.value = generalSettingSelect;
};
const addGeneralSetting = () => {
  isEdit.value = true;
  generalSetting.value = false;
};
const getGeneralSettings= () =>{
    axios.get(`get-general_settings`).then((res) => {
        GeneralSettings.value = res.data.GeneralSettings;

    });
}
const goBack = (event) => {
  isEdit.value = event;
  generalSetting.value = false;
  getGeneralSettings(generalSetting.value);
};
onMounted(() => {
    getGeneralSettings();
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
    <GeneralSettingAdd v-if="isEdit"  @goBack="goBack($event)" :generalSetting="generalSetting" />
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-header">
        <h4 class="card-title" >{{ $t('table') }} {{ $t('GeneralSettings') }} </h4>
        <v-btn
        v-if="chickPermission('GeneralSettings','create')"
        @click="addGeneralSetting"
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
                v-if="chickPermission('GeneralSettings','edit')"
                >{{ $t('actions') }}</th>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('name') }}</th>
                <th>{{ $t('font') }}</th>
                <th v-if="chickPermission('GeneralSettings','delete') ">{{ $t('delete') }}</th>
              </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
              <tr v-for="generalSetting in GeneralSettings" :key="generalSetting.id">
                <td  v-if="chickPermission('GeneralSettings','delete') || chickPermission('GeneralSettings','edit')" >

                  <v-btn
                  v-if="chickPermission('GeneralSettings','edit')"
                   @click="generalSettingEdit(generalSetting)"
                    class="ma-2"
                    color="orange-darken-2"
                    icon="mdi-pencil"
                ></v-btn>

                </td>
                <td>
                    {{ generalSetting.id }}
                </td>
                <td>
                    {{ generalSetting.name }} <br />
                    {{ generalSetting.logo }}
                </td>
                <td>
                    {{ generalSetting.font.name_font }} <br />
                    {{ generalSetting.font_size }}
                </td>
                <td v-if="chickPermission('GeneralSettings','delete') " >
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
