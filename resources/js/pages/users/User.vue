<script setup>
import { ref } from 'vue';
import AddUser from "./AddUser.vue";
import { onMounted } from "@vue/runtime-core";
import axios from "axios";
import { toast } from "vue3-toastify";
import Paginate from "vuejs-paginate-next";

const isEdit = ref(false);
const user = ref({});
const Users = ref([]);
const page = ref(1);
const search = ref("");
const length = ref(1);
const max = ref(3);
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
const userEdit = (userSelect) => {
  isEdit.value = true;
  user.value = userSelect;
};
const addUser = () => {
  isEdit.value = true;
  user.value = false;
};
const getUsers= (page) =>{
    axios.get(`index-users?page=${page} && search=${search.value}`).then((res) => {
        Users.value = res.data.users.data;
        length.value = res.data.users.last_page

    });
}
const goBack = (event) => {
  isEdit.value = event;
  user.value = false;
  getUsers(page);
};
onMounted(() => {
    getUsers(page);
});
</script>
<template>
  <div>
    <AddUser v-if="isEdit"  @goBack="goBack($event)" :user="user" />
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-header">
        <h4 class="card-title" >{{ $t('table') }} {{ $t('users') }} </h4>

        <v-btn
        v-if="chickPermission('users','create') "
        @click="addUser"
        class="ma-2"
        color="indigo"
        icon="mdi-plus"
      ></v-btn>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
            <h4 class="card-title"><input class="form-control" v-model="search" @input="getUsers(page)" placeholder="search" /></h4>
          <table class="table table-bordered text-center" width="100%">
            <thead>
              <tr>
                <th  v-if="chickPermission('users','edit') " >{{ $t('actions') }}</th>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('name') }}</th>
                <th>{{ $t('email') }}</th>
                <th>{{ $t('mobile') }}</th>
                <th>{{ $t('name_role') }}</th>
              </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
              <tr v-for="user in Users" :key="user.id">
                <td   v-if="chickPermission('users','edit') " >
                  <button hidden class="btn btn-danger btn-circle btn-sm m-1">
                    <i class="fas fa-trash"></i>
                  </button>
                  <v-btn
                    @click="userEdit(user)"
                    class="ma-2"
                    color="orange-darken-2"
                    icon="mdi-pencil"
                ></v-btn>
                </td>
                <td>
                    {{ user.id }}
                </td>
                <td>
                    {{ user.name }}
                </td>
                <td>
                    {{ user.email }}
                </td>
                <td>
                    {{ user.mobile }}
                </td>
                <td>
                    {{ user.role?.name_role }}
                </td>
              </tr>
            </tbody>
          </table>
          <Paginate
            v-model="page"
            @click="getUsers(page)"
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
</template>
