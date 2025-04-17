<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, CloudMoon, UserRoundPlus, TableProperties } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// start of fetching user data
import { type SharedData, type User } from '@/types';
const page = usePage<SharedData>();
const user = page.props.auth.user as User;
// end of fetching user data

const allMenuItems = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        show: true,
    },
    {
        title: 'Register New User',
        href: '/register',
        icon: UserRoundPlus,
        show: (user&&(user.role === 'admin')),
    },
    {
        title: 'Users List',
        href: '/user/index',
        icon: TableProperties,
        show: (user&&(user.role === 'admin')),
    },
    {
        title: 'Complains',
        href: '/complaint',
        icon: CloudMoon,
        show: true,
    },
];

const mainNavItems: NavItem[] = allMenuItems.filter((item) => {
    return (item.show === true);
});

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('home')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
