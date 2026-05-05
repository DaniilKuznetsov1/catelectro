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
    activeremount?: string;
}>();

const emit = defineEmits<{
  (e:'resdatacreatetov', succesdata:any):void;
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
    category_id: 0
});

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

async function fileUpload(event:any) {
  const files = event.target.files;
  if (files.length === 0) return;
  file.value = files[0];
  imageUrl.value = URL.createObjectURL(file.value);
  form.photo = await toBase64(file.value);
}

function fileRemove() {
  URL.revokeObjectURL(imageUrl.value); // Освобождаем память
  imageUrl.value = null;
  file.value = null;
  form.photo = null;
}

const submit = () => {
  form.post(route('products.store'), {
    onFinish: () => {
      form.reset('name');
      form.reset('description');
      fileRemove();
    },
    onSuccess: (page) => {
      emit('resdatacreatetov', page.props.activeremount); 
    }
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
          <textarea id="description" required tabindex="1" v-model="form.description" class="w-full border-2 border-gray" rows="4"></textarea>
        </div>
        <div class="grid gap-2">
          <Label for="catname">Категория товара</Label>
          <select class="w-full" id="catname" v-model="form.category_id" >
            <option v-for="category in $props.categories" :value="category.cat_id" :key="category.cat_id">{{ category.catname }}</option>
          </select>
        </div>
        <div class="grid gap-2">
          <Label for="photo">Фото товара</Label>
          <Input id="photo" type="file" required tabindex="1"  autocomplete="" accept="image/*" @change="fileUpload" />
          <div v-if="imageUrl" class="preview">
            <img :src="imageUrl" alt="Preview" style="max-width: 200px; max-height: 200px;" />
            <button class="border-2 border-gray" @click="fileRemove">Удалить</button>
          </div>
        </div>
        <div class="flex">
          <Label for="price" class="w-[calc(20%-5px)]">Стоимость товара</Label>
          <Input id="price" type="number" class="w-[calc(60%+5px)]" required autofocus tabindex="1"  autocomplete="" v-model="form.price" placeholder="" />
          <Input id="valprice" type="text" class="w-[calc(20%-5px)]" required autofocus tabindex="1"  autocomplete="" v-model="form.valprice" placeholder="" />
        </div>
        <Button type="submit" class="mt-4 w-full" tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Записать товар
        </Button>
      </div>
    </form>
  </div>
</template>