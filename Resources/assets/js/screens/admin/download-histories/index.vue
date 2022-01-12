<template>
  <admin-layout>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  插件名称
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  插件版本
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  插件价格
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  用户名称
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  下载时间
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(download, index) in downloads">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{download.plugin_name}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{download.plugin_version}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{download.price}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{download.user_name}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{download.time}}
                </td>
              </tr>

              <!-- More people... -->
              </tbody>
            </table>
            <admin-pagination ref="pagination" :meta="meta"></admin-pagination>
          </div>
        </div>
      </div>
    </div>

  </admin-layout>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      meta:{},
      downloads:[]
    }
  },
  provide() {
    return {
      reload: this.loadDownloads
    };
  },

  methods: {
    loadDownloads() {
      axios.get('/api/pluginmarket/download-histories?page=' + this.$refs.pagination.page ?? 1).then(resp => {
        this.downloads = resp?.data?.data;
        this.meta = resp?.data?.meta;
      })
    }
  }
}
</script>

<style scoped>

</style>