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
            path: '/administration',
            component: () => import('./views/administration/Administration'),
            name: 'administration',
            children: [
                {
                    path: '/dashboard',
                    component: () => import('./components/administration/Dashboard'),
                    name: 'dashboard'
                }
            ]
        },
       

    ]
}