<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

</script>

<template>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    <span class="flex items-center justify-start w-[calc(30%-5px)]">Фильтр по категориям</span>
    <span class="flex items-center justify-center w-[calc(50%-5px)]">
      <select class="w-full">
        <option>1</option>
      </select>
    </span>
    <span class="flex items-center justify-center w-[calc(20%-5px)]">&nbsp;</span>
  </div>
  <div class="border-2 flex flex-row mb-4 w-full text-sm">
    Товары
  </div>
</template>