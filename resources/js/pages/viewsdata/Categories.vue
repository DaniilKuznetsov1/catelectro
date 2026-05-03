<script setup lang="ts">
import { getURLPopEnd } from '@/lib/utils';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import CreateCategory from '@/pages/viewsdata/CreateCategory.vue';
import EditCategory from '@/pages/viewsdata/EditCategory.vue';

const props = defineProps<{
    status?: string;
    stradmin?: string;
}>();

const categories = ref([]);
const currentCategory = ref({cat_id: 0, catname: '', catdescription: ''});
const visCreate = ref(0);
const visEdit = ref(0);

async function getCategories() {
  let str = getURLPopEnd(window.document.location.href);
  let csrf = window.document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const response = await fetch(str+'/categorysapi', {
            headers: { "Content-Type": "application/json", 'X-CSRF-TOKEN':  csrf},
            credentials: "include",
          });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    categories.value = data;

  } catch (error) {
    console.error('Сетевая ошибка:', error);
  }
}

onMounted(() => {
  getCategories();
});

function toogleVisCreate() {
  if (visCreate.value == 0) {
    visCreate.value = 1;
  } else {
    visCreate.value = 0;
  }
}

function toogleVisEdit(id:any) {
  let obj = {};
  if (visEdit.value == 0) {
    visEdit.value = 1;
    if (categories != undefined) {
      obj = categories.value.find((item:any) => {
        if (item.cat_id == id) {
          return true;
        } else {
          return false;
        }
      });
      currentCategory.value.cat_id = id;
      currentCategory.value.catname = obj.catname;
      currentCategory.value.catdescription = obj.catdescription;
    }
  } else {
    visEdit.value = 0;
  }
}

async function catDelete(id: any) {
  let obj = categories.value.find((item:any) => {
  if (item.cat_id == id) {
      return true;
    } else {
      return false;
    }
  });

  let str = getURLPopEnd(window.document.location.href);
  let csrf = window.document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  try {
    const response = await fetch(str+'/categorysa/'+id, {
            headers: { "Content-Type": "application/json", 'X-CSRF-TOKEN':  csrf},
            credentials: "include",
            method: 'DELETE',
          });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    categories.value = data;

  } catch (error) {
    console.error('Сетевая ошибка:', error);
  }
}

function createok(event: any) {
  visCreate.value = 0;
  console.log('create event');
  console.log(event);
  let str = getURLPopEnd(window.document.location.href);
  window.location.href = str+'/dashboard';
}

function editok(event: any) {
  visEdit.value = 0;
  console.log('update event');
  console.log(event);
  let str = window.document.location.origin;
  window.location.href = str+'/dashboard';
}

function testUrl2() {
  console.log(window.document.location);
}

</script>

<template>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
  <table class="border-1 border-black border-collapse w-full">
    <caption class="text-base">Категории</caption>
    <colgroup>
      <col style="width: 40%">
      <col style="width: 50%">
      <col style="width: 10%">
    </colgroup>
    <tr>
      <th class="border-2 border-black">Название категории</th> <th class="border-2 border-black">Описание категории</th> <th class="border-2 border-black">Операции</th>
    </tr>
    <tr v-for="category in categories">
      <td class="border-2 border-black">{{ category.catname }}</td> <td class="border-2 border-black">{{ category.catdescription }}</td> 
      <td class="border-2 border-black">
        <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisEdit(category.cat_id)"> /ред </button>
        <button class="rounded-sm border-2 border-black min-w-[30px]" @click="catDelete(category.cat_id)"> /del </button>
      </td>
    </tr>
  </table>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <span class="flex items-center justify-start w-[calc(50%-5px)]">
      <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisCreate" title="Добавить категорию"> + </button> 
      <!-- <button class="rounded-sm border-2 border-black min-w-[30px]" @click="testUrl2">TU</button> -->
    </span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 1">
      <create-category @resdatacreatecat="createok"></create-category></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visEdit == 1">
      <edit-category :category="currentCategory" :visible="visEdit == 1"  @resdataeditcat="editok"></edit-category></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 0 && visEdit == 0">&nbsp;</span>
  </div>
</template>