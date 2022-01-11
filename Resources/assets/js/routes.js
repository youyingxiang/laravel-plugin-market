export default [
    {
        path: '/admin',
        name: 'admin-index',
        redirect: '/admin/users'
    },

    {
        path: '/admin/users',
        name: 'admin-users',
        component: require('./screens/admin/users/index').default,
    },
    {
        path: '/admin/plugins/:status?',
        name: 'admin-plugins',
        component: require('./screens/admin/plugins/index').default,
    },
]