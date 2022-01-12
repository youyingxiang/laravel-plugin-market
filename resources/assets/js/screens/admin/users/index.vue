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
                  名称
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  邮箱
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  图像
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  注册时间
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(user, index) in users">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{user.name}}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{user.email}}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" :src="user.avatar" alt="user.name">
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{user.created_at}}
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
       users:[]
     }
   },
   provide() {
    return {
      reload: this.loadUsers
    };
  },

   methods: {
     loadUsers() {
        axios.get('/api/pluginmarket/users?page=' + this.$refs.pagination.page ?? 1).then(resp => {
          this.users = resp?.data?.data;
          this.meta = resp?.data?.meta;
       })
     }
   }

}
</script>

<style scoped>

</style>