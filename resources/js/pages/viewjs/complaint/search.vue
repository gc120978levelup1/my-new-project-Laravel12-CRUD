<script setup lang="ts">

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"

import { ref, onMounted } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

const headTitle = "Complaint Search";
const description = "Searches for Complaints in the Master list of customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Complaint Search',
    href: '/complaint/search',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    'accountnumber': "",
});

const submit = () => {
    form.get(route('complaint.index'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <Toaster />
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6 max-w-xl">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />

                <form @submit.prevent="submit" class="space-y-6" ref="myForm">
                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" required ref="accountnumber"
                            v-model="form.accountnumber" autofocus @input="input" autocomplete="accountnumber"
                            placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing" @click="click">Search</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                </form>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
