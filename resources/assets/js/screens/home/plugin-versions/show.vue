<template>
  <layout>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg  px-5 px-2 bg-white">
            <form class="space-y-8 divide-y divide-gray-200 ">
              <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                <div>
                  <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                      <label for="plugin-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        插件名称
                      </label>
                      <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" id="plugin-name" disabled readonly v-model="version.plugin_name" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                      </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                      <label for="plugin-version" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        插件版本
                      </label>
                      <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" :disabled="!this.canEdit" v-model="version.version" id="plugin-version" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                      </div>
                    </div>


                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                      <label for="price" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        价格
                      </label>
                      <div class="relative rounded-md shadow-sm sm:mt-0 sm:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <span class="text-gray-500 sm:text-sm">
                            ¥
                          </span>
                        </div>
                        <input type="number" id="price" min=0 :disabled="!this.canEdit" v-model="version.price" class="focus:ring-indigo-500 focus:border-indigo-500  max-w-lg block w-full pl-7 pr-12 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                      </div>
                    </div>


                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                      <label for="about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        插件简介
                      </label>
                      <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <textarea id="about" :disabled="!this.canEdit" rows="3" v-model="version.description" class="max-w-lg shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md"></textarea>
                      </div>
                    </div>


                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                      <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        插件 logo
                      </label>
                      <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div @click="this.$refs.upload.click()" class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                          <div class="space-y-1 text-center">
                            <img v-if="version.logo" class="mx-auto h-24 w-24 text-gray-400" :src="version.logo">
                            <svg v-else class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                              <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                              <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <input id="file-upload" :disabled="!this.canEdit" accept="image/*" type="file" @change="upload" ref="upload" class="sr-only">
                              </label>
                            </div>
                            <p class="text-xs text-gray-500">
                              支持 PNG, JPG, GIF，大小不超过 500 KB
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="py-5">

                <div class="flex justify-end">

                  <button type="button" @click="this.$router.back()" class="ml-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    返回
                  </button>
                  <template v-if="this.canEdit">
                    <button type="button" :disabled="saving" @click="changeStatusSave($event,false)" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" v-if="saving">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      <span v-if="!saving">
                        保存
                      </span>
                    </button>
                    <button type="button" :disabled="changStatusSaving" @click="changeStatusSave($event,true)" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" v-if="changStatusSaving">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      <span v-if="!changStatusSaving">
                        提交审核
                      </span>
                    </button>
                  </template>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import axios from "axios";
const status = [
  {text:'待审核', value: 0},
  {text:'审核中', value: 1},
  {text:'停用', value: 2},
  {text:'已发布', value: 3},
]
export default {
  data() {
    return {
      version: {},
      isLoading: false,
    }
  },
  setup() {
    return {
      status
    }
  },
  mounted() {
    this.loadVersion()
  },
  computed: {
    id() {
      return this.$route.params.id;
    },
    canEdit() {
      // 审核中和已经审核不能编辑
      return this.version.status !== 3 &&  this.version.status !== 1
    },
    saving() {
      return this.isLoading === true && this.changeStatus === false;
    },
    changStatusSaving() {
      return this.isLoading && this.changeStatus === true
    }
  },
  methods: {
    loadVersion() {
      axios.get("/api/pluginmarket/pluginversions/" + this.id).then(response => {
        this.version = response.data
      })
    },
    upload(event) {
      const file = event?.target?.files?.[0],
          formData = new FormData();

      if (file.size > 500 * 1024) {
        this.alertError("上传文件大小不能超过 500 kb")
        return;
      }
      formData.append('file', file)
      axios.post('/api/pluginmarket/upload/image', formData, {
        headers: {
          "Content-Type": 'multipart/form-data'
        }
      }).then(response => {
        this.version.logo = response?.data?.url;
        this.alertSuccess("上传成功！", 3000);
      })
    },
    changeStatusSave(event,status) {
      this.changeStatus = status;
      this.save();
    },
    save() {
      if (this.version.price.length === 0 ||  this.version.price < 0) {
        this.alertError("请输入正确的价格");
        return;
      }
      if (this.isLoading === true) {
        return;
      }
      this.isLoading = true;

      axios.put("/api/pluginmarket/pluginversions/" + this.id, {
        'logo': this.version.logo,
        'description': this.version.description,
        'price' : this.version.price,
        'version': this.version.version,
        'status': this.changeStatus ? 1 : this.version.status
      }).then(response => {
        this.loadVersion()
        this.alertSuccess("保存成功！", 3000);
      }).finally(()=> {
        this.isLoading = false;
      })
    }
  }
}
</script>

<style scoped>

</style>