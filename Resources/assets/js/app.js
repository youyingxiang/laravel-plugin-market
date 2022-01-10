import { createApp, h } from "vue";
import Routes from './routes';
import Base from './base';
import { createRouter,createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory("/pluginmarket"),
    routes: Routes,
})


const app = createApp({}).mixin(Base);


app.component("admin-layout", require("./components/admin/Layout").default);


app.use(router).mount("#pluginmarket")
