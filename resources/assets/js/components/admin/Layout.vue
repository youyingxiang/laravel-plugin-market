
<template>

  <div>
    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="border-r border-gray-200 pt-5 flex flex-col flex-grow bg-white overflow-y-auto">
        <div class="flex-shrink-0 px-4 flex items-center">
            <h1 class="text-2xl font-semibold text-gray-900 tracking-wider">Laravel - Plugin</h1>
        </div>
        <div class="flex-grow mt-5 flex flex-col">
          <nav class="flex-1 px-2 pb-4 space-y-1">
            <router-link v-for="item in navigation" :key="item.name" :to="item.to" :class="[item.to.name === routeName ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group rounded-md py-2 px-2 flex items-center text-sm font-medium']">
              <component :is="item.icon" :class="[item.current ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
              {{ item.name }}
            </router-link>
          </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
          <a href="#" @click="logout" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
              <div class="">
                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                  退出登录
                </p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1">
          <div class="py-6 max-w-7x space-y-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
              <alert :message="this.$root.alert.message" :type="this.$root.alert.type" :auto-close="this.$root.alert.autoClose" :time="this.$root.alert.time"></alert>
              <h1 class="text-2xl font-semibold text-gray-900">{{desc}}</h1>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
              <!-- Replace with your content -->
              <slot></slot>
              <!-- /End replace -->
            </div>
          </div>
        </main>
      </div>
 </div>

</template>

<script>
import Alert from "../Alert";
import { ref } from 'vue';
import _ from 'lodash';
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  BellIcon,
  FolderIcon,
  MenuAlt2Icon,
  UsersIcon,
  XIcon,
  CalendarIcon
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'

const navigation = [
  { name: '注册用户', to: {'name': 'admin-users'}, icon: UsersIcon},
  { name: '上传插件', to: {'name': 'admin-plugins'}, icon: FolderIcon},
  { name: '下载记录', to: {'name': 'admin-download-histories'}, icon: CalendarIcon},
]

export default {
  components: {
    Alert,
    CalendarIcon,
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    BellIcon,
    MenuAlt2Icon,
    SearchIcon,
    XIcon,
  },

  computed: {
    routeName() {
       if (this.$route.name === "admin-plugin-versions-show") {
         return "admin-plugins"
       }
       return this.$route.name;
    },

    desc() {
      return _.filter(navigation, (nav) =>{
          return nav.to.name === this.routeName
      })[0].name
    }
  },
  methods: {
    logout() {
      this.$root.token = "";
      this.$router.push({name : "login"})
    }
  },

  setup() {
    const sidebarOpen = ref(false)

    return {
      navigation,
      sidebarOpen,
    }
  },
}
</script>