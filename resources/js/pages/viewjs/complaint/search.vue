<script setup lang="ts">

import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Ref, ref } from 'vue'
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

// Start of retreiving current user data
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
// End of retreiving  current user data

// Start of Declaration for User Input Form
const form = useForm({
    'accountnumber': localStorage.getItem("accountnumber_jaed"),
});
// End of Declaration for User Input Form

// Start User Input Form Submittal Event Handler, Send Message To the Router
const submit = () => {
    localStorage.setItem("accountnumber_jaed", form.accountnumber); // optional saving of form input
    form.get(route('complaint.index'), {
        preserveScroll: true,
    });
};
// End User Input Form Submittal Event Handler

/*
// Start of Declaration of QRCode Reader with Video Projection
import { BrowserMultiFormatReader } from '@zxing/browser';
const imagestr = ref(null);
const imageremarks = ref(null);
const showcam = ref(false);
const streamSrc = ref();
const codeReader = ref();
const startWebCam = (imageRef: Ref<null, null>, captionRef: Ref<null, null>) => {
    var width = 620; // We will scale the photo width to this
    var height = 0; // This will be computed based on the input stream
    var streaming = false;
    var video: HTMLElement | null = null;
    var canvas: HTMLElement | null = null;
    var startbutton = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        startbutton = document.getElementById('startbutton');

        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        }).then(function (stream) {
                streamSrc.value = stream;
                video.srcObject = stream;
            }).catch(function (err) {
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
        clearphoto();
    };

    function clearphoto() {
        const context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
    };

    startup();
};

const startCam = () => {
    form.accountnumber = "";
    startWebCam(imagestr, imageremarks);
    showcam.value = !showcam.value;
    if (!showcam.value) {
        if (codeReader.value)
            codeReader.value.reset();
    } else {
        //const codeReader = new BrowserQRCodeReader();
    };

    codeReader.value = new BrowserMultiFormatReader();
    codeReader.value.decodeFromVideoDevice(streamSrc.value, 'video', (result: { text: string | null; }, err: string | null) => {
        if (result) {
            if (showcam.value === true){
                localStorage.setItem("accountnumber_jaed", result.text);
                form.accountnumber = result.text;
                showcam.value = false;
                submit();
            }
            codeReader.value.reset();
        }
        if (err && !(err)) {
            console.error(err);
            form.accountnumber = err;
        }
    });
};
*/

// Start Declaration of Web Cam Function to take photo
// find <!-- Start of Web Cam Component --> to see the html component
// find #WebCam to see the css file component. it requires scss
import { Vue3CameraQrcodeReader } from 'vue3-camera-qrcode-reader';

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
    localStorage.setItem("accountnumber_jaed", event.QRCode);
    form.accountnumber = event.QRCode;
    submit();
    console.log(event.QRCode); // QR Code Value in Text/string form
    show_picture.value = true;
};
// End Declaration of Web Cam Function

//Start of Declaration of Page Title
const headTitle = "Complaint Search";
const description = "Searches for Complaints in the Master list of customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Complaint Search',
    href: '/complaint/search',
},];

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

                        <div class="flex">
                            <Input id="accountnumber" class="mt-1 block w-full" required ref="accountnumber"
                                v-model="form.accountnumber" autofocus autocomplete="accountnumber"
                                placeholder="accountnumber" />
                            <Button type="button" @click="startCam" class="mt-1 rounded-l-none bg-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-scan-line-icon lucide-scan-line">
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                    <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                    <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                    <path d="M7 12h10" />
                                </svg>
                            </Button>
                        </div>

                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>
                    <!-- Start of QRCODE SCANNER Web Cam Component
                    <div class="relative">
                        <div v-show="showcam" id="WebCam" class="text-white absolute bottom-0">
                            <div class="contentarea relative">
                                <h1 class=" translate-y-8 -translate-x-14 text-amber-800">
                                    QR Code Scanner
                                </h1>
                                <canvas id="canvas"
                                    class="border-4 absolute top-0 left-0 z-0 rounded-lg overflow-hidden">
                                </canvas>
                                <div class="camera border-4 z-10  rounded-lg overflow-hidden">
                                    <video id="video">Video stream not available.</video>
                                </div>
                                <div class="z-100 -translate-y-15">
                                </div>
                            </div>
                        </div>
                    </div>
                    End of QRCODE SCANNER Web Cam Component -->

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Search</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="relative">
                        <Vue3CameraQrcodeReader ref="camera" visible="false" @onTakePicture="handleTakePix"
                        @onEncodeQRCode="handleEncodeQRCode" />
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
