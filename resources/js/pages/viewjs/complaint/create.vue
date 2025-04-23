<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage, } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

// Start of retreiving single item data to be shown in the form from create controller
interface Props {
    complaint: Object,
}
const props = defineProps<Props>();
// End of retreiving single item data to be shown

// Start of retreiving current user data
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
// End of retreiving  current user data

// Start of declation for form input data
const form = useForm({
    accountnumber: "",
    name: "",
    address: "",
    complaint: "",
    description: "",
    picture: "xxxxx",
    image_file: null,
});
// End of declation for form input data

// Start of declaration of Misc. Event handlers
const imageURL = ref();
const onPictureChange = (event) => {
    const files = event.target.files;
    imageURL.value = URL.createObjectURL(files[0]);
    form.image_file = files[0];
};
// End of declaration of Misc. Event handlers

// Start of declaration of main submit event handler
const submit = () => {
    form.post(route('complaint.post'), {
        preserveScroll: true,
    });
};
// End1 of declaration of main submit event handler

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
    console.log(event.QRCode); // QR Code Value in Text/string form
    show_picture.value = true;
};
// End Declaration of Web Cam Function


//
import { Progress } from '@/components/ui/progress'; // a shadcn component
import { Vue3OcrPhDriverLicenseParser } from 'vue3-ocr-ph-driver-license-parser';
const parser1 = ref();
const textOutput = ref();
const imageDOM = ref();
const progress = ref(0);
const fileChange = (event) => {
    parser1.value.openFile(event.target.files[0]);
    console.log(event);
}
const handleParse = (event) => {
    console.log("output ng laravel...........");
    console.log("output ng laravel...........", event);
}
const handleProgress = (event) => {
    progress.value = event;
}
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//import { ref } from 'vue'; // optional

