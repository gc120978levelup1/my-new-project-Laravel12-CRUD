<script setup lang="ts">

import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue'
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
    'accountnumber': localStorage.getItem("accountnumber_jaed"),
});

const submit = () => {
    localStorage.setItem("accountnumber_jaed",form.accountnumber);
    form.get(route('complaint.index'), {
        preserveScroll: true,
    });
};

import { BrowserMultiFormatReader } from '@zxing/browser';
const imagestr = ref(null);
const imageremarks = ref(null);
const showcam = ref(false);
const streamSrc = ref();
const codeReader = ref();
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
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
        var data = canvas.toDataURL('image/png');
    };
    
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
    codeReader.value.decodeFromVideoDevice(streamSrc.value, 'video', (result, err) => {
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

                    <!-- Start of Web Cam Component -->
                    <div class="relative">
                        <div v-show="showcam" id="WebCam" class="text-white absolute bottom-0">
                            <div class="contentarea relative">
                                <h1 class=" translate-y-6 text-amber-800">
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
                    <!-- End of Web Cam Component -->

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Search</Button>
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
