export default {
    mode:'history',
    routes:[
        {
            path: '/',
            component: () => import('./views/Home'),
            name: 'home'
        },
        {
            path: '/about',
            component: () => import('./views/About'),
            name: 'About'
        },
        {
            path: '/Administration',
            component: () => import('./views/administration/Administration'),
            name: 'Administration'
        }

    ]
}