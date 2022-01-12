<template>
  <div class="rounded-md p-4" :class="bgColor50" v-show="show">
    <div class="flex">
      <div class="flex-shrink-0">
        <CheckCircleIcon  v-if="type === 'success'" class="h-5 w-5 text-green-400" aria-hidden="true" />
        <XCircleIcon v-if="type === 'error'" class="h-5 w-5 text-red-400" aria-hidden="true" />
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium" :class="textColor800">
          {{message}}
        </p>
      </div>
      <div class="ml-auto pl-3">
        <div class="-mx-1.5 -my-1.5">
          <button type="button" :class="hoverBg100" class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2">
            <span class="sr-only">Dismiss</span>
            <XIcon class="h-5 w-5" aria-hidden="true" @click="close"/>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { CheckCircleIcon, XIcon, XCircleIcon } from '@heroicons/vue/solid'

export default {
  props: ['message', 'autoClose', 'type', 'time'],
  data(){
    return {
      timeout: null,
      show: null
    }
  },
  computed: {
    bgColor50() {
      return {
        'bg-green-50': this.type === "success",
        'bg-red-50': this.type === "error"
      }
    },
    textColor800() {
      return {
        'text-green-800': this.type === "success",
        'text-red-800': this.type === "error"
      }
    },
    hoverBg100() {
      return {
        'hover:bg-green-100 text-green-500 focus:ring-offset-green-50 focus:ring-green-600': this.type === "success",
        'hover:bg-red-100 text-red-500 focus:ring-offset-red-50 focus:ring-red-600': this.type === "error"
      }
    },
  },
  watch: {
    time() {
      document.body.scrollTop = 0
      document.documentElement.scrollTop = 0
      this.show = true
      if (this.autoClose) {
        this.timeout = setTimeout(() => {
          this.close();
        }, this.autoClose);
      }
    }
  },

  methods: {
    /**
     * Close the alert.
     */
    close() {
      clearTimeout(this.timeout);
      this.show = false;
    }
  },
  components: {
    CheckCircleIcon,
    XIcon,
    XCircleIcon
  },
}
</script>