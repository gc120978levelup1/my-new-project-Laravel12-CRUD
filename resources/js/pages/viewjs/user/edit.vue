
<script setup lang="ts">

import { Head, useForm, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    user: Object,
}
const props = defineProps<Props>();

const form = useForm({
    id: props.user.id,
    password: 'password123',
});

const submit = () => {
    form.post(route('user.update', { id: form.id }), {
        preserveScroll: true,
    });
};

const headTitle = "Reset User Password";
const description = "Resets user password upon the request of the user as per written consent/approved by superior.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Reset Pasword',
    href: '/user/reset',
},];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6  max-w-xl">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">

                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input id="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="password"
                            placeholder="password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                            <Button>Reset Password</Button>
                        </div>
                    </div>
                </form>
            </div>

        </SettingsLayout>
    </AppLayout>
</template>