const training_data = [
    {
        name: "Felipe",
        images: ["/labels/Felipe/1.jpg", "/labels/Felipe/2.jpg"],
    },
    {
        name: "Messi",
        images: ["/labels/Messi/1.jpg", "/labels/Messi/2.jpg"],
    },
    {
        name: "Data",
        images: ["/labels/Data/1.jpg", "/labels/Data/2.jpg"],
    },
    {
        name: "Garry",
        images: [
            "/labels/Garry/1.jpg", "/labels/Garry/2.jpg",
            "https://scontent.fdvo2-1.fna.fbcdn.net/v/t39.30808-6/453301894_26310634645219263_3469027653173770258_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeHCpk4D4t5CVeLOE_JMcDTpft99dKY79sJ-3310pjv2wtDhfRTIv1arY14mYB2u1nXtzOLNKgHeRerMfG5tlf_P&_nc_ohc=SeZ66R3VKIAQ7kNvwHg_g6j&_nc_oc=AdnlOZYS0pooK5qGni_bjxemqQL4VnT0dUZjkYRfQVc-DAUuR7xyk8Bx4fQDOCCze2I&_nc_zt=23&_nc_ht=scontent.fdvo2-1.fna&_nc_gid=rU5kgJZx2t4Vp9Je_2DFoQ&oh=00_AfFthUPswuK-8ZwB7wOEetfk0eKenltbvoTv9WSpikIZ6A&oe=680E4465",
            "https://scontent.fcgy1-1.fna.fbcdn.net/v/t39.30808-6/461169407_8297452433675803_2581180205887555989_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=aa7094&_nc_eui2=AeE1MmEwNmZgH4YfU5oaaGxOEYJWzx86KdARglbPHzop0KvUvOyPNaIccX8LxrPurC0p1DO6t5Ph6NVKudDKaGQm&_nc_ohc=6JhAV5gAMzIQ7kNvwEqm9L0&_nc_oc=AdmPBkfghsId8zLQ2hOF4mqn2qrSurYCwzB-I5gzj4wvWTDydRVKgB_Vs9YkV8PGzhQ&_nc_zt=23&_nc_ht=scontent.fcgy1-1.fna&_nc_gid=ELwHI6XCpCvKjbmT8BV3pA&oh=00_AfF8GW4UhthvaI0CMy5wHSApGAC_iR_HG3hrRWiDhWtYKw&oe=680E0BBF",
            "https://scontent.fceb2-1.fna.fbcdn.net/v/t39.30808-6/461169407_8297452433675803_2581180205887555989_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=aa7094&_nc_eui2=AeE1MmEwNmZgH4YfU5oaaGxOEYJWzx86KdARglbPHzop0KvUvOyPNaIccX8LxrPurC0p1DO6t5Ph6NVKudDKaGQm&_nc_ohc=CPO8LbJPZYQQ7kNvwHF-UQU&_nc_oc=AdmR5xrKx9vkaKWnMGp-bqSMCNklQBN_CH7ZlRPDTZp3YeBasfLMMHA760P13_SLhe4&_nc_zt=23&_nc_ht=scontent.fceb2-1.fna&_nc_gid=_Bf0AbCR_CbcsT8w9WPTUA&oh=00_AfGESaVu1oUHVBMz0XkOqnJfe-nUp0AWzsmQgiq-IJmtjg&oe=6809363F",
            "https://scontent.fceb6-1.fna.fbcdn.net/v/t39.30808-6/465782553_10161159446454092_2602332091773645185_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeEwPDqJ9shkkRQ5j_hOxEHpPri_tAn3tbM-uL-0Cfe1sxVmy_BY3-dbv_hh5b3g1VzaYEj_-_22-IBau8v57Yap&_nc_ohc=ZAeOf5oASDsQ7kNvwELJH6X&_nc_oc=AdlF9FFdpz-y-DcZtyMQRekSeOHd-icsOT1ya8X3X0vWnWANzRnJaTADMkknrBhqbEM&_nc_zt=23&_nc_ht=scontent.fceb6-1.fna&_nc_gid=8MP3IEYSR7e6QlhG0oGDSQ&oh=00_AfG2FSV2DdpKCHQ9tw-muwnEBdUgZ-siE-AE_uC-ZImG0A&oe=68090FA2",
            "https://scontent.fceb2-1.fna.fbcdn.net/v/t39.30808-6/459889279_26849214878027901_7013988479687942446_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeHcYAsHBZ2mkVlT1joelLSLLsp7SJ6QGW4uyntInpAZbkxDXinJa1SZviZDySx5USHx6hEbyj561n1vUFxJp4uD&_nc_ohc=Z8FSSCpto88Q7kNvwGp7Rz4&_nc_oc=AdnPhiaO2ZP30QndE4C7WDlpmRTm7mnMjzX-qGA-Z6jbVGkEVqnV-aS2ZDL7csGbYW0&_nc_zt=23&_nc_ht=scontent.fceb2-1.fna&_nc_gid=sPTcoXXdAfW7dISkXrqRMg&oh=00_AfEqmIUDh_ByfWCPFLBmqkwDgIJiuv5aNUwcJwl-Vo14KA&oe=680931E1",
        ],
    },
    {
        name: "Sweet Sweet",
        images: [
            "https://scontent.fceb2-2.fna.fbcdn.net/v/t39.30808-6/491958015_1741826886743679_6873391425685042853_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHTqABMWgJJfTJBd0B9m2x20_6z-2Lu52DT_rP7Yu7nYIXkz1KCfe7GjENMqv_R6pCGEC9uKUxqdQ0LJ1Uqy5BX&_nc_ohc=-W0v40B0ceAQ7kNvwGUGds5&_nc_oc=AdkVFWEnS5Idaf0l88SfbmgtZf9JuS9UvwyHx8hrVaOJPy4NhcVXAVuKtPCkOKrh_r0&_nc_zt=23&_nc_ht=scontent.fceb2-2.fna&_nc_gid=wyjIMIE864msBZWLGxpuEQ&oh=00_AfFiHg6wMdDKug2h_8tW1Xw873G_tj0mPLyP4Cc0zSPeJA&oe=6809009E",
            "https://scontent.fceb2-1.fna.fbcdn.net/v/t39.30808-6/488178180_1729791727947195_2749432054859476183_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeH1GlgJnsdR4CcAmC_YtIxpLsWmCdhr_KMuxaYJ2Gv8o_F-Je6Zd1oFeEK2AI0d6vn49EdwzUrlo1mDDcZ7xbbu&_nc_ohc=kecxgyQh5x8Q7kNvwFqjuUt&_nc_oc=AdlBtbY-FIw_8GGDigNEwqUer24WQlElVgT0SQ7AZS2s2t7FrWJfOA1jPnOUy3dRqXc&_nc_zt=23&_nc_ht=scontent.fceb2-1.fna&_nc_gid=CWUpWRnKSUGIklCKU31CnQ&oh=00_AfGPMcFoG81f4ElDUVbPL1_3di4DNIn3n1ElFrkqFcy2Iw&oe=6809309C",
            "https://scontent.fceb6-2.fna.fbcdn.net/v/t39.30808-6/482030338_1709345729991795_8441657627238964072_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeF5u8IS_IU0jdanyPg7O5zy0lVDHf0PfG7SVUMd_Q98buhRIiEXsieTcbJGaKWlaPrduCLV8TBBm1rkS8cQNxYy&_nc_ohc=ba8fqx6VaegQ7kNvwHQS6he&_nc_oc=AdlDdRJKtkl4ZlPVDoV-x6XSEOHvU-uSPs-ApqXNfm-35KGfOCA7zhEyLwDVB8ywPgA&_nc_zt=23&_nc_ht=scontent.fceb6-2.fna&_nc_gid=Z6xYJcOIB9VkNevw3dZVHA&oh=00_AfFUaaGVFsFf723B9SeAzSQQY05kY4tgpp3hGRj4G5Prww&oe=680901B2",
            "https://scontent.fceb6-2.fna.fbcdn.net/v/t39.30808-6/482018776_1705985003661201_6866237238867411005_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeHvPv0R13FDsAG1uGcDyBsRwDyrjtAjvDDAPKuO0CO8MM4X_g5_fPm8hVhel0j2HayOg4AB4vLpcV_mH6xXv-6f&_nc_ohc=eaq03aqEXE8Q7kNvwHRl-5T&_nc_oc=AdkpYV8IrDl-rtDVWiprOgRftXBhFR08JQqbtd7TJjVk_-LSiS-XKr3OPLps9TZmfUs&_nc_zt=23&_nc_ht=scontent.fceb6-2.fna&_nc_gid=WzeHRcYLlLs-p1Qd2_DOGw&oh=00_AfFxGRohxVzLx9zKQUZVFmtIJnUwlLh80ZwGvbBzh6uygA&oe=6808FED8",
        ],
    },
    {
        name: "Giannah Bella",
        images: [
            "../labels/Gianna/IMG20241003094453.jpg",
            "../labels/Gianna/IMG20241023130321.jpg",
            "https://scontent.fceb6-1.fna.fbcdn.net/v/t39.30808-6/469864420_18471408577017022_7695272385786972972_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeG3z5Z28E5GbtWUnZK0XbuWXBl4rNqzEThcGXis2rMROFAQKMPVXEPG91JgWzbl2g1b8swmLURzQZgdVIxzNssH&_nc_ohc=Mmj_krfxWoIQ7kNvwEa_z-W&_nc_oc=AdkUMijsy-k8KY3A7l4_bF5W__ftwJoqug-UKBDWfym0c11wcjpXKl6-3U6W3_Jyuss&_nc_zt=23&_nc_ht=scontent.fceb6-1.fna&_nc_gid=Q4SBVMufRI9VCOLdCXI_Kw&oh=00_AfEi7Y8chg3txwr5uz8Ik1ZYTyLokv2eCTnLigw_bKZ3Eg&oe=6809297D",
            "https://scontent.fceb6-1.fna.fbcdn.net/v/t39.30808-6/469702416_18471408886017022_9144433638876269205_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeHye2QTaZ-DKaEWB2Wb1DXEmNd_qH6yi5iY13-ofrKLmFj7OQM-mX7AiNmfCTFPWxeHjGzklVJh0GqxKNfHVQLM&_nc_ohc=pSbmkVjMQ88Q7kNvwE01KU3&_nc_oc=Adm4FsceleB48De0yYkH2Vxl2q4j3sgsgqj6yG5QdPD5MP_AerwuCNtLALJwVt9X9Rk&_nc_zt=23&_nc_ht=scontent.fceb6-1.fna&_nc_gid=BBMDBtxZ4wljeY9akYOi_w&oh=00_AfEEmEryv4wAsR1oZPltmRE9Nji3-HTgOz0i7dYDHVTWjQ&oe=6809120C",
        ],
    },
    {
        name: "Vann dela Cruz",
        images: [
            "https://scontent.fceb2-1.fna.fbcdn.net/v/t39.30808-6/491354487_4004770899842035_5313976838712998161_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeH7TR78nqlDUngtAS-Zy7oOssxkEtWrSBayzGQS1atIFh1h0-cj6An_w2ZMMXXCsuj9Y9XGKG_JCEnXMk9p-qBH&_nc_ohc=C-3YhyUcGqYQ7kNvwHKoizk&_nc_oc=AdnNGXkyNjD7hMr_AZRk6Kn5nfv3MwqYVU75HQW8Dez-iZECbeZUEtt8FWKzOETvuEU&_nc_zt=23&_nc_ht=scontent.fceb2-1.fna&_nc_gid=snTwFygwhYpS3FRIJtvJaQ&oh=00_AfGFYU1K1W4p5FYxbz4tO1YswxaScMC8sPMAiAArjWbGsw&oe=68090F17",
            "https://scontent.fceb2-2.fna.fbcdn.net/v/t39.30808-6/489770320_3997932953859163_3172372066499534477_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeF4l4mxlNI3E8HXfXp-QIQ_ikfHEThhJ7GKR8cROGEnsfBrONqmGWMv0HFduERoX11dbmnwdZaSod1P1m7eZYHm&_nc_ohc=8tAEeqMmE3IQ7kNvwED8H9B&_nc_oc=AdnSNgGP0lCEBerz-O6FJCtmYceiGYsWx6CMT3ZIpEeB-zcwVN_8xh8kEOPe9j_c2G4&_nc_zt=23&_nc_ht=scontent.fceb2-2.fna&_nc_gid=kQL4q8XA_rJETZPGkg3dQA&oh=00_AfFgZoGNbNhl7J9KsfLAiJ6wUH3YDw8E0NoFMLY-MYWRhQ&oe=6809082B",
        ],
    },
    {
        name: "Grace dela Cruz",
        images: [
            "https://scontent.fceb6-2.fna.fbcdn.net/v/t39.30808-6/463869766_10229680616574383_6364438004125494629_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeFU1kflmLSEKwO_C8FOFGURFwAqfQSeu-UXACp9BJ675dm3Om8ao2c0RLqYpD6oZtd_m6VUNoSR9_tEjGJO8D8v&_nc_ohc=Bpfn_ieahWYQ7kNvwENpR1t&_nc_oc=AdlGhR5AmCwjPuLZcnRWe0_nV2sqGWC8ixsGJpmrQuSwBW5DwhaQWco9Nuk3L1GkoA8&_nc_zt=23&_nc_ht=scontent.fceb6-2.fna&_nc_gid=Pbj-UJVb4-ew5IBbDkxRPQ&oh=00_AfExwU36V3Yc0rKVYY_yg0e9V-zOuHkXMpeUDAQzeqChwQ&oe=68093698",
            "https://scontent.fceb6-1.fna.fbcdn.net/v/t39.30808-6/463733405_10229680616614384_4238841187617797270_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeGbpuTUgSa0YK4hmBFTPqD59f4P6pGNt1z1_g_qkY23XGGWG9CrbsT6W89GU6XDzhY29vV2qSy6D-n0KieB6lqt&_nc_ohc=IjPN5BKx-Z4Q7kNvwEOoiD6&_nc_oc=AdmSFEimidSh3NiogLEIcMpMf6p3qngNKa6kOVjWp9o9wSa9KVtKRjvTWnyBU_2r-pk&_nc_zt=23&_nc_ht=scontent.fceb6-1.fna&_nc_gid=StOQodp2w-kWLuRb421R9g&oh=00_AfHNUWBtVn8bWEDJzWnr-Z2vjGEiCoTFE9eDiEVrrzbYlA&oe=68093637",
            "https://scontent.fceb2-2.fna.fbcdn.net/v/t39.30808-6/463427717_10213322873902156_5125227151273889082_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeFYMEuhothToEl5QrrhzllTGOv8iJG218UY6_yIkbbXxZSnQfvj5lxCY9MQSAOgOyJf5mcnhzSEM3NSDecAaHEO&_nc_ohc=4mwrzPL6jOMQ7kNvwFV3v9M&_nc_oc=AdkayC6Anh5a_47CAOcTfqbxER5Q5yrW2Dr2Mp1D7igppJ2iBBv1yQHERCuWcN9WVT8&_nc_zt=23&_nc_ht=scontent.fceb2-2.fna&_nc_gid=AFSzeivfkcdVZZUwdtJzCA&oh=00_AfE00HGPoea-kPF5qThcoNjp41PMDbFdxT5roqwmIMeHiA&oe=6809212E",
            "https://scontent.fceb2-2.fna.fbcdn.net/v/t39.30808-6/459741239_26849213654694690_5725659559917962669_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=cf85f3&_nc_eui2=AeH8HQQAdxfMXdmDmJHZLclwo8WaJe3EwQSjxZol7cTBBGVvrj9BmjiRhUDHJNYg3GtVqrO1mMiMpXP-z6T0kwAS&_nc_ohc=jRX49zOvuREQ7kNvwHYu-U0&_nc_oc=Adktxbcw-aLEwWYrF71fY3OTZVYF1UOnl_zdcAgK-oT_4XxyPZ6RdqabouRJ-0IfbG4&_nc_zt=23&_nc_ht=scontent.fceb2-2.fna&_nc_gid=gTOru11ySvkcSNa0y1eZVg&oh=00_AfFZ7NiLWJB9BrX0u_Cwk41jp-SjYGMbPa7la06K8VAv2g&oe=68093234",
        ],
    },
];

