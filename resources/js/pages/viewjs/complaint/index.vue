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

import { Toaster } from '@/components/ui/sonner'
import { toast } from 'vue-sonner'

const url = new URL(window.location);
const messagemain = url.searchParams.get('messagemain');
const messagedescription = url.searchParams.get('messagedescription');
onMounted(() => {
    if (messagemain) {
        toast(messagemain, {
            description: messagedescription,
            action: {
                label: 'Ok',
                onClick: () => console.log('OK'),
            },
        });
    }
});


interface Props {
    pagination: { type: Array, },
    accountnumber: string,
}

const props = defineProps<Props>();

const complaints = ref(props.pagination.data);
const prev_page_url = ref(props.pagination.prev_page_url);
const next_page_url = ref(props.pagination.next_page_url);

console.log(props.pagination);
const xx = ref(props.pagination);
const yy = ref(JSON.stringify(xx.value));

const headTitle = "Complaint Master List";
const description = "Master list of customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Complaint Index',
    href: '/complaint',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    'accountnumber': props.accountnumber,
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
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <div class="text-gray-900 dark:text-gray-100 border rounded">

                    <div className="flex flex-row gap-4 p-2 sm:flex-row justify-center items-center min-w-2xs">
                        <Link :href="prev_page_url" 
                            class="flex p-2 px-2 rounded  text-gray-400 bg-red-950 m-1 w-10 sm:w-10 justify-center items-center hover:bg-red-800 active:bg-red-700"
                            :disabled="prev_page_url">
                            <<|
                        </Link>
                        <Link :href="next_page_url"
                            class="flex p-2 px-2 rounded  text-gray-400 bg-red-950 m-1 w-10 sm:w-10  ml-auto justify-center items-center hover:bg-red-800 active:bg-red-700"
                            :disabled="next_page_url">
                            |>>
                        </Link>
                    </div>

                    <div class="overflow-auto border rounded">
                        <table class="min-w-full text-left text-sm font-dark text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10 bg-gray-950">
                                <tr>
                                    <th scope="col" class="px-1 py-4">
                                        &nbsp;&nbsp;&nbsp;Action
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        #
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Accountnumber
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Name
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Address
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(complaint, index) in complaints" :key="index"
                                    class="border-b border-neutral-200 dark:border-white/10">
                                    <td class="flex whitespace-nowrap px-6 py-1">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <div
                                                    class="mr-2 h-6 flex items-center space-x-2 border border-neutral-200 dark:border-white/10 rounded-full p-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    ⋮
                                                </div>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <div
                                                    class="flex p-2 space-y-2 border-b border-neutral-200 dark:border-white/10">
                                                    <Link :href="route(
                                                        'complaint.show',
                                                        [complaint.id]
                                                    )
                                                        " class="p-2 px-5 rounded my-auto text-white bg-green-600 m-2">
                                                    View
                                                    </Link>

                                                    <Link :href="route(
                                                        'complaint.edit',
                                                        { id: complaint.id }
                                                    )
                                                        " class="p-2 px-6 rounded my-auto text-white bg-blue-500 m-2">
                                                    Edit
                                                    </Link>

                                                    <Dialog>
                                                        <DialogTrigger asChild>
                                                            <Button :disabled="form.processing"
                                                                class="p-2 px-4 rounded my-auto text-white text-white bg-red-500 m-2">
                                                                Delete
                                                            </Button>
                                                        </DialogTrigger>
                                                        <DialogContent class="!max-w-fit max-h-full p-3 overflow-auto">
                                                            <DialogHeader>
                                                                <DialogTitle>
                                                                    <span
                                                                        class="text-red-500 text-3xl py-4">Delete</span>
                                                                </DialogTitle>
                                                                <DialogDescription>
                                                                    Are you sure to DELETE this item?
                                                                </DialogDescription>
                                                            </DialogHeader>
                                                            <div className="py-0">
                                                                <div
                                                                    className="flex flex-col sm:flex-row items-center gap-4">
                                                                    <div v-if="complaint.picture" class="w-full">
                                                                        <img :src="complaint.picture" alt="" srcset=""
                                                                            class="border-2 rounded-lg">
                                                                    </div>
                                                                    <div className="flex flex-col gap-2 py-4">
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="accountnumber">
                                                                                Account Number : &nbsp;&nbsp;{{
                                                                                    complaint.accountnumber }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="name">
                                                                                Name : &nbsp;&nbsp;{{ complaint.name }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="complaint">
                                                                                Address : &nbsp;&nbsp;{{
                                                                                    complaint.address }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="complaint">
                                                                                Complaint : &nbsp;&nbsp;{{
                                                                                    complaint.complaint }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="description">
                                                                                Description : &nbsp;&nbsp;{{
                                                                                    complaint.description }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="created_at">
                                                                                created_at : &nbsp;&nbsp;{{
                                                                                    complaint.created_at }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="updated_at">
                                                                                updated_at : &nbsp;&nbsp;{{
                                                                                    complaint.updated_at }}
                                                                            </Label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <DialogFooter>
                                                                <Link :href="route(
                                                                    'complaint.delete',
                                                                    { id: complaint.id })"
                                                                    class="flex p-2 px-1 rounded my-auto text-white bg-red-500 m-1 justify-center items-center w-35">
                                                                    Delete Forever
                                                                </Link>
                                                            </DialogFooter>
                                                        </DialogContent>
                                                    </Dialog>

                                                </div>

                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                        <div v-if="complaint.picture" class="grid gap-2 w-[50px]">
                                            <img :src="complaint.picture" alt="" srcset="" class="border-2 rounded-lg">
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ complaint.id }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ complaint.accountnumber }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ complaint.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ complaint.address }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ complaint.description }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!---
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
                -->

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
