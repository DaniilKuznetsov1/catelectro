<script setup lang="ts">
import { Head, useForm, defineEmits } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    category?:object;
    visible?:boolean;
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

/* watch(()=> props.visible, (newVal) => {
  console1.log('watch1');
  console1.log(newVal);
}); */

watch(() => props.category, (newVal) => {
  if (newVal) {
    form.cat_id = newVal.cat_id;
    form.catname = newVal.catname;
    form.catdescription = newVal.catdescription;
    console.log(form);
  }
}, {deep: true});

const submit = () => {
    //let category1:object = {cat_id: form.cat_id, catname: form.catname, catdescription: form.catdescription};
    //form.append('_method', 'PUT');
    console.log(form.cat_id);
    form.put(route('categorys.update', {category: form.cat_id}), { //  /categorys/update
        forceFormData: true,
        onFinish: () => {
          form.reset('catname');
          form.reset('catdescription');
        },
        onSuccess: (page) => {
          emit('resdataeditcat', page.props.activeremount); 
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
          <Input id="catname" type="text" required autofocus tabindex="1"  autocomplete="" v-model="form.catname" placeholder="" />
          <InputError :message="form.errors.catname" />
        </div>

        <div class="grid gap-2">
          <Label for="catdescription">Описание категории</Label>
          <Input id="catdescription" type="text" required autofocus tabindex="1"  autocomplete="" v-model="form.catdescription" placeholder="" />
          <InputError :message="form.errors.catdescription" />
        </div>

        <Button type="submit" class="mt-4 w-full" tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Записать категорию
        </Button>
      </div>
    </form>
  </div>
</template>