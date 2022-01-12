export default [
    {
        path: '/admin',
        name: 'admin-index',
        redirect: '/admin/users',
        meta: {
            login: true,
        }
    },

    {
        path: '/admin/users',
        name: 'admin-users',
        component: require('./screens/admin/users/index').default,
        meta: {
            login: true,
        }
    },
    {
        path: '/admin/plugins/:status?',
        name: 'admin-plugins',
        component: require('./screens/admin/plugins/index').default,
        meta: {
            login: true,
        }
    },
    {
        path: '/admin/download-histories',
        name: 'admin-download-histories',
        component: require('./screens/admin/download-histories/index').default,
        meta: {
            login: true,
        }
    },
    {
        path: '/admin/plugin-versions/:id',
        name: 'admin-plugin-versions-show',
        component: require('./screens/admin/plugin-versions/show').default,
        meta: {
            login: true,
        }
    },
    {
        path: '/login',
        name: 'login',
        component: require('./screens/login').default,
    },
    {
        path: '/register',
        name: 'register',
        component: require('./screens/register').default,
    },
]