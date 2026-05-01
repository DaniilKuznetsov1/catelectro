<script setup lang="ts">
import { getURLPopEnd } from '@/lib/utils';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import CreateProduct from '@/pages/viewsdata/CreateProduct.vue';
import EditProduct from '@/pages/viewsdata/EditProduct.vue';

const props = defineProps<{
    status?: string;
    stradmin?: string;
}>();

const categories = ref([]);
const products = ref([]);
const currentCatId = ref(1);
const currentCategory = ref({cat_id: 0, catname: '', catdescription: ''});
const currentProduct = ref({name: '', description: '', photo: '', price: 0, valprice:'р', category_id: 0});

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

async function getProducts() {
    let str = getURLPopEnd(window.document.location.href);
    let csrf = window.document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  try {
    const response = await fetch(str+'/productsa', {
            headers: { "Content-Type": "application/json", 'X-CSRF-TOKEN':  csrf},
            credentials: "include",
          });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    //console.log(data);
    products.value = data;

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

</script>

<template>
  <div class="border-2 flex flex-row w-full text-sm">
    <span class="flex items-center justify-start w-[calc(30%-5px)]">Фильтр по категориям</span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]">
      <select class="w-full" v-model="currentCatId" >
        <option v-for="category in categories" :value="category.cat_id" :key="category.cat_id">{{ category.catname }}</option>
      </select>
    </span>
    <span class="flex items-center justify-center w-[calc(20%-5px)]">&nbsp;</span>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <table class="border-1 border-black border-collapse w-full">
      <caption class="text-base">Товары</caption>
    <colgroup>
      <col style="width: 20%">
      <col style="width: 20%">
      <col style="width: 20%">
      <col style="width: 20%">
      <col style="width: 20%">
    </colgroup>
    <tr >
      <td class="border-2 border-black">1 </td>
      <td class="border-2 border-black">2 </td>
      <td class="border-2 border-black">3 </td>
      <td class="border-2 border-black">4 </td>
      <td class="border-2 border-black">5 </td>
    </tr>
    <!--<tr v-for="product in products">
      <td class="border-2 border-black">{{ product.name }}</td> <td class="border-2 border-black">{{ product.description }}</td> 
      <td class="border-2 border-black">
        <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisEdit(category.cat_id)"> /ред </button>
        <button class="rounded-sm border-2 border-black min-w-[30px]" @click="catDelete(category.cat_id)"> /del </button>
      </td>
    </tr>-->
    </table>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <span class="flex items-center justify-start w-[calc(50%-5px)]">
      <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisCreate"> + </button> 
    </span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 1">
      <create-product :categories="categories" @resdatacreatecat="createok"></create-product></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visEdit == 1">
      <edit-product :category="currentCategory" :visible="visEdit == 1"  @resdataeditcat="editok"></edit-product></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 0 && visEdit == 0"></span>
  </div>
</template>