import { Vue3FaceRecog } from 'vue3-face-recog';
const video = ref();
const canvas2 = ref();
const faceRecog = ref();

onMounted(() => {
    faceRecog.value.startWebcam(); // maybe not needed
    faceRecog.value.loadModels("/models"); // be sure that /models exists with weight files
    setTimeout(() => {
        faceRecog.value.trainFaceMatching(training_data); // upon finish it will emit handleTrainingDone(xLabeledFaces) in which xLabeledFaces will be save externally
        // or
        // faceRecog.value.obtainFaceMatchingData (xLabeledFaces)
    }, 1000);
    setTimeout(() => {
        faceRecog.value.startFaceMatching();
    }, 4000);
});

const handleTrainingDone = (event) => {
    console.log("Training Done  ", event);
};
const handleMatchFace = (event) => {
    console.log("MatchFace Done  ", event);
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Start of Declaration of Page Title
const headTitle = "Create New Customer Complaint";
const description = "Create a new customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Create New Complaint',
    href: '/complaint/create',
},];
//End of Declaration of Page Title

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
                        <InputError class="mt-2" :message="form.errors.picture" />
                    </div>


                    <div ref="textOutput">
                        <Progress :model-value="progress" />
                    </div>
                    <img ref="imageDOM" />
                    <span>Open File</span>
                    <input type="file" accept="image/*" @change="fileChange" />
                    <Vue3OcrPhDriverLicenseParser ref="parser1" :textOutput="textOutput" :imageDOM="imageDOM"
                        @onProgress="handleProgress" @onParse="handleParse" />


                    <div class="relative m-0 p-0 border rounded-lg overflow-hidden w-[600px] h-[450]">
                        <video ref="video" width="600" height="450" autoplay class="border rounded-lg"></video>
                        <canvas ref="canvas2" width="600" height="450"
                            class="absolute top-0 left-0 border rounded-lg"></canvas>
                        <Vue3FaceRecog ref="faceRecog" :video="video" :canvas="canvas2"
                            @onTrainingDone="handleTrainingDone" @onMatchFace="handleMatchFace" />
                    </div>
                    <br>
                    <input type="text" class="border rounded-lg" />
                    <button
                        class="bg-black text-white px-4 rounded-lg hover:cursor-pointer hover:bg-gray-700 active:bg-gray-500">Save</button>

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
