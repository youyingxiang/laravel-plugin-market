import { createApp, h } from "vue";
import Routes from './routes';
import Base from './base';
import axios from "axios";
import { createRouter,createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory("/pluginmarket"),
    routes: Routes,
})


const app = createApp({
    data() {
      return {
          alert : {
              message: "",
              autoClose: 0,
              type:null,
              time:null
          },
      }
    },
    mounted() {
        const that = this
        axios.interceptors.response.use(function (response) {
            return response
        }, async function (error) {
            that.alertError(error?.response?.data?.message)
            return Promise.reject(error)
        })
    }
}).mixin(Base);


app.component("admin-layout", require("./components/admin/Layout").default);
app.component("admin-pagination", require("./components/admin/Pagination").default);


app.use(router).mount("#pluginmarket")
