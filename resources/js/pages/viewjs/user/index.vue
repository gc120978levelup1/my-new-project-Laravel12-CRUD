<script setup lang="ts">

import {
    DropdownMenu,
    DropdownMenuContent,
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
import { Head, Link, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

// Start of retreiving messages from the redirect controller and show it in the Toaster
import { Toaster } from '@/components/ui/sonner'; // A <Toaster /> is also installed inside the template
import { toast } from 'vue-sonner';
const url = new URL(window.location);
const messagemain = url.searchParams.get('messagemain');
const messagedescription = url.searchParams.get('messagedescription');
onMounted(() => {
    if (messagemain) {
        toast(messagemain, {
            'description': messagedescription,
            'action': {
                label: 'Ok',
                onClick: () => console.log('OK'),
            },
        });
    }
});
// Emd of retreiving messages and show it in the Toaster

// Start of retreiving paginated data to be shown in the table from index controller
interface Props {
    pagination: { type: Array, },
}
const props = defineProps<Props>();
const users = ref(props.pagination.data);
const prev_page_url = ref(props.pagination.prev_page_url);
const next_page_url = ref(props.pagination.next_page_url);
// End of retreiving paginated data from index controller

// Start of retreiving current user data
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
// End of retreiving  current user data

//Start of Declaration of Page Title
const headTitle = "User Master List";
const description = "Master list of users.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Users Index',
    href: '/user',
},];
//End  of Declaration of Page Title

</script>

<template>
    <Toaster />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" class="hidden md:block" />
                <div class="text-gray-900 dark:text-gray-100 border rounded">

                    <!-- Start of Backward and Forward Button for the Pagination Table -->
                    <div className="flex flex-row gap-4 p-2 sm:flex-row justify-left items-center min-w-2xs">
                        <Link :href="prev_page_url"
                            class="flex p-2 px-2 rounded  text-gray-400 bg-red-950 m-1 w-10 sm:w-10 justify-center items-center hover:bg-red-800 active:bg-red-700"
                            :disabled="prev_page_url">
                            <<|
                        </Link>
                        <Link :href="next_page_url"
                            class="flex p-2 px-2 rounded  text-gray-400 bg-red-950 m-1 w-10 sm:w-10  ml-auto md:ml-1 justify-center items-center hover:bg-red-800 active:bg-red-700"
                            :disabled="next_page_url">
                            |>>
                        </Link>
                    </div>
                    <!-- End of Backward and Forward Button for the Pagination Table -->

                    <!-- Start of Pagination Table -->
                    <div class="overflow-auto border rounded">
                        <table class="min-w-full text-left text-sm font-dark text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/25">
                                <tr>
                                    <th scope="col" class="px-1 py-4">
                                        &nbsp;&nbsp;&nbsp;Action
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        #
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Name
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Email Address
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Role
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(xuser, index) in users" :key="index"
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
                                                        'user.show',
                                                        [xuser.id]
                                                    )
                                                        " class="p-2 px-5 rounded my-auto text-white bg-green-600 m-2">
                                                    View
                                                    </Link>

                                                    <Link :href="route(
                                                        'user.edit',
                                                        { id: xuser.id }
                                                    )
                                                        " class="p-2 px-6 rounded my-auto text-white bg-blue-500 m-2">
                                                    Reset
                                                    </Link>

                                                    <Dialog>
                                                        <DialogTrigger asChild>
                                                            <Button
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
                                                                    <div v-if="xuser.picture" class="w-full">
                                                                        <img :src="xuser.picture" alt="" srcset=""
                                                                            class="border-2 rounded-lg">
                                                                    </div>
                                                                    <div className="flex flex-col gap-2 py-4 w-100 sm:max-w-lg">
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="name">
                                                                                Name : &nbsp;&nbsp;{{
                                                                                    xuser.name }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="email">
                                                                                Email : &nbsp;&nbsp;{{ xuser.email }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="role">
                                                                                Role : &nbsp;&nbsp;{{
                                                                                    xuser.role }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="created_at">
                                                                                created_at : &nbsp;&nbsp;{{
                                                                                    xuser.created_at }}
                                                                            </Label>
                                                                        </div>
                                                                        <div className="grid items-center gap-2 w-100">
                                                                            <Label for="updated_at">
                                                                                updated_at : &nbsp;&nbsp;{{
                                                                                    xuser.updated_at }}
                                                                            </Label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <DialogFooter>
                                                                <Link :href="route(
                                                                    'user.delete',
                                                                    { id: xuser.id })"
                                                                    class="flex p-2 px-1 rounded my-auto text-white bg-red-500 m-1 justify-center items-center w-35">
                                                                Delete Forever
                                                                </Link>
                                                            </DialogFooter>
                                                        </DialogContent>
                                                    </Dialog>

                                                </div>

                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                        <div v-if="xuser.picture" class="grid gap-2 w-[50px]">
                                            <img :src="xuser.picture" alt="" srcset="" class="border-2 rounded-lg">
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ xuser.id}}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ xuser.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ xuser.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-2">
                                        {{ xuser.role }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    </div>
                    <!-- End of Pagination Table -->

                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
