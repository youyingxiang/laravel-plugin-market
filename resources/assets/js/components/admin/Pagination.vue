<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" v-if="meta.last_page > 1">

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          共 {{ meta.total }} 条数据
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <template v-for="(link, index) in meta.links">
            <router-link :to="{'name':routeName,params:{...this.$route.params},query:{...this.$route.query, 'page': parseInt(page) - 1}}" v-if="index === 0 && link.url" :class="[link.active ? currentClass : defaultClass]" class="relative inline-flex items-center px-2 py-2 rounded-l-md border text-sm font-medium">
              <span class="sr-only">上一叶</span>
              <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
            </router-link>
            <router-link :to="{'name':routeName,params:{...this.$route.params}, query:{...this.$route.query,'page':parseInt(page) + 1}}" v-else-if="index === meta.links.length-1 && link.url"  :class="[link.active ? currentClass : defaultClass]" class="relative inline-flex items-center px-2 py-2 rounded-r-md border text-sm font-medium">
              <span class="sr-only">下一页</span>
              <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
            </router-link>
            <router-link :to="{'name':routeName,params:{...this.$route.params}, query:{...this.$route.query,'page':link.label}}" v-else-if="index > 0 && index < meta.links.length-1" :class="[link.active ? currentClass : defaultClass]" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              {{link.label}}
            </router-link>
          </template>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'

export default {
  components: {
    ChevronLeftIcon,
    ChevronRightIcon,
  },
  inject: ['reload'],
  data() {
    return {
      currentClass: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600",
      defaultClass: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50",
    }
  },
  mounted() {
    this.reload()
  },
  watch: {
    $route(form, to) {
      if (form.name === to.name) {
        this.reload()
      }
    },
  },

  computed:{
    routeName() {
      return this.$route.name
    },
    page() {
      return this.$route?.query?.page ?? 1
    }
  },
  props:['meta'],

}
</script>