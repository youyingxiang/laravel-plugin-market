<template>
  <layout desc="插件市场">
    <div class="flex flex-col mt-5">
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
                  作者
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  版本
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
                  <download :version-id="plugin.version_id"></download>
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
import Download from "../../components/Download";
import _ from 'lodash';
export default {
  components: {
    Download
  },
  data() {
    return {
      meta:{},
      plugins:[],
      pluginArr:[],
      currentStatus: "release"
    }
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
      axios.get('/api/pluginmarket/plugins?page=' + (this.$refs.pagination.page ?? 1) + '&status=' + (this.currentStatus ?? '')).then(resp => {
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
      plugin.description = defaultVersion.description.length > 0 ? defaultVersion.description : "暂无描述"
      plugin.logo = defaultVersion.logo
      plugin.version = defaultVersion.version
      plugin.status_str = defaultVersion.status_str
      plugin.status = defaultVersion.status
      plugin.price = defaultVersion.price > 0 ? defaultVersion.price : "免费"
      plugin.version_id = defaultVersion.id
      return plugin
    },
  },
}
</script>

<style scoped>

</style>