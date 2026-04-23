<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <AuthLayout title="Подтвердите адрес электронной почты" 
    description="Пожалуйста, подтвердите свой адрес электронной почты, перейдя по ссылке, которую мы только что вам отправили.">
        <Head title="Подтверждение электронной почты" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            На указанный вами при регистрации адрес электронной почты отправлена ​​новая ссылка для подтверждения.
        </div>

        <form @submit.prevent="submit" class="space-y-6 text-center">
            <Button :disabled="form.processing" variant="secondary">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Повторно отправить письмо с подтверждением.
            </Button>

            <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm"> Выход </TextLink>
        </form>
    </AuthLayout>
</template>
