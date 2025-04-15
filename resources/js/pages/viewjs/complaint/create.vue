<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    complaints: { type: Array, },
}

defineProps<Props>();

const headTitle = "Create New Customer Complaint";
const description = "Create a new customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Create New Complaint',
    href: '/complaint/create',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    accountnumber: "",
    name: "",
    address: "",
    complaint: "",
    description: "",
    picture: "xxxxx",
    image_file: null,
});

// Register the form with into local storage
//import mem from '@/extra/gboi_memory';
//mem.register('complaint', form);

const imageURL = ref();
const onPictureChange = (event) => {
    const files = event.target.files;
    imageURL.value = URL.createObjectURL(files[0]);
    form.image_file = files[0];
};

const submit = () => {
    form.post(route('complaint.post'), {
        preserveScroll: true,
    });
};

const imagestr = ref(null);
const imageremarks = ref(null);
const showcam = ref(false);
const startWebCam = (imageRef, captionRef) => {
    var width = 620; // We will scale the photo width to this
    var height = 0; // This will be computed based on the input stream
    var streaming = false;
    var video = null;
    var canvas = null;
    var startbutton = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        startbutton = document.getElementById('startbutton');

        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        })
            .then(function (stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function (err) {
                console.log("An error occurred: " + err);
            });

        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);
                if (isNaN(height)) {
                    height = width / (4 / 3);
                }
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        startbutton.addEventListener('click', function (ev) {
            takepicture();
            ev.preventDefault();
        }, false);

        clearphoto();
    }
    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);

        var data = canvas.toDataURL('image/png');
    }
    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            imageRef.value = canvas;
            imageURL.value = data;
            canvas.toBlob((blob) => {
                form.image_file = blob;
            });
            captionRef.value = "Portrait Picture";
        } else {
            clearphoto();
        }
    }
    startup();
}

const startCam = () => {
    startWebCam(imagestr, imageremarks);
    showcam.value = !showcam.value;
}

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6  max-w-xl">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
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
                        <div v-if="imageURL && !showcam" class="grid gap-2">
                            <img :src="imageURL" alt="" srcset="" class="border-2 rounded-lg">
                        </div>
                        <!-- Start of Web Cam Component -->
                        <div class="relative">
                            <div v-show="showcam" id="WebCam" class="text-white absolute bottom-0">
                                <div class="contentarea relative">
                                    <h1 class=" translate-y-6 text-amber-800">
                                        Active Webcam Video
                                    </h1>
                                    <canvas id="canvas" class="border-4 absolute top-0 left-0 z-0 rounded-lg overflow-hidden">
                                    </canvas>
                                    <div class="camera border-4 z-10  rounded-lg overflow-hidden">
                                        <video id="video">Video stream not available.</video>
                                    </div>
                                    <div class="z-100 -translate-y-15">
                                        <button @click="startCam" class="p-2 rounded-full my-auto text-white bg-green-600 hover:bg-green-400 active:bg-violet-700"
                                            id="startbutton">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-instagram-icon lucide-instagram">
                                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Web Cam Component -->
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
                        <InputError class="mt-2" :message="form.errors.picture" />
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
