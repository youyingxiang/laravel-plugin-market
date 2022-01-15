<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-white border-b border-gray-200" v-slot="{ open }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <div class="flex-shrink-0">
                <svg t="1641991191764" class="icon block h-8 w-8" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1806" width="200" height="200"><path d="M640 85.333333a42.666667 42.666667 0 0 1 42.666667 42.666667v128h42.666666a128 128 0 0 1 128 128v128a256 256 0 0 1-256 256h-42.666666v128a42.666667 42.666667 0 0 1-85.333334 0v-128h-42.666666a256 256 0 0 1-256-256V384a128 128 0 0 1 128-128h42.666666V128a42.666667 42.666667 0 1 1 85.333334 0v128h170.666666V128a42.666667 42.666667 0 0 1 42.666667-42.666667z m85.333333 256H298.666667a42.666667 42.666667 0 0 0-42.666667 42.666667v128a170.666667 170.666667 0 0 0 170.666667 170.666667h170.666666a170.666667 170.666667 0 0 0 170.666667-170.666667V384a42.666667 42.666667 0 0 0-42.666667-42.666667z" p-id="1807" fill="#6366f1"></path></svg>
              </div>
              <div class="flex-shrink-0">
                <router-link :to="{name:'home-index'}" class="text-gray-900 rounded-md py-2 px-3 text-sm font-medium tracking-wider" aria-current="page">
                  Laravel Plugin
                </router-link>
              </div>
            </div>
            <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
              <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                {{ item.name }}
              </a>
            </div>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Profile dropdown -->
            <Menu as="div" class="ml-3 relative" v-if="isLogin">
              <div>
                <MenuButton class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <span class="sr-only">Open user menu</span>
                  <img class="h-8 w-8 rounded-full" v-show="userInfo?.avatar"  :src="userInfo?.avatar" alt="" />
                </MenuButton>
              </div>
              <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <MenuItem v-slot="{ active }">
                    <router-link :to="{name: 'users-plugins'}" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                      插件管理
                    </router-link>
                  </MenuItem>
                  <MenuItem v-slot="{ active }" v-if="userInfo.is_admin">
                    <router-link :to="{name: 'admin-index'}" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                      后台
                    </router-link>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a @click='logout' :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                      登出
                    </a>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
            <template v-else>
              <a href="login" class="ml-3 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700">
                登录
              </a>
              <a href="register" class="m-3 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700">
                注册
              </a>
            </template>
          </div>
          <div class="-mr-2 flex items-center sm:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800', 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">
            {{ item.name }}
          </DisclosureButton>

          <router-link v-if="!isLogin" :to="{name: 'register'}" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            注册
          </router-link>
          <router-link v-if="!isLogin" :to="{name: 'login'}" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
            登录
          </router-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200" v-if="isLogin">
          <div class="flex items-center px-4" >
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" v-show="userInfo?.avatar" :src="userInfo?.avatar" alt="" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">{{ userInfo.name }}</div>
              <div class="text-sm font-medium text-gray-500">{{ userInfo.email }}</div>
            </div>
            <button type="button" class="ml-auto bg-white flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-3 space-y-1">
            <DisclosureButton :to="{name: 'users-plugins'}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              插件管理
            </DisclosureButton>
            <DisclosureButton v-if="userInfo.is_admin" :to="{name: 'admin-index'}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              后台
            </DisclosureButton>
            <DisclosureButton @click="logout" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
              登出
            </DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <alert :message="this.$root.alert.message" :type="this.$root.alert.type" :auto-close="this.$root.alert.autoClose" :time="this.$root.alert.time"></alert>
    </div>
    <div class="py-5">
      <header v-if="desc">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold leading-tight text-gray-900">
            {{desc}}
          </h1>
        </div>
      </header>
      <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          <!-- Replace with your content -->
          <slot></slot>
          <!-- /End replace -->
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import Alert from "../Alert";

const navigation = [
  { name: '文档', href: 'http://docs.you-tang.com/', current: false },
  { name: 'Github', href: 'https://github.com/youyingxiang/laravel-plugin', current: false },
]

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
    Alert
  },
  props:['desc'],
  computed:{
    isLogin() {
      return this.$root.isLogin
    },
    userInfo() {
      return this.$root.userInfo
    }
  },
  methods: {
    logout() {
      this.$root.token = "";
      this.$router.push({name : "login"})
    }
  },
  setup() {
    return {
      navigation,
    }
  },
}
</script>