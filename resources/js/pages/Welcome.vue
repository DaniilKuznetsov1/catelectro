<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Products from '@/pages/viewsdata/Products.vue';

</script>

<template>
    <Head title="Интернет магазин">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center p-4">
        <header class="flex flex-row not-has-[nav]:hidden mb-4 w-full text-sm">
            <div class="flex items-center justify-start w-[calc(50%-10px)]">
                <Link :href="route('home')"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a]"
                >Главная</Link>
            </div>
            <nav class="flex items-center justify-end gap-4 w-[calc(50%-10px)]">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Главная Администрирование
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Логин
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Регистрация
                    </Link>
                </template>
            </nav>
        </header>
        <div class="duration-750 starting:opacity-0 flex w-full justify-center opacity-100 transition-opacity lg:grow">
            <main class="w-full overflow-hidden rounded-lg">
                <!-- Стартовая страница -->
                <products stradmin="false"></products>
            </main>
        </div>
        <div class="h-14.5 hidden lg:block"></div>
    </div>
</template>
