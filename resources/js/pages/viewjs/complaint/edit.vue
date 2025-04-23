
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
import { ref } from 'vue';

interface Props {
    complaint: Object,
}
const props = defineProps<Props>();

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    id: props.complaint.id,
    accountnumber: props.complaint.accountnumber,
    name: props.complaint.name,
    address: props.complaint.address,
    complaint: props.complaint.complaint,
    description: props.complaint.description,
    picture: props.complaint.picture,
    image_file: null,
    created_at: props.complaint.created_at,
    updated_at: props.complaint.updated_at,
});

const imageURL = ref(form.picture);
const onPictureChange = (event) => {
    const files = event.target.files;
    imageURL.value = URL.createObjectURL(files[0]);
    form.image_file = files[0];
}

const submit = () => {
    console.log(form);
    form.post(route('complaint.update', { id: form.id }), {
        preserveScroll: true,
    });
};

// Start Declaration of Web Cam Function to take photo
// find <!-- Start of Web Cam Component --> to see the html component
// find #WebCam to see the css file component. it requires scss
import {Vue3CameraQrcodeReader} from 'vue3-camera-qrcode-reader';

const camera = ref(null);
const show_picture = ref(true);

const startCam = () => {
    camera.value.flip();
    show_picture.value = !show_picture.value;
};

const handleTakePix = (event: { URL: object, File: object }) => {
    imageURL.value = event.URL;   // url
    form.image_file = event.File; // file
    show_picture.value = true;
};

const handleEncodeQRCode = (event: { QRCode: string }) => {
    console.log(event.QRCode); // QR Code Value in Text/string form
    show_picture.value = true;
};
// End Declaration of Web Cam Function

const headTitle = "Modify Customer Complaint";
const description = "Input data change for customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Edit Complaint',
    href: '/complaint/edit',
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
                        <Label for="accountnumber">
                            Account Number
                        </Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required
                            autocomplete="accountnumber" placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                            placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="address">Address</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.address" required
                            autocomplete="address" placeholder="Address" />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="complaint">Complaint</Label>
                        <Input id="complaint" class="mt-1 block w-full" v-model="form.complaint" required
                            autocomplete="complaint" placeholder="complaint" />
                        <InputError class="mt-2" :message="form.errors.complaint" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Input id="description" class="mt-1 block w-full" v-model="form.description" required
                            autocomplete="description" placeholder="Description" />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="picture">Picture</Label>
                        <div v-if="imageURL && show_picture" class="grid gap-2">
                            <img :src="imageURL" alt="" srcset="" class="border-2 rounded-lg">
                        </div>

                        <Vue3CameraQrcodeReader ref="camera" visible="false" @onTakePicture="handleTakePix"
                            @onEncodeQRCode="handleEncodeQRCode" />

                        <div class="flex">
                            <Input type="file" accept="image/*" @change="onPictureChange" id="picture"
                                class="mt-1 block w-full rounded-r-none" autocomplete="picture" placeholder="picture" />
                            <Button type="button" @click="startCam" class="mt-1 rounded-l-none bg-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-camera-icon lucide-camera">
                                    <path
                                        d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                            </Button>
                        </div>
                        <InputError class="mt-2" :message="form.errors.image_file" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                            <Button :disabled="form.processing">Save</Button>
                        </div>
                    </div>
                </form>
            </div>

        </SettingsLayout>
    </AppLayout>
</template>


<style lang="scss" scoped>
#WebCam {
    #video {
        border: 1px solid black;
        width: 320px;
        height: 240px;
    }

    #photo {
        border: 1px solid black;
        width: 320px;
        height: 240px;
    }

    #canvas {
        display: none;
    }

    .camera {
        width: 320px;
        display: inline-block;
    }

    .output {
        width: 340px;
        display: inline-block;
    }

    .contentarea {
        font-size: 16px;
        font-family: Arial;
        text-align: center;
    }
}
</style>
