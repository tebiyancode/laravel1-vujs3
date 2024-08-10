<script setup>
import { ref } from 'vue';
import PageAdd from "./PageAdd.vue";
import { onMounted } from "@vue/runtime-core";
import axios from "axios";
import { toast } from "vue3-toastify";
const isEdit = ref(false);
const page = ref({});
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
const pageEdit = (pageSelect) => {
  isEdit.value = true;
  page.value = pageSelect;
};
const addPage = () => {
  isEdit.value = true;
  page.value = false;
};
const getPages= () =>{
    axios.get(`get-pages`).then((res) => {
        Pages.value = res.data.pages;

    });
}
const goBack = (event) => {
  isEdit.value = event;
  page.value = false;
  getPages(page);
};
onMounted(() => {
    getPages();
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
    <PageAdd v-if="isEdit"  @goBack="goBack($event)" :page="page" :Pages="Pages" />
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-header">
        <h4 class="card-title" >  {{ $t('table') }} {{ $t('pages') }}</h4>

        <v-btn

        @click="addPage"
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
                <th   v-if="chickPermission('pages','delete') || chickPermission('pages','edit')"
                >{{ $t('actions') }}</th>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('name') }} </th>
              </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
              <tr v-for="page in Pages" :key="page.id">
                <td  v-if="chickPermission('pages','delete') || chickPermission('pages','edit')" >
                  <button
                    v-if="chickPermission('pages','delete')"
                   class="btn btn-danger btn-circle btn-sm m-1">
                    <i class="fas fa-trash"></i>
                  </button>
                  <v-btn
                    @click="pageEdit(page)"
                    v-if="chickPermission('pages','edit')"
                    class="ma-2"
                    color="orange-darken-2"
                    icon="mdi-pencil"
                ></v-btn>

                </td>
                <td>
                    {{ page.id }}
                </td>
                <td>
                    {{$t(page.page)  }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
