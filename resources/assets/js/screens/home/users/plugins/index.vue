<template>
  <layout desc="我的插件">
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
              <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
              <router-link  v-for="item in allStatus" :to="item.to" :class="[(currentStatus === item?.to?.params?.status || (!currentStatus && !item?.to?.params?.status)) ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300']" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                {{item.title}}
              </router-link>
            </nav>
          </div>
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  插件名称
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  作者
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  版本
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  状态
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  描述
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  价格
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  下载次数
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only"></span>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(plugin, index) in pluginArr" :key="plugin.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{plugin.name}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{plugin.author}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <select id="location" name="location" @change="changeVersion($event, plugin.versions, index)" class="mt-1 block  pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option v-for="(version,index) in plugin.versions" :value="index">{{version.version}}</option>
                  </select>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{plugin.status_str}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{plugin.description}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{plugin.price}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{plugin.download_times}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <span class="sr-only"></span>
                  <router-link :to="{name:'plugin-versions-show', params: {id: plugin.version_id}}">
                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-700" x-description="Heroicon name: solid/chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                  </router-link>
                </td>
              </tr>
              </tbody>
            </table>
            <admin-pagination ref="pagination" :meta="meta"></admin-pagination>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import axios from "axios";
import _ from 'lodash';
const allStatus = [
  {title: "所有", to:{name:'users-plugins'}},
  {title: "已发布", to:{name:'users-plugins', params:{'status': 'release'}}},
  {title: "未发布", to:{name:'users-plugins', params:{'status': 'notRelease'}}}
]
export default {
  data() {
    return {
      meta:{},
      plugins:[],
      pluginArr:[],
    }
  },
  computed: {
    currentStatus() {
      return this.$route.params.status;
    },
  },
  watch: {
    plugins() {
      const that = this;
      this.pluginArr = _.map(this.plugins, function (plugin){
        const defaultVersion = _.first(plugin.versions)
        return that._setPluginDefaultVersion(plugin, defaultVersion);
      });
    },
  },
  provide() {
    return {
      reload: this.loadPlugins
    };
  },

  methods: {
    loadPlugins() {
      axios.get('/api/pluginmarket/user/plugins?page=' + (this.$refs.pagination.page ?? 1) + '&status=' + (this.currentStatus ?? '')).then(resp => {
        this.plugins = resp?.data?.data;
        this.meta = resp?.data?.meta;
      })
    },
    changeVersion(event, versions, index) {
      const defaultVersion = versions[event.target.value];
      this.pluginArr[index] = this._setPluginDefaultVersion(this.pluginArr[index], defaultVersion)
    },

    _setPluginDefaultVersion(plugin, defaultVersion) {
      plugin.download_link = defaultVersion.download_link
      plugin.download_times = defaultVersion.download_times
      plugin.description = defaultVersion.description
      plugin.logo = defaultVersion.logo
      plugin.version = defaultVersion.version
      plugin.status = defaultVersion.status
      plugin.status_str = defaultVersion.status_str
      plugin.price = defaultVersion.price > 0 ? defaultVersion.price : "免费"
      plugin.version_id = defaultVersion.id
      return plugin
    },
  },
  setup() {
    return {
      allStatus
    }
  }
}
</script>

<style scoped>

</style>