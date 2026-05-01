<script setup lang="ts">
import { ref, onMounted, defineEmits } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    categories?:object;
}>();

const currentCategory = ref({cat_id: 0, catname: '', catdescription: ''});

const imageUrl = ref(null);
const file = ref(null);

const form = useForm({
    name: '',
    description: '',
    photo: null,
    price: 0,
    valprice: 'Р',
    cat_id: 0
});

function fileUpload(event:any) {
  const files = event.target.files;
  if (files.length === 0) return;
  file.value = files[0];
  imageUrl.value = URL.createObjectURL(file.value);
  form.photo = URL.createObjectURL(file.value);
}

function fileRemove() {
  URL.revokeObjectURL(imageUrl.value); // Освобождаем память
  imageUrl.value = null;
  file.value = null;
  form.photo = null;
}

const submit = () => {
  form.post(route('categorys.store'), {

  });
}

</script>

<template>
  <div class="w-full">
    <h2>Создать товар</h2>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="name">Название товара</Label>
          <Input id="name" type="text" required autofocus tabindex="1"  autocomplete="" v-model="form.name" placeholder="" />
        </div>
        <div class="grid gap-2">
          <Label for="description">Описание товара</Label>
          <Input id="description" type="text" required autofocus tabindex="1"  autocomplete="" v-model="form.description" placeholder="" />
        </div>
        <div class="grid gap-2">
          <Label for="catname">Категория товара</Label>
          <select class="w-full" id="catname" v-model="form.cat_id" >
            <option v-for="category in $props.categories" :value="category.cat_id" :key="category.cat_id">{{ category.catname }}</option>
          </select>
        </div>
        <div class="grid gap-2">
          <Label for="photo">Фото товара</Label>
          <Input id="photo" type="file" required tabindex="1"  autocomplete="" accept="image/*" @change="fileUpload" />
          <div v-if="imageUrl" class="preview">
            <img :src="imageUrl" alt="Preview" style="max-width: 200px; max-height: 200px;" />
            <button @click="fileRemove">Удалить</button>
          </div>
        </div>
        <div class="flex">
          <Label for="price">Стоимость товара</Label>
          <Input id="price" type="number" class="w-[calc(70%-15px)]" required autofocus tabindex="1"  autocomplete="" v-model="form.price" placeholder="" />
          <Input id="valprice" type="text" class="w-[calc(30%-15px)]" required autofocus tabindex="1"  autocomplete="" v-model="form.valprice" placeholder="" />
        </div>
        <Button type="submit" class="mt-4 w-full" tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Записать товар
        </Button>
      </div>
    </form>
  </div>
</template>