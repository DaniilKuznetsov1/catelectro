<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    cat_id?:number;
    catname?:string;
    catdescription?:string;
}>();

const emit = defineEmits<{
  (e:'resdataeditcat', succesdata:any):void;
}>();

//const editCategory = ref({cat_id: 0, catname: '', catdescription: ''});

const form = useForm({
    cat_id: 0,
    catname: '',
    catdescription: '',
});

watch(() => props.cat_id, (newVal) => {form.cat_id = newVal});
watch(() => props.catname, (newVal) => {form.catname = newVal});
watch(() => props.catdescription, (newVal) => {form.catdescription = newVal});

const submit = () => {
    form.put(route('categorys.update', {cat_id: form.cat_id, catname: form.catname, catdescription: form.catdescription}), { //  /categorys/update
        onFinish: () => {
          form.reset('catname');
          form.reset('catdescription');
        },
        onSuccess: (page) => {
          $emit('resdataeditcat', page.props.success_data); 
        }
    });
};

</script>

<template>
  <div class="w-full">
    <h2>Редактировать категорию</h2>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="catname">Название категории</Label>
          <Input id="catname" type="text" required autofocus tabindex="1"  autocomplete="email" v-model="form.catname" placeholder="" />
          <InputError :message="form.errors.catname" />
        </div>

        <div class="grid gap-2">
          <Label for="catdescription">Описание категории</Label>
          <Input id="catdescription" type="text" required autofocus tabindex="1"  autocomplete="email" v-model="form.catdescription" placeholder="" />
          <InputError :message="form.errors.catdescription" />
        </div>

        <Button type="submit" class="mt-4 w-full" tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Записать категорию
        </Button>
      </div>
    </form>
  </div>
</template>