<script setup lang="ts">
import { getURLPopEnd } from '@/lib/utils';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps<{
    status?: string;
    stradmin?: string;
}>();

const categories = ref([]);
const products = ref([]);
const currentCategory = ref({cat_id: 0, catname: '', catdescription: ''});
const currentProduct = ref({name: '', description: '', photo: '', price: 0, valprice:'р', category_id: 0});

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
    console.log("prod categoryes: "+data);
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

</script>

<template>
  <div class="border-2 flex flex-row w-full text-sm">
    <span class="flex items-center justify-start w-[calc(30%-5px)]">Фильтр по категориям</span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]">
      <select class="w-full">
        <option>1</option>
      </select>
    </span>
    <span class="flex items-center justify-center w-[calc(20%-5px)]">&nbsp;</span>
  </div>
  <div class="border-2 flex flex-row w-full text-sm">
    Товары, {{ props.stradmin }}
  </div>
</template>