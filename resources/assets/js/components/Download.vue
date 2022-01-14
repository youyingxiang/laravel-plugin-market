<template>
  <button @click="download()" :disabled="isLoading">
    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" v-show="isLoading">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <svg t="1642050340182" class="icon h-5 w-5 text-gray-400 hover:text-indigo-900" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2329" width="200" height="200"><path d="M828.975746 894.125047 190.189132 894.125047c-70.550823 0-127.753639-57.18542-127.753639-127.752616L62.435493 606.674243c0-17.634636 14.308891-31.933293 31.93227-31.933293l63.889099 0c17.634636 0 31.93227 14.298658 31.93227 31.933293l0 95.821369c0 35.282574 28.596292 63.877843 63.87682 63.877843L765.098927 766.373455c35.281551 0 63.87682-28.595268 63.87682-63.877843l0-95.821369c0-17.634636 14.298658-31.933293 31.943526-31.933293l63.877843 0c17.634636 0 31.933293 14.298658 31.933293 31.933293l0 159.699212C956.729385 836.939627 899.538849 894.125047 828.975746 894.125047L828.975746 894.125047zM249.938957 267.509636c12.921287-12.919241 33.884738-12.919241 46.807049 0l148.97087 148.971893L445.716876 94.89323c0-17.634636 14.300704-31.94762 31.933293-31.94762l63.875796 0c17.637706 0 31.945573 14.312984 31.945573 31.94762l0 321.588299 148.97087-148.971893c12.921287-12.919241 33.875528-12.919241 46.796816 0l46.814212 46.818305c12.921287 12.922311 12.921287 33.874505 0 46.807049L552.261471 624.930025c-1.140986 1.137916-21.664416 13.68365-42.315758 13.69286-20.87647 0.010233-41.878806-12.541641-43.020816-13.69286L203.121676 361.13499c-12.922311-12.933567-12.922311-33.884738 0-46.807049L249.938957 267.509636 249.938957 267.509636z" p-id="2330" fill="#707070"></path></svg>
  </button>
</template>

<script>
import axios from "axios";

export default {
  props:['versionId'],
  data() {
    return {
      isLoading: false
    }
  },
  inject: ['reload'],
  methods: {
    download() {
      if (this.isLoading === true) {
        return;
      }
      this.isLoading = true
      axios({
        method: 'post',
        url:"/api/pluginmarket/plugins/download/" + this.versionId,
        responseType: "arraybuffer"
      }).then(resp => {
        const filename = resp.headers["content-disposition"];
        const blob = new Blob([resp.data],{type:'application/zip'});
        let downloadElement = document.createElement("a"),
            href = window.URL.createObjectURL(blob);
        downloadElement.href = href;
        downloadElement.download = decodeURIComponent(filename.split("filename=")[1]);
        document.body.appendChild(downloadElement);
        downloadElement.click();
        document.body.removeChild(downloadElement);
        window.URL.revokeObjectURL(href);
        this.reload();
      }).finally(()=>{
        this.isLoading = false;
      });
    }
  }
}
</script>

<style scoped>

</style>