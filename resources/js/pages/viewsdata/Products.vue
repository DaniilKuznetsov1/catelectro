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
const tovarTable = ref([]);

function runTovarTable() {
  let countArr = products.value.length;
  let ccol = 5; 
  let crow = Math.trunc(countArr / ccol); //Определяем число строк
  let crow1 = countArr % ccol;  //число столбцов в доп строке + 1. Если 0 - доп строки нет
  console.log('runTovarTable');
  console.table({countArr: countArr, crow: crow, crow1: crow1});
  let i = 0;
  //for (let i=0; i<countArr; i++) {
    for (let row=0; row<crow; row++) {
      //tovarTable.value.push(new Array());
      let row1 = [];
      for (let col=0; col<ccol; col++) {
        //tovarTable.value[row].push(products.value[i]);
        row1.push(products.value[i]);
        if (i<countArr) {i = i + 1}
      }
      tovarTable.value.push(row1.slice());
    }
    if (crow1 > 0) {
      //tovarTable.value.push(new Array());
      let row1 = [];
      for (let j=0; j<crow1; j++) {
        //tovarTable.value[crow].push(products.value[i]);
        row1.push(products.value[i]);
        if (i<countArr) {i = i + 1}
      }
      tovarTable.value.push(row1.slice());
    } //crow1
  //} //for let i
  console.log(tovarTable);
}

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
    const response = await fetch(str+'/productsapi', {
            headers: { "Content-Type": "application/json", 'X-CSRF-TOKEN':  csrf},
            credentials: "include",
          });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    //console.log(data);
    products.value = data;
    runTovarTable();
  } catch (error) {
    console.error('Сетевая ошибка:', error);
  }
}

onMounted(() => {
  getCategories();
  getProducts();
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
  let str = window.document.location.origin;
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
    <tr v-for="(tovarRow, indexrow) in tovarTable" key="indexrow">
      <td class="border-2 border-black" v-for="(tovar, indexcol) in tovarRow" key="indexcol">
        <div class="flex w-100 flex-col justify-center items-center">
          <span class="w-100">
            {{ tovar.name }}
          </span>
          <span class="w-100">
            Photo
          </span>
          <span :title="tovar.description" class="w-100">
            (!)
          </span>
          <span class="w-100">
            {{ tovar.price }} {{ tovar.valprice }}
          </span>
        </div>
        <div v-show="props.stradmin == 'true'">
          <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisEdit(category.cat_id)"> /ред </button>
          <button class="rounded-sm border-2 border-black min-w-[30px]" @click="catDelete(category.cat_id)"> /del </button>
        </div>
      </td> 
    </tr>
    </table>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <span class="flex items-center justify-start w-[calc(50%-5px)]">
      <button class="rounded-sm border-2 border-black min-w-[30px]" @click="toogleVisCreate" title="Добавить товар"> + </button> 
    </span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 1">
      <create-product :categories="categories" @resdatacreatetov="createok"></create-product></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visEdit == 1">
      <edit-product :category="currentCategory" :visible="visEdit == 1"  @resdataedittov="editok"></edit-product></span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]" v-show="visCreate == 0 && visEdit == 0"></span>
  </div>
</template>