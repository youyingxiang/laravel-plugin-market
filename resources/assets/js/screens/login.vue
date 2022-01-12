<template>
  <layout>
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          登录你的账号
        </h2>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
          <div class="space-y-6">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">
                邮箱
              </label>
              <div class="mt-1">
                <input id="email" name="email" v-model="form.email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">
                密码
              </label>
              <div class="mt-1">
                <input id="password" name="password" type="password" v-model="form.password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
            </div>

            <!--          <div class="flex items-center justify-between">-->
            <!--            <div class="text-sm">-->
            <!--              <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">-->
            <!--                忘记你的密码 ?-->
            <!--              </a>-->
            <!--            </div>-->
            <!--          </div>-->

            <div>
              <a @click="onSubmit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :disabled="isLoading">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" v-show="isLoading">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                登录
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      isLoading: false,
      form: {
        email: null,
        password: null
      }
    }
  },
  methods: {
    onSubmit() {
      const regEmail = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
      if (! this.form.email || !regEmail.test(this.form.email)) {
        this.alertError("邮箱格式不正确!");
        return;
      }
      if (this.form.password?.length < 8) {
        this.alertError("密码长度不能小于8位!");
        return;
      }
      if (this.isLoading === true) {
        return;
      }
      this.isLoading = true
      axios({
        method:"post",
        url: "/api/pluginmarket/login",
        data: this.form,
        header: {
          'Content-Type': 'application/json'
        }
      }).then(response => {
        this.$root.token = response.data.token;
        this.$router.push({name:"home-index"});
      }).finally(()=>{
        this.isLoading = false
      })
    }
  }
}
</script>

<style scoped>

</style>