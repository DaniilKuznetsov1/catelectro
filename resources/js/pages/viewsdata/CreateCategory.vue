<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({
    catname: '',
    catdescription: '',
});

const submit = () => {
    form.post(route('/categorys/store'), {
        onFinish: () => {
          form.reset('catname');
          form.reset('catdescription');
        },
    });
};

</script>

<template>
  <div class="w-full">

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