<template>

  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 z-40 flex md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative max-w-xs w-full bg-white pt-5 pb-4 flex-1 flex flex-col">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-14 p-1">
                <button type="button" class="h-12 w-12 rounded-full flex items-center justify-center focus:outline-none focus:bg-gray-600" @click="sidebarOpen = false">
                  <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  <span class="sr-only">Close sidebar</span>
                </button>
              </div>
            </TransitionChild>
            <div class="flex-shrink-0 px-4 flex items-center">
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/easywire-logo-purple-600-mark-gray-900-text.svg" alt="Easywire" />
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
              <nav class="h-full flex flex-col">
                <div class="space-y-1">
                  <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-purple-50 border-purple-600 text-purple-600' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group border-l-4 py-2 px-3 flex items-center text-base font-medium']" :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" :class="[item.current ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                    {{ item.name }}
                  </a>
                </div>
                <div class="mt-auto pt-10 space-y-1">
                  <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href" class="group border-l-4 border-transparent py-2 px-3 flex items-center text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <component :is="item.icon" class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                    {{ item.name }}
                  </a>
                </div>
              </nav>
            </div>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <nav class="bg-gray-50 border-r border-gray-200 pt-5 pb-4 flex flex-col flex-grow overflow-y-auto">
        <div class="flex-shrink-0 px-4 flex items-center">
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/easywire-logo-purple-600-mark-gray-900-text.svg" alt="Easywire" />
        </div>
        <div class="flex-grow mt-5">
          <div class="space-y-1">
            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-purple-50 border-purple-600 text-purple-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50', 'group border-l-4 py-2 px-3 flex items-center text-sm font-medium']">
              <component :is="item.icon" :class="[item.current ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
              {{ item.name }}
            </a>
          </div>
        </div>
        <div class="flex-shrink-0 block w-full">
          <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href" class="group border-l-4 border-transparent py-2 px-3 flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
            <component :is="item.icon" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6" aria-hidden="true" />
            {{ item.name }}
          </a>
        </div>
      </nav>
    </div>

    <!-- Content area -->
    <div class="md:pl-64">
      <div class="max-w-4xl mx-auto flex flex-col md:px-8 xl:px-0">
        <main class="flex-1">
          <div class="relative max-w-4xl mx-auto md:px-8 xl:px-0">
            <div class="pt-10 pb-16">
              <div class="px-4 sm:px-6 md:px-0">
                <h1 class="text-3xl font-extrabold text-gray-900">Settings</h1>
              </div>
              <div class="px-4 sm:px-6 md:px-0">
                <div class="py-6">
                  <slot></slot>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import {
  Dialog,
  DialogOverlay,
  Switch,
  SwitchGroup,
  SwitchLabel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  BellIcon,
  BriefcaseIcon,
  CogIcon,
  HomeIcon,
  MenuAlt2Icon,
  XIcon,
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'

const navigation = [
  { name: 'Home', href: '#', icon: HomeIcon, current: false },
  { name: 'Jobs', href: '#', icon: BriefcaseIcon, current: false },
]
const secondaryNavigation = [
  { name: 'Logout', href: '#', icon: CogIcon },
]
const tabs = [
  { name: 'General', href: '#', current: true },
  { name: 'Password', href: '#', current: false },
  { name: 'Notifications', href: '#', current: false },
  { name: 'Plan', href: '#', current: false },
  { name: 'Billing', href: '#', current: false },
  { name: 'Team Members', href: '#', current: false },
]

export default {
  components: {
    Dialog,
    DialogOverlay,
    Switch,
    SwitchGroup,
    SwitchLabel,
    TransitionChild,
    TransitionRoot,
    BellIcon,
    MenuAlt2Icon,
    SearchIcon,
    XIcon,
  },
  setup() {
    const sidebarOpen = ref(false)
    const automaticTimezoneEnabled = ref(true)
    const autoUpdateApplicantDataEnabled = ref(false)

    return {
      navigation,
      secondaryNavigation,
      tabs,
      sidebarOpen,
      automaticTimezoneEnabled,
      autoUpdateApplicantDataEnabled,
    }
  },
}
</script>