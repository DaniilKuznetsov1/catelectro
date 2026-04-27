<script setup lang="ts">
import { getURLPopEnd } from '@/lib/utils';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import CreateCategory from '@/pages/viewsdata/CreateCategory.vue';

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
    const response = await fetch(str+'/categorysa', {
            headers: { "Content-Type": "application/json", 'X-CSRF-TOKEN':  csrf},
            credentials: "include",
          });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    console.log("categoryes: "+data);
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

function toogleVisEdit(id) {
  let obj = {};
  if (visEdit.value == 0) {
    visEdit.value = 1;
    obj = categories.value[id];
  } else {
    visEdit.value = 0;
  }
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
    <tr>
      <td class="border-2 border-black"></td> <td class="border-2 border-black"></td> 
      <td class="border-2 border-black"><button class="rounded-sm border-2 border-black" @click="toogleVisEdit(0)"> /ред </button></td>
    </tr>
  </table>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <span class="flex items-center justify-start w-[calc(50%-5px)]">
      <button class="rounded-sm border-2 border-black" @click="toogleVisCreate"> + </button> </span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-if="visCreate == 1"><create-category ></create-category></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-if="visEdit == 1">EditCategory</span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-if="visCreate == 0 && visEdit == 0">000</span>
  </div>
</template>