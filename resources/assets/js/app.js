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
          userInfo: null,
          token: null,
      }
    },
    computed: {
        isLogin() {
            return !!this.token
        },
        csrfToken() {
            return document.head.querySelector('meta[name="csrf-token"]');
        }
    },
    mounted() {
        this.token = window.localStorage.getItem("token");
        if (this.csrfToken) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken.content
        }
        const that = this
        axios.interceptors.response.use(function (response) {
            return response
        }, async function (error) {
            that.alertError(error?.response?.data?.message)
            if (error.response && error.response.status === 403) {
                router.push({name : "home-index"})
            }
            if (error.response && (error.response.status === 401)) {
                that.token = ""
                router.push({name : "login"})
            }
            return Promise.reject(error)
        })
    },
    watch: {
        token() {
            if (this.token) {
                window.localStorage.setItem("token", this.token);
                axios.defaults.headers.common['Authorization'] = "Bearer " + this.token;
                this.getUserInfo();
            } else {
                this.userInfo = null;
                axios.defaults.headers.common['Authorization'] = "";
                window.localStorage.removeItem("token");
            }
        }
    }
}).mixin(Base);


app.component("admin-layout", require("./components/admin/Layout").default);
app.component("admin-pagination", require("./components/admin/Pagination").default);
app.component("layout", require("./components/home/Layout").default);

router.beforeEach((to, from, next) => {
    if ((to.name === "login" || to.name === "register") && window.localStorage.getItem("token")) {
        router.push({name : "admin-index"})
        return;
    }
    if (to.meta.login && !window.localStorage.getItem("token")) {
        router.push({name : "login"})
        return;
    }
    next()
})
app.use(router).mount("#pluginmarket")